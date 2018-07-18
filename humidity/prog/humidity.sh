#!/bin/bash

while true; do

humidity=$(wget http://192.168.1.105/humidity -q -O -)
#echo $humidity

influx -database=loggers -execute "INSERT humidity value=$humidity"

sleep 10
done
