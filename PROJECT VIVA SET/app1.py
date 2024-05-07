from flask import Flask, request, render_template
import pymysql

app = Flask(__name__)

@app.route('/')
def index():
    return render_template('just.html')

@app.route('/submit_form', methods=['POST'])
def submit_form():
    # Get form data
    name = request.form['name']
    email = request.form['email']
    gender = request.form['gender']
    age = request.form['age']
    duration_effect = request.form['duration_effect']
    Drug_name = request.form['Drug_name']
    severity_effect = request.form['severity_effect']
    Drug_quantity = request.form['Drug_quantity']
    side_effects = request.form['side_effects']
    Other_medication = request.form['Other_medication']
    Medical_history = request.form['Medical_history']
    RESULT = request.form['RESULT']

    # Connect to MySQL database
    connection = pymysql.connect(host='localhost',
                                 user='username',
                                 password='',
                                 database='test',
                                 cursorclass=pymysql.cursors.DictCursor)

    try:
        # Execute SQL query to insert data
        with connection.cursor() as cursor:
            sql = """INSERT INTO patient_details 
                     (name, email, age, gender, Drug_name, Drug_quantity, side_effects, severity_effect, duration_effect, Other_medication, Medical_history, RESULT) 
                     VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)"""
            cursor.execute(sql, (name, email, gender, age, duration_effect, Drug_name, severity_effect, Drug_quantity, side_effects, Other_medication, Medical_history, RESULT))
        
        # Commit the transaction
        connection.commit()
    finally:
        # Close the connection
        connection.close()

    return 'Data submitted successfully!'

if __name__ == '__main__':
    app.run(debug=True)
