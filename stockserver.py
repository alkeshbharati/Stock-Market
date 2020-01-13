#!/usr/bin/env python3

'''
Author: Zack Oldham
Date: 11/07/2019
Description: This script retrieves stock information in JSON format from the AlphaVantage API and stores in a dictionary, indexed by stock index label.
'''

import time
from wsgiref.simple_server import make_server
from datetime import datetime
from flask import Flask
from flask import request
import json
import _thread
import mysql.connector as mysql
from datetime import datetime
from random import uniform as uf
from alpha_vantage.timeseries import TimeSeries
from pprint import pprint as pp



APP = Flask(__name__)

API_KEYS = ['5XPC56EI8P013YIP',
	    'ENTPODGFKJTF8RLQ',
	    'FM2K9QC4JRABLP65',
	    'NII3MQUH9HPWT5P7',
	    'GWSE0LQK7RGFC861',
	    '9O14BAQ0YGGOSUSL',
            '739EAJSF3K41493F',
            'U5HILTQUSLNJ41WQ', 
            'XICO7EVTXMHG175N', 
            'EFG5Z4BVC8R6IT5U', 
            '0LSA2MUPR2WLUTC2',
            'CHEQ7C6JY6FH76V9', 
            'KSXC6C0BNNHJ7QHN', 
            '4X7VKEPLALHEM3EZ',
            '0X4VUSM4XSBIT4AY', 
            '34KJQHUATTREZTQ4',
            'QIFZUXI4OM5UMQDP', 
            'BRY0QQ5G5AT36FH7', 
            'CPANX0CK64T57VGE', 
            'M5X1YURAPP2BBI1D']

SYMBOLS = ["MMM",
        "AOS", 
        "ABT",
        "ABBV",
        "ACN",
        "ATVI",
        "AYI",
        "ADBE",
        "AAP",
        "AMD",
        "AES",
        "AET",
        "AMG",
        "AFL",
        "A",
        "APD",
        "ALK",
        "AKAM",
        "ALB",
        "ARE",
        "ALXN",
        "ALGN",
        "ALLE",
        "AGN",
        "ADS",
        "LNT",
        "ALL",
        "GOOGL",
        "GOOG",
        "MO",
        "AMZN",
        "AEE",
        "AAL",
        "AEP",
        "AXP",
        "AIG",
        "AMT",
        "AWK",
        "AMP",
        "ABC",
        "AME",
        "AMGN",
        "APH",
        "APC",
        "ADI",
        "ANDV",
        "ANSS",
        "ANTM",
        "AON",
        "APA",
        "AIV",
        "AAPL",
        "AMAT",
        "APTV",
        "ADM",
        "ARNC",
        "AJG",
        "AIZ",
        "T",
        "ADSK",
        "ADP",
        "AZO",
        "AVB",
        "AVY",
        "BHGE",
        "BLL",
        "BAC",
        "BAX",
        "BBT",
        "BDX",
        "BRK.B",
        "BBY",
        "BIIB",
        "BLK",
        "HRB",
        "BA",
        "BKNG",
        "BWA",
        "BXP",
        "BSX",
        "BHF",
        "BMY",
        "AVGO",
        "BF.B",
        "CHRW",
        "CA",
        "COG",
        "CDNS",
        "CPB",
        "COF",
        "CAH",
        "KMX",
        "CCL",
        "CAT",
        "CBOE",
        "CBRE",
        "CBS",
        "CELG",
        "CNC",
        "CNP",
        "CTL",
        "CERN",
        "CF",
        "SCHW",
        "CHTR",
        "CVX",
        "CMG",
        "CB",
        "CHD",
        "CI",
        "XEC",
        "CINF",
        "CTAS",
        "CSCO",
        "C",
        "CFG",
        "CTXS",
        "CME",
        "CMS",
        "KO",
        "CTSH",
        "CL",
        "CMCSA",
        "CMA",
        "CAG",
        "CXO",
        "COP",
        "ED",
        "STZ",
        "GLW",
        "COST",
        "COTY",
        "ETN",
        "EBAY",
        "ECL",
        "EIX",
        "EW",
        "EA",
        "EMR",
        "ETR",
        "EVHC",
        "EOG",
        "EQT",
        "EFX",
        "EQIX",
        "EQR",
        "ESS",
        "EL",
        "RE",
        "ES",
        "EXC",
        "EXPE",
        "EXPD",
        "ESRX",
        "EXR",
        "XOM",
        "FFIV",
        "FB",
        "FAST",
        "FRT"]



STOCK_DATA = {}

HOURLY_DATA = {}



# initialize the stock data dictionary with label, {} pairs
def init_data():
    global SYMBOLS, STOCK_DATA
    
    for symbol in SYMBOLS:
        STOCK_DATA[symbol] = {}
        STOCK_DATA[symbol]["open"] = uf(10, 10000)
        STOCK_DATA[symbol]["high"] = uf(STOCK_DATA[symbol]['open'], 10000)
        STOCK_DATA[symbol]["low"] = uf(10, STOCK_DATA[symbol]['open'])
        STOCK_DATA[symbol]["close"] = None
        STOCK_DATA[symbol]["volume"] = uf(100000, 100000000)


# encrypt a string before sending - key is 123
#def encrypt(raw):
#    encrypted = ''
#    
#    for i in range(len(raw)):
#        ascii_val = ord(raw[i])
#        enc_char = ascii_val ^ 123
#        encrypted = encrypted + chr(enc_char)

#    return encrypted



# convert STOCK_DATA dict to JSON format
def makeJSON():
    global STOCK_DATA
    preJSON =[]
    

    for i,v in enumerate(STOCK_DATA.keys()):
        STOCK_DATA[v]['stock_name'] = v
        preJSON.append(STOCK_DATA[v])
   
    return json.dumps(preJSON)



# convert dict to JSON for dicts that have date as a key
def makeJSON_date(data): 
    preJSON =[]

    for i,v in enumerate(data.keys()):
        date = v.split('-')
        data[v]['date'] = str(date[1] + '/' + date[2] + '/' + date[0])
        preJSON.append(data[v])
   
    return json.dumps(preJSON)



def makeJSON_hour(data):
    preJSON = []

    for i,v in enumerate(data.keys()):
        hour = str(v + ':00')
        data[v]['hour'] = hour
        preJSON.append(data[v])

    return json.dumps(preJSON)



# convert single record to JSON
def makeJSON_single(data):
    preJSON = []
    preJSON.append(data)
    return json.dumps(preJSON)


# Server the hour by hour price of a given stock for today
@APP.route('/hourly', methods=['GET', 'POST'])
def hourly():
    global SYMBOLS, HOURLY_DATA
    result = {}

    symbol = request.args.get('symbol')
    if symbol == None:
        return 'Error 400: Symbol must be provided\n'
    
    if symbol not in SYMBOLS:
        return 'Error 400: Invalid Symbol\n'

    now=(str(datetime.today()).split())[1]
    # print(now)
    currentHour=int(now.split(':')[0])-6
    # currentHour = 10

    i = 9;
    
    # print('i:', i)
    # print('currentHour:', currentHour)

    # print(HOURLY_DATA)

    # result[10] = HOURLY_DATA[symbol][10]

    while i<=16 and i<=currentHour:
        if symbol in HOURLY_DATA and i in HOURLY_DATA[symbol]:
            result[i] = HOURLY_DATA[symbol][i]

        i += 1

    # return encrypt(makeJSON_hour(result))
    return makeJSON_hour(result)


# serve the realtime price of ALL stocks
@APP.route('/all', methods=['GET', 'POST'])
def all():
    global SYMBOLS, STOCK_DATA, HOURLY_DATA		

    if STOCK_DATA == {}:
        init_data()
        # return encrypt(makeJSON())
        return makeJSON()

    now = str(datetime.today()).split()[1]
    currentHour = int(now.split(':')[0]) - 6
    currentMin = int(now.split(':')[1])
    
    for symbol in SYMBOLS:
        if currentHour == 9 and currentMin == 0:
            STOCK_DATA[symbol]["open"] = STOCK_DATA[symbol]['close']
            STOCK_DATA[symbol]["high"] = uf(STOCK_DATA[symbol]['open'], 10000)
            STOCK_DATA[symbol]["low"] = uf(10, STOCK_DATA[symbol]['open'])
            STOCK_DATA[symbol]["close"] = None
            STOCK_DATA[symbol]["volume"] = uf(100000, 100000000)
        
        if (currentHour < 9 or currentHour >= 16) and STOCK_DATA[symbol]["close"] == None:
            STOCK_DATA[symbol]["close"] = uf(STOCK_DATA[symbol]["low"], STOCK_DATA[symbol]["high"]) 
            
        if currentHour >= 9 and currentHour < 16:
            STOCK_DATA[symbol]["high"] += uf(-10, 10)
            
            while STOCK_DATA[symbol]["high"] < STOCK_DATA[symbol]["open"]:
                STOCK_DATA[symbol]["high"] += uf(-10, 10)
                
            STOCK_DATA[symbol]["low"] += uf(-10, 10)
            
            while STOCK_DATA[symbol]["low"] > STOCK_DATA[symbol]['open']:
                STOCK_DATA[symbol]["low"] += uf(-10, 10)
                
                
        if currentMin == 0 and currentHour >= 9 and currentHour <= 16:
            if symbol not in HOURLY_DATA:
                HOURLY_DATA[symbol] = {}
                HOURLY_DATA[symbol][currentHour] = STOCK_DATA[symbol]
        
    # return encrypt(makeJSON())
    return makeJSON()




# Serve the realtime price of the requested stock label
@APP.route('/realtime', methods=['GET', 'POST'])
def realtime():
    global SYMBOLS, STOCK_DATA, HOURLY_DATA		

    symbol = request.args.get('symbol')
    if symbol not in SYMBOLS:
        return 'Error 400: Invalid Symbol\n'
	
    if STOCK_DATA == {}:
        init_data()
        # return encrypt(makeJSON_single(STOCK_DATA[symbol]))
        return makeJSON_single(STOCK_DATA[symbol])

    now = str(datetime.today()).split()[1]
    currentHour = int(now.split(':')[0])-6
    currentMin = int(now.split(':')[1])
    # currentHour = 10
    # currentMin = 0
    if currentHour == 9 and currentMin == 0:
        STOCK_DATA[symbol]['open'] = STOCK_DATA[symbol]['close']
        STOCK_DATA[symbol]['high'] = uf(STOCK_DATA[symbol]['open'], 10000)
        STOCK_DATA[symbol]['low'] = uf(10, STOCK_DATA[symbol]['open'])
        STOCK_DATA[symbol]['close'] = None
        STOCK_DATA[symbol]['volume'] = uf(100000, 100000000)

    if (currentHour < 9 or currentHour >= 16) and STOCK_DATA[symbol]['close'] == None:
        print('realtime...close was none...')
        STOCK_DATA[symbol]['close'] = uf(STOCK_DATA[symbol]['low'], STOCK_DATA[symbol]['high']) 
	
    if currentHour >= 9 and currentHour < 16:
        STOCK_DATA[symbol]['high'] += uf(-10, 10)
	
        while STOCK_DATA[symbol]['high'] < STOCK_DATA[symbol]['open']:
            STOCK_DATA[symbol]['high'] += uf(-10, 10)
            
        STOCK_DATA[symbol]['low'] += uf(-10, 10)
        
        while STOCK_DATA[symbol]['low'] > STOCK_DATA[symbol]['open']:
            STOCK_DATA[symbol]['low'] += uf(-10, 10)
            
            
    if currentMin == 0 and currentHour >= 9 and currentHour <= 16:
        if symbol not in HOURLY_DATA:
            HOURLY_DATA[symbol] = {}
            HOURLY_DATA[symbol][currentHour] = STOCK_DATA[symbol]
            
    # return encrypt(makeJSON_single(STOCK_DATA[symbol]))
    return makeJSON_single(STOCK_DATA[symbol])


# Get the daily data for a symbol for the past month
@APP.route('/pastMonth', methods=['GET', 'POST'])
def pastMonth():
    global SYMBOLS, API_KEYS
    
    symbol = request.args.get('symbol')
    if symbol == None:
        return 'ERROR 400: Symbol must be provided'
    if symbol not in SYMBOLS:
        return 'ERROR 400: Invalid Symbol'
    
    k = 0
    ts = TimeSeries(API_KEYS[k])
    monthData = None
    while monthData == None:
        try:
            monthData, meta = ts.get_daily(symbol=symbol)
        except ValueError:
            k += 1
            if k == len(API_KEYS):
                k = 0
            
            ts = TimeSeries(API_KEYS[k])
            
    result = {}
    i = 0

    for date in monthData:
        result[date] = {}
        result[date]['open'] = monthData[date]['1. open']
        result[date]['high'] = monthData[date]['2. high']
        result[date]['low'] = monthData[date]['3. low']
        result[date]['close'] = monthData[date]['4. close']
        result[date]['volume'] = monthData[date]['5. volume']
        
        i += 1
        
        if i == 20:
            break
        
    # return encrypt(makeJSON_date(result))
    return makeJSON_date(result)


# Get the monthly data for the past year for the given symbol	
@APP.route('/pastYear', methods=['GET', 'POST'])
def pastYear():
    global SYMBOLS, API_KEYS
    symbol = request.args.get('symbol')
    
    if symbol == None:
        return 'ERROR 400: Symbol must be provided'
    if symbol not in SYMBOLS:
        return 'ERROR 400: Invalid Symbol'
    
    k = 0
    ts = TimeSeries(API_KEYS[k])
    yearData = None
    
    while yearData == None:
        try:
            yearData, meta = ts.get_monthly(symbol=symbol)
        except ValueError:
            k += 1
            if k == len(API_KEYS):
                k = 0
                ts = TimeSeries(API_KEYS[k])
                
        result = {}
        i = 0
        
    for month in yearData:
        result[month] = {}
        result[month]['open'] = yearData[month]['1. open']
        result[month]['high'] = yearData[month]['2. high']
        result[month]['low'] = yearData[month]['3. low']
        result[month]['close'] = yearData[month]['4. close']
        result[month]['volume'] = yearData[month]['5. volume']
        
        i += 1
        if i == 12:
            break
        
        
    # return encrypt(makeJSON_date(result))
    return makeJSON_date(result)



# Get the monthly data for the past 5 years for the given symbol	
@APP.route('/pastFiveYears', methods=['GET', 'POST'])
def pastFiveYears():
    global SYMBOLS, API_KEYS
    symbol = request.args.get('symbol')
    
    if symbol == None:
        return 'ERROR 400: Symbol must be provided'
    if symbol not in SYMBOLS:
        return 'ERROR 400: Invalid Symbol'
    
    k = 0
    ts = TimeSeries(API_KEYS[k])
    yearData = None
    
    while yearData == None:
        try:
            yearData, meta = ts.get_monthly(symbol=symbol)
        except ValueError:
            k += 1
            if k == len(API_KEYS):
                k = 0
            ts = TimeSeries(API_KEYS[k])
            
    result = {}
    i = 0

    for month in yearData:
        result[month] = {}
        result[month]['open'] = yearData[month]['1. open']
        result[month]['high'] = yearData[month]['2. high']
        result[month]['low'] = yearData[month]['3. low']
        result[month]['close'] = yearData[month]['4. close']
        result[month]['volume'] = yearData[month]['5. volume']
        
        i += 1
        
        if i == 60:
            break
        
    
    # return encrypt(makeJSON_date(result))
    return makeJSON_date(result)
    


def wait_on_shutdown(httpd):
    #global THREAD_RUNNING
    
    #while THREAD_RUNNING:
    while True:
        time.sleep(0.25)
        
    #time.sleep(0.25)
    #httpd.shutdown()




def main():
    #global CXN
    #updateDB_pastMonth()
    #CURSOR.close()
    #CXN.close()
    
    print('server running...')
    
    try:
        with make_server("127.0.0.1", 9085, APP) as httpd:
            _thread.start_new_thread(wait_on_shutdown, (httpd, ))
            httpd.serve_forever()
    
    except KeyboardInterrupt:
        print('Server Stopped\n')
        exit()


if __name__ == '__main__':
    main()
