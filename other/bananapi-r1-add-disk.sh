#! /bin/bash

echo Are You ready add disk to Your Banana Pi device? 
read x

if [ "$x" == "runbaby" ]
then

 
# Czyszczenie sektra trzymajacego informacje o partcjach
dd if=/dev/zero of=/dev/sda bs=512 count=1 conv=notrunc

# Tworzenie partcji
(
echo o # Create a new empty DOS partition table
echo n # Add a new partition
echo p # Primary partition
echo 1 # Partition number
echo   # First sector (Accept default: 1)
echo   # Last sector (Accept default: varies)
echo w # Write changes
) | fdisk /dev/sda

# Tworzeenie systemu plików
mkfs.ext4 /dev/sda1

# Instalacja pakietów
aptitude update && aptitude install rsync u-boot-tools

# Monotwanie dysku i kopiowanie dotychczasowej partycji na nowy dysk
mkdir /tmp/sata
mount /dev/sda1 /tmp/sata
rsync -arx --progress / /tmp/sata
sync
umount /tmp/sata

# Zmiana wpisu w pliku rozruchowym boot.cmd, która partycja to root i skompilowanie pliku boot.scr, który jest rozumiany przez bootloader U-BOOT
mount /dev/mmcblk0p1 /boot
cd /boot/bananapi/bpi-r1/linux
mv boot.scr boot.scr.old
sed -i -e 's/root=${root}/root=\/dev\/sda1/g' boot.cmd
sed -i -e 's/root=\/dev\/mmcblk0p2/root=\/dev\/sda1/g' boot.cmd
mkimage -C none -A arm -T script -d boot.cmd boot.scr

# Restart
reboot

fi
