import re
import datetime
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
# if value needed to be constructed
# constructed = "CONSTRUCTED"
constructed = True
# if value did not need to be constructed
# notConstructed = "NOT CONSTRUCTED"
notConstructed = False

# check is string is either empty or was filled with "NULL" by extraction
def isEmpty(s):
    if not s:
        return True
    else:
        if s.lower() == "null":
            return True
        else:
            return False

# remove punctuation
def removePunctuation(s):
    #return s.translate(None, string.punctuation)
    return ''.join(c for c in s if c not in punctuation)


##REGEX PATTERN MATCHING
##LAYCAN - COLUMN
# find the date in a string using various regular expressions, focussing on complete dates and
# trying to complete dates with missing information

##Functions used in conjuction with the regular expressions above to create sensible dates
# add month from mail to day and year:
def addMonth(day, year, mailDate):
    if isinstance(mailDate, datetime.date):
        if int(day) < int(mailDate.day):
            if mailDate.month == 12:
                return str(day) + "." + 1 + "." + str(year + 1)
            else:
                return str(day) + "." + str(mailDate.month + 1) + "." + str(year)
        else:
            return str(day) + "." + str(mailDate.month) + "." + str(year)
    else:
        return notFoundString


# add month and year from mail to day and make sure it's in the future
def addMonthAndYear(day, mailDate):
    if isinstance(mailDate, datetime.date):
        # check if to use this or next year
        if int(day) < int(mailDate.day):
            if mailDate.month == 12:
                return str(day) + "." + 1 + "." + str(mailDate.year + 1)
            else:
                return str(day) + "." + str(mailDate.month + 1) + "." + str(mailDate.year)
        else:
            return str(day) + "." + str(mailDate.month) + "." + str(mailDate.year)
    else:
        return notFoundString


# add year from mail to month and day
def addYear(day, month, mailDate):
    if isinstance(mailDate, datetime.date):
        return str(day) + "." + str(month) + "." + str(mailDate.year)
    else:
        return notFoundString


# check if sensible date by checking if constructed date is in the (near) future of the date the email was received
# there actually are some mails where the Laycan is before the mail date so this is out for now
def isSensibleDate(consDate, mailDate):
    return True
    # if isinstance(consDate, datetime.date) & isinstance(mailDate, datetime.date):
    #    if consDate >= mailDate:
    #        return True


# convert 17 to 2017 using a delimiter like / or .
def completeYear(s, deli):
    subs = s.split(deli)
    if len(subs) == 3:
        year = "20" + subs[2]
        return subs[0] + "." + subs[1] + "." + str(year)
    else:
        return notFoundString


# takes a month, either complete or abbreviated, return corresponding number
def convertMonthToNumber(s):
    s = str(s)
    s = s.lower()
    s = removePunctuation(s)
    months = ['jan', 'feb', 'mar', 'apr', 'may', 'jun', 'jul', 'aug', 'sep', 'oct', 'nov', 'dec']
    if s in months:
        return months.index(s) + 1
    else:
        months = ['january', 'february', 'march', 'april', 'may', 'june', 'july', 'august', 'september', 'october',
                  'november', 'december']
        if s in months:
            return months.index(s) + 1
        else:
            return notFoundString


# when two dates are given, split them up an return two proper dates
# deli1: delimiter used for the two days, deli2: delimiter used for rest
def createTwoDatesComplete(s, deli1, monyea, deli2):
    days = re.findall('\d{1,2}' + deli1 + '\d{1,2}', s)
    days = re.findall('\d{1,2}', days[0])
    day1 = days[0]
    day2 = days[1]
    month = monyea.split(deli2)[0]
    year = monyea.split(deli2)[1]
    dates = []
    dates.append(day1 + "." + month + "." + year)
    dates.append(day2 + "." + month + "." + year)
    return dates

# identify complete dates, i.e. when day, month and year are given
def findCompleteDate(s, mailDate):
    s = str(s)
    if isEmpty(s):
        return emptyString
    s = s.lower()
    s = s.strip()
    if s.__contains__("spot"):
        return mailDate
    months = "(?:jan(?:uary)?|feb(?:ruary)?|mar(?:ch)?|apr(?:il)?|may|jun(?:e)?|jul(?:y)?|aug(?:ust)?|sep(?:tember)?|oct(?:ober)?|nov(?:ember)?|dec(?:ember)?)"
    ###COMPLETE DATES, i.e. with day+month+year
    ##DAY / DAY + MONTH + YEAR
    # "15-20/07/2017"
    date = re.findall('\d{1,2}\-\d{1,2}\/\d{1,2}\/\d{4}', s)
    if date:
        logging.debug('found dd-dd/mm/yyy')
        monyea = re.findall('\d{1,2}/\d{4}', s)
        return createTwoDatesComplete(date[0], "-", monyea[0], "/")
    # "15:20/07/2017"
    date = re.findall('\d{1,2}\:\d{1,2}\/\d{1,2}\/\d{4}', s)
    if date:
        logging.debug('found dd:dd/mm/yyyy')
        monyea = re.findall('\d{1,2}\/\d{4}', s)
        return createTwoDatesComplete(date[0], ":", monyea[0], "/")
    ##DAY MONTH YEAR
    # "20/07/17"
    date = re.findall('\d{1,2}\/\d{1,2}\/\d{2}', s)
    if date:
        logging.debug('found dd/mm/yy')
        return completeYear(date[0].replace("/", "."), ".")
    # "20/07/2017"
    date = re.findall('\d{1,2}\/\d{1,2}\/\d{4}', s)
    if date:
        logging.debug('found dd/mm/yyyy')
        return date[0].replace("/", ".")
    # "20.07.17"
    date = re.findall('\d{1,2}\.\d{1,2}\.\d{2}', s)
    if date:
        logging.debug('found dd.mm.yy')
        return completeYear(date[0], ".")
    # "20.07.2017"
    date = re.findall('\d{1,2}\.\d{1,2}\.\d{4}', s)
    if date:
        logging.debug('found dd.mm.yyyy')
        return date
    # "21st jul 2017", "3rd august 2018"
    date = re.findall(
        '\d{1,2}\s?(?:st|nd|rd|th)\s' + months + '\s\d{4}',
        s)
    if date:
        logging.debug('found ddst/nd/rd/th month/mon yyyy')
        day = re.findall('\d{1,2}', s)[0]
        month = re.findall(
            months,
            s)[0]
        year = re.findall('\d{4}', s)[0]
        return str(day) + "." + str(convertMonthToNumber(month)) + "." + str(year)
    # "21. jul 2017", "3. august 2018"
    date = re.findall(
        '\d{1,2}\.\s' + months + '\s\d{4}',
        s)
    if date:
        logging.debug('found dd. month/mon yyyy')
        day = re.findall('\d{1,2}', s)[0]
        month = re.findall(
            months,
            s)[0]
        year = re.findall('\d{4}', s)[0]
        return str(day) + "." + str(convertMonthToNumber(month)) + "." + str(year)
    # "21 jul 2017", "3 august 2018"
    date = re.findall(
        '\d{1,2}\s' + months + '\s\d{4}',
        s)
    if date:
        logging.debug('found dd month/mon yyyy')
        day = re.findall('\d{1,2}', s)[0]
        month = re.findall(
            months,
            s)[0]
        year = re.findall('\d{4}', s)[0]
        return str(day) + "." + str(convertMonthToNumber(month)) + "." + str(year)
    # "21-jul-2017", "3-august-2018"
    date = re.findall(
        '\d{1,2}\-' + months + '\-\d{4}',
        s)
    if date:
        logging.debug('found dd-month/mon-yyyy')
        day = re.findall('\d{1,2}', s)[0]
        month = re.findall(
            months,
            s)[0]
        year = re.findall('\d{4}', s)[0]
        return str(day) + "." + str(convertMonthToNumber(month)) + "." + str(year)
    # "21-jul-17", "3-august-18"
    date = re.findall(
        '\d{1,2}\-' + months + '\-\d{2}',
        s)
    if date:
        logging.debug('found dd-month/mon-yy')
        day = re.findall('\d{1,2}', s)[0]
        month = re.findall(
            months,
            s)[0]
        year = str(date[0][-2:])
        return completeYear(str(day) + "." + str(convertMonthToNumber(month)) + "." + str(year), ".")

    return notFoundString


# search for incomplete dates, i.e. when either day, month or year are missing, use information from the mailDate
def findIncompleteDate(s, mailDate):
    s = str(s)
    if isEmpty(s):
        return emptyString
    s = s.lower()
    s = s.strip()
    if s.__contains__("spot"):
        return mailDate
    months = "(?:jan(?:uary)?|feb(?:ruary)?|mar(?:ch)?|apr(?:il)?|may|jun(?:e)?|jul(?:y)?|aug(?:ust)?|sep(?:tember)?|oct(?:ober)?|nov(?:ember)?|dec(?:ember)?)"
    ###INCOMPLETE DATES, i.e. only 2 of the 3 (day month year), complete dates might be constructed using the mail date
    ##DAY / DAY + YEAR
    # "15/20 2017"
    date = re.findall('\d{1,2}\/\d{1,2}\s\d{4}', s)
    if date:
        logging.debug('found dd/dd yyyy')
        days = re.findall('\d{1,2}\/\d{1,2}', date[0])
        days = days[0].split("/")
        year = re.findall('\d{4}', date[0])[0]
        dates = []
        dates.append(addMonth(days[0], year, mailDate))
        dates.append(addMonth(days[1], year, mailDate))
        return dates
    # "15-20 2017"
    date = re.findall('\d{1,2}\-\d{1,2}\s\d{4}', s)
    if date:
        logging.debug('found dd-dd yyyy')
        days = re.findall('\d{1,2}\-\d{1,2}', date[0])
        days = days[0].split("-")
        year = re.findall('\d{4}', date[0])[0]
        dates = []
        dates.append(addMonth(days[0], year, mailDate))
        dates.append(addMonth(days[1], year, mailDate))
        return dates
    # "15:20 2017"
    date = re.findall('\d{1,2}\:\d{1,2}\s\d{4}', s)
    if date:
        logging.debug('found dd:dd yyyy')
        days = re.findall('\d{1,2}\:\d{1,2}', date[0])
        days = days[0].split(":")
        year = re.findall('\d{4}', date[0])[0]
        dates = []
        dates.append(addMonth(days[0], year, mailDate))
        dates.append(addMonth(days[1], year, mailDate))
        return dates
    ##DAY / DAY + MONTH
    # "15-20 08"
    date = re.findall('\d{1,2}\-\d{1,2}\s\d{1,2}', s)
    if date:
        logging.debug('found dd-dd mm')
        days = re.findall('\d{1,2}\-\d{1,2}', date[0])
        temp = date[0].replace(days[0], "")
        month = re.findall('\d{1,2}', temp)[0]
        days = days[0].split("-")
        dates = []
        dates.append(addYear(days[0], month, mailDate))
        dates.append(addYear(days[1], month, mailDate))
        return dates
    # "15:20 08"
    date = re.findall('\d{1,2}\:\d{1,2}\s\d{1,2}', s)
    if date:
        logging.debug('found dd:dd mm')
        days = re.findall('\d{1,2}\:\d{1,2}', date[0])
        temp = date[0].replace(days[0], "")
        month = re.findall('\d{1,2}', temp)[0]
        days = days[0].split(":")
        dates = []
        dates.append(addYear(days[0], month, mailDate))
        dates.append(addYear(days[1], month, mailDate))
        return dates

    ##DAY MONTH
    # "21st july", "22nd jan", "25th dec" ,"21st July - 05th August"
    date = re.findall(
        '\d{1,2}\s?(?:st|nd|rd|th)\s?' + months,
        s)
    if date:
        logging.debug('found ddst/nd/rd/th mon/month')
        #only one date
        if len(date) == 1:
            day = re.findall('\d{1,2}',
                             date[0])
            month = re.findall(months, date[0])[0]
            return addYear(day[0], convertMonthToNumber(month), mailDate)
        #two dates
        elif len(date) ==2:
            day1 = re.findall('\d{1,2}',
                              date[0])[0]
            month1 = re.findall(months, date[0])[0]
            day2 = re.findall('\d{1,2}',
                              date[1])[0]
            # see if there is a second month, else use first one
            month2 = re.findall(months, date[0])
            if len(month2)>1:
                month2 = month2[1]
            else:
                month2 = month2[0]
            result = []
            result.append(addYear(day1, convertMonthToNumber(month1), mailDate))
            result.append(addYear(day2, convertMonthToNumber(month2), mailDate))
            return result
    # "12/06"
    date = re.findall('\d{1,2}\/\d{1,2}', s)
    if date:
        logging.debug('found dd/mm')
        temp = date[0].split("/")
        return addYear(temp[0], temp[1], mailDate)
    # "12.06"
    date = re.findall('\d{1,2}\.\d{1,2}', s)
    if date:
        logging.debug('found dd.mm')
        temp = date[0].split(".")
        return addYear(temp[0], temp[1], mailDate)
    # DAY + DAY
    # "10-12"
    date = re.findall('\d{1,2}\-\d{1,2}', s)
    if date:
        logging.debug('found dd-dd')
        temp = date[0].split("-")
        dates = []
        dates.append(addMonthAndYear(temp[0], mailDate))
        dates.append(addMonthAndYear(temp[1], mailDate))
        return dates
    # Might not be necessary
    # "10-12th"
    date = re.findall('\d{1,2}\-\d{1,2}\s?(?:st|nd|rd|th)', s)
    if date:
        logging.debug('found dd-dd_|st|nd|rd|th')
        days = re.findall('\d{1,2}\-\d{1,2}', date[0])
        temp = days[0].split("-")
        dates = []
        dates.append(addMonthAndYear(temp[0], mailDate))
        dates.append(addMonthAndYear(temp[1], mailDate))
        return dates
    # "10:12"
    date = re.findall('\d{1,2}\:\d{1,2}', s)
    if date:
        logging.debug('found dd:dd')
        temp = date[0].split(":")
        dates = []
        dates.append(addMonthAndYear(temp[0], mailDate))
        dates.append(addMonthAndYear(temp[1], mailDate))
        return dates
    # DAY
    # "ddst"
    date = re.findall('\d{1,2}\s?(?:st|nd|rd|th)', s)
    if date:
        logging.debug('found ddst/nd/rd/th')
        date = re.findall('\d{1,2}', date[0])
        return addMonthAndYear(date[0], mailDate)
    # "12"
    date = re.findall('\d{1,2}', s)
    if date:
        logging.debug('found dd')
        return addMonthAndYear(date[0], mailDate)

    return notFoundString


# main function to find date using the maildate; this one checks only if a date is empty and add the constructed value
def findDate(s, mailDate):
    # an empty string was given
    if isEmpty(s):
        result = {}
        result["first_date"] = emptyString
        result["second_date"] = emptyString
        result["constructed_date"] = notConstructed
        return result
    # check if mailDate is a date
    if not isinstance(mailDate, datetime.date):
        # create a dummy date
        newDate = mailDate

    date = findDate2(s, mailDate, findCompleteDate)
    # first, search for complete dates and return notConstructed
    if date["first_date"] != notFoundString:
        result = {}
        result["first_date"] = date["first_date"]
        result["second_date"] = date["second_date"]
        result["constructed_date"] = notConstructed
        return result
    date = findDate2(s, mailDate, findIncompleteDate)
    # second, search for incomplete dates and return constructed
    if date["first_date"] != notFoundString:
        result = {}
        result["first_date"] = date["first_date"]
        result["second_date"] = date["second_date"]
        result["constructed_date"] = constructed
        return result
    else:
        result = {}
        result["first_date"] = date["first_date"]
        result["second_date"] = date["second_date"]
        result["constructed_date"] = notConstructed
        return result


# checks if the found or created dates are valid and prepares the output accordingly
def findDate2(s, mailDate, funct):
    result = {}
    d = funct(s, mailDate)
    # only one date was found
    if not isinstance(d, list):
        # check if either not found or empty for some reason
        if d == emptyString:
            result["first_date"] = emptyString
            result["second_date"] = emptyString
            return result
        elif d == notFoundString:
            result["first_date"] = notFoundString
            result["second_date"] = notFoundString
            return result
        # try to create a date out of the output and see if findDate worked correctly
        try:
            d = datetime.datetime.strptime(d, '%d.%m.%Y')
            if isSensibleDate(d, mailDate):
                result["first_date"] = str(d)
                result["second_date"] = noSecondDate
            else:
                result["first_date"] = noSensibleDate
                result["second_date"] = noSensibleDate
        except ValueError:
            result["first_date"] = notFoundString
            result["second_date"] = notFoundString
    # two dates were found
    elif len(d) == 2:
        if d[0] == emptyString:
            result["first_date"] = emptyString
        else:
            # try to create a date out of the output and see if findDate worked correctly
            try:
                d1 = datetime.datetime.strptime(d[0], '%d.%m.%Y')
                if isSensibleDate(d1, mailDate):
                    result["first_date"] = str(d1)
                else:
                    result["first_date"] = noSensibleDate
            except ValueError:
                result["first_date"] = notFoundString
        if d[1] == emptyString:
            result["second_date"] = emptyString
        else:
            # try to create a date out of the output and see if findDate worked correctly
            try:
                d2 = datetime.datetime.strptime(d[1], '%d.%m.%Y')
                if isSensibleDate(d2, mailDate):
                    result["second_date"] = str(d2)
                else:
                    result["second_date"] = noSensibleDate
            except ValueError:
                result["second_date"] = notFoundString
    # no date was found/too many were found, which should not be the case
    else:
        result["first_date"] = notFoundString
        result["second_date"] = notFoundString
    return result
