#!/usr/bin/env python
from elasticsearch import Elasticsearch
from elasticsearch import helpers
from datetime import datetime
import json
import sys

#path to bulkcargotool script files
sys.path.insert(0, '/home/munsteruniversity/bulk_cargo_tool/api/')
import api_client

#get specified number (500) of emails not processed in kibana from database
emails_as_json = api_client.query_api_get("emails", {"filter":"kibana-unextracted"}, "json", 500)
emails = json.loads(emails_as_json._content.decode('utf-8'))

#array being pushed to elasticsearch
data_to_upload = []

for item in emails:
    #initialize variables in case of malformed data
    emailID = 0 if not item['emailID'] else item['emailID']
    subject = "" if not item['subject'] else item['subject']
    sender = "" if not item['sender'] else item['sender']
    receiver = "" if not item['receiver'] else item['receiver']
    classification_manual = "" if not item['classification_manual'] else item['classification_manual']
    #parse date type from database output
    date = "" if not item['date'] else datetime.strptime(item['date'].strip(), "%Y-%m-%d %H:%M:%S")
    classification_automated = "" if not item['classification_automated'] else item['classification_automated']
    classification_automated_certainty = 0 if not item['classification_automated_certainty'] else item['classification_automated_certainty']

    #create single data set according to elasticsearch formate
    index_data = [
        {"_index": "emails",
         "_type": "emails",
         "_source": {
             'emailID': int(emailID),
             'subject': subject,
             'sender': sender,
             'receiver': receiver,
             'classification_manual': classification_manual,
             'Date': date,
             'classification_automated': classification_automated,
             'classification_automated_certainty': float(classification_automated_certainty)
         }
        }
    ]

    #write extracted flag to database excluding the current data set from next request
    try:
        modifcations = {"kibana_extracted": 1}
        api_client.query_api_post("emails/" + str(emailID), modifcations)
    except:
        print("Error occured while setting extracted flag in DB to 1")

    #add single data set to full array
    data_to_upload.extend(index_data)


#initialize elasticsearch instance on default port
es = Elasticsearch()

#upload data to elasticsearch
print(helpers.bulk(es, data_to_upload))
