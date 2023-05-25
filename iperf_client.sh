#!/bin/bash


echo " Iperf Client Running. Logs shown in this page is found in /var/log/iperf3.log" > /var/log/iperf3.log
#echo $3 $4 >> /var/log/iperf3.log
date >> /var/log/iperf3.log
#iperf3 -s --logfile /var/log/iperf3.log
iperf3 -c $1 -p $2 $* --connect-timeout 5000 --logfile /var/log/iperf3.log