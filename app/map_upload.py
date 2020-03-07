from app import app
from flask import Flask, request, jsonify, render_template, redirect, url_for
import sqlite3, os
from werkzeug.utils import secure_filename
from werkzeug.security import safe_join
from flask_login import login_required

ALLOWED_EXTENSIONS = {'jpg', 'jpeg'}
UPLOAD_FOLDER = app.config['UPLOAD_FOLDER']

def allowed_file(filename):
    return '.' in filename and \
           filename.rsplit('.', 1)[1].lower() in ALLOWED_EXTENSIONS

@app.route('/settings/map/upload', methods=['GET','POST'])
@login_required
def upload_file():
    if request.method == 'POST':
      # check if the post request has the file part
      if 'file' in request.files:
        file = request.files['file']
        # if user does not select file, browser also
        # submit an empty part without filename
        if file.filename == '':
          file('No selected file')
        #return redirect(request.url)
        if file and allowed_file(file.filename):
          filename = secure_filename(file.filename)
          file.save(os.path.join(app.config['UPLOAD_FOLDER'], 'map.jpg'))

      """ remove """
      if request.form.get('send-remove-mapimage') == 'yes':
        if os.path.exists("data/upload/map.jpg"):
          os.remove("data/upload/map.jpg")

    if os.path.exists('data/upload/map.jpg'):
      mapimage = 'new'
    else:
      mapimage = None

    return render_template('map_upload.html', mapimage=mapimage)

@app.route('/mapimage', methods=['GET'])
@login_required
def get_file():
  file = open(os.path.join(app.config['UPLOAD_FOLDER'], 'map.jpg')).read()
  return file


