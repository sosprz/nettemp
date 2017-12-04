#! /bin/bash 

apt-get install libssl-dev  libgnutls28-dev  gcc python2.7-dev libldap2-dev libacl1-dev libtalloc-dev libsasl2-dev
cd /tmp
wget ftp://ftp.freeradius.org/pub/freeradius/freeradius-server-3.0.15.tar.gz 
tar -xzf freeradius-server-3.0.15.tar.gz 
cd freeradius-server-3.0.15
./configure
make
make install

cd /usr/local/etc/raddb/certs/

capass=$(cat /dev/urandom | tr -dc 'a-zA-Z0-9' | fold -w 32 | head -n 1)
srvpass=$(cat /dev/urandom | tr -dc 'a-zA-Z0-9' | fold -w 32 | head -n 1)

#ca
cafile=ca.cnf
sed -i -e '/\[ req \]/,/^\[/ s/.*input_password.*/input_password		= '$capass'/' $cafile
sed -i -e '/\[ req \]/,/^\[/ s/.*output_password.*/output_password		= '$capass'/' $cafile

sed -i -e '/\[certificate_authority\]/,/^\[/ s/.*countryName.*/countryName		= PL/' $cafile
sed -i -e '/\[certificate_authority\]/,/^\[/ s/.*stateOrProvinceName.*/stateOrProvinceName		= Radius/' $cafile
sed -i -e '/\[certificate_authority\]/,/^\[/ s/.*localityName.*/localityName		= Poland/' $cafile
sed -i -e '/\[certificate_authority\]/,/^\[/ s/.*organizationName.*/organizationName		= nettemp.pl/' $cafile
sed -i -e '/\[certificate_authority\]/,/^\[/ s/.*emailAddress.*/emailAddress		= admin@nettemp.pl/' $cafile
sed -i -e '/\[certificate_authority\]/,/^\[/ s/.*commonName.*/commonName		= "Local nettemp"/' $cafile

sed -i -e '/\[ CA_default \]/,/^\[/ s/.*default_days.*/default_days		= 1825/' $cafile

#server
serverfile=server.cnf

sed -i -e '/\[ req \]/,/^\[/ s/.*input_password.*/input_password		= '$srvpass'/' $serverfile
sed -i -e '/\[ req \]/,/^\[/ s/.*output_password.*/output_password		= '$srvpass'/' $serverfile

sed -i -e '/\[server\]/,/^\[/ s/.*countryName.*/countryName		= PL/' $serverfile
sed -i -e '/\[server\]/,/^\[/ s/.*stateOrProvinceName.*/stateOrProvinceName		= Radius/' $serverfile
sed -i -e '/\[server\]/,/^\[/ s/.*localityName.*/localityName		= Poland/' $serverfile
sed -i -e '/\[server\]/,/^\[/ s/.*organizationName.*/organizationName		= nettemp.pl/' $serverfile
sed -i -e '/\[server\]/,/^\[/ s/.*emailAddress.*/emailAddress		= admin@nettemp.pl/' $serverfile
sed -i -e '/\[server\]/,/^\[/ s/.*commonName.*/commonName		= "Local nettemp"/' $serverfile

sed -i -e '/\[ CA_default \]/,/^\[/ s/.*default_days.*/default_days		= 1825/' $serverfile


#client
clientfile=client.cnf
sed -i -e '/\[client\]/,/^\[/ s/.*countryName.*/countryName		= PL/' $clientfile
sed -i -e '/\[client\]/,/^\[/ s/.*stateOrProvinceName.*/stateOrProvinceName		= Radius/' $clientfile
sed -i -e '/\[client\]/,/^\[/ s/.*localityName.*/localityName		= Poland/' $clientfile
sed -i -e '/\[client\]/,/^\[/ s/.*organizationName.*/organizationName		= nettemp.pl/' $clientfile
sed -i -e '/\[client\]/,/^\[/ s/.*emailAddress.*/emailAddress		= admin@nettemp.pl/' $clientfile
sed -i -e '/\[client\]/,/^\[/ s/.*commonName.*/commonName		= "Local nettemp"/' $clientfile

sed -i -e '/\[ CA_default \]/,/^\[/ s/.*default_days.*/default_days		= 365/' $clientfile

#make

rm -f *.pem *.der *.csr *.crt *.key *.p12 serial* index.txt*
rm -rf CA
rm -rf CRL
mkdir -p CA
mkdir -p CRL
make ca
make server

# default CLR

capass=$(grep output_password ca.cnf | sed 's/.*=//;s/^ *//')
openssl ca -gencrl -keyfile ca.key -key $capass -cert ca.pem -out CRL/crl.pem -config ./ca.cnf
ln -s /usr/local/etc/raddb/certs/ca.pem CA/
ln -s /usr/local/etc/raddb/certs/CRL/crl.pem CA/
c_rehash CA/


#eap
cp ../mods-available/eap ../mods-available/eap.org
sed -i -e 's/.*private_key_password.*/private_key_password		= '$srvpass'/' ../mods-available/eap
sed -i -e 's/.*ca_file = ${cadir}\/ca.pem.*/#ca_file = ${cadir}\/ca.pem/' ../mods-available/eap
sed -i -e 's/.*check_crl =.*/check_crl = yes/' ../mods-available/eap
sed -i -e 's/.*ca_path = ${cadir}.*/ca_path = ${cadir}\/CA/' ../mods-available/eap
sed -i -e 's/.*check_cert_cn = %{User-Name}.*/check_cert_cn = %{User-Name}/' ../mods-available/eap

#perms
chmod 644 /usr/local/etc/raddb/clients.conf
chmod g+rx -R /usr/local/etc/raddb/certs/
gpasswd -a www-data staff
chmod o+rx -R /usr/local/etc/raddb/certs/
sed -i '214,241 s/^/#/' /usr/local/etc/raddb/sites-enabled/default
sed -i -e 's/.*allow_vulnerable_openssl = no.*/allow_vulnerable_openssl = yes/' /usr/local/etc/raddb/radiusd.conf


