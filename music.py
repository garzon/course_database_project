#!/usr/bin/env python
# -*- coding: utf-8 -*-
from mysqlmodel import MysqlModel
import os

class Music(MysqlModel):
	table_name = 'Music'
	colmap = ['music_id', 'name', 'file_path', 'author', 'type', 'username', 'introduction']

	@classmethod
	def getNextId(cls):
		query = u"select music_id from Music order by music_id desc limit 1"
		res = cls.query(query, True)
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
			self.music_id = self.id
			self._isLoaded = True
			self._exist = False
		MysqlModel.save(self)


	def getContentType(self):
		return u'audio/' + os.path.splitext(self.file_path)[1][1:]

	def getComments(self):
		query = u"select score, username, feedback from Comment where music_id = %d order by id desc" % self.id
		cols = ['score', 'username', 'feedback']
		res = self.query(query, True)
		return self.wrapToJson(res, cols)

	def getAuthorGenre(self):
		query = u"""select genre from Artist where author = '%s'""" % self.escape(self.author)
		res = self.query(query, True)
		if len(res):
			return res[0][0]
		return ''

	def getScore(self):
		query = u"""select avg(score) from Comment where music_id = %d""" % self.id
		res = self.query(query, True)
		if len(res):
			res = res[0][0]
		else:
			res = 0.0
		return "%.2f" % (res if res else 0)

	def delete(self):
		query = u"delete from Comment where music_id = %d" % self.id
		self.query(query, False)
		MysqlModel.delete(self)

	@classmethod
	def getList(cls, subclause=''):
		query = u"select music_id, name, author, type, username, introduction from Music %s order by music_id desc" % ('where ' + subclause if subclause else '')
		cols = ['music_id', 'name', 'author', 'type', 'username', 'introduction']
		res = cls.query(query, True)
		return cls.wrapToJson(res, cols)

	@classmethod
	def getListByScore(cls, score, subclause=''):
		if score == 0: return cls.getList(subclause)
		query = u"""select music_id, name, author, type, username, introduction from Music
					where (select avg(score) as avg_score from Comment as X where X.music_id = music_id) > %d
					%s
					order by music_id desc""" % (score, 'and ' + subclause if subclause else '')
		cols = ['music_id', 'name', 'author', 'type', 'username', 'introduction']
		#raise Exception(query)
		res = cls.query(query, True)
		return cls.wrapToJson(res, cols)