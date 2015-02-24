/************************************************************************
  This is an example program which uses the DHT Temperature & Humidity 
  Sensor library for use on FoxG20 embedded Linux board (by ACME Systems).

  Author: Ondrej Wisniewski
  
  Build command (make sure to have dhtlib built and installed):
  gcc -o dhtsensor dhtsensor.c -ldht
  
************************************************************************/

#include <stdio.h>
#include <stdlib.h>
#include <stdint.h>
#include <string.h>
#include <unistd.h>

#include "dht.h"

#define MAX_RETRIES 3


int main(int argc, char* argv[])
{
   uint8_t data_pin  = 0;
   uint8_t power_pin  = 0;
   DHT_MODEL_t model = AUTO_DETECT;
   int retry = MAX_RETRIES;
 
   
   /* Parse command line */
   switch (argc)
   {   
      case 2:  /* 1 paramters provided */
      case 3:  /* 2 paramters provided */
      case 4:  /* 3 paramters provided */
         /* Get first parameter: sensor type */ 
         if (strcmp(argv[1], "DHT11")==0) model = DHT11;
         else if (strcmp(argv[1], "DHT22")==0) model = DHT22;
         else
         {
            printf("Unknown sensor model %s\n", argv[1]);
            return -1;
         }

         /* Get second parameter: data pin */ 
         if (argc==3)
         {
            /* Get Kernel Id of data pin */
            data_pin = atoi(argv[2]);
         }
         
         /* Get third parameter: power pin */ 
         if (argc==4)
         {
            /* Get Kernel Id of power pin */
            power_pin = atoi(argv[3]);
         }
      break;
      
      default: /* print help message */
         printf("dhtsensor - read temperature and humidity data from DHT11 and DHT22 sensors\n\n");
         printf("Usage: dhtsensor <sensor type> [<data pin>] [<power pin>]\n");
         printf("       sensor type: DHT11|DHT22 \n");
         printf("       data pin:    Kernel Id of GPIO data pin (not needed for SPI communication mode)\n");
         printf("       power pin:   Kernel Id of GPIO power pin (optional)\n");
         return -1;
   }

   /* Power on the sensor */
   if (power_pin) dhtPoweron(power_pin);
   
   /* Init sensor communication */
   dhtSetup(data_pin, model);
   if (getStatus() != ERROR_NONE)
   {
      printf("Error during setup: %s\n", getStatusString());
      return -1;
   }

   /* Read sensor with retry */
   do    
   {
      readSensor();
   
      if (getStatus() == ERROR_NONE)
      {
         printf("Rel. Humidity: %3.1f %%\n", getHumidity());
         printf("Temperature:   %3.1f °C\n", getTemperature());
      }
      else
      {
         sleep(2);
      }
   }
   while ((getStatus() != ERROR_NONE) && retry--);
   
   if (getStatus() != ERROR_NONE)
   {
      printf("Error reading sensor: %s\n", getStatusString());
   }
   
   /* Cleanup */
   dhtCleanup();

   /* Power off the sensor */
   if (power_pin) dhtPoweroff(power_pin);
   
   return 0;
}
