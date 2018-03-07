
# coding: utf-8

# In[1]:


import os
import re
from random import shuffle, seed
seed(1)


# In[2]:


# ✓ Get annotation files that are not empty
# ✓ Get associated email txts
# ✓ Extract information from ann file and save as structured object
# ✓ Tag entities
    # ✓ No-Entity --> "O"
    # ✓ Entity, --> "B-Entity ... I-Entity"
# ✓ Split into training and test data
# ✓ Save to specified directory
# ✓ Disregard whitespaces (currently tagged as "O")
# X Improve splitting of entites
# X Deal with fragmented Entities
# X Deal with relations between entities


# In[3]:


def filled_ann_paths(path_to_files):
    ann_paths = []
    for file in os.listdir(path_to_files):
        if file.endswith(".ann"):
            full_path = os.path.join(path_to_files, file)
            if os.stat(full_path).st_size > 0:
                ann_paths.append(full_path)
    return ann_paths


# In[4]:


def according_email_paths(ann_paths):
    email_paths = []
    for ann_path in ann_paths:
        ann_name = os.path.basename(ann_path)
        email_name = ann_name[0:-4] + '.txt'
        email_paths.append(os.path.dirname(ann_path) + '/' + email_name)
    return email_paths


# In[5]:


def annotation_as_structure(ann_file_path):
    result = []
    with open(ann_file_path, 'r') as file:
        lines = file.readlines()
    for line in lines:
        if line.startswith("T"):  # Go through entities (not relations)
            line = re.sub(r'^T\d+\s+', '', line)  # Remove unnecessary stuff
            tag_and_positions = re.search(r'^\w+ +\d+ +\d+', line).group()  # Extract tag and the positions
            tag = re.search(r'^\w+', tag_and_positions).group()  # Get the tag
            positions = re.findall(r'(?<= )\d+', tag_and_positions)[0:2]  # Get the positions
            positions = list(map(int, positions))  # Convert into integer
            entity = line[len(tag_and_positions) + 1:]  # Get the entity
            result.append({'tag': tag, 'start_pos': positions[0], 'end_pos': positions[1], 'entity': entity})
    return sorted(result, key = lambda el: el['start_pos'])


# In[6]:


def tag_no_ent_part(until_pos, email, pos_in_text):
    no_ent_part = email[pos_in_text:until_pos]  # Grab part that doesn't contain tagged entities
    comb = no_ent_part.split()  # Split by any whitespace
    comb = list(filter(None, comb))  # Remove empty strings
    comb = [s + " O" for s in comb]  # Append "O" to all strings
    return comb
    
def tag_ent_part(ann):
    comb = ann['entity'].split()  # Split by any whitespace
    comb = list(filter(None, comb))  # Remove empty strings
    first = [comb[0] + " B-" + ann['tag']]  # Append "B-" tag
    rest = [s + " I-" + ann['tag'] for s in comb[1:]]  # Append "I-" tags
    return first + rest


# In[7]:


def generate_iob_list(ann_data, email):
    comb = []
    pos_in_text = 0
    for ann in ann_data:
        comb += tag_no_ent_part(ann['start_pos'], email, pos_in_text)
        comb += tag_ent_part(ann)
        pos_in_text = ann['end_pos'] + 1
    comb += tag_no_ent_part(len(email), email, pos_in_text)
    return comb


# In[8]:


def generate_all_iob_lists(ann_paths, email_paths):
    all_lists = []
    for ann_path, email_path in zip(ann_paths, email_paths):
        ann_data = annotation_as_structure(ann_path)
        with open(email_path, 'r') as file:
            email = file.read()

        iob_list = generate_iob_list(ann_data, email)
        all_lists.append(iob_list)
    return all_lists


# In[9]:


email_category = "cargo"


# In[10]:


# Find relevant filepaths ----------------------------------------
ann_paths = filled_ann_paths("/var/www/24vision/PyTools/bulkcargotools/data/txt/" + email_category)
email_paths = according_email_paths(ann_paths)


# In[11]:


# Some testing code ----------------------------------------------
# ann_path = ann_paths[0]
# email_path = email_paths[0]
# ann_data = annotation_as_structure(ann_path)
# with open(email_path, 'r') as file:
#     email = file.read()
# 
# x = generate_iob_list(ann_data, email)
# x


# In[12]:


# Generate iob data -----------------------------------------------
all_iobs = generate_all_iob_lists(ann_paths, email_paths)


# In[13]:


# Make training, validation (test_a) and test (test_b) sets -------
shuffle(all_iobs)
training_percentage = 0.7
nr_of_training_ex = int(len(all_iobs) * training_percentage)
nr_of_test_a_ex = int((len(all_iobs) - nr_of_training_ex) / 2)
training = all_iobs[:nr_of_training_ex]
test_a = all_iobs[nr_of_training_ex:nr_of_training_ex + nr_of_test_a_ex]
test_b = all_iobs[nr_of_training_ex + nr_of_test_a_ex:]


# In[14]:


# Convert data sets to strings and save to disk -------------------
training_str = ""
for l in training:
    s = "\n".join(l)
    training_str += s + "\n\n"
test_a_str = ""
for l in test_a:
    s = "\n".join(l)
    test_a_str += s + "\n\n"
test_b_str = ""
for l in test_b:
    s = "\n".join(l)
    test_b_str += s + "\n\n"

# Write files to specified path
path = "sequence_tagging/data/" + email_category + "/24Vision/iob"
with open(os.path.join(path, "train.iob"), "w") as file:
    file.write(training_str)
with open(os.path.join(path, "test_a.iob"), "w") as file:
    file.write(test_a_str)
with open(os.path.join(path, "test_b.iob"), "w") as file:
    file.write(test_b_str)

