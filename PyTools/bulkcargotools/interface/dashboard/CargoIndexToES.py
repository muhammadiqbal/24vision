from datetime import datetime
import googlemaps
import json
from elasticsearch import Elasticsearch
from elasticsearch import helpers
import sys

#path to bulkcargotool script files
sys.path.insert(0, '/home/munsteruniversity/bulk_cargo_tool/api/')
import api_client
######################################
#todo: insert API key from 24Vision  #
######################################

#initialize google maps instance
gmaps = googlemaps.Client("")

#get specified number (500) of emails not processed in kibana from database
cargo_as_json = api_client.query_api_get("cargoofferextracted", {}, "json", 500)
cargo = json.loads(cargo_as_json._content.decode('utf-8'))

#array being pushed to elasticsearch
data_to_upload = []

for item in cargo:
    #initialize variables in case of malformed data
    loc_type_load = "invalid"
    loc_lat_load = float()
    loc_lng_load = float()
    loc_type_disch = "invalid"
    loc_lat_disch = float()
    loc_lng_disch = float()

    #initialize variables in case of malformed data
    emailID = 0 if not item['emailID'] else item['emailID']
    sender = "" if not item['sender'] else item['sender']
    cargoID = 0 if not item['cargo_offer_extracted_ID'] else item['cargo_offer_extracted_ID']
    cargo = "" if not item['cargo'] else item['cargo']
    loadPlace = "" if not item['load_place'] else item['load_place']
    dischPlace = "" if not item['disch_place'] else item['disch_place']
    #parse date type from database output
    date = "" if not item['date'] else datetime.strptime(item['date'].strip(), "%Y-%m-%d %H:%M:%S")


    #call googlemaps API if load place exists
    if loadPlace:
        geocode_result = []
        try:
            #sample_result = [{'geometry': {'viewport': {'southwest': {'lng': -8.665443800000002, 'lat': 40.6241712}, 'northeast': {'lng': -8.6238121, 'lat': 40.6545896}}, 'bounds': {'southwest': {'lng': -8.665443800000002, 'lat': 40.6241712}, 'northeast': {'lng': -8.6238121, 'lat': 40.6545896}}, 'location_type': 'APPROXIMATE', 'location': {'lng': -8.6537539, 'lat': 40.6405055}}, 'formatted_address': 'Aveiro, Portugal', 'place_id': 'ChIJjeey1Q6YIw0RBx88Ac3hQjA', 'types': ['locality', 'political'], 'address_components': [{'long_name': 'Aveiro', 'short_name': 'Aveiro', 'types': ['locality', 'political']}, {'long_name': 'Aveiro District', 'short_name': 'Aveiro District', 'types': ['administrative_area_level_1', 'political']}, {'long_name': 'Portugal', 'short_name': 'PT', 'types': ['country', 'political']}]}]
            geocode_result = gmaps.geocode(loadPlace)
        except:
            print("Error while calling google API for load place: " + loadPlace)

        #response can still be empty if nothing found by google
        if not geocode_result:
            ""
        else:
            #extract geo points
            geometry = geocode_result[0]['geometry']
            loc_type_load = geometry['location_type']
            loc_lng_load = geometry['location']['lng']
            loc_lat_load = geometry['location']['lat']
    else:
        print("Load place is null, skipping")
    
    #call googlemaps API if discharge place exists
    if dischPlace:
        print ("Discharging place is not null, calling Google API")
        geocode_result = []
        try:
            #sample_result = [{'geometry': {'viewport': {'southwest': {'lng': -8.665443800000002, 'lat': 40.6241712}, 'northeast': {'lng': -8.6238121, 'lat': 40.6545896}}, 'bounds': {'southwest': {'lng': -8.665443800000002, 'lat': 40.6241712}, 'northeast': {'lng': -8.6238121, 'lat': 40.6545896}}, 'location_type': 'APPROXIMATE', 'location': {'lng': -8.6537539, 'lat': 40.6405055}}, 'formatted_address': 'Aveiro, Portugal', 'place_id': 'ChIJjeey1Q6YIw0RBx88Ac3hQjA', 'types': ['locality', 'political'], 'address_components': [{'long_name': 'Aveiro', 'short_name': 'Aveiro', 'types': ['locality', 'political']}, {'long_name': 'Aveiro District', 'short_name': 'Aveiro District', 'types': ['administrative_area_level_1', 'political']}, {'long_name': 'Portugal', 'short_name': 'PT', 'types': ['country', 'political']}]}]
            geocode_result = gmaps.geocode(dischPlace)
        except:
            print("Error while calling google API for discharging place: " + dischPlace)
            
        #response can still be empty if nothing found by google
        if not geocode_result:
            ""
        else:
            #extract geo points
            geometry = geocode_result[0]['geometry']
            loc_type_disch = geometry['location_type']
            loc_lng_disch = geometry['location']['lng']
            loc_lat_disch = geometry['location']['lat']
    else:
        print("Discharging place is null, skipping")

    #create single data set according to elasticsearch format    
    index_data = [
        {"_index": "cargo",
         "_type": "cargo",
         "_source": {
             'cargo_offer_extracted_ID': cargoID,
             'emailID': emailID,
             'load_place': loadPlace,
             'disch_place': dischPlace,
             'Date': date,
             'location_accuracy_load_place': loc_type_load,
             'load_place_location': {
                 'lat': loc_lat_load,
                 'lon': loc_lng_load
             },
             'location_accuracy_discharge_place': loc_type_disch,
             'discharge_place_location': {
                 'lat': loc_lat_disch,
                 'lon': loc_lng_disch
             }
         }
        }
    ]

    #write extracted flag to database excluding the current data set from next request
    try:
        modifcations = {"kibana_extracted": 1}
        api_client.query_api_post("cargoofferextracted/" + str(cargoID), modifcations)
        
        #write resolved geo coordinates back to database
        geo_modifications = {"load_place_lat": str(loc_lat_load), "load_place_lon": str(loc_lng_load), "disch_place_lon": str(loc_lng_disch), "disch_place_lat": str(loc_lat_disch)}
        api_client.query_api_post("cargoofferextracted/" + str(cargoID), geo_modifications)
    except:
        print("Error occured while setting extracted flag in DB to 1")
    
    #add single data set to full array
    data_to_upload.extend(index_data)

#elasticsearch mapping for elasticsearch index with data type 'geo point' for discharge and load place
mappings = {
    "mappings": {

        "cargo": {
            "properties": {
                 "load_place_location": {
                     "type": "geo_point"

                 },
                "discharge_place_location": {
                    "type": "geo_point"

                }
            }
        }
    }
}

#initialize elasticsearch instance
es = Elasticsearch()
#create index even if it exists currently (ignore code 400) for ensuring a geopoint mapping
es.indices.create(index='cargo', body=mappings, ignore=400)

#upload data to elasticsearch
print(helpers.bulk(es, data_to_upload))
