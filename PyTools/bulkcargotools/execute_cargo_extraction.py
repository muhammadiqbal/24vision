import api.api_client as api_client
from extraction.sequence_tagging.data_utils import get_trimmed_glove_vectors, load_vocab, \
    get_processing_word, EmailDataset
from extraction.sequence_tagging.general_utils import get_logger
from extraction.sequence_tagging.model import NERModel
#Library for numbers
import numpy as np
import os
#machine learning
import tensorflow as tf
os.environ['TF_CPP_MIN_LOG_LEVEL'] = '3'
#FuzzyLogic
import fuzzywuzzy
from fuzzywuzzy import fuzz
from fuzzywuzzy import process
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
logger.disabled = True
# build model
model = NERModel(config, embeddings, ntags=len(vocab_tags),
                 nchars=len(vocab_chars), logger=logger)
model.build()

#Load Emails
emails =    api_client.query_api_get_unextractedcargo(str(10000))
emaildata = json.loads(emails._content.decode('utf-8'))
#print(json.dumps(emaildata))

#Set Data for Fuzzy Search
cargo_list_raw=["CAN", "alumina", "calcines", "Corn glutten feed in meal", "Ammonium Sulphate", "Stone chips", "Corn", "Kaolin clay", "Wheat flour", "steel coils", "pipes", "clay", "soda feldspar", "copper slag", "granite blocks", "solid pitch", "perlite", "sulphur", "Nitro Phosphatic Kompound", "ammonium nitrate", "UREA", "BHF", "ferts", "zn calcines", "coke", "sso rock phosphate", "Calcined pet coke", "bentonite",  "aluminium",  "mop", "sugar", "rock phosphate", "harmless fertilizer", "hles fert", "calcinit", "urea", "amidas", "axan", "coal", "cement", "zn concs", "nitrabor", "aggregate", "wheat", "sun flower seed", "copper", "minerals", "sodium sulph", "marble", "Anthracite coal", "profils", "slab", "steel", "scrap", "cable reels", "timber", "plywood", "white lime stone", "bauxite", "manganese ore", "clinker", "chromite", "malt", "agriproducts", "rebars", "Soybean meal", "tapioca chips", "BGD", "rice", "gypsum", "sbm", "sbp", "CGO SLINGED", "cement in jumbo", "molco HR slabs", "kaolin", "molasses", "stlpipes", "cu concs", "agri", "soda feldspar", "mthanol reactor", "marble blocks", "BDMT woodchips", "coli", "steel billets"]
cargo_list = [x.lower() for x in cargo_list_raw]

cargo_type_raw=["bulk", "blk", "OO", "chopt", "BGD", "pct", "molchopt", "in bulk", "big bags", "bagged"]
cargo_type = [x.lower() for x in cargo_type_raw]

terms_list_raw= ['UU', 'FHEX', 'FSHINC','FHINC', 'SATSHEX', 'SATSHINC', 'SSHEX', 'SSHINC', 'SATSHEX', 'SATSHINC', 'SHEX', 'SHEXEIU', 'SHEXUU', 'SHINC', 'Shinc', 'SHIX', 'W.W.D.SHEX', 'W.W.D.SHINC', 'WWD', 'ATDNSHINC', 'TTL DAYS', 'ttl days', 'PWWD']
terms_list = [x.lower() for x in terms_list_raw]

#Fuzzy search for cargos
def fuzzysearch_cargos (text):

    dictlist = text.split()
    fuzzy_cargo = []
    for value in dictlist:
        for cargo in cargo_list:
            if (fuzz.QRatio(value, cargo))>=95:
                if len(value) > 2 and not value in fuzzy_cargo:
                    #fuzzy_cargo.append(value)
                    return value
    #return(fuzzy_cargo)
    return []

#Fuzzy search for terms
def fuzzysearch_terms (text):
    dictlist = text.split()
    fuzzy_term = []
    for value in dictlist:
        for term in terms_list:
            if (fuzz.QRatio(value, term))>=95:
                if len(value) > 2 and not value in fuzzy_term:
                    return value
                    #fuzzy_term.append(value)
    return []
    #return(fuzzy_term)

def contains_number(s):
    return any(i.isdigit() for i in s)

def clean_field(fieldname, fieldvalue):
    fieldvalue = fieldvalue.replace("=3D", "")
    fieldvalue = fieldvalue.replace("=20", "")
    fieldvalue = fieldvalue.replace("=A0", "")
    fieldvalue = fieldvalue.replace("&quot;", "")
    return fieldvalue

#This function offers basic, heuristic sensibility checks for fields and is later used to test prediction results.
def is_sensible_prediction(fieldname, fieldvalue):
    #General Checks
    if len(fieldvalue) < 2:
##        print(fieldvalue + " is too short.")
        return False
    if "https://" in fieldvalue:
        return False
    if "http://" in fieldvalue:
        return False
    if "tel:" in fieldvalue:
        return False
    if "@" in fieldvalue:
        return False

    #Field-Specific Checks
    numbers = sum(c.isdigit() for c in fieldvalue)
    chars = sum(c.isalpha() for c in fieldvalue)
    fieldvalue = fieldvalue.lower()
    #spaces = sum(c.isspace() for c in fieldvalue)

    if fieldname == "Laycan":
        if len(fieldvalue) < 3:
            #print(fieldvalue + " is not really a " + fieldname)
            return False
        if " lot" in fieldvalue:
            return False
    if fieldname == "Cargo":
        if len(fieldvalue) > 11 and " " not in fieldvalue:
            return False
        if len(fieldvalue) < 6:
##            print(fieldvalue + " is too short")
            return False
        if "=" in fieldvalue:
##            print(fieldvalue + " contains a '='")
            return False
        if len(fieldvalue) == numbers:
##            print(fieldvalue + " is only numbers.")
            return False

    if fieldname == "Terms":
        if len(fieldvalue) < 2:
##            print(fieldvalue + " is too short.")
            return False
    if fieldname == "Commission":
        if chars < 2:
            return False
        if not contains_number(fieldvalue):
            #print(fieldvalue + " is not really a " + fieldname)
            return False
        if fieldvalue.isdigit():
            if float(fieldvalue) > 10:
                #print(fieldvalue + " is not really a " + fieldname)
                return False
    if fieldname in ["Load_Place", "Disch_Place"]:
        if "skype" in fieldvalue:
            return False
        if numbers > 1:
            return False
    return True

# Basic sensibility checks for an entire extracted entity
def is_sensible_entity(entity):
    try:
        del entity['Quantity']
        del entity['Port_No']
        del entity['Commodity']
    except KeyError:
        pass
    if "Cargo" in entity:
	#Here a ) was wrong: len(entity["Cargo"] > 15)
        if len(entity["Cargo"]) > 15:
            return True
    #Definition of rules for usefulness
    #Either Cargo, Load Place or Disch Place have to be set
    if not ("Cargo" in entity or "Load_Place" in entity or "Disch_Place" in entity):
        #print(entity)
##        print("###################### Above entity does not contain sufficient information.") 
        return False

    #Every Entity needs to have at least 3 fields filled
    if len(entity) < 4:
##        print("###################### Above entity is too short.")
        return False
    return True

#Function that stores an extracted entity in the database
def store_cargo_in_db(cargo):
    db_cargo = {}
    if "Cargo" in cargo:
        db_cargo["cargo"] = cargo["Cargo"]
    if "Load_Place" in cargo:
        db_cargo["load_place"] = cargo["Load_Place"]
    if "Disch_Place" in cargo:
        db_cargo["disch_place"] = cargo["Disch_Place"]
    if "Terms" in cargo:
        db_cargo["terms"] = cargo["Terms"]
    if "Laycan" in cargo:
        db_cargo["laycan"] = cargo["Laycan"]
    if "Commission" in cargo:
        db_cargo["commission"] = cargo["Commission"]
    if "emailID" in cargo:
        db_cargo["emailID"] = str(cargo["emailID"])
    #print("==========================================")
    #print("This object will be sent to db:")
    #print(db_cargo)
    res6 = api_client.query_api_post("cargoofferextracted", db_cargo)
    if res6.status_code != 200:
       print(res6.status_code)
       print("cargo_offer from " + db_cargo["emailID"] + " could not be inserted. Please try again.")
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
#        print("An Error occurred.")
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
                if prediction_field in ["Cargo", "Load_Port"]:
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
 ##                       print("Overriding previous " + prediction_field + " of value '" + current_entity[prediction_field] + " with " + fieldvalue)
                        current_entity[prediction_field] = fieldvalue

                else:
                    #Default Case
                    current_entity[prediction_field] = fieldvalue
 #           else:
 #               print("Finished field " + prediction_field + " marked as non-useful: " + fieldvalue)
            continue
        else:
            continueindex = continueindex + 1

    #Save the last entity
    current_entity["emailID"] = email["emailID"]
    all_predictions.append(current_entity)
#    print("Finished entity: ==================")
##    print(current_entity)

    #Try to merge and check sensibility of entire cargo entity

    #@TODO: Try to extend the data using dictionary search
    #Fuzzy Cargo
    for entity in all_predictions:
        if "text" in entity:
            if not "Cargo" in entity:
                fuzzy_cargo = fuzzysearch_cargos(entity["text"].lower())
                if not fuzzy_cargo == []:
                    entity["Cargo"] = fuzzy_cargo
##                    print("Found Fuzzy_cargo: ##################################")
##                    print(fuzzy_cargo)
                    fuzzy_counter = fuzzy_counter + 1
            if not "Terms" in entity:
                fuzzy_terms = fuzzysearch_terms(entity["text"].lower())
                if not fuzzy_terms == []:
                    entity["Terms"] = fuzzy_terms
##                    print("Found Fuzzy_terms: ####################################")
##                    print(fuzzy_terms)
                    fuzzy_counter = fuzzy_counter + 1
 #       else:
 #           print("Entity has no text.")		
			
    #Store all in database if sensible
    for entity in all_predictions:
##        print(entity)
        if type(entity) is list:
            entity = entity[0]
        if is_sensible_entity(entity):
 #           print("ABOVE ENTITY MAKES SENSE")
            entity_counter = entity_counter + 1
            store_cargo_in_db(entity)
  ##      else:
##            print("ABOVE ENTITY IS DISCARDED !!!!!!!!!!!!!!!!!!!!!") #Should happen rarely and only on really sh**ty results.

    #Append
    #extracted_cargoes.extend(all_predictions)

#print(extracted_cargoes)
##print("Fuzzy_counter: ")
##print(fuzzy_counter)


