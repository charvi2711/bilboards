#!flask/bin/python
from flask import Flask, send_from_directory, request
import logging, os
from werkzeug import secure_filename
import sys

app = Flask(__name__)


def create_new_folder(local_dir):
    newpath = local_dir
    if not os.path.exists(newpath):
        os.makedirs(newpath)
    return newpath

@app.route('/test', methods = ['GET', 'POST'])
def api_root():
   
    print('1')
    if request.method == 'POST':
        try:
            f = open('log.txt','a+')
            f.write('Helo', request.files)
            f.close()
            #app.logger.info(app.config['UPLOAD_FOLDER'])
            
            img = request.files['file']
            f = open('log.txt','a+')
            f.write(img)
            f.close()
            print(img, file=sys.stderr)
            img_name = secure_filename(img.filename)
        except(ex):
            f = open('log.txt','a+')
            f.write(ex)
            f.close()
        #create_new_folder(app.config['UPLOAD_FOLDER'])
        #saved_path = os.path.join(app.config['UPLOAD_FOLDER'], img_name)
        #app.logger.info("saving {}".format(saved_path))
        #img.save(saved_path)
        return send_from_directory(app.config['UPLOAD_FOLDER'],img_name, as_attachment=True)
    else:
        return "Where is the image?"

if __name__ == '__main__':
    app.run(host='0.0.0.0', debug=False)