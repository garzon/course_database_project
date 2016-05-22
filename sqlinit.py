#!/bin/python
# -*- coding: utf-8 -*-

debug = True

if globals().get('debug'):
	import MySQLdb
	informixdb = MySQLdb
else:
	import informixdb


def init_SQL():

    Database = 'd_1460371579579196'
    if globals().get('debug'):
        Server = 'localhost'
        Username = 'root'
        Password = 'toor'
    else:
        Server = 'ifxserver1'
        Username = 'lphmxmnl'
        Password = 'gfAHlK4TUv'

    try:
        cur = conn = None
        #connect
        if globals().get('debug'):
            conn = informixdb.connect(Server, Username, Password, Database)
        else:
            conn = informixdb.connect(Database + '@' + Server, Username, Password)
        if not conn:
            raise Exception("Failed to connect via SQL")
        else:
            print("connect !!!!")
        #get cursor
        cur = conn.cursor()

        cur.execute("DROP TABLE IF EXISTS User");
        cur.execute("DROP TABLE IF EXISTS Artist");
        cur.execute("DROP TABLE IF EXISTS Music");
        cur.execute("DROP TABLE IF EXISTS Comment");

        cur.execute("""create table User
(username char(30) not null,
 password char(32) not null,
 region char(16),
 introduction char(200),
 mail char(30),
 primary key(username))""")

        cur.execute("""create table Artist
(author char(40) not null,
 genre char (10),
 introduction char(200),
 primary key(author))""")

        cur.execute("""create table Music
(music_id int not null,
 name char(100) not null,
 file_path char(200) not null,
 author char(40) not null,
 type char(20),
 username char(30) not null,
 introduction char(100),
 primary key(music_id))""")

        cur.execute("""create table Comment
(id int not null,
 score int not null,
 feedback char(200),
 username char(30) not null,
 music_id int not null,
 primary key(id))""")

        conn.commit()

    finally:
        if cur:
            cur.close()
        if conn:
            conn.close()

if __name__=='__main__':
    print("-----------------------------------------this is a SQL test")
    init_SQL()
    print("-----------------------------------------this is a SQL test")


