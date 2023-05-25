#!/bin/bash


echo "Iperf Server Running. Logs shown in this page is found in /var/log/iperf3.log" > /var/log/iperf3.log
date >> /var/log/iperf3.log
iperf3 -s --logfile /var/log/iperf3.log