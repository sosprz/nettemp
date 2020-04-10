from app import app
from flask import Flask, request, jsonify, render_template
from flask_login import login_required
from smtplib import *
from app.nettemp import nt_settings
from flask_mysqldb import MySQL
mysql = MySQL()

#global info

@app.route('/settings/mail', methods=['GET','POST'])
@login_required
def mail_settings():
  if request.method == "POST":
    if request.form.get('send-mail') == 'yes':
      smtp_user = request.form['smtp_user']
      smtp_p = request.form['smtp_p']
      smtp_server = request.form['smtp_server']
      smtp_port = request.form['smtp_port']
      mail_subject = request.form['mail_subject']

      m = mysql.connection.cursor()
      m.execute("UPDATE nt_settings SET value=%s WHERE option='smtp_user'", (smtp_user,))
      m.execute("UPDATE nt_settings SET value=%s WHERE option='smtp_p'", (smtp_p,))
      m.execute("UPDATE nt_settings SET value=%s WHERE option='smtp_server'", (smtp_server,))
      m.execute("UPDATE nt_settings SET value=%s WHERE option='smtp_port'", (smtp_port,))
      m.execute("UPDATE nt_settings SET value=%s WHERE option='mail_subject'", (mail_subject,))
      m.connection.commit()
      m.close()

    if request.form.get('send-test-mail') == 'yes':
      import smtplib, ssl
      from email.mime.text import MIMEText
      from email.mime.multipart import MIMEMultipart
      recipient = request.form['recipient']
      try:
        if recipient:
          m = mysql.connection.cursor()
          m.execute("SELECT option, value FROM nt_settings")
          s = m.fetchall()  
          m.close()

          for k, v in s:
            if k=='smtp_user':
              smtp_user = v
            if k=='smtp_p':
              smtp_p = v
            if k=='smtp_server':
              smtp_server = v
            if k=='smtp_port':
              smtp_port = v
            if k=='mail_subject':
              mail_subject = v
              print(mail_subject)

          data = "Test mail fom nettemp!"

          message = MIMEMultipart("alternative")
          message["Subject"] = mail_subject
          message["From"] = smtp_user
          message["To"] = recipient
          text = """\
          Hi,
          {data}
          """.format(data=data)
          html = """\
          <html>
          <body>
          <p>
            {data}<br>
          <br >
            <a href="http://techfreak.pl/tag/nettemp"> <img src="http://techfreak.pl/wp-content/uploads/2012/12/nettemp.pl_.png" style="width:120px;height:40px;"></a><br>
          </p>
          </body>
          </html>
          """.format(data=data)

          part1 = MIMEText(text, "plain")
          part2 = MIMEText(html, "html")

          message.attach(part1)
          message.attach(part2)

          context = ssl.create_default_context()
          with smtplib.SMTP_SSL(smtp_server, smtp_port, context=context) as server:
              server.login(smtp_user, smtp_p)
              server.sendmail(smtp_user, recipient, message.as_string(),)
          info = ("Mail was send to %s" % (recipient))
          return render_template('mail_settings.html', nt_settings=dict(nt_settings()), info=info)
      except SMTPException as e:
        info='Error: %s' % e
        return render_template('mail_settings.html', nt_settings=dict(nt_settings()), info=info)
      except smtplib.socket.gaierror as e:
        info='Error: %s:' % e
        return render_template('mail_settings.html', nt_settings=dict(nt_settings()), info=info)
      except SMTPAuthenticationError:
        info='Error: %s:' % e
        return render_template('mail_settings.html', nt_settings=dict(nt_settings()), info=info)
      except SomeSendMailError:
        info='Error: %s:' % e
        return render_template('mail_settings.html', nt_settings=dict(nt_settings()), info=info)

  return render_template('mail_settings.html', nt_settings=dict(nt_settings()))
