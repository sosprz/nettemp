from app import app
from flask import Flask, request, jsonify, render_template
import sqlite3
from flask_login import login_required

@app.route('/info')
@login_required
def info():
  return render_template('info.html')
