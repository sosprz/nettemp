from app import app
from flask import Flask, request, jsonify, g
import os, json, datetime
from flask_jwt_extended import JWTManager, jwt_required, create_access_token, get_jwt_identity
from flask_bcrypt import Bcrypt
from flask_mysqldb import MySQL
mysql = MySQL()


bcrypt = Bcrypt()
jwt = JWTManager(app)

@app.route('/register', methods=['POST'])
def register():
    if not request.is_json:
        return jsonify({"msg": "Missing JSON in request"}), 400

    username = request.json.get('username', None)
    password = request.json.get('password', None)
    if not username:
        return jsonify({"msg": "Missing username parameter"}), 400
    if not password:
        return jsonify({"msg": "Missing password parameter"}), 400

    m = mysql.connection.cursor()
    m.execute("SELECT username, password, jwt FROM users WHERE username=%s", (username,))
    data = m.fetchone()
    
    if data != None:
      pass_from_db = data[1]
      print(bcrypt.check_password_hash(pass_from_db,password))
      if username != None and username == data[0] and bcrypt.check_password_hash(pass_from_db,password) and 'yes' == data[2]:
        print('JWT Logged in..')
        expires = datetime.timedelta(days=365)
        access_token = create_access_token(identity=username, expires_delta=expires)
        return jsonify(access_token=access_token), 200
      else:
        print ('Bad username ')
        return jsonify({"msg": "Bad username or password"}), 401
    return jsonify({"msg": "Bad username or password"}), 401

