#!/bin/sh
cd /var/www/html/mt4_data
while [ true ]
do
URA=`date +%H`
DOW=$(date +%u)
if [ "$URA" -ge 8 -a "$URA" -le 19 -a "$DOW" -ge 1 -a "$DOW" -le 5 ]
then
curl http://frx.marefx.com/update
sleep 5
else
echo "Market offline"
sleep 30
fi
done
