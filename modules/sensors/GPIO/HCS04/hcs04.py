#!/usr/bin/python

# Author  : Matt Hawkins
# Date    : 09/01/2013
# Modifty : techfreak.pl
# Date;   : 27/01/2015
#http://stackoverflow.com/questions/14920384/stop-code-after-time-period
 
# Import required Python libraries
import time
import RPi.GPIO as GPIO
import multiprocessing
import time


def foo():
    GPIO.setmode(GPIO.BCM)
    # Define GPIO to use on Pi
    GPIO_TRIGGER = 23
    GPIO_ECHO = 24
    # Set pins as output and input
    GPIO.setup(GPIO_TRIGGER,GPIO.OUT)  # Trigger
    GPIO.setup(GPIO_ECHO,GPIO.IN)      # Echo
    #Set trigger to False (Low)
    GPIO.output(GPIO_TRIGGER, False)
 
    # Allow module to settle
    time.sleep(0.5)
 
    # Send 10us pulse to trigger
    GPIO.output(GPIO_TRIGGER, True)
    time.sleep(0.00001)
    GPIO.output(GPIO_TRIGGER, False)
    start = time.time()
    while GPIO.input(GPIO_ECHO)==0:
	start = time.time()
 
    while GPIO.input(GPIO_ECHO)==1:
	stop = time.time()
 
    # Calculate pulse length
    elapsed = stop-start
 
    # Distance pulse travelled in that time is time
    # multiplied by the speed of sound (cm/s)
    distance = elapsed * 34000
 
    # That was the distance there and back so halve the value
    distance = distance / 2
 
    print "%.1f" % distance



    # Reset GPIO settings
    GPIO.cleanup()


if __name__ == '__main__':
    # Start foo as a process
    p = multiprocessing.Process(target=foo, name="Foo")
    p.start()

    # Wait 10 seconds for foo
    time.sleep(1)

    # Terminate foo
    p.terminate()

    # Cleanup
    p.join()






