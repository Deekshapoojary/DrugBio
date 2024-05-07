from flask import Flask, render_template, request, redirect, url_for
import joblib
import json
from fuzzywuzzy import fuzz

app = Flask(__name__, template_folder=r'C:\xampp\htdocs\final prjct\NEW UI')

# Load the model
model_side, model, combined_side_effects=(joblib.load('xampp/htdocs/final prjct/drug_side_effects_model.pkl'))


# Define age-specific thresholds for adverse effects
age_thresholds = {
    '8': {
        'seizures': 2.0,
        'hallucinations': 1.0,
        # Define thresholds for other adverse effects for this age group
    },
    '8-18': {
        'seizures': 3.0,
        'hallucinations': 1.5,
        # Define thresholds for other adverse effects for this age group
    },
    # Define thresholds for other age groups as needed
}

# Define messages for different age groups
age_message = {
    '0-2': "During this critical developmental stage, any atypical symptoms should be promptly brought to the attention of a healthcare provider for thorough evaluation and intervention.",
    '3-7': "For children in this age, any unexpected reactions should be promptly reported to a pediatrician for comprehensive assessment and appropriate management.",
    '8-12': "Considering your age group, any unusual symptoms should be communicated with a parent or guardian, and seeking medical advice is strongly advised for proper evaluation and care.",
    '13-18': "While experiencing side effects during adolescence is not uncommon, it's imperative to inform a parent or guardian and seek prompt medical attention if symptoms persist or exacerbate.",
    '19-30': "Encountering side effects can be concerning, especially during this pivotal stage of adulthood. It's crucial to consult with a healthcare provider for diligent assessment and management.",
    '31-50': "f you're encountering side effects, it's vital to address them promptly with a healthcare provider to ensure thorough evaluation and effective management.",
    '51-70': "Given your age, any unusual symptoms should be discussed with a healthcare provider to effectively rule out any underlying health conditions and ensure comprehensive care.",
    '71+': "During this stage of life, any unexpected side effects should be promptly reported to a healthcare provider for thorough assessment and comprehensive management."
    # Define messages for other age groups as needed
}

model_side_effects = combined_side_effects


def check_common_side_effects(user_input, model):
    common_side_effects = set()
    model_side_effects = combined_side_effects
    for side_effect in user_input:
        # Fuzzy match each user input side effect with the side effects stored in the model
        for side_effect in model_side_effects:
            # Adjust the threshold as needed
            if fuzz.partial_ratio(side_effect.lower(), side_effect.lower()) >= 98:
                common_side_effects.add(side_effect)
    return common_side_effects


@app.route('/', methods=['GET', 'POST'])
def home():
    result_string=None
    if request.method == "POST":
        # Extracting input data from the form
        name = request.form.get('name')
        email = request.form.get('email')
        side_effects = request.form.get('side_effects')
        user_age = int(request.form.get('age'))
        user_symptom_duration = int(request.form.get('duration_effect')) if request.form.get('duration_effect') else None
        user_input_condition = request.form.get('Medical_history').lower()
        Other_medication = request.form.get('Other_medication')
        Medical_history = request.form.get('Medical_history')
        Gender = request.form.get('gender')
        drug_name = request.form.get('Drug_name')
        drug_quantity = request.form.get('Drug_quantity')
        severity_effect = request.form.get('severity_effect')
 
        # Combining side_effects into a single string separated by commas
        print("Original side_effects:", side_effects)
        if ', ' or ', ' or '' in side_effects:
            user_input = str(side_effects).split(",")
        else:
            user_input = [side_effects]
        print("Processed user_input:", user_input)

        adverse_effects_danger = model_side.adverse_effects_danger

        print(adverse_effects_danger)
        
        # Identify common side effects
        common_side_effects = check_common_side_effects(user_input, model_side_effects)
        adverse_effects = set(user_input) & set(adverse_effects_danger.keys())

        
        adverse_effects_set = model_side.adverse_effects

        side_effects_ouput = common_side_effects - adverse_effects
        
        if common_side_effects:
            print("Common side effects:", side_effects_ouput)
        else:
            print("No common side effects were reported.")

        if adverse_effects:
                    print("Adverse effects:", adverse_effects)
                    print("Adverse effects danger levels:")
                    for effect in adverse_effects:
                        print(f"{effect}: {adverse_effects_danger.get(effect, 0)}")
        else:
            print("No adverse effects were reported.")

        # Adjust danger levels based on age-specific thresholds
        if str(user_age) in age_thresholds:
            age_threshold_effects = age_thresholds[str(user_age)]
            for effect, threshold in age_threshold_effects.items():
                if effect in adverse_effects:
                    adverse_effects_danger[effect] = threshold


        if 0 <= user_age <= 2:
            age_message_key = '0-2'
        elif 3 <= user_age <= 7:
            age_message_key = '3-7'
        elif 8 <= user_age <= 12:
            age_message_key = '8-12'
        elif 13 <= user_age <= 18:
            age_message_key = '13-18'
        elif 19 <= user_age <= 30:
            age_message_key = '19-30'   
        elif 31 <= user_age <= 50:
            age_message_key = '31-50'
        elif 51 <= user_age <= 70:
            age_message_key = '51-70'
        else:
            age_message_key = '71+'


        # Calculate total danger level
        total_danger_level = sum(adverse_effects_danger.get(effect, 0) for effect in adverse_effects)

        if user_input_condition == "pregnancy":
            condition_result= "Pregnancy can alter the way drugs are metabolized and distributed in the body due to changes in hormone levels and physiological processes. Certain medications may pose risks to the developing fetus and require careful consideration."
        elif user_input_condition == "liver disease":
            condition_result= "Liver disease can impair the liver's ability to metabolize drugs, leading to accumulation of medications in the body and potential toxicity. Dosage adjustments may be necessary for individuals with liver impairment."
        elif user_input_condition == "kidney disease":
            condition_result= "Kidney disease can affect the elimination of drugs from the body, leading to potential drug accumulation and toxicity. Adjustments in drug dosage or frequency may be required for individuals with impaired kidney function."
        elif user_input_condition == "heart disease" or "heart disorder":
            condition_result= "Heart disease can impact blood flow and circulation, affecting the distribution of drugs throughout the body. Some medications may also interact with heart medications or exacerbate certain heart conditions."
        elif user_input_condition == "diabetes":
            condition_result= "Diabetes can affect drug metabolism and clearance, particularly for medications that are metabolized in the liver. Blood sugar levels may also be affected by certain medications used to treat diabetes."
        elif user_input_condition == "respiratory disease":
            condition_result= "Respiratory diseases such as asthma or chronic obstructive pulmonary disease (COPD) can affect how drugs are absorbed into the bloodstream, especially if administered via inhalation or oral routes."
        elif user_input_condition == "neurological disorder":
            condition_result= "Neurological disorders like epilepsy or Parkinson's disease may require specific medications that can interact with other drugs or have side effects that impact the individual's neurological condition."
        elif user_input_condition == "autoimmune disorder":
            condition_result= "Autoimmune disorders such as rheumatoid arthritis or lupus may require immunosuppressive medications that can increase the risk of infections or affect the body's response to other drugs."
        elif user_input_condition == "gastrointestinal disorder":
            condition_result= "Gastrointestinal disorders like inflammatory bowel disease or gastric ulcers can affect the absorption of medications taken orally. Additionally, some medications used to treat these conditions may interact with other drugs."
        elif user_input_condition == "psychiatric disorder":
            condition_result= "Psychiatric disorders may require medications that can have complex interactions with other drugs or it may have side effects that impact the individual's mental health. Close monitoring and adjustment of medication regimens may be necessary."
        elif user_input_condition == "depression":
            condition_result= "Depression can require specific medications such as antidepressants, which may have side effects or interactions with other drugs. It's essential to discuss any symptoms and treatment options with a healthcare provider."
        else:
            condition_result= "No relevant medical condition provided was provided."


        if user_symptom_duration > 7 and total_danger_level >= 0:
            symptomd_result= "The symptoms have persisted for more than a week. It is advisable to seek medical attention."
        elif user_symptom_duration < 7 and total_danger_level >=0:
            symptomd_result= "It seems like you're experiencing some adverse reactions, but since these symptoms have only been present for a short period, there's no need to worry excessively. However, it's always a good idea to seek medical attention to ensure your well-being."
        else:
            symptomd_result= "The symptoms have persisted for less than a week. Monitoring the symptoms and consulting with a healthcare professional if they worsen is recommended."

        print(f"Total danger level of adverse effects: {total_danger_level}")
                
        result = ""
                
        age_result=""

        # Determine if the drug has adverse effects based on the total danger level
        if total_danger_level >= 5:
            if age_message_key in age_message:
                age_result= age_message[age_message_key]
                result = "The combination of reported adverse effects suggests potential health risks associated with this drug. It is strongly advised to consult with a medical professional for further evaluation and guidance."
            else:
                print(" ")
        elif total_danger_level > 0:
             result = "The reported side effects are minor and transient, indicating that they are unlikely to persist or pose any significant health concerns, it is anticipated that these effects will resolve shortly without any lasting consequences."
        else:
            result = "The drug you have taken is unlikely to have adverse effects."

    else:
        result= "No side effect columns found in the dataset."

    # Construct final result
    Result = result, symptomd_result, condition_result, age_result

    result_string = ''.join(map(str, Result))


    return render_template('just.html', result_string=result_string, name=name, age=user_age, email=email, drug_name=drug_name, side_effects=side_effects, user_symptom_duration=user_symptom_duration, gender=Gender, severity_effect=severity_effect, drug_quantity=drug_quantity, user_input_condition=user_input_condition, Other_medication=Other_medication)

if __name__ == '__main__':
    app.run(debug=True)