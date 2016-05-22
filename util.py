import json, random, string
from flask import request, abort, session, render_template

from user import User

def gen_random_string():
	randint = random.randint
	printable = string.printable
	return ''.join([printable[randint(0, 61)] for _ in xrange(32)])

def auth():
	username = request.cookies.get('username', '')
	usr = User(username)
	if usr.load() == False:
		abort(401)
	token = request.cookies.get('token', '')
	if usr.verifyToken(token) == False:
		abort(401)
	session['username'] = username

def wrapper(htmlContent):
	header = render_template('header.php', session=session)
	footer = render_template('footer.php')
	return header + htmlContent + footer