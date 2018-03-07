import time
import os
import tensorflow as tf

#Run the Programs
#imap caller is temporary commented 
#because we don't have imap configured
#os.system('python3 imap_caller.py')
#os.system('python3 execute_classification.py')
os.system('python3 execute_cargo_extraction.py "cargo"')
#Commented since we only test with cargo
#os.system('python3 execute_ship_extraction.py "ship"')
#os.system('python3 execute_order_extraction.py "order"')

print("--- %s seconds ---" % (time.time() - start_time))
