# Enable imports from parent/sibling directories/packages
import sys
import os
sys.path.insert(0, os.path.abspath('..'))

import api.api_client as api_client
import json

emails_as_json = api_client.query_api_get("emails", {}, "json", 20000)
all_emails = json.loads(emails_as_json._content.decode('utf-8'))
