#!/bin/bash
if [ -f $1 ]
then
    if [ -n "$2" ] && [ -f $2 ] 
    then
        timeout 5s /usr/bin/time -f "\n%E" $1 < $2
    else
        timeout 5s /usr/bin/time -f "\n%E" $1
    fi
    exit 0
else
    exit -1
fi