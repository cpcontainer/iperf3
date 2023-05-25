<?php
    //$output = passthru("pgrep -l iperf3");
    $cmd = exec("pgrep -l iperf3", $output, $return_var);
    //print_r($output);
    //print_r($return_var);
    //echo("<pre>$output</pre>");
    if (isset($output[0])) {
      echo "Iperf3 server is running.<br>";
      echo '<pre>';
      passthru("tail -f /var/log/iperf3.log");
      //passthru("iperf3 -c $ip -p $port --connect-timeout 5000 --logfile /var/log/iperf3.log 2>&1");
      echo '</pre>';

      }
?>