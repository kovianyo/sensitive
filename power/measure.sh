#!/bin/bash

while true; do

RAWVOLTAGE=`wget -q -S -O - http://192.168.1.102/voltage`
VOLTAGE=`echo "scale=1; $RAWVOLTAGE/10" | bc`

RAWCURRENT=`wget -q -S -O - http://192.168.1.102/current`
CURRENT=`echo "scale=2; $RAWCURRENT/100" | bc`

POWER=`wget -q -S -O - http://192.168.1.102/power`

ENERGY=`wget -q -S -O - http://192.168.1.102/energy`

echo "$VOLTAGE V, $CURRENT A, $POWER W, $ENERGY Wh"

mysql -u kovi -e "USE ajto; INSERT INTO power VALUES(null, $POWER, $VOLTAGE, $CURRENT, $ENERGY, null);"

sleep 2
done
