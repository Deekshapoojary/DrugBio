import pandas as pd
from sklearn.feature_extraction.text import TfidfVectorizer
from sklearn.decomposition import TruncatedSVD
from sklearn.ensemble import RandomForestClassifier
import joblib
import cgi
import cgitb
import sys
import requests

# Enable CGI error reporting for debugging
cgitb.enable()

# Load data with specified dtype for column 18
data = pd.read_csv("Dataset.csv", dtype={18: str})

# Define the numerical values for adverse effects
adverse_effects_danger = {
    'mood swings': 1.6,
    'irritability': 0.5,
    'loss of appetite': 0.7,
    'coughing': 0.5,
    'weight gain': 0.6,
    'hair loss': 0.8,
    'kidney failure': 3.9,
    'changes in appetite': 1.4,
    'rash': 0.9,
    'low blood pressure': 0.9,
    'seizures': 3.8,
    'shortness of breath': 1.7,
    'severe bleeding (hemorrhage)': 4.9,
    'irregular heartbeat (arrhythmia)': 2.8,
    'diarrhea': 1.5,
    'fatigue': 1.6,
    'confusion': 0.9,
    'hallucinations': 2.8,
    'bleeding': 3.6,
    'severe allergic reactions (anaphylaxis)': 2.7,
    'allergic reaction': 1.0,
    'tremors': 0.9,
    'tingling sensations': 0.5,
    'heart attack': 5.9,
    'joint pain': 1.5,
    'anxiety': 2.6,
    'abdominal pain': 3.5,
    'blurred vision': 1.6,
    'Nausea': 1.4,
    'nausea': 1.4,
    'insomnia': 0.5,
    'weight loss': 1.6,
    'suicidal thoughts or behaviors': 4.8,
    'suicidal behavior': 5.0,
    'suicidal thoughts': 4.9,
    'dizziness': 1.5,
    'dizzy': 1.5,
    'death': 7.0,
    'drowsiness': 0.7,
    'muscle weakness': 1.6,
    'liver toxicity': 1.8,
    'vomiting': 2.5,
    'vommitting': 2.5,
    'vomitting': 2.5,
    'dry mouth': 0.8,
    'numbness': 1.4,
    'stroke': 4.9,
    'fainting': 2.7,
    'high blood pressure': 1.7,
    'constipation': 1.4,
    'bruising': 1.4,
    'chest pain': 0.7,
    'heart pain': 0.7,
    'increased heart rate': 1.6,
    'difficulty breathing': 1.1,
    'palpitations': 1.1,
    'sweating': 1.0,
    'headache': 0.5
    # Add other adverse effects and their danger levels here
}

# Get form data
form = cgi.FieldStorage()
side_effects_str = form.getvalue('side_effects')

# Process the input side effects
user_side_effects = [effect.strip() for effect in side_effects_str.split(',')]  # Split by commas and remove extra spaces

# Preprocessing data
if 'SIDE_EFFECTS' in data.columns and 'adverse_effects' in data.columns:
    data = data.dropna(subset=['SIDE_EFFECTS', 'adverse_effects'])  # Drop rows with NaN in SIDE_EFFECTS and adverse_effects
    data['SIDE_EFFECTS'] = data['SIDE_EFFECTS'].astype(str)
    data['adverse_effects'] = data['adverse_effects'].astype(str)

    # TF-IDF Vectorization for SIDE_EFFECTS
    tfidf_vectorizer_side = TfidfVectorizer(stop_words='english', max_features=5000)
    X_tfidf_side = tfidf_vectorizer_side.fit_transform(data['SIDE_EFFECTS'].apply(lambda x: " ".join(x.split())))  # Split by spaces

    # Dimensionality Reduction using TruncatedSVD for SIDE_EFFECTS
    svd_side = TruncatedSVD(n_components=min(X_tfidf_side.shape[1], 100))  # Ensure number of components <= number of features
    X_tfidf_svd_side = svd_side.fit_transform(X_tfidf_side)

    # Train the model
    model_side = RandomForestClassifier()
    model_side.fit(X_tfidf_svd_side, data['SIDE_EFFECTS'])

    # Split adverse effects from the dataset into individual effects
    adverse_effects_set = set()
    for adverse_effect in data['adverse_effects']:
        adverse_effects_set.update(effect.strip() for effect in adverse_effect.split(","))

    # Identify common side effects and adverse effects
    adverse_effects = set(user_side_effects) & adverse_effects_set
    common_side_effects = set(user_side_effects) - adverse_effects

    # Calculate the total danger level for user's side effects
    total_danger_level = sum(adverse_effects_danger.get(effect, 0) for effect in user_side_effects)

    # Determine if the drug has adverse effects based on the total danger level
    if total_danger_level >= 5:
        output_data = "The combination of reported side effects suggests potential health risks associated with this drug. It is strongly advised to consult with a medical professional for further evaluation and guidance."
    elif total_danger_level > 0:
        output_data = "The reported side effects are minor and transient, indicating that they are unlikely to persist or pose any significant health concerns. It is anticipated that these effects will resolve shortly without any lasting consequences."
    else:
        output_data = "The drug you have taken is unlikely to have adverse effects."

    # Save the model
    joblib.dump(model_side, 'drug_side_effects_model.pkl')
else:
    output_data = "The required columns 'SIDE_EFFECTS' and 'adverse_effects' do not exist in the dataset."

# Define the URL of the PHP script
url = 'http://localhost/final prjct/NEW UI/result.php'

# Send the POST request with the output data
response = requests.post(url, data={'output_data': output_data})

# Print the response
print(response.text)
