#!/usr/bin/env python

import RPi.GPIO as GPIO
import paho.mqtt.client as mqtt
from mfrc522 import SimpleMFRC522
from datetime import datetime, date
import time

my_class = "IOT_01CLC"
schedule = "13:20:00"

broker_address = "broker.hivemq.com"
broker_port = 1883
topic = "iot/test1/rfid"

while True:
    # Connect to broker MQTT
    client = mqtt.Client()
    client.connect(broker_address, broker_port)

    # Read data from RFID card
    print('\nWaiting for cards!')
    reader = SimpleMFRC522()
    id, text = reader.read()

    # check for time
    current_time = datetime.now().strftime("%H:%M:%S")
    current_date = date.today().strftime("%Y/%m/%d")
    current_time = datetime.strptime(current_time, "%H:%M:%S")
    schedule_time = datetime.strptime(schedule, "%H:%M:%S")
    current_time_str = current_time.strftime("%H:%M:%S")

    # Calculate late time
    late_time = (current_time - schedule_time).total_seconds()

    # Determine status
    if abs(late_time) <= 900:
        status = "APPEAR"
    else:
        status = "LATE"

    print(f'ID: {id}')
    print(f'Content: {text}')
    print(f'Date: {current_date}')
    print(f'Time: {current_time_str}')
    print(f'Status: {status}')

    # Send data to broker
    data_to_MQTT = str(text) + " " + str(current_time_str) +" "+ str(current_date) + " " + str(status) + " " + str(id);
    client.publish(topic, data_to_MQTT, qos=1, retain=False)
    print(f'=> Sent "{data_to_MQTT}" to "{topic}"!')

    # Disconnect from broker MQTT
    client.disconnect()
    time.sleep(1)

# Clean up GPIO outside the loop
GPIO.cleanup()
