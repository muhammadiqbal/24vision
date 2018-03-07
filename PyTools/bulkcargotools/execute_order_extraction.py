import api.api_client as api_client
from extraction.sequence_tagging.data_utils import get_trimmed_glove_vectors, load_vocab, \
    get_processing_word, EmailDataset
from extraction.sequence_tagging.general_utils import get_logger
from extraction.sequence_tagging.model import NERModel
import numpy as np
import os
import tensorflow as tf
import json
import sys
from extraction.sequence_tagging.config import config
#import extraction.search_extractor

#Load TensorFlow Model
# directory for training outputs
if not os.path.exists(config.output_path):
    os.makedirs(config.output_path)

# load vocabs
vocab_words = load_vocab(config.words_filename)
vocab_tags = load_vocab(config.tags_filename)
vocab_chars = load_vocab(config.chars_filename)

# get processing functions
processing_word = get_processing_word(vocab_words, vocab_chars,
                                      lowercase=config.lowercase, chars=config.chars)
processing_tag = get_processing_word(vocab_tags, lowercase=False)

# get pre trained embeddings
embeddings = get_trimmed_glove_vectors(config.trimmed_filename)

# get logger
logger = get_logger(config.log_path)

# build model
model = NERModel(config, embeddings, ntags=len(vocab_tags),
                 nchars=len(vocab_chars), logger=logger)
model.build()

#Load Emails
emails =    api_client.query_api_get_unextractedcargo(str(100))
emaildata = json.loads(emails._content.decode('ascii'))

def contains_number(s):
    return any(i.isdigit() for i in s)

#Cleaning of a few unwanted characters to circumvent an encoding error somewhere in the system.
def clean_field(fieldname, fieldvalue):
    fieldvalue = fieldvalue.replace("=3D", "")
    fieldvalue = fieldvalue.replace("=20", "")
    fieldvalue = fieldvalue.replace("=A0", "")
    fieldvalue = fieldvalue.replace("&quot;", "")
    return fieldvalue

#Basic sensibility checks of a value based on the fieldname
def is_sensible_prediction(fieldname, fieldvalue):
    if fieldname == "Laycan":
        if len(fieldvalue) < 4:
            #print(fieldvalue + " is not really a " + fieldname)
            return False
    if fieldname == "Size":
        if fieldvalue.count("/") == 2 and fieldvalue.count(":") > 0:
            return False #It's a date
    if fieldname == "Commission":
        if not contains_number(fieldvalue):
            #print(fieldvalue + " is not really a " + fieldname)
            return False
        if fieldvalue.isdigit():
            if float(fieldvalue) > 10:
                #print(fieldvalue + " is not really a " + fieldname)
                return False
    return True

def is_sensible_entity(entity):
    #Definition of rules for usefulness
    #ship_size, delivery location or laycan have to be set
    #if not ("ship_size" in entity or "delivery_location" in entity or "laycan" in entity):
        #print(entity)
        #print("###################### Above entity does not contain sufficient information.")
    #    return False

    #Every Entity needs to have at least 3 fields filled

    if len(entity) < 4:
##        print("###################### Above entity is too short.")
        return False
    return True


def store_cargo_in_db(cargo):
    db_cargo = {}
##    print("This object planned for db:")
##    print(cargo)
    if "Intended_Cargo" in cargo:
        db_cargo["cargo"] = cargo["Intended_Cargo"]
    if "Delivery_Location" in cargo:
        db_cargo["delivery_location"] = cargo["Delivery_Location"]
    if "Redelivery_Location" in cargo:
        db_cargo["redelivery_location"] = cargo["Redelivery_Location"]
    if "Cranes" in cargo:
        db_cargo["ship_cranes"] = cargo["Cranes"]
    if "Employment" in cargo:
        db_cargo["employment"] = cargo["Employment"]
    if "Type_Of_Ship" in cargo:
        db_cargo["ship_type"] = cargo["Type_Of_Ship"]
    if "Duration" in cargo:
        db_cargo["duration"] = cargo["Duration"]
    if "Laycan" in cargo:
        db_cargo["laycan"] = cargo["Laycan"]
    if "Commission" in cargo:
        db_cargo["commission"] = cargo["Commission"]
    if "Size" in cargo:
        db_cargo["ship_size"] = cargo["Size"]
    if "Account" in cargo:
        db_cargo["account_name"] = cargo["Account"]
    if "emailID" in cargo:
        db_cargo["emailID"] = str(cargo["emailID"])
##   print("==========================================")
##    print("This object will be sent to db:")
##    print(db_cargo)
    res6 = api_client.query_api_put("shiporderextracted", db_cargo)
    if res6.status_code != 200:
##        print(res6.status_code)
##        print("cargo_offer from " + db_cargo["emailID"] + " could not be inserted. Please try again.")
##        print(db_cargo)

#Extract from Emails using the Model
extracted_cargoes = []
fuzzy_counter = 0
entity_counter = 0
for email in emaildata:
    prediction = ""
    try:
        # Get the prediction
        prediction = model.predict_text(email["body"], vocab_tags, processing_word)
    except:
##        print("An Error occurred. - Updated")
        continue

    # Parse the prediction
    all_predictions = []
    current_entity = {}
    current_entity_text = "" #Collect entire text of one entity
    prediction_content = "" #Variable used to track multi-word predictions
    prediction_fieldname = ""

    continueindex = 0
    for index, item in enumerate(prediction[:(len(prediction)-8)]):
        if (continueindex > index):
            #print("Skipping Index " + str(index))
            continue

        ele_word = item
        word = ele_word[0]
        pred = ele_word[1]

        if pred != "O":
            #Start search for that field's content
            prediction_field = pred[2:]
            fieldvalue = ""

            for i in range(index, index+8):
                if len(prediction[i][1]) > 2 and prediction[i][1][2:] == prediction_field:
                    #print("Adding " + prediction[i][0] + " to " + fieldvalue + " [" + prediction_field + "]")
                    fieldvalue = fieldvalue + " " + prediction[i][0]
                    continueindex = i+1
                else:
                    if prediction[i][1] != "O":
                        #Chain was interrupted, save value and set continueindex to this
                        continueindex = i
                        break
            if prediction_field in current_entity:
                #A new entity can only begin with Cargo or Load Port
                if prediction_field in ["Cargo", "Ship_Size", "Delivery_Location"]:
                    # Create a new entity
                    current_entity["emailID"] = email["emailID"]
                    all_predictions.append(current_entity)
##                    print("Finished entity (early): ================================================")
##                    print(current_entity)
                    current_entity = {}

            fieldvalue = clean_field(prediction_field, fieldvalue)
            if is_sensible_prediction(prediction_field, fieldvalue):
                #print("Finished field " + prediction_field + ": " + fieldvalue)
                if prediction_field in current_entity: #if the doubling occurs here, we have to check whether an override makes sense
                    if len(fieldvalue) > len(current_entity[prediction_field]):
##                        print("Overriding previous " + prediction_field + " of value '" + current_entity[prediction_field] + " with " + fieldvalue)
                        current_entity[prediction_field] = fieldvalue

                else:
                    #Default Case
                    current_entity[prediction_field] = fieldvalue
            else:
 ##               print("Finished field " + prediction_field + " marked as non-useful: " + fieldvalue)
            continue
        else:
            continueindex = continueindex + 1

    #Save the last entity
    current_entity["emailID"] = email["emailID"]
    all_predictions.append(current_entity)
##    print("Finished entity: ==================")
##    print(current_entity)

    #Store all in database if sensible
    for entity in all_predictions:
##        print(entity)
        if type(entity) is list:
            entity = entity[0]
        if is_sensible_entity(entity):
            store_cargo_in_db(entity)

    #Append
    #extracted_cargoes.extend(all_predictions)

#print(extracted_cargoes)


