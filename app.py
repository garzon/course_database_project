#!/usr/bin/env python
# -*- coding: utf-8 -*-

import sys
reload(sys)
sys.setdefaultencoding("utf-8")

import os

from flask import Flask, abort, current_app, make_response, render_template, send_file
from werkzeug import secure_filename
from util import *
from api_util import *

from user import User
from music import Music
from artist import Artist
from comment import Comment
from mysqlmodel import MysqlModel

app = Flask(__name__)

# Error handlers =====================================================================
@app.errorhandler(400)
def empty_req_error(error):
	return u'{"failed": true, "msg": "请完整填写表单"}', 200

@app.errorhandler(501)
def redirect_handler(error):
	resp = make_response('', 302)
	resp.headers['Location'] = '/login'
	return resp

@app.errorhandler(401)
def not_login_handler(error):
	return u'{"failed": true, "msg": "请先登录"}', 200

@app.errorhandler(403)
def auth_error(error):
	return u'{"failed": true, "msg": "用户名或密码错误"}', 200

@app.errorhandler(404)
def not_found_error(error):
	return u'{"failed": true, "msg": "页面不存在，请<a href=\'/\'>返回首页</a>"}', 404

# Controllers ========================================================================

def dummy():
	pass

@app.route('/')
def listing_handler():
	auth(dummy)
	categories = ['folk','pop','jazz','electrical','soundtrack','newage','classical']
	return make_response(wrapper(render_template('index.php', request=request, categories=categories)), 200)

@app.route('/api/list', methods=['GET'])
def getlisting_api_handler():
	score = request.args.get('score', None)
	music_cat = request.args.get('music_cat', '')
	author_cat = request.args.get('author_cat', '')
	subclause = u''
	if music_cat:
		subclause = u"type='%s' " % MysqlModel.escape(music_cat)
	if author_cat:
		if subclause: subclause += u'and '
		subclause += u"(select genre from Artist as Y where Y.author=Music.author)='%s' " % MysqlModel.escape(author_cat)
	if score:
		score = int(score)
		return make_response(json.dumps(Music.getListByScore(score, subclause)), 200)
	return make_response(json.dumps(Music.getList(subclause)), 200)

@app.route('/api/delete/<int:music_id>', methods=['POST'])
def delete_api_handler(music_id):
	music = Music(music_id)
	if music.load() == False: abort(404)
	def callback():
		abort(401)
	usr = auth(callback)
	if music.username == usr.username:
		music.delete()
	return succ(u'删除成功！')

@app.route('/login', methods=['GET'])
def login_page_handler():
	resp = make_response(wrapper(render_template('login.php')), 200)
	return resp

@app.route('/api/login', methods=['POST'])
def login_api_handler():
	data = parse_req_body(['username', 'password'])
	username = data['username']
	password = data['password']

	user = User.login(username, password)
	if user is None:
		abort(403)

	resp = succAndRedirect(u'登录成功', '/')
	resp.set_cookie('username', user.username)
	resp.set_cookie('token', user.genToken())
	return resp

@app.route('/api/register', methods=['POST'])
def register_api_handler():
	data = parse_req_body(['username', 'password', 'mail'])
	username = data['username']
	password = data['password']
	mail = data['mail']

	err_msg = User.register(username, password, mail)

	if err_msg is None:
		resp = succ(u'注册成功，请登录后继续操作')
	else:
		resp = fail(u'注册失败，原因：' + err_msg)
	return resp


@app.route('/view/<int:music_id>', methods=['GET'])
def view_handler(music_id):
	resp = make_response(wrapper(render_template('view.php', music_id=music_id)), 200)
	return resp

@app.route('/editor/<int:music_id>', methods=['GET'])
def editor_handler(music_id):
	resp = make_response(wrapper(render_template('editor.php', music_id=music_id)), 200)
	return resp

@app.route('/api/get_music/<int:music_id>', methods=['GET'])
def get_music_api_handler(music_id):
	music = Music(music_id)
	if music.load() == False: abort(404)
	return send_file(music.file_path, music.getContentType())

@app.route('/api/comment/<int:music_id>', methods=['POST'])
def comment_api_handler(music_id):
	music = Music(music_id)
	if music.load() == False: abort(404)
	def callback():
		abort(401)
	usr = auth(callback)
	data = parse_req_body(['score', 'feedback'])
	try:
		score = int(data['score'])
	except:
		abort(400)
	comment = Comment()
	comment.score = score
	comment.feedback = data['feedback']
	comment.username = usr.username
	comment.music_id = music.music_id
	comment.save()
	return succ(u'评论成功！')

@app.route('/api/detail/<int:music_id>', methods=['GET'])
def detail_api_handler(music_id):
	music = Music(music_id)
	if music.load() == False: abort(404)

	obj = {i:j for i, j in music.__dict__.items()}
	obj['file_path'] = music.file_path[-5:]
	obj['comments'] = music.getComments()
	obj['content_type'] = music.getContentType()
	obj['score'] = music.getScore()
	obj['genre'] = music.getAuthorGenre()

	return make_response(json.dumps(obj), 200)

@app.route('/upload', methods=['GET'])
def upload_handler():
	auth()
	resp = make_response(wrapper(render_template('upload.php')), 200)
	return resp

@app.route('/api/upload', methods=['POST'])
def upload_api_handler():
	usr = auth()

	data = parse_req_body(['name', 'author', 'mtype', 'introduction', 'genre'])
	try:
		f = request.files['music_file']
	except:
		return fail(u'发布失败，请选择要上传的文件')

	music = Music()
	music.name = data['name']
	if not music.name: return fail(u'请填写音乐名称')
	music.author = data['author']
	music.type = data['mtype']
	music.username = usr.username
	music.introduction = data['introduction']

	music.file_path = './attachments/' + secure_filename(gen_random_string()+f.filename[-70:])
	try:
		f.save(music.file_path)
	except:
		return fail(u'保存音乐文件失败，请重试')

	if data['author']:
		artist = Artist(data['author'])
		artist.load()
		artist.genre = data['genre']
	else:
		artist = Artist('')
		artist.load()
		artist.genre = ''

	artist.save()
	music.save()
	return succAndRedirect(u'成功发布', '/view/' + str(music.id))

if __name__ == '__main__':
	host = os.getenv("APP_HOST", "0.0.0.0")
	port = int(os.getenv("APP_PORT", "7654"))
	app.secret_key = User.secret_salt_right + User.secret_salt_left
	app.run(host=host, port=port, debug=True, threaded=True)

