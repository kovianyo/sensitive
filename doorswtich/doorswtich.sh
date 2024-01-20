#!/bin/bash

LIGHTPIN=7
DOORPIN=9

while true
do

  # wait for door to open
  gpio wfi $DOORPIN rising

  # wait for state to settle
  sleep 1

  DOORSTATE=`gpio read $DOORPIN`

  # if the door was closed again, then this was only a prell
  if [ "$DOORSTATE" = "0" ]; then
    continue
  fi

  CURRENTSTATE=`gpio -g read $LIGHTPIN`

  echo "Current state: $CURRENTSTATE"

  if [ "$CURRENTSTATE" = "1" ]; then
    TARGETSTATE="0"
  else
    TARGETSTATE="1"
  fi

  echo "Target state: $TARGETSTATE"

  gpio -g write $LIGHTPIN $TARGETSTATE

done
