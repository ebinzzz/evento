#!C:\Users\ebinb\AppData\Local\Programs\Python\Python312\python.exe

print("Content-Type: text/html\n")
import os
import smtplib
import mysql.connector
from email.mime.multipart import MIMEMultipart
from email.mime.text import MIMEText
from email.mime.application import MIMEApplication
from PIL import Image, ImageDraw, ImageFont

# Set up email server and credentials
smtp_server = 'smtp.gmail.com'
smtp_port = 587
smtp_username = 'ebin.cec@gmail.com'  # Sender's email address
smtp_password = 'rgoclgzigtyjfofx'  # Sender's email password

def send_certificate():
    try:
        # Establish connection to MySQL database
        connection = mysql.connector.connect(
            host="localhost",
            user="root",
            password="",  # Enter your MySQL password here
            database="events"
        )

        # Create a cursor object to execute SQL queries
        cursor = connection.cursor()

        # Query the MySQL database to get participant information based on the ID
        query = """
        SELECT participants.fullname, participants.email, events.event_title
        FROM participants
        JOIN events ON participants.event_id = events.event_id
        WHERE participants.certi = 'no'  AND  participants.feed = 'done'
        """
        cursor.execute(query)

        # Fetch all rows from the result set
        data = cursor.fetchall()

        # Check if participant data is found
        if not data:
            cursor.close()
            connection.close()
            return "No participants found."

        # Iterate through the participant data
        for row in data:
            name, email, event = row

            # Create the email message
            msg = MIMEMultipart()
            msg['From'] = smtp_username
            msg['To'] = email
            msg['Subject'] = 'Certificate'

            body = f'Hi {name},\n\nPlease find the attached certificate for your participation in the event "{event}".\n\nBest regards,\nYour Name'
            msg.attach(MIMEText(body, 'plain'))

            # Generate the certificate
            image_path = 'ap.png'  # Adjust file path if necessary
            if not os.path.exists(image_path):
                cursor.close()
                connection.close()
                return f"Image file '{image_path}' not found."

            im = Image.open(image_path)
            d = ImageDraw.Draw(im)

            # Draw participant's name on the certificate
            name_location = (1000, 600)
            name_text_color = (255, 215, 0)
            name_font = ImageFont.truetype("DejaVuSerif-Italic.ttf", 90)
            d.text(name_location, name, fill=name_text_color, font=name_font)

            # Draw event name on the certificate
            event_location = (1400, 750)
            event_text_color = (0, 137, 0)
            event_font = ImageFont.truetype("timr45w.ttf", 40)
            d.text(event_location, event, fill=event_text_color, font=event_font)

            # Save the certificate as PDF
            certificate_filename = f"certificate_{name}.pdf"
            im.save(certificate_filename)

            # Attach the certificate to the email
            with open(certificate_filename, "rb") as f:
                attachment = MIMEApplication(f.read(), _subtype="pdf")
                attachment.add_header('Content-Disposition', 'attachment', filename=certificate_filename)
                msg.attach(attachment)

            # Send the email
            try:
                with smtplib.SMTP(smtp_server, smtp_port) as server:
                    server.starttls()
                    server.login(smtp_username, smtp_password)
                    server.sendmail(smtp_username, email, msg.as_string())
            except Exception as e:
                cursor.close()
                connection.close()
                return f"Error sending email to {email}: {str(e)}"

            # Update the participant's certificate status in the database
            try:
                update_query = "UPDATE participants SET certi = %s WHERE fullname = %s AND email = %s"
                cursor.execute(update_query, ('yes', name, email))
                connection.commit()
            except Exception as e:
                cursor.close()
                connection.close()
                return f"Error updating participant '{name}': {str(e)}"

            # Remove the certificate file
            os.remove(certificate_filename)

    except Exception as e:
        return f"Error: {str(e)}"

    # Close the cursor and database connection
    cursor.close()
    connection.close()

    return "Certificate(s) sent successfully We've dispatched them to your registered email address. Please check your inbox, and if you don't see them there, don't forget to look in your spam or junk folder. If you still encounter any issues, feel free to reach out to us for assistance.\n\nOnce again, congratulations on your achievement! "
result = send_certificate()
print(result)