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
#emails =    api_client.query_api_get("emails", {"filter": "unextracted-ship"}, "json", 100)
emails =    api_client.query_api_get_unextractedship(str(200))
emaildata = json.loads(emails._content.decode('ascii'))



def contains_number(s):
    return any(i.isdigit() for i in s)

def is_sensible_prediction(fieldname, fieldvalue):
    #Eliminate all "------------" only immediately.
    if (len(fieldvalue.replace("-", "")) < 2):
        return False

    fieldvalue = fieldvalue.lower()
    numbers = sum(c.isdigit() for c in fieldvalue)
    chars = sum(c.isalpha() for c in fieldvalue)

    if fieldname == "Ship":
        if len(fieldvalue) < 4:
            return False
    #    if numbers > 4:
    #        return False
    #    if chars < 3:
    #        return False
    if fieldname == "Loading_Place":
        if fieldvalue == "spot":
            return False
        if fieldvalue == "ppt":
            return False
        if fieldvalue == "ada":
            return False
    if fieldname == "Open_Date":
        if len(fieldvalue) < 3:
            return False
    if fieldname == "DWT":
        if len(fieldvalue) > 12:
            return False
    if fieldname == "Year":
        if numbers > 4 and numbers < 8:
            return False
        if numbers > 8:
            return False
        if numbers < 2:
            return False
        if chars > 3:
            return False
    return True

#Basic cleaning of unwanted characters to circumvent encoding error somewhere in the system.
def clean_field(fieldname, fieldvalue):
    fieldvalue = fieldvalue.replace("=3D", "")
    fieldvalue = fieldvalue.replace("=20", "")
    fieldvalue = fieldvalue.replace("=A0", "")
    fieldvalue = fieldvalue.replace("&quot;", "")
    return fieldvalue

def is_sensible_entity(entity):
    #Definition of rules for usefulness
    #Ship_Name or Load_Place have to be set
    if not (("Ship" in entity) or ("Loading_Place" in entity) or ("Open_Date" in entity)):
 ##       print(entity)
 ##       print("###################### Above entity does not contain sufficient information.")
        return False

    #Every Entity needs to have at least 2 fields filled
    if len(entity) < 4:
 ##       print("###################### Above entity is too short. It has a length of: " + str(len(entity)))
        return False
    return True


def store_cargo_in_db(cargo):
 ##   print("--------------------------------------- ORIGINAL SHIP")
 ##   print(cargo)
    db_cargo = {}
    if "Ship" in cargo:
        db_cargo["ship_name"] = cargo["Ship"]
    if "Loading_Place" in cargo:
        db_cargo["loading_place"] = cargo["Loading_Place"]
    if "DWT" in cargo:
        db_cargo["ship_dwt"] = cargo["DWT"]
    if "Year" in cargo:
        db_cargo["ship_year"] = cargo["Year"]
    if "Open_Date" in cargo:
        db_cargo["open_date"] = cargo["Open_Date"]
    if "Destination" in cargo:
           db_cargo["destination"] = cargo["Destination"]
    if "emailID" in cargo:
        db_cargo["emailID"] = str(cargo["emailID"])
    #print("==========================================")
 ##   print("This object will be sent to db:")
 ##   print(db_cargo)
    res6 = api_client.query_api_put("shipofferextracted", db_cargo)
    if res6.status_code != 200:
  ##      print(res6.status_code)
  ##      print("cargo_offer from " + db_cargo["emailID"] + " could not be inserted. Please try again.")
  ##      print(db_cargo)
 ##   print("API RESPONSE: ")
 ##   print(res6._content)

#Extract from Emails using the Model
extracted_cargoes = []
for email in emaildata:
    prediction = ""
    try:
        if len(email["body"]) < 20:
            #Nothing to predict
 ##           print("THERE IS NOTHING TO PREDICT IN THIS EMAIL:")
 ##           print(email)
            continue
        # Get the prediction
        prediction = model.predict_text(email["body"], vocab_tags, processing_word)
    except:
 ##       print("Unexpected error:" + str(sys.exc_info()[0]))
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
                if prediction_field in ["Ship", "Loading_Place"]:
                    # Create a new entity
                    current_entity["emailID"] = email["emailID"]
                    all_predictions.append(current_entity)
                    #print("Finished entity (early): ================================================")
                    #print(current_entity)
                    current_entity = {}

            fieldvalue = clean_field(prediction_field, fieldvalue)
            if is_sensible_prediction(prediction_field, fieldvalue):
                #print("Finished field " + prediction_field + ": " + fieldvalue)
                if prediction_field in current_entity: #if the doubling occurs here, we have to check whether an override makes sense
                    if len(fieldvalue) > len(current_entity[prediction_field]):
                        #print("Overriding previous " + prediction_field + " of value '" + current_entity[prediction_field] + " with " + fieldvalue)
                        current_entity[prediction_field] = fieldvalue

                else:
                    #Default Case
                    current_entity[prediction_field] = fieldvalue
            #else:
                #print("Finished field " + prediction_field + " marked as non-useful: " + fieldvalue)
            continue
        else:
            continueindex = continueindex + 1

    #Save the last entity
    current_entity["emailID"] = email["emailID"]
    all_predictions.append(current_entity)
    #print("Finished entity: ==================")
    #print(current_entity)

    #Try to merge and check sensibility of entire cargo entity

    #Try to merge
    lastentity = {}
    merged_predictions = []
    merge_occurred = 0
    #count_before = str(len(all_predictions))
    #state_before = all_predictions

    for entity in all_predictions:
        if not lastentity == {} and "Ship" in lastentity and "Ship" in entity:
            if entity["Ship"] == lastentity["Ship"]:
                merge_occurred = 1
  ##              print("INSTITUTE A MERGER ------------------------------------------------")
  ##              print("LASTENTITY")
  ##              print(lastentity)
  ##              print("ENTITY")
  ##              print(entity)
                lastentity = dict(entity, **lastentity)
                merged_predictions.append(lastentity)
  ##              print(lastentity)
                lastentity = {}
                continue
        if not lastentity == {}:
            merged_predictions.append(lastentity)
        lastentity = entity
    if not lastentity == {}:
        merged_predictions.append(all_predictions[-1:])
    all_predictions = merged_predictions
    #if merge_occurred == 1:
    #    print("COUNT BEFORE MERGE: " + count_before)
    #    print(state_before)
    #    print("COUNT AFTER MERGE: " + str(len(all_predictions)))
    #    print(all_predictions)
    #    exit()
    #if not count_before == str(len(all_predictions)):
    #    print("COUNT UNEQUAL WITHOUT MERGE")
    #    print("COUNT BEFORE MERGE: " + count_before)
    #    print(state_before)
    #    print("COUNT AFTER MERGE: " + str(len(all_predictions)))
    #    print(all_predictions)
    #    exit()

    #@TODO: Try to extend the data using dictionary search

    #Store all in database if sensible
    for entity in all_predictions:
 ##       print(entity)
        if type(entity) is list:
            entity = entity[0]
        if is_sensible_entity(entity):
            store_cargo_in_db(entity)

    #Append
    #extracted_cargoes.extend(all_predictions)

#print(extracted_cargoes)


