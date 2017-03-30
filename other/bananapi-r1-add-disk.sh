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





pi@bpi-iot-ros-ai:~ $ sudo su -
root@bpi-iot-ros-ai:~# df -h
Filesystem      Size  Used Avail Use% Mounted on
/dev/mmcblk0p2  1.6G  1.4G  201M  87% /
udev            435M     0  435M   0% /dev
tmpfs            88M  4.5M   83M   6% /run
tmpfs           437M     0  437M   0% /dev/shm
tmpfs           5.0M  4.0K  5.0M   1% /run/lock
tmpfs           437M     0  437M   0% /sys/fs/cgroup
/dev/mmcblk0p1  256M  208M   48M  82% /boot


pi@bpi-iot-ros-ai:~ $ df -h
Filesystem      Size  Used Avail Use% Mounted on
/dev/sda1        29G  1.5G   26G   6% /
udev            435M     0  435M   0% /dev
tmpfs            88M  8.5M   79M  10% /run
tmpfs           437M     0  437M   0% /dev/shm
tmpfs           5.0M  4.0K  5.0M   1% /run/lock
tmpfs           437M     0  437M   0% /sys/fs/cgroup
/dev/mmcblk0p1  256M  208M   48M  82% /boot

