# ;
# Makefile:
###############################################################################
#
#  DHT Temperature & Humidity Sensor library for use on 
#  FoxG20 embedded Linux board (by ACME Systems).
#
###############################################################################

DYN_VERS_MAJ=0
DYN_VERS_MIN=1

VERSION=$(DYN_VERS_MAJ).$(DYN_VERS_MIN)
DESTDIR=/usr
PREFIX=/local

STATIC=libdht.a
DYNAMIC=libdht.so.$(VERSION)

#DEBUG	= -g -O0
DEBUG	= -O2
CC	= gcc
INCLUDE	= -I.
DEFS	= -D_GNU_SOURCE
CFLAGS	= $(DEBUG) $(DEFS) -Wformat=2 -Wall -Winline $(INCLUDE) -pipe -fPIC

LIBS    =

# Should not alter anything below this line
###############################################################################

SRC	=	dht.c dht_spi.c dht_gpio.c

OBJ	=	$(SRC:.c=.o)

all:		$(DYNAMIC)

static:		$(STATIC)

$(STATIC):	$(OBJ)
	@echo "[Link (Static)]"
	@ar rcs $(STATIC) $(OBJ)
	@ranlib $(STATIC)
#	@size   $(STATIC)

$(DYNAMIC):	$(OBJ)
	@echo "[Link (Dynamic)]"
	@$(CC) -shared -Wl,-soname,libdht.so -o libdht.so.$(VERSION) -lrt $(OBJ)

.c.o:
	@echo [Compile] $<
	@$(CC) -c $(CFLAGS) $< -o $@

.PHONEY:	clean
clean:
	@echo "[Clean]"
	@rm -f $(OBJ) $(OBJ_I2C) *~ core tags Makefile.bak libdht.*

.PHONEY:	tags
tags:	$(SRC)
	@echo [ctags]
	@ctags $(SRC)


.PHONEY:	install-headers
install-headers:
	@echo "[Install Headers]"
	@install -m 0755 -d		$(DESTDIR)$(PREFIX)/include
	@install -m 0644 dht.h		$(DESTDIR)$(PREFIX)/include

.PHONEY:	install
install:	$(DYNAMIC) install-headers
	@echo "[Install Dynamic Lib]"
	@install -m 0755 -d					$(DESTDIR)$(PREFIX)/lib
	@install -m 0755 libdht.so.$(VERSION)			$(DESTDIR)$(PREFIX)/lib/libdht.so.$(VERSION)
	@ln -sf $(DESTDIR)$(PREFIX)/lib/libdht.so.$(VERSION)	$(DESTDIR)/lib/libdht.so
	@ldconfig

.PHONEY:	install-static
install-static:	$(STATIC) install-headers
	@echo "[Install Static Lib]"
	@install -m 0755 -d		$(DESTDIR)$(PREFIX)/lib
	@install -m 0755 libdht.a	$(DESTDIR)$(PREFIX)/lib

.PHONEY:	uninstall
uninstall:
	@echo "[UnInstall]"
	@rm -f $(DESTDIR)$(PREFIX)/include/dht.h
	@rm -f $(DESTDIR)$(PREFIX)/lib/libdht.*
	@ldconfig


# DO NOT DELETE

dht.o: dht.h
 
