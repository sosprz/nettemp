# 
# Makefile:
#
###############################################################################


RM	=\rm -f
PROG	=dhtsensor
BINPATH	=/usr/local/bin

CC	= gcc
INCLUDE	= -I.
CFLAGS	= $(DEBUG) $(INCLUDE) -Wformat=2 -Wall -Winline  -pipe -fPIC 


# List of objects files for the dependency
OBJS_DEPEND= -ldht

# OPTIONS = --verbose

all: target

target: Makefile
	@echo "--- Compile and Link: $(PROG) ---"
	$(CC) $(PROG).c -o $(PROG) $(CFLAGS) $(OBJS_DEPEND) $(OPTIONS)

clean :
	@echo "---- Cleaning all object files in all the directories ----"
	$(RM) $(PROG) $(PROG).o

install : target
	@echo "---- Install binaries ----"
	cp $(PROG) $(BINPATH)
