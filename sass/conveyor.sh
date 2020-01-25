#!/bin/sh

inotifywait -m ./*.scss -e modify -e create -e delete_self | while read line;
do
    make
done
