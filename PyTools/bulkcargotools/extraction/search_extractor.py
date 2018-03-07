import json
import api.api_client as api_client

# Query the API
ports = api_client.query_api_get("ports", {}, "json", 40000)
# Be careful with the limit for performance reasons
companies = api_client.query_api_get("companies", {}, "json", 40000)
vessels = api_client.query_api_get("ships", {}, "json", 5000)

# Convert responses to Python Lists of Dictionaries
portdata = json.loads(ports._content.decode('utf-8'))
companydata = json.loads(companies._content.decode('utf-8'))
vesseldata = json.loads(vessels._content.decode('utf-8'))

# port0 = portdata[0]["countrycode"]

# Create lists of possible values
portnameset = set()
for port in portdata:
    portnameset.add(port["name"].lower())

companynameset = set()
for company in companydata:
    companyname = company["Name"].lower().replace(" inc", "")
    companyname = companyname.replace(" co ltd", "")
    companyname = companyname.replace(" pte ltd", "")
    companyname = companyname.replace(" ltd", "")
    companynameset.add(company["Name"].lower())

vesselnameset = set()
for vessel in vesseldata:
    vesselnameset.add(vessel["Vessel_Name"].lower())

# Define functions to test an email


def IsInSet(phrase, the_set):
    if phrase.lower() in the_set:
        return 1
    else:
        return 0


def IsPort(phrase1):
    return IsInSet(phrase1, portnameset)


def IsCompany(phrase1):
    return IsInSet(phrase1, companynameset)


def IsVessel(phrase1):
    return IsInSet(phrase1, vesselnameset)


def AnalyzePhrase(phrase1):
    if IsPort(phrase1) == 1:
        return "port"
    elif IsCompany(phrase1) == 1:
        return "company"
    elif IsVessel(phrase1) == 1:
        return "ship"
    else:
        return "unknown"

# IsPort1 = IsPort("REYKJAVIK")

# Extraction Function


def ExtractFromEmail(email):
    ExtractionResult = dict()
    if email is None:
        return ExtractionResult

    emailwords = email.lower().split()
    if emailwords.__len__() < 2:
        return ExtractionResult

    lastword = "----"
    for curword in emailwords:
        word_res = AnalyzePhrase(lastword)

        twoword = str(lastword) + " " + str(curword)
        twoword_res = AnalyzePhrase(twoword)

        if twoword_res != "unknown":
            # print(twoword + " is a " + twoword_res)
            if twoword_res in ExtractionResult.keys():
                ExtractionResult[twoword_res + "2"] = twoword
            else:
                ExtractionResult[twoword_res] = twoword
        elif word_res != "unknown":
            # print(lastword + " is a " + word_res)
            if twoword_res in ExtractionResult.keys():
                ExtractionResult[word_res + "2"] = lastword
            else:
                ExtractionResult[word_res] = lastword
        lastword = curword
    return ExtractionResult

# Get emails to extract
#emails = api_client.query_api_get("emails", {}, "json", 20000)
#emaildata = json.loads(emails._content.decode('utf-8'))

# EXTRACT

# Example for individual extraction
# email = "DEAR ALL / TED Mv East Ayutthaya 2010blt/ 32770dwt/10..15m/4c30.5 Open Mongla o/a 20-24.May.2017 - Co2 fitted Orange Truth - equipped with A60 bulkhead - App B - Grain Clean Try any === Mv Inlaco Express 2011blt/ 34053dwt/9.85m/4c30 open Bintulu o/a 26.May.2017 box shaped, 25x2 ok, deck cargo ok, a60 bulkhead/app b/co2/ pg/jpn range including aus/nz NO Bangladesh NO Iran"
# res = ExtractFromEmail(email)

# Mass Extraction
#ExtractionCollector = []
#for email in emaildata:
#    try:
#        base_string = ""
#        if email["sender"] is not None:
#            base_string = base_string + email["sender"].lower()
#        if email["body"] is not None:
#            base_string = base_string + email["body"].lower()
#        if email["subject"] is not None:
#            base_string = base_string + email["subject"].lower()
#        ExtractedData = ExtractFromEmail(base_string)
#        print(ExtractedData)
#        ExtractionCollector.append([email["emailID"], ExtractedData])
#    except:
#        print("Error occurred.")
        # print(email)

# shipres = AnalyzePhrase("orange truth")
#ExtractionCollector
