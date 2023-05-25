#!/bin/bash


echo "Iperf3 Repeat Client Running. Logs found in /var/log/iperf3.log" > /var/log/iperf3.log

while true; do
  echo "################################" >> /var/log/iperf3.log
  date >> /var/log/iperf3.log
  iperf3 -c $1 -p $2 $* --connect-timeout 5000 --logfile /var/log/iperf3.log
  sleep $3

  raw_file_size=$(du -sk /var/log/iperf3.log)
  #echo $fraw_file_size >> /var/log/iperf3.log
  file_size=$(awk -F" " '{print $1}' <<< $raw_file_size)

  #echo $file_size >> /var/log/iperf3.log
  if [ $file_size -gt 100000 ]
  then
    echo "Iperf3 logs rotated" > /var/log/iperf3.log
  fi

done