import csv
import re
import datetime
import api.api_client as api_client
import json
import logging
import date_finder as date_finder
import list_searcher as list_searcher
import time

# set logging file name and format
logging.basicConfig(filename='data_cleaning.log', level=logging.DEBUG)
logging.basicConfig(format='%(levelname)s:%(message)s', level=logging.DEBUG)
# enable or disable logging
logger = logging.getLogger()
logger.disabled = True

# create console handler and set level to info
handler = logging.StreamHandler()
handler.setLevel(logging.DEBUG)
formatter = logging.Formatter("%(levelname)s - %(message)s")
handler.setFormatter(formatter)
logger.addHandler(handler)

now = datetime.datetime.time(datetime.datetime.now())
logging.info('Starting Data Cleaning Script at ' + str(now))

###PLEASE READ
###DATA CLEANING SCRIPT
## This script aims at producing processable data out of the data that was output by the extraction.
## It includes string search functions for ports for example and uses regular expressions to find the
## usable values for laycan, terms, commission and cargo. It imports date_finder.py for laycan.
## The logic that needs to be followed when adding new regular expression patterns is, that the
## "more complete" entries need to be searched first, since, for example, the laycan pattern
## dd/mm/yyyy is included in dd:dd/mm/yyyy: If the first was identified first, important information
## would be missed. However, this is very case-specific.
## The patterns are most likely not complete and more may need to be added. Sometimes information like
## for example the date from the mail is used to complete a value.
##
## The column-relevant functions are in the following order:
##      - commission
##      - terms
##      - cargo
##          - quantity
##          - type
## Ports are searched using the list_searcher.py, dates via the date_finder.py. The rest is in this script.
## Alternative files are provided in the cleaning_files folder.

## Define global variables
# emptyString, notFoundString, noSecondDate and noSensibleDate are just for debugging purposes
# in the final product, all should resolve to None
# standard string returned when nothing was extracted
# emptyString = "NONE EXTRACTED"
emptyString = None
# standard string returned when a value couldn't be found
# notFoundString = "NONE FOUND"
notFoundString = None
# standard string returned when no second date could be found in laycan
# noSecondDate = "NO SECOND DATE"
noSecondDate = None
# standard string returned when no sensible date could be found in laycan
# noSensibleDate = "NO SENSIBLE DATE"
noSensibleDate = None
# string distance used for search in port list to allow for typos, for example
stringDist = 0
# minimum number of characters a substring must have, anything above 2 will exclude SU-AO, for example
minChars = 2
# if value needed to be constructed
# constructed = "CONSTRUCTED"
constructed = True
# if value did not need to be constructed
# notConstructed = "NOT CONSTRUCTED"
notConstructed = False


##String and String Cleaning functions
# check is string is either empty or was filled with "NULL" by extraction
def isEmpty(s):
    if not s:
        return True
    else:
        if s.lower() == "null":
            return True
        else:
            return False


### Get all necessary tables from the database
## Get list of ports
# Use the API
ports_db = api_client.query_api("ports","get", {}, {}, "json",str(200))
ports_with_IDs = json.loads(ports_db._content.decode('utf-8'))
# Get Data locally.
# with open('cleaning_files/ports.csv') as csvfile:
#     portreader = csv.DictReader(csvfile, delimiter=';')
#     ports_with_IDs = [{'id': int(row['id']), 'name': row['name']} for row in portreader]
ports = []
for port in ports_with_IDs:
    portTemp = list_searcher.cleanString(str(port['name']))
    ports.append(portTemp)
for port in ports_with_IDs:
    port["name"] = list_searcher.cleanString(str(port["name"]))

## Get List of Cargo Types
# Use the API
cargo_types_db = api_client.query_api("cargo_types","get", {}, {}, "json",str(200))
cargo_types_db = json.loads(cargo_types_db._content.decode('utf-8'))
# Get Data locally
# with open('cleaning_files/cargo_types.csv') as csvfile:
#     cargoreader = csv.DictReader(csvfile, delimiter=';')
#     cargo_types_db = [{'id': int(row['id']), 'name': row['name']} for row in cargoreader]
cargo_types = []
for cargo_type in cargo_types_db:
    cargo_typeTemp = {}
    cargo_typeTemp["type"] = list_searcher.cleanString(str(cargo_type['name']))
    cargo_typeTemp["id"] = cargo_type['id']
    cargo_types.append(cargo_typeTemp)
# (cargo_types)
# create regex
cargo_type_regex = "(?:"
cargo_type_regex = cargo_type_regex + cargo_types[0]["type"]
cargo_types2 = list(cargo_types)
cargo_types2.pop(0)
for cargo_type in cargo_types2:
    cargo_type_regex = cargo_type_regex + "|" + cargo_type["type"]
cargo_type_regex = cargo_type_regex + ")"
#(cargo_type_regex)

## Get List of Terms
# Use the API
term_list_db = api_client.query_api("ld_rate_types","get", {}, {}, "json",str(200))
term_list_db = json.loads(term_list_db._content.decode('utf-8'))
# Get Data locally.
# with open('cleaning_files/loading_discharging_rate_type.csv') as csvfile:
#     termreader = csv.DictReader(csvfile, delimiter=';')
#     term_list_db = [{'id': int(row['id']), 'name': row['name']} for row in termreader]
term_list = []
for rate_type in term_list_db:
    termTemp = {}
    termTemp["term"] = list_searcher.cleanString(str(rate_type['name']))
    termTemp["id"] = rate_type['id']
    term_list.append(termTemp)
# create regex
#term_abbrevations = "(?:pwwd\s)?(?:"
term_abbrevations = "(?:"
term_abbrevations = term_abbrevations + term_list[0]["term"]
term_list2 = list(term_list)
term_list2.pop(0)
for term in term_list2:
    term_abbrevations = term_abbrevations + "|" + term["term"]
term_abbrevations = term_abbrevations + ")"
# term_abbrevations

##COMMISSION COLUMN
# find the commission by simple searching for the numbers, since only they are required in the calculation
def findCommission2(s):
    commission = {}
    if isEmpty(s):
        commission["commission"] = emptyString
        commission["constructed_commission"] = notConstructed
        return commission
    ##Commission
    # needs to add both together
    # "3.75 PCT + 1,25 PCT WONSILD"
    comm = re.findall('\d{1}(?:\,|\.)\d{1,2}', s)
    if comm:
        logging.debug('found n.nn|n,nn')
        comm = [val.replace(",", ".") for val in comm]
        comm = [float(val) for val in comm]
        commission["commission"] = sum(comm)
        commission["constructed_commission"] = (constructed if len(comm) > 1 else notConstructed)
        return commission
    # "375TTL", "250 pct add comm plus", "125%" --> convert to float and add
    comm = re.findall('\d{3}\s?', s)
    if comm:
        logging.debug('found nnn%?')
        comm = [convertComm3ToFloat(val) for val in comm]
        commission["commission"] = sum(comm)
        commission["constructed_commission"] = (constructed if len(comm) > 1 else notConstructed)
        return commission
    # "50 % ttl iac" --> convert to float and add
    comm = re.findall('\d{2}\s?', s)
    if comm:
        logging.debug('found nnn%?')
        comm = [convertComm2ToFloat(val) for val in comm]
        commission["commission"] = sum(comm)
        commission["constructed_commission"] = (constructed if len(comm) > 1 else notConstructed)
        return commission
    commission["commission"] = emptyString
    commission["constructed_commission"] = notConstructed
    return commission

# calls findCommission2, checks if results are greater 0
def findCommission(s):
    commission = findCommission2(s)
    if commission["commission"] != emptyString:
        try:
            if float(commission["commission"]) > 0:
                return commission
            else:
                commission["commission"] = notFoundString
                commission["constructed_commission"] = notConstructed
                return commission
        except ValueError:
            commission["commission"] = notFoundString
            commission["constructed_commission"] = notConstructed
            return commission
    else:
        return commission

# convert to proper number, needs integer value with 3 digits
def convertComm3ToFloat(s):
    return float(str(s)[0] + "." + str(s)[1:3])

# convert to proper number, needs integer value with 3 digits
def convertComm2ToFloat(s):
    return float(str(s)[0] + "." + str(s)[1])

##TERMS COLUMN
# find the terms in the column using a list of all abbreviations available
# always returns a list of 4 entries, i.e. two number + terms - pairs, that are manually constructed for each case
def findTerms2(s):
    if isEmpty(s):
        return emptyString
    s = s.lower()
    s = str(s).strip()
    abbreviations = term_abbrevations
    # terms and numbers
    result = {}
    terms = re.findall('(?:\d{3,5}|\d{1,2}\.?\s?\d{2,3})', s)
    if terms:
        result = {}
        logging.debug('found terms and numbers '+ s)
        terms = [q.replace(".", "") for q in terms]
        terms = [q.replace(" ", "") for q in terms]
        numbers = terms
        terms = re.findall(abbreviations, s)
        if terms:
            result["terms_rate1"] = numbers[0]
            result["terms1"] = terms[0]
            if len(numbers) >1:
                result["terms_rate2"] = numbers[1]
            else:
                result["terms_rate2"] = notFoundString
            if len(terms) > 1:
                result["terms2"] = terms[1]
            else:
                result["terms2"] = notFoundString
            return result
    # number(s) only
    terms = re.findall('(?:\d{3,5}|\d{1,2}\.?\s?\d{2,3})', s)
    # "30.500 / 32.000", "30500 32000"
    if terms:
        result = {}
        terms = [q.replace(".", "") for q in terms]
        terms = [q.replace(" ", "") for q in terms]
        if len(terms) == 1:
            logging.debug('found number')
            result["terms_rate1"] = terms[0]
            result["terms1"] = notFoundString
            result["terms_rate2"] = notFoundString
            result["terms2"] = notFoundString
        elif len(terms) > 1:
            logging.debug('found two numbers ' + s)
            result["terms_rate1"] = terms[0]
            result["terms1"] = notFoundString
            result["terms_rate2"] = terms[1]
            result["terms2"] = notFoundString
            return result
    # term(s) only
    terms = re.findall(abbreviations, s)
    if terms:
        result = {}
        if len(terms) == 1:
            logging.debug('found term ' + s)
            result["terms_rate1"] = notFoundString
            result["terms1"] = terms[0]
            result["terms_rate2"] = notFoundString
            result["terms2"] = notFoundString
        elif len(terms) > 1:
            logging.debug('found two terms ' + s)
            result["terms_rate1"] = notFoundString
            result["terms1"] = terms[0]
            result["terms_rate2"] = notFoundString
            result["terms2"] = terms[1]
            return result
    return notFoundString


# use number of found terms to figure out how the terms were written in the email
# "nnnn", "nnnn shex" "'nnnn shex','nnnn shex'" --> make 4 of them
def findTerms(s):
    if isEmpty(s):
        result = {}
        # needs to return 4 to fill database
        result["terms_rate1"] = emptyString
        result["terms1"] = emptyString
        result["terms_rate2"] = emptyString
        result["terms2"] = emptyString
    result = findTerms2(s)
    # has all 4 entries (findterms2 only returns either one or four)
    if isinstance(result, dict):
        # check if values are higher than 0, regex are prone to error in that regard
        rate1 = result["terms_rate1"]
        rate2 = result["terms_rate2"]
        try:
            # get rid of leading 0s
            rate1 = str(rate1).lstrip("0")
            temp = int(rate1)
            if temp <= 0:
                result["terms_rate1"] = notFoundString
            else:
                result["terms_rate1"] = temp
        except ValueError:
            result["terms_rate1"] = notFoundString
        try:
            # get rid of leading 0s
            rate2 = str(rate2).lstrip("0")
            temp = int(rate2)
            if temp <= 0:
                result["terms_rate2"] = notFoundString
            else:
                result["terms_rate2"] = temp
        except ValueError:
            result["terms_rate2"] = notFoundString
        return result
    # did not find anything
    else:
        result = {}
        result["terms_rate1"] = notFoundString
        result["terms1"] = notFoundString
        result["terms_rate2"] = notFoundString
        result["terms2"] = notFoundString
        return result


##CARGO COLUMN
# find important information contained in the cargo column
def findCargo(s):
    if isEmpty(s):
        result = {}
        result["cargo_quantity"] = emptyString
        result["constructed_quantity"] = notConstructed
        result["cargo_type"] = emptyString
        return result
    s = s.lower()
    s = str(s).strip()
    quantity = findQuantity(s)
    cargoType = findCargoType(s)
    cargo = {}
    # get rid of leading 0s
    try:
        cargo["cargo_quantity"] = int(str(quantity["cargo_quantity"]).lstrip("0"))
    except ValueError:
        cargo["cargo_quantity"] = notFoundString
    cargo["constructed_quantity"] = quantity["constructed_quantity"]
    cargo["cargo_type"] = cargoType
    return cargo


# find the quantity in the cargo column
def findQuantity(s):
    result = {}
    if isEmpty(s):
        result["cargo_quantity"] = emptyString
        result["constructed_quantity"] = notConstructed
        return result
    # abbreviations = "(?:dwt|mt|cbm|ts)"
    # "30/32000", "30/32.000
    quantity = re.findall('\d{1,2}\/(?:\d{3,5}|\d{1,2}\.?\s?\d{2,3})', s)
    if quantity:
        quantity = quantity[0].split("/")
        # be sure something like 30500/32000 does not become 00/32000
        if int(quantity[0]) > 0:
            logging.debug('found nn/nn.?nnn')
            quantity1 = quantity[0] + "000"
            quantity2 = quantity[1].replace(".", "").replace(" ", "")
            quantity = str((int(quantity1) + int(quantity2)) / 2)
            result["cargo_quantity"] = quantity
            result["constructed_quantity"] = constructed
            return result
    quantity = re.findall('(?:\d{3,5}|\d{1,2}\.?\s?\d{2,3})', s)
    # "30.500 / 32.000", "30500 32000"
    if quantity:
        quantity = [q.replace(".", "") for q in quantity]
        quantity = [q.replace(" ", "") for q in quantity]
        if len(quantity) == 1:
            try:
                int(quantity[0])
            except ValueError:
                result["cargo_quantity"] = notFoundString
                result["constructed_quantity"] = notConstructed
                return result
            if int(quantity[0]) > 0:
                logging.debug('found nnnnn|nn.?nnn')
                result["cargo_quantity"] = quantity[0]
                result["constructed_quantity"] = notConstructed
                return result
        elif len(quantity) == 2:
            try:
                int(quantity[0])
                int(quantity[1])
            except ValueError:
                result["cargo_quantity"] = notFoundString
                result["constructed_quantity"] = notConstructed
                return result
            if int(quantity[0]) > 0 & int(quantity[1]) > 0:
                logging.debug('found (nnnnn|nn.?nnn)/(nnnnn|nn.?nnn)')
                result["cargo_quantity"] = str((int(quantity[0]) + int(quantity[1])) / 2)
                result["constructed_quantity"] = constructed
                return result
    result = {}
    result["cargo_quantity"] = notFoundString
    result["constructed_quantity"] = notConstructed
    return result


# find the type of cargo in the cargo column, using a list of standard commodities
def findCargoType(s):
    if isEmpty(s):
        return emptyString
    cargoes = cargo_type_regex
    # cargoes = "(?:agri|cement|corn|coal|iron|minerals|project|rock|steel|sugar|zinc)"
    cargoType = re.findall(cargoes, s)
    if cargoType:
        return cargoType[0]
    else:
        return notFoundString


## translate found cargo_types, ports and terms into IDs
def get_cargo_type_ID(cargo_type):
    cargo_type_ID = None
    for i in cargo_types:
        if i['type'] == cargo_type:
            cargo_type_ID = i['id']
    if cargo_type_ID:
        return cargo_type_ID
    else:
        return notFoundString


def get_term_ID(term):
    term_ID = None
    for i in term_list:
        if i['term'] == term:
            term_ID = i['id']
    if term_ID:
        return term_ID
    else:
        return notFoundString


def get_port_ID(port):
    port_ID = None
    for i in ports_with_IDs:
        if i['name'] == port:
            port_ID = i['id']
    if port_ID:
        return port_ID
    else:
        return notFoundString


# translate the found values into their respective IDs for the DB
def get_IDs(entry):
    entry["load_port"] = get_port_ID(entry["load_port"])
    entry["disch_port"] = get_port_ID(entry["disch_port"])
    entry["terms1"] = get_term_ID(entry["terms1"])
    entry["terms2"] = get_term_ID(entry["terms2"])
    entry["cargo_type"] = get_cargo_type_ID(entry["cargo_type"])
    return entry

# set the status according to whether or not the entry is usable or partially usable
def getStatus(entry):
    # entry is not usable
    if not entry["cargo_type"]:
        return 3
    if not entry["cargo_quantity"]:
        return 3
    if not entry["load_port"]:
        return 3
    if not entry["disch_port"]:
        return 3
    if not entry["first_date"]:
        return 3

    #entry is partially usable
    if not entry["second_date"]:
        entry_temp = entry
        del entry_temp["second_date"]
        if all(v is not None for v in entry_temp):
            return 2

    if not entry["terms_rate1"]:
        entry_temp = entry
        del entry_temp["terms_rate1"]
        if all(v is not None for v in entry_temp):
            return 2

    if not entry["terms1"]:
        entry_temp = entry
        del entry_temp["terms1"]
        if all(v is not None for v in entry_temp):
            return 2

    if not entry["terms_rate2"]:
        entry_temp = entry
        del entry_temp["terms_rate2"]
        if all(v is not None for v in entry_temp):
            return 2

    if not entry["terms2"]:
        entry_temp = entry
        del entry_temp["terms2"]
        if all(v is not None for v in entry_temp):
            return 2

    if not entry["commission"]:
        entry_temp = entry
        del entry_temp["commission"]
        if all(v is not None for v in entry_temp):
            return 2

    #entry is completely usable
    if all(v is not None for v in entry):
        return 1

# stores an extracted entity in the database
def store_clean_cargo_in_db(cargo_clean, coe_ID):
    cargo_clean = get_IDs(cargo_clean)
    db_cargo = {}
    if "load_port" in cargo_clean:
         db_cargo["loading_port"] = cargo_clean["load_port"]
    db_cargo["loading_port_manual"] = 0
    if "disch_port" in cargo_clean:
        db_cargo["discharging_port"] = cargo_clean["disch_port"]
    db_cargo["discharging_port_manual"] = 0
    if "first_date" in cargo_clean:
        db_cargo["laycan_first_day"] = cargo_clean["first_date"]
    db_cargo["laycan_first_day_manual"] = 0
    if "second_date" in cargo_clean:
        db_cargo["laycan_last_day"] = cargo_clean["second_date"]
    db_cargo["laycan_last_day_manual"] = 0
    if "constructed_date" in cargo_clean:
        db_cargo["laycan_first_day_constructed"] = (1 if cargo_clean["constructed_date"] == constructed else 0)
        db_cargo["laycan_last_day_constructed"] = db_cargo["laycan_first_day_constructed"]
    if "cargo_quantity" in cargo_clean:
        db_cargo["quantity"] = cargo_clean["cargo_quantity"]
    db_cargo["quantity_manual"] = 0
    db_cargo["quantity_constructed"] = 0
    if "constructed_quantity" in cargo_clean:
        db_cargo["constructed_quantity"] = (1 if cargo_clean["constructed_quantity"] == constructed else 0)
    if "cargo_type" in cargo_clean:
        db_cargo["cargo_type_id"] = cargo_clean["cargo_type"]
    db_cargo["cargo_type_id_manual"] = 0
    db_cargo["stowage_factor"] = 0
    db_cargo["stowage_factor_manual"] = 0
    db_cargo["stowage_factor_constructed"] = 0
    db_cargo["sf_unit"] = 1
    db_cargo["ship_specialization_id"] = 1
    db_cargo["quantity_measurement_id"] = 1
    if "terms_rate1" in cargo_clean:
        db_cargo["loading_rate"] = cargo_clean["terms_rate1"]
    if "terms1" in cargo_clean:
        db_cargo["loading_rate_type"] = cargo_clean["terms1"]
    db_cargo["loading_rate_manual"] = 0
    db_cargo["loading_rate_constructed"] = 0
    if "terms_rate2" in cargo_clean:
        db_cargo["discharging_rate"] = cargo_clean["terms_rate2"]
    if "terms2" in cargo_clean:
        db_cargo["discharging_rate_type"] = cargo_clean["terms2"]
    db_cargo["discharging_rate_manual"] = 0
    db_cargo["discharging_rate_constructed"] = 0
    db_cargo["extra_condition"] = None
    if "commission" in cargo_clean:
        db_cargo["commission"] = cargo_clean["commission"]
    db_cargo["commision_manual"] = 0
    db_cargo["commision_constructed"] = (1 if cargo_clean["constructed_commission"] == constructed else 0)
    db_cargo["email_id"] = cargo_clean["email_id"]
    db_cargo["status_id"] = getStatus(cargo_clean)
    print("NOW SAVING CARGO WITH ID: " + str(coe_ID))
    logging.info("==========================================")
    logging.info("This object will be sent to db:")
    logging.info(db_cargo)
    res6 = api_client.query_api("cargos","post", {},db_cargo, "json", str(200))
    if res6.status_code != 200:
        print("COULD NOT SAVE")
        logging.info(res6.status_code)
        logging.info("clean_cargo from " + db_cargo["email_id"] + " could not be inserted. Please try again.")
    else:
        res6 = api_client.query_api_set_cleaned_cargo_offer(str(coe_ID))
        if res6.status_code != 200:
            print("COULD NOT SET ENTRY CLEAN")
            logging.info(res6.status_code)
            logging.info("cargo from " + db_cargo["email_id"] + " could not be set to >cleaned<. Please try again.")


# combine output of extraction using the functions defined above and clean the data
def cleanEntry(port_list, load_port, disch_port, laycan, mailDate, cargo, terms, commission, emailID):
    result = {}
    result["load_port"] = list_searcher.findEntry(load_port, port_list, stringDist)
    result["disch_port"] = list_searcher.findEntry(disch_port, port_list, stringDist)
    d = date_finder.findDate(laycan, mailDate)
    result["first_date"] = d["first_date"]
    result["second_date"] = d["second_date"]
    result["constructed_date"] = d["constructed_date"]
    cargo = findCargo(cargo)
    result["cargo_quantity"] = cargo["cargo_quantity"]
    result["constructed_quantity"] = cargo["constructed_quantity"]
    result["cargo_type"] = cargo["cargo_type"]
    terms = findTerms(terms)
    result["terms_rate1"] = terms["terms_rate1"]
    result["terms1"] = terms["terms1"]
    result["terms_rate2"] = terms["terms_rate2"]
    result["terms2"] = terms["terms2"]
    commission = findCommission(commission)
    result["commission"] = commission["commission"]
    result["constructed_commission"] = commission["constructed_commission"]
    result["email_id"] = emailID
    store_clean_cargo_in_db
    return result

# for printing purposes and to input into csv, to generate statistics about the cleaning process and enhance it
def resultArrayToList(result):
    resultTemp = []
    resultTemp.append(result["load_port"])
    resultTemp.append(result["disch_port"])
    resultTemp.append(result["first_date"])
    resultTemp.append(result["second_date"])
    resultTemp.append(result["constructed_date"])
    resultTemp.append(result["cargo_quantity"])
    resultTemp.append(result["constructed_quantity"])
    resultTemp.append(result["cargo_type"])
    resultTemp.append(result["terms_rate1"])
    resultTemp.append(result["terms1"])
    resultTemp.append(result["terms_rate2"])
    resultTemp.append(result["terms2"])
    resultTemp.append(result["commission"])
    resultTemp.append(result["constructed_commission"])
    resultTemp.append(result["email_id"])
    return resultTemp

# for printing purposes and to input into csv, puts input besides output
def resultToCompare(input, result):
    resultTemp = []
    resultTemp.append(str(input["load_port"]).replace(",", " "))
    resultTemp.append(result["load_port"])
    resultTemp.append(str(input["disch_port"]).replace(","," "))
    resultTemp.append(result["disch_port"])
    resultTemp.append(str(input["laycan"]).replace(",", " "))
    resultTemp.append(result["first_date"])
    resultTemp.append(result["second_date"])
    resultTemp.append(result["constructed_date"])
    resultTemp.append(str(input["cargo"]).replace(",", " "))
    resultTemp.append(result["cargo_quantity"])
    resultTemp.append(result["constructed_quantity"])
    resultTemp.append(result["cargo_type"])
    resultTemp.append(str(input["terms"]).replace(",", " "))
    resultTemp.append(result["terms_rate1"])
    resultTemp.append(result["terms1"])
    resultTemp.append(result["terms_rate2"])
    resultTemp.append(result["terms2"])
    resultTemp.append(str(input["commission"]).replace(","," "))
    resultTemp.append(result["commission"])
    resultTemp.append(result["constructed_commission"])
    resultTemp.append(result["email_id"])
    return resultTemp

## Main part of script, that gets the required information from the database and inputs it to the cleaning algorithm
now = datetime.datetime.time(datetime.datetime.now())
logging.info('Loading data and cleaning it at ' + str(now))
# Get extracted cargo data - change acccording to actual function name
# Use API
emails =    api_client.query_api_get_cargo_for_cleaning(str(10000))
emaildata = json.loads(emails._content.decode('utf-8'))
#print(emaildata)
# Use local file for testing etc.
# NewExtractedCargoWithDate Data_Cleaning_Test_Set_09_01_2018
# with open('ManualTestSet.csv') as csvfile:
#     inputreader = csv.DictReader(csvfile, delimiter=';')
#     emaildata = [{'load_place': row['load_place'], 'disch_place': row['disch_place'], 'laycan': row['laycan'],
#                   'laycan': row['laycan'], 'date': row['date'], 'terms': row['terms'], 'cargo': row['cargo'],
#                   'commission': row['commission'], 'emailID': row['emailID'],
#                   'cargo_offer_extracted_ID': row['cargo_offer_extracted_ID']} for row in inputreader]
# transform into strings + put into main function at bottom of page
cargo_entries = []
for cargo_entry in emaildata:
    cargoTemp = {}
    cargoTemp["load_port"] = cargo_entry['load_place']
    cargoTemp["disch_port"] = cargo_entry['disch_place']
    cargoTemp["laycan"] = cargo_entry['laycan']
    cargoTemp["date"] = cargo_entry['date']
    cargoTemp["terms"] = cargo_entry['terms']
    cargoTemp["cargo"] = cargo_entry['cargo']
    cargoTemp["commission"] = cargo_entry['commission']
    cargoTemp["email_id"] = cargo_entry['emailID']
    cargoTemp["cargo_offer_extracted_ID"] = cargo_entry['cargo_offer_extracted_ID']
    cargo_entries.append(cargoTemp)

# only for writing results into csv
output = []
# counter = 0
cleanedCounter = 0
# maximumEntries = 10000
for entry in cargo_entries:
    time.sleep(0.5)
    # if counter < maximumEntries:
        # print("Entry:")
        # print(entry)
        # fill content of emails into script
        # deli = " , "
    try:
        # '%Y-%m-%d %H:%M:%S' '%d.%m.%Y'
        date1 = datetime.datetime.strptime(str(entry["date"]), '%Y-%m-%d %H:%M:%S')
        # print("valid date")
        # input = str(cargoTemp["load_port"]) + deli + str(cargoTemp["disch_port"]) + deli + str(cargoTemp["laycan"]) + deli + str(cargoTemp["date"]) + deli + str(
        #    cargoTemp["cargo"]) + deli + deli + str(cargoTemp["terms"]) + deli + deli + deli + deli + str(cargoTemp["commission"])
        # +print("ID " + str(entry[1]) + deli + input)
        # print input
        result = cleanEntry(ports, str(entry["load_port"]), str(entry["disch_port"]), str(entry["laycan"]), str(entry["date"]), str(entry["cargo"]), str(entry["terms"]), str(entry["commission"]), str(entry["email_id"]))
        logging.info('Found' + str(result))
        # Fill results into a csv to test locally
        resultTemp = resultArrayToList(result)
        output.append(resultTemp)
        print("FOUND: ")
        print(resultTemp)
        # with open("output.csv", "wb") as f:
        #    writer = csv.writer(f)
        #    writer.writerows(output)
        # end csv filling
        store_clean_cargo_in_db(result, entry["cargo_offer_extracted_ID"])
        cleanedCounter +=1
    except ValueError:
        print("NO VALID DATE")
        logging.info("no valid date was transmitted by the database")
    # counter += 1

now = datetime.datetime.time(datetime.datetime.now())
logging.info('All input data cleaned at ' + str(now) + " with " + str(cleanedCounter) + " entries in total")