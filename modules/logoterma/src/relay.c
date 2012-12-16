/*
  * gpio_relay.c - example of driving a relay using the GPIO peripheral on a BCM2835 (Raspberry Pi)
  *
  * Copyright 2012 Kevin Sangeelee.
  * Released as GPLv2, see <http://www.gnu.org/licenses/>
  *
  * This is intended as an example of using Raspberry Pi hardware registers to drive a relay using GPIO. Use at your own
   * risk or not at all. As far as possible, I've omitted anything that doesn't relate to the Raspi registers. There are more
  * conventional ways of doing this using kernel drivers.
  */
#include <stdio.h>
#include <fcntl.h>
#include <sys/mman.h>

#define IOBASE   0x20000000

#define GPIO_BASE (IOBASE + 0x200000)

#define GPFSEL0    *(gpio.addr + 0)
#define GPFSEL1    *(gpio.addr + 1)
#define GPFSEL2    *(gpio.addr + 2)
#define GPFSEL3    *(gpio.addr + 3)
#define GPFSEL4    *(gpio.addr + 4)
#define GPFSEL5    *(gpio.addr + 5)
// Reserved @ word offset 6
#define GPSET0    *(gpio.addr + 7)
#define GPSET1    *(gpio.addr + 8)
// Reserved @ word offset 9
#define GPCLR0    *(gpio.addr + 10)
#define GPCLR1    *(gpio.addr + 11)
// Reserved @ word offset 12
#define GPLEV0    *(gpio.addr + 13)
#define GPLEV1    *(gpio.addr + 14)

#define BIT_17 (1 << 17)

#define PAGESIZE 4096
#define BLOCK_SIZE 4096

struct bcm2835_peripheral {
    unsigned long addr_p;
    int mem_fd;
    void *map;
    volatile unsigned int *addr;
};

struct bcm2835_peripheral gpio = {GPIO_BASE};

// Some forward declarations...
int map_peripheral(struct bcm2835_peripheral *p);
void unmap_peripheral(struct bcm2835_peripheral *p);

int gpio_state = -1;

////////////////
//  main()
////////////////
int main(int argc, char *argv[]) {

    if(argc == 2) {
        if(!strcmp(argv[1], "on"))
            gpio_state = 1;
        if(!strcmp(argv[1], "off"))
            gpio_state = 0;
    }

    if(map_peripheral(&gpio) == -1) {
        printf("Failed to map the physical GPIO registers into the virtual memory space.\n");
        return -1;
    }

    /* Set GPIO 17 as an output pin */
    GPFSEL1 &= ~(7 << 21); // Mask out bits 23-21 of GPFSEL1 (i.e. force to zero)
    GPFSEL1 |= (1 << 21);  // Set bits 23-21 of GPFSEL1 to binary '001'

    if(gpio_state == 0)
        GPCLR0 = BIT_17;
    else if(gpio_state == 1)
        GPSET0 = BIT_17;

    usleep(1);    // Delay to allow any change in state to be reflected in the LEVn, register bit.

    printf( "%s \n",(GPLEV0 & BIT_17) ? "on" : "off");

    unmap_peripheral(&gpio);

    // Done!
}

// Exposes the physical address defined in the passed structure using mmap on /dev/mem
int map_peripheral(struct bcm2835_peripheral *p)
{
   // Open /dev/mem
   if ((p->mem_fd = open("/dev/mem", O_RDWR|O_SYNC) ) < 0) {
      printf("Failed to open /dev/mem, try checking permissions.\n");
      return -1;
   }

   p->map = mmap(
      NULL,
      BLOCK_SIZE,
      PROT_READ|PROT_WRITE,
      MAP_SHARED,
      p->mem_fd,  // File descriptor to physical memory virtual file '/dev/mem'
      p->addr_p      // Address in physical map that we want this memory block to expose
   );

   if (p->map == MAP_FAILED) {
        perror("mmap");
        return -1;
   }

   p->addr = (volatile unsigned int *)p->map;

   return 0;
}

void unmap_peripheral(struct bcm2835_peripheral *p) {

    munmap(p->map, BLOCK_SIZE);
    close(p->mem_fd);
}