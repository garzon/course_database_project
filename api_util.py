import json
from flask import make_response, request, abort

def parse_req_body(arr):
	try:
		ret = request.form
		for i in arr:
			if ret[i]:
				pass
		return ret
	except:
		abort(400)
		return dict()

def fail(msg):
	ret = {'failed': True, 'msg': msg}
	resp = make_response(json.dumps(ret), 200)
	return resp

def succ(msg):
	ret = {'failed': False, 'msg': msg}
	resp = make_response(json.dumps(ret), 200)
	return resp

def succAndRedirect(msg, uri):
	ret = {'msg': msg, 'redirect': uri}
	resp = make_response(json.dumps(ret), 200)
	return resp
