#!/usr/bin/python

import requests
from requests.auth import HTTPBasicAuth

#Core Function
def queryAPI(endpoint, method="get", parameters={}, inputdata={}, format="csv", limit="200" ):
    #basedomain = "http://localhost/"
    basedomain = "developer.cargoinship.com"
    username = 'munsteruniversity'
    password = 'huHzJKb459Wz'

    parameters['format'] = format
    parameters['limit'] = limit
    if method=="get":
        return requests.get(basedomain +'api/' + endpoint, data=inputdata, params=parameters, auth=HTTPBasicAuth('munsteruniversity', 'huHzJKb459Wz'))
    elif method=="post":
        return requests.post(basedomain + 'api/' + endpoint, data=inputdata,params=parameters, auth=HTTPBasicAuth('munsteruniversity', 'huHzJKb459Wz'))
    elif method=="put":
        return requests.put(basedomain + 'api/' + endpoint, data=inputdata,params=parameters, auth=HTTPBasicAuth('munsteruniversity', 'huHzJKb459Wz'))
    elif method=="delete":
        return requests.delete(basedomain + 'api/' + endpoint, data=inputdata,params=parameters, auth=HTTPBasicAuth('munsteruniversity', 'huHzJKb459Wz'))
    else:
        return "Method currently not (or not yet) supported"

#Function Aliases for easier usage
def queryAPIget(endpoint, parameters={}, format="csv", limit="200"):
    return queryAPI(endpoint, "get", parameters, {}, format, limit)
def queryAPIpost(endpoint, inputdata, format="csv", parameters={}):
    return queryAPI(endpoint, "post", parameters, inputdata, format)
def queryAPIput(endpoint, inputdata, parameters = {}, format = "csv"):
    return queryAPI(endpoint, "put", parameters, inputdata, format)
def queryAPIdelete(endpoint, parameters={}, format="csv"):
    return queryAPI(endpoint, "delete", parameters, {}, format)

############ SAMPLE USAGE #############

##Asks for emails
#res = queryAPIget("emails", {"filter":"unclassified"}, "json", 20)#<-- GET requests are available for all tables. Please use CamelCase (e.g. ShipOfferExtracted)
#print(res)

##Ask for emails with different filters
#res2 = queryAPIget("emails", {"filter":"unclassified"}) #Yields emails with classification_automated="Unknown"
#res2 = queryAPIget("emails", {"filter":"cargo"}) #Yields emails with classification_manual="mix", available for all classification types

##Asks for a list of all ports
#res3 = queryAPIget("ports", {}, "csv", 4000)

##Ask for a single port
#res3_1 = queryAPIget("ports/11")

##Writes an email classification back into the database
#classif_data = {"classification_automated": "Cargo", "classification_automated_certainty":0.12345} #<-- The email-POST endpoint is currently limited to these two fields
#res4 = queryAPIpost("emails/6", classif_data)

##Modify Port Data
#modifications = {"available": "Y"} #<-- All other POST endpoints now support POST request for all fields, given correct fieldnames and a primary key in the endpoint url
#res5 = queryAPIpost("ports/11", modifications);

##INSERT dataset
#testamax = {"name": "Testamax", "minLoad":"1", "maxLoad":10} #<-- All other PUT endpoints now support PUT request for all fields, given correct fieldnames and a primary key in the endpoint url
#res6 = queryAPIput("ShipType", testamax);

##Ask for Ships
#res7 = queryAPIget("ships", {}, "csv", 15000) #All Ships
#res8 = queryAPIget("ships/3728") #One Ship

##Ask for Companies
#res9 = queryAPIget("companies", {}, "csv", 15000) #All Companies
#res10 = queryAPIget("companies/3718") #One Company

##Delete Classifications
#res11 = queryAPIdelete("emails", {"filter":"classification"})
