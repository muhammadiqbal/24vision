import api.api_client as api_client
import requests
from requests.auth import HTTPBasicAuth

val = requests.get('http://developer.cargoinship.com/IMAP.php?filter=new', auth=HTTPBasicAuth('admin@bi4macom', 'PSbi4macom'))
print(val._content)
val = requests.get('http://developer.cargoinship.com/IMAP.php?filter=recent', auth=HTTPBasicAuth('admin@bi4macom', 'PSbi4macom'))
print(val._content)
