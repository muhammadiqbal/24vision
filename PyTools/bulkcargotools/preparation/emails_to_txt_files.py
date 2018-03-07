
# coding: utf-8

# In[ ]:


import prepare_data


# In[ ]:


names = ["cargo", "ship", "order", "mix"]


# In[ ]:


data_path = "../DATA/"


# In[ ]:


# Remove newlines from emails
for name in names:
    prepared_emails = prepare_data.PrepareEmails(path_to_csv=data_path + "csv/" + name + ".csv", remove_stopwords_flag=False)
    
    data = []
    for el in prepared_emails.premature_list:
        el = prepared_emails.single_newlines(el)
        data.append(el)
    
    # Write txt files
    for index, email in enumerate(data):
        with open("txt/" + name + "/" + name + "_" + str(index) + ".txt", "w") as text_file:
            text_file.write(email)
        with open("txt/" + name + "/" + name + "_" + str(index) + ".ann", "w") as text_file:
            text_file.write("")


# In[ ]:


# -------------------------------


# In[ ]:


# Do nothing with emails
for name in names:
    prepared_emails = prepare_data.PrepareEmails(path_to_csv=data_path + "csv/" + name + ".csv", remove_stopwords_flag=False)
    
    data = []
    for el in prepared_emails.premature_list:
        data.append(el)
    
    # Write txt files
    for index, email in enumerate(data):
        with open("txt/" + name + "/" + name + "_" + str(index) + ".txt", "w") as text_file:
            text_file.write(email)
        with open("txt/" + name + "/" + name + "_" + str(index) + ".ann", "w") as text_file:
            text_file.write("")

