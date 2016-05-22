#!/usr/bin/env python
# -*- coding: utf-8 -*-
import os

from flask import Flask, abort, current_app, make_response, render_template

from util import *
from api_util import *

from user import User

app = Flask(__name__)

# Error handlers =====================================================================
@app.errorhandler(400)
def empty_req_error(error):
	return u'{"failed": true, "msg": "请完整填写表单"}', 400

@app.errorhandler(403)
def auth_error(error):
	return u'{"failed": true, "msg": "用户名或密码错误"}', 403

@app.errorhandler(404)
def cart_error(error):
	return u'{"failed": true, "msg": "页面不存在"}', 404

# Controllers ========================================================================

@app.route('/')
def hello_world():
	return 'Hello World!'

@app.route('/api/list', methods=['GET'])
def getlisting_api_handler():
	pass

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


@app.route('/view', methods=['GET'])
def view_handler():
	pass

@app.route('/api/comment', methods=['POST'])
def comment_api_handler():
	pass

@app.route('/api/detail', methods=['GET'])
def detail_api_handler():
	pass

@app.route('/upload', methods=['GET', 'POST'])
def upload_handler():
	pass

if __name__ == '__main__':
	host = os.getenv("APP_HOST", "0.0.0.0")
	port = int(os.getenv("APP_PORT", "80"))
	app.run(host=host, port=port, debug=True)
