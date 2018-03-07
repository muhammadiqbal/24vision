from classification.contractions import CONTRACTION_MAP
import re
import nltk
import string
from nltk.stem import WordNetLemmatizer
from nltk.corpus import wordnet as wn
from classification.feature_extractors import tfidf_extractor
from sklearn import metrics
import numpy as np
import json
import pickle
from sklearn.svm import SVC
import sys
import os
sys.path.insert(0, os.path.abspath('..'))
import api.api_client as api_client

stopword_list = nltk.corpus.stopwords.words('english')
wnl = WordNetLemmatizer()


#Method: Expand_Contractions( text, contraction_mapping )
#Description:
#   This method will recieve a text (mail) and will transform the contractions to the original form
#   That will help to retrive better the words to the word matrix
#Import Parameters:
#   Text A string , a text we want to use remove the contractions
#   Constraction_mapping , a list of the contractions in english and their respective transformations
#Export Parameters:
#   Expanded_text: string, the text wihtout the contractions
def expand_contractions(text, contraction_mapping):
    contractions_pattern = re.compile('({})'.format(
        '|'.join(contraction_mapping.keys())), flags=re.IGNORECASE | re.DOTALL)

    def expand_match(contraction):
        match = contraction.group(0)
        first_char = match[0]
        expanded_contraction = contraction_mapping.get(match)\
            if contraction_mapping.get(match)\
            else contraction_mapping.get(match.lower())
        expanded_contraction = first_char + expanded_contraction[1:]
        return expanded_contraction
    expanded_text = contractions_pattern.sub(expand_match, text)
    expanded_text = re.sub("'", "", expanded_text)
    return expanded_text

#Method: remove_stopwords( tokens )
#Description:
#   This method will delete the stopwords of the text. The stop words are compared using
#   the stopwords dictionary from NKTK package
#Import parameters:
#   tokens: a token is sentence
#Return parameters:
#   filtered_tokens: the token without stopwords
def remove_stopwords(tokens):
    stopword_list = nltk.corpus.stopwords.words('english')
    filtered_tokens = [token for token in tokens if token not in stopword_list]
    return filtered_tokens

#Method: lemmatize_corpus(text)
#Description:
#   This method will transform the words in their lemma, for example ate -> eat
#bigger -> big . THis will help to count the words better in the word matrix
#Import parameters:
#   text is a string, this text also will need to have the tags per every word, definig what this word is
#   for example. Ate,'V'  , beacuse is a verb . 
#Return parameters:
#   lematized_tokens= the text with all the words tranformed to their lemma
def lemmatize_corpus(text): # In parameter is a tokenized text
    def penn_to_wn_tags(pos_tag):
        if pos_tag.startswith('J'):
            return wn.ADJ
        elif pos_tag.startswith('V'):
            return wn.VERB
        elif pos_tag.startswith('N'):
            return wn.NOUN
        elif pos_tag.startswith('R'):
            return wn.ADV
        else:
            return None

    tagged_text = nltk.pos_tag(text)
    tagged_converted_text = [(word, penn_to_wn_tags(pos_tag))
                             for word, pos_tag in tagged_text]
    lemmatized_tokens = [wnl.lemmatize(word, pos_tag) if pos_tag
                         else word for word, pos_tag in tagged_converted_text]
    return lemmatized_tokens

#Method: normalize_corpus
#Description:
#   This method is the integration of all the methods which are related to the manipulation and normalization 
#   of the text. This method encapsualte, the functions to put the text to lower, expand contractions
#   remove_stopwords, lemmatize the corpus.
#Import parameters:
#   corpus is a string, in this case is every mail that was fetched from the data base
#Export parameter: The corpus with all the normalized text
def normalize_corpus(corpus):
    normalized_corpus = []
    translator = str.maketrans('', '', string.punctuation)
    for i in mailCorpus:
        text = i
        text = text.lower()
        text = expand_contractions(text, CONTRACTION_MAP)
        text = text.translate(translator)
        text = nltk.word_tokenize(text)
        text = remove_stopwords(text)
        text = lemmatize_corpus(text)
        text = ' '.join(text)
        normalized_corpus.append(text)
    return normalized_corpus

#Method: remove_empty_docs
#Description:
#   This method reomve all the mails that have an empty body, also will delete the label in hte label list
#Import parameters:
#   Corpus is a string set, is the set of all the training mails,
#   lables is a string set, is the labels of the training mails
#Export parameters:
# filtered_corpus is a string set, with mail with contend in the body
# filtered_labels is a string set, with the labels of the mails with body
def remove_empty_docs(corpus, labels):
    filtered_corpus = []
    filtered_labels = []
    for doc, label in zip(corpus, labels):
        if doc.strip():
            filtered_corpus.append(doc)
            filtered_labels.append(label)
    return filtered_corpus, filtered_labels


def get_metrics(true_labels, predicted_labels):
    print('Accuracy:', np.round(metrics.accuracy_score(
        true_labels, predicted_labels), 2))
    print('Precision:', np.round(metrics.precision_score(
        true_labels, predicted_labels, average='weighted'), 2))
    print('Recall:', np.round(metrics.recall_score(
        true_labels, predicted_labels, average='weighted'), 2))
    print('F1 Score:', np.round(metrics.f1_score(
        true_labels, predicted_labels, average='weighted'), 2))

#Method: train_predict_evaluate_model( classifier, train_ features, train_labels)
#Description
#This method will do classify the mail with the train featurs and the train labels
# after the prediction model will be saved ( pickle )
#Import parameters:
#   Train features is a word matrix, with all the words of the mails 
#   train labels is a set with all the labels of the training mails
#   
def train_predict_evaluate_model(classifier, train_features, train_labels):
    # build model
    classifier.fit(train_features, train_labels)
    # save the model to disk
    filename = 'svm_email.sav'
    pickle.dump( classifier , open(filename, 'wb'))
    #return predictions


#The clasification  mails are received from the server
#Added a counter to check the no of fetched mails
emails = api_client.query_api_get_classificationtraining(str(5000))
emaildata = json.loads(emails._content.decode('utf-8'))
mailCorpus = []
mailLabels = []
mailID = []
counter = 0
for part in emaildata:
  #  if(part['classification_manual'] != 'Mix'):
        mailCorpus.append(str(part['body']))
        mailLabels.append(part['classification_manual'])
        mailID.append(part['emailID'])
        counter = counter +1
print("no of fetched mails in text_classification: "+str(counter))

labelSet = set(mailLabels)
normalized_corpus = normalize_corpus(mailCorpus)
normalized_corpus, mailLabels = remove_empty_docs(normalized_corpus, mailLabels)
tfidf_vectorizer, tfidf_train_features = tfidf_extractor(normalized_corpus)
filename = 'tfidf_vectorizer.sav' #The word matrix is saved
pickle.dump( tfidf_vectorizer , open(filename, 'wb'))
filename = 'tfidf_train_features.sav' #The train features are saved
pickle.dump( tfidf_train_features  , open(filename, 'wb'))
C = 1.0

#The model is parametrized as a support vector machine
svm_class = SVC(kernel='linear', C=C, probability=True, random_state=0)

train_predict_evaluate_model(classifier=svm_class ,
                             train_features=tfidf_train_features,
                             train_labels= mailLabels ) 
