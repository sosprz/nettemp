<?php
$instruction="./sdmfake /dev/ttyUSB0 1 2>&1";
exec($instruction, $result);

foreach ($result as $line) {
    echo "$line\n";
}


?>