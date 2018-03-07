import re
import editdistance
import datetime
# import api.api_client as api_client
import logging
from string import punctuation

# set logging file name and format
logging.basicConfig(filename='data_cleaning.log', level=logging.DEBUG)
logging.basicConfig(format='%(levelname)s:%(message)s', level=logging.DEBUG)
# enable or disable logging
logger = logging.getLogger()
logger.disabled = True

now = datetime.datetime.time(datetime.datetime.now())
logging.info('Starting Data Cleaning Script at ' + str(now))

## Define global variables
# emptyString, notFoundString, noSecondDate and noSensibleDate are just for debugging purposes
# in the final product, all should resolve to None
# standard string returned when nothing was extracted
# emptyString = "NONE EXTRACTED"
emptyString = None
# standard string returned when a value couldn't be found
# notFoundString = "NONE FOUND"
notFoundString = None
# standard string returned when no second date could be found in laycan
# noSecondDate = "NO SECOND DATE"
noSecondDate = None
# standard string returned when no sensible date could be found in laycan
# noSensibleDate = "NO SENSIBLE DATE"
noSensibleDate = None
# string distance used for search in port list to allow for typos, for example
stringDist = 0
# minimum number of characters a substring must have, anything above 2 will exclude SU-AO, for example
minChars = 2
# if value needed to be constructed
# constructed = "CONSTRUCTED"
constructed = True
# if value did not need to be constructed
# notConstructed = "NOT CONSTRUCTED"
notConstructed = False

##String and String Cleaning functions
# check is string is either empty or was filled with "NULL" by extraction
def isEmpty(s):
    if not s:
        return True
    else:
        if s.lower() == "null":
            return True
        else:
            return False


# clean a string
def cleanString(s):
    s = removeDigits(s)
    s = removeHyphen(s)
    s = removePunctuation(s)
    s = toLowerCase(s)
    s = stripString(s)
    s = removeTooShort(s)
    return s


# some of these functions are also used for reference/make the code easier understandable
# trim: no leading or trailing spaces
def stripString(s):
    return s.strip()


# remove digits
def removeDigits(s):
    return re.sub(r'\d+', '', s)


# remove punctuation
def removePunctuation(s):
    #return s.translate(None, string.punctuation)
    return ''.join(c for c in s if c not in punctuation)


# switch - with a blanc so that ports like "qasigiannguit-christianshab" still can be found
def removeHyphen(s):
    return s.replace("-", " ")


# remove substrings that have a length shorter than specified in minChars
def removeTooShort(s):
    return ' '.join([w for w in s.split() if len(w) > minChars - 1])


# to lower case
def toLowerCase(s):
    return s.lower()


# split into substrings
def getSubstrings(s):
    return s.split(' ')


# check if a string has substrings
def hasSubstrings(s, c):
    if len(s.split(c)) > 1:
        return True
    else:
        return False

##Functions for String Search
# get substring combinations, ["string1 string2 string3"] -> ["string1 string2"] ["string2 string3"]
def getSubstringCombinations(s):
    combinations = []
    subs = getSubstrings(s)
    for x, y in zip(subs, subs[1:]):
        combinations.append(x + " " + y)
    return combinations


# use distance measure to see if two string match each other
def matches(s1, s2, dist):
    if (editdistance.eval(s1, s2) <= dist):
        return True
    else:
        return False


# return distance between two strings using distance measure
def getDistance(s1, s2):
    return editdistance.eval(s1, s2)


# return closest matching string from list of strings using distance measure
def closestMatch(s, l):
    if notFoundString in l:
        l = [x for x in l if x != notFoundString]
    if len(l) > 0:
        closest = l[0]
        for index in range(len(l)):
            if (getDistance(s, closest) > getDistance(s, l[index])):
                closest = l[index]
        return closest
    else:
        return notFoundString


# search string in a list of strings
# return closest match from list
def searchString(s, l, dist):
    results = []
    for index, val in enumerate(l):
        if (matches(s, val, dist)):
            results.append(val)
    if not results:
        return notFoundString
    else:
        return closestMatch(s, results)


# search string in a list of strings split up into substrings
# return whole string of closest match, not just the substring
def searchInSubstrings(s, l, dist):
    results = []
    for index, val in enumerate(l):
        subs = getSubstrings(val)
        for index2, val2 in enumerate(subs):
            if (matches(s, val2, dist)):
                results.append(val)
    if not results:
        return notFoundString
    else:
        return closestMatch(s, results)


# search substrings of a string in a list of string, which is split up into substrings as well
# return whole string of closest match, not just the substring combination
def searchInSubstringCombinations(s, l, dist):
    results = []
    for index, val in enumerate(l):
        subs = getSubstringCombinations(val)
        for index2, val2 in enumerate(subs):
            if (matches(s, val2, dist)):
                results.append(val)
    if not results:
        return notFoundString
    else:
        return closestMatch(s, results)


# use the passed function on the list of strings s and return closest match
def listMatchWithFunction(fct, s, ss, l, dist):
    results = []
    for index, val in enumerate(ss):
        results.append(fct(val, l, dist))
    return closestMatch(s, results)


# find entry in list: main functions to search with strings
# combines the three functions below
def findEntry(s, l, dist):
    if isEmpty(s):
        return emptyString
    s = cleanString(s)
    results = []
    ##with input string as it is
    # in list
    # "pointe noire" matches port "pointe noire"
    results.append(searchString(s, l, dist))
    # in list being split up into substrings
    # "gronnedal" matches port "gronnedal" in "gronnedal kangilinngui"
    results.append(searchInSubstrings(s, l, dist))
    # in list being split up into substring combinations
    # "port alfred" matches port "port alfred" in "la baie port alfred"
    results.append(searchInSubstringCombinations(s, l, dist))

    ##with substring combinations of input string
    # in list
    # "victoria harbour" in "august victoria harbour" matches "victoria harbour"
    results.append(listMatchWithFunction(searchString, s, getSubstringCombinations(s), l, dist))
    # in list of substrings - has no application here
    # in list being split up into substring combinations
    # "port saguenay" in "september port saguenay" matches "port saguenay" in "chicoutimi port saguenay"
    results.append(listMatchWithFunction(searchInSubstringCombinations, s, getSubstringCombinations(s), l, dist))

    ##with substrings of input string
    # in list
    # "ottawa" in "august ottawa" matches "ottawa"
    # results.append(listMatchWithFunction(searchString, s, getSubstrings(s), l, dist))
    # in list of substrings
    # "gronnedal" in "july gronnedal" matches port "gronnedal" in "gronnedal kangilinngui"
    # results.append(listMatchWithFunction(searchInSubstrings, s, getSubstrings(s), l, dist))
    # in list being split up into substring combinations - has no application here
    result = closestMatch(s, results)
    if result:
        return result
    else:
        return notFoundString