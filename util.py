import json, random, string
from flask import request, abort, session, render_template

from user import User

def gen_random_string():
	randint = random.randint
	printable = string.printable
	return ''.join([printable[randint(0, 61)] for _ in xrange(10)])

def auth(callback=None):
	username = request.cookies.get('username', '')
	usr = User(username)
	if usr.load() == False:
		if callback is None:
			abort(501)
		else:
			callback()
	token = request.cookies.get('token', '')
	if usr.verifyToken(token) == False:
		if callback is None:
			abort(501)
		else:
			callback()
	session['username'] = username
	return usr


def wrapper(htmlContent):
	header = render_template('header.php', session=session, request=request)
	footer = render_template('footer.php')
	return header + htmlContent + footer

