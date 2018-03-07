import requests
from requests.auth import HTTPBasicAuth

# Core Function

basedomain = "http://developer.cargoinship.com"
def query_api(endpoint, method="get", parameters={}, inputdata={}, format="csv", limit="200"):
    
    #basedomain = "http://h2692022.stratoserver.net/api/"
  #  username = 'munsteruniversity'
   # password = 'huHzJKb459Wz'
    api_version = 'v1.0'

    parameters['format'] = format
    parameters['limit'] = limit
    if method == "get":
        return requests.get(basedomain +"/api"+ "/" + endpoint,
                            data=inputdata,
                            params=parameters,
                            #auth=HTTPBasicAuth(username, password)
							)
    elif method == "post":
        return requests.post(basedomain + "/api" +"/" + endpoint,
                             data=inputdata,
                             params=parameters,
                             #auth=HTTPBasicAuth(username, password)
							 )
    elif method == "put":
        return requests.put(basedomain +"/api"+ "/" + endpoint +"/" +str(inputdata),
                            data=inputdata,
                            params=parameters,
                           # auth=HTTPBasicAuth(username, password)
							)
    elif method == "delete":
        return requests.delete(basedomain +"/api"+ "/" + endpoint,
                               data=inputdata,
                               params=parameters,
                               #auth=HTTPBasicAuth(username, password)
							   )
    else:
        return "Method currently not (or not yet) supported"


# Function Aliases for easier usage

def query_api_get_classificationtraining(limit : object = "200") -> object:
    return requests.get(basedomain +"/api"+ "/emails/classificationtraining/"+limit
                            #auth=HTTPBasicAuth(username, password)
							)
							
def query_api_get_unextractedcargo(limit : object = "200") -> object:
    return requests.get(basedomain +"/api"+ "/emails/unextracted-cargo/"+limit
                            #auth=HTTPBasicAuth(username, password)
							)

def query_api_get_unextractedship(limit : object = "200") -> object:
    return requests.get(basedomain +"/api"+ "/emails/unextracted-ship/"+limit
                            #auth=HTTPBasicAuth(username, password)
							)	

def query_api_get_unextractedorder(limit : object = "200") -> object:
    return requests.get(basedomain +"/api"+ "/emails/unextracted-order/"+limit
                            #auth=HTTPBasicAuth(username, password)
                                                        )
														
def query_api_get_cargo_for_cleaning(limit : object = "200") -> object:
    return requests.get(basedomain +"/api"+ "/emails/cargoforcleaning/"+limit
                            #auth=HTTPBasicAuth(username, password)
							)

def query_api_get(limit: object = "200") -> object:
    return query_api(basedomain +"/api"+ "/emails?limit="+limit)


def query_api_post(endpoint, inputdata, format="csv", parameters={}):
    return query_api(endpoint, "post", parameters, inputdata, format)


def query_api_put(endpoint, inputdata, parameters={}, format="csv"):
    return query_api(endpoint, "put", parameters, inputdata, format)


def query_api_delete(endpoint, parameters={}, format="csv"):
    return query_api(endpoint, "delete", parameters, {}, format)


# SAMPLE USAGE

# Asks for emails
# res = query_api_get("emails") # <-- GET requests are available for all
# tables. Please use CamelCase (e.g. ShipOfferExtracted)

# Ask for emails with different filters
# res2 = query_api_get("emails", {"filter":"unclassified"}) # Yields emails with classification_automated="Unknown"
# res2 = query_api_get("emails", {"filter":"cargo"}) # Yields emails with
# classification_manual="mix", available for all classification types

# Asks for a list of all ports
# res3 = query_api_get("ports", {}, "csv", 4000)

# Ask for a single port
# res3_1 = query_api_get("ports/11")

# Writes an email classification back into the database
# classif_data = {"classification_automated": "Cargo", "classification_automated_certainty":0.12345} # <-- The email-POST endpoint is currently limited to these two fields
# res4 = query_api_post("emails/6", classif_data)

# Modify Port Data
#modifications = {"available": "Y"} # <-- All other POST endpoints now support POST request for all fields, given correct fieldnames and a primary key in the endpoint url
#res5 = query_api_post("ports/11", modifications);

# INSERT dataset
#testamax = {"name": "Testamax", "minLoad":"1", "maxLoad":10} # <-- All other PUT endpoints now support PUT request for all fields, given correct fieldnames and a primary key in the endpoint url
#res6 = query_api_put("ShipType", testamax);
#res6
# Ask for Ships
# res7 = query_api_get("ships", {}, "csv", 15000) # All Ships
# res8 = query_api_get("ships/3728") # One Ship

# Ask for Companies
# res9 = query_api_get("companies", {}, "csv", 15000) # All Companies
# res10 = query_api_get("companies/3718") # One Company

# Delete Classifications
# res11 = query_api_delete("emails", {"filter":"classification"})
# res11
