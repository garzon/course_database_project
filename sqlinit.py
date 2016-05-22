#!/bin/python
import informixdb
import os

Database = 'd_1460371579579196'
#Server='172.16.16.181'
Server='ifxserver1'
Username = 'lphmxmnl'
Password = 'gfAHlK4TUv'

def init_SQL():

    try:
        cur = conn = None
        #connect
        conn = informixdb.connect(Database+'@'+Server,Username,Password)
        if not conn:
            raise Exception("Failed to connect via SQL to " + dbservername)
        else:
            print("connect !!!!")
        #get cursor
        cur = conn.cursor()
        cur.execute("""create table user
(username char(30) not null,
 password char(32) not null,
 region char(16),
 introduction char(200),
 mail char(30),
 primary key(username))""")

        cur.execute("""create table artist
(author char(40) not null,
 genre char (10),
 introduction char(200),
 primary key(author))""")

        cur.execute("""create table music
(music_id int not null,
 name char(100) not null,
 file_path char(200) not null,
 author char(40) not null,
 type char(20),
 username char(30) not null,
 introduction char(100),
 primary key(music_id),
 constraint fk1 foreign key(author) references artist,
 constraint fk2 foreign key(username) references user)""")

        cur.execute("""create table comment
(id int not null,
 score int not null,
 feedback char(200),
 username char(30) not null,
 music_id int not null,
 primary key(id),
 constraint fk1 foreign key(username) references user,
 constraint fk2 foreign key(music_id) references music)""")

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


