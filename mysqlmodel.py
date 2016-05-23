#!/usr/bin/env python
# -*- coding: utf-8 -*-
#debug = True

import MySQLdb

if globals().get('debug'):
	informixdb = MySQLdb
else:
	import informixdb

#kZ2ZqaGZydWloc

class MysqlModel:
	# ORM settings
	colmap = []
	table_name = 'Mysql'
	conn = None

	@classmethod
	def connect(cls):
		Database = 'd_1460371498316150'
		if globals().get('debug'):
			Database = 'd_1460371579579196'
			Server = 'localhost'
			Username = 'root'
			Password = 'toor'
		else:
			Server = 'ifxserver1'
			Username = 'bhdaatqt'
			Password = 'eLLANNdLpU'

		#if MysqlModel.conn is not None:
		#	return MysqlModel.conn
		try:
			if globals().get('debug'):
				MysqlModel.conn = informixdb.connect(Server, Username, Password, Database)
			else:
				MysqlModel.conn = informixdb.connect(Database + '@' + Server, Username, Password)
		except:
			MysqlModel.conn = None
		if MysqlModel.conn is None:
			raise Exception("Failed to connect via SQL")
		return MysqlModel.conn

	@classmethod
	def close(cls):
		if MysqlModel.conn is not None: MysqlModel.conn.close()

	@classmethod
	def query(cls, sql, hasData):
		conn = cls.connect()
		cur = conn.cursor()
		#cur.execute("SET NAMES UTF8")
		try:
			cur.execute(sql)
		except Exception:
			raise Exception(sql)
		if hasData: res = cur.fetchall()
		cur.close()
		conn.commit()
		conn.close()
		if hasData: return res

	def __init__(self, id):
		self._isLoaded = False
		self.id = id
		setattr(self, self.colmap[0], self.id)

	def whereClause(self):
		if type(self.id) != type(1):
			clause = u" where %s = '%s' " % (self.colmap[0], self.escape(self.id))
		else:
			clause = u" where %s = %d " % (self.colmap[0], self.id)
		return clause

	def load(self):
		if self._isLoaded: return self._exist
		self._isLoaded = True

		if self.id is not None:
			res = self.query((u"select * from %s" % self.table_name) + self.whereClause(), True)
			if len(res) != 0:
				for key, val in zip(self.colmap, res[0]):
					setattr(self, key, val)
				self._exist = True
				return True
		self._exist = False
		return False

	def delete(self):
		if self._isLoaded == False:
			if self.load():
				raise Exception(u'数据在删除前必须先载入')
		if self._exist:
			self.query((u"delete from %s" % self.table_name) + self.whereClause(), False)

	def save(self):
		if self._isLoaded == False:
			if self.load():
				raise Exception(u'数据在保存前必须先载入')
		if self._exist:
			query = u'update %s set ' % self.table_name
			query += ','.join([u"%s='%s'" % (key, i) for key in self.colmap for i in [self.escape(getattr(self, key, None))] if i is not None])
			query += self.whereClause()
			self.query(query, False)
		else:
			query = u'insert into %s' % self.table_name
			#query += u','.join([u'%s' % key for key in self.colmap])
			query += u' VALUES ('
			query += u','.join([(u"'%s'" % i if type(i)!=type(1) else u"%d" % i) if i is not None else u'NULL' for key in self.colmap for i in [self.escape(getattr(self, key, None))]])
			query += u')'
			self.query(query, False)
		self._exist = True

	@classmethod
	def escape(cls, st):
		if type(1) == type(st) or type(1L) == type(st): return st
		if st is None: return 'NULL'
		st = MySQLdb.escape_string(st)
		st = st.replace("\\'", "''")
		return st

	@classmethod
	def wrapToJson(cls, res, cols):
		ret = []
		for i in res:
			obj = {}
			for ind, j in enumerate(cols):
				obj[j] = i[ind]
			ret.append(obj)
		return ret

