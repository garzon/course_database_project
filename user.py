#!/usr/bin/env python
# -*- coding: utf-8 -*-
from mysqlmodel import MysqlModel
import hashlib

class User(MysqlModel):
	table_name = 'User'
	colmap = ['username', 'password', 'region', 'introduction', 'mail']

	secret_salt_left = '#$%^&gr'
	secret_salt_right = 'h3L10, w0Rid'

	@classmethod
	def genHash(cls, txt):
		return hashlib.md5(cls.secret_salt_left+txt+cls.secret_salt_right).hexdigest()

	@classmethod
	def login(cls, username, password):
		usr = User(username)
		if usr.load():
			if usr.password == cls.genHash(password):
				return usr
		return None

	@classmethod
	def check_email_registered(cls, mail):
		mail = cls.escape(mail)
		res = cls.query("select count(*) from `User` where mail='%s'" % mail)
		if res[0] != 0:
			return True
		return False

	@classmethod
	def register(cls, username, password, mail):
		usr = User(username)
		if usr.load():
			return u'用户名已存在'
		if cls.check_email_registered(cls, mail):
			return u'邮箱已被注册'
		usr.mail = mail
		usr.password = cls.genHash(password)
		usr.save()

	def genToken(self):
		self.load()
		return self.genHash(self.password)

	def verifyToken(self, token):
		self.load()
		return self.genHash(self.password) == token