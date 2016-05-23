#!/usr/bin/env python
# -*- coding: utf-8 -*-
from mysqlmodel import MysqlModel
import hashlib

class Comment(MysqlModel):
	table_name = 'Comment'
	colmap = ['id', 'score', 'feedback', 'username', 'music_id']

	@classmethod
	def getNextId(cls):
		query = "select id from Comment order by id desc limit 1"
		res = cls.query(query)
		if len(res):
			res = res[0][0]+1
		else:
			res = 1
		return res

	def __init__(self, id=None):
		MysqlModel.__init__(self, id)

	def save(self):
		if self.id is None:
			self.id = self.getNextId()
			self._isLoaded = True
			self._exist = False
		MysqlModel.save(self)

