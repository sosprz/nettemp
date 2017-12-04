CC = gcc
CFLAGS = `pkg-config --cflags libmodbus`
LDFLAGS = `pkg-config --libs libmodbus`

SDM = sdm120c
%.o: %.c
	$(CC) -c -o $@ $< $(CFLAGS)

${SDM}: sdm120c.o 
	$(CC) -o $@ sdm120c.o $(LDFLAGS)

clean:
	rm -f *.o ${SDM}

install: ${SDM}
	install -m 4711 $(SDM) /usr/local/bin

uninstall:
	rm -f /usr/local/$(SDM)
