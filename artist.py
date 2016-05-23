#!/usr/bin/env python
# -*- coding: utf-8 -*-
from mysqlmodel import MysqlModel
import hashlib

class Artist(MysqlModel):
	table_name = 'Artist'
	colmap = ['author', 'genre']
