<!DOCTYPE html>
<html lang="en">

<!--
<script type=“text/javascript” >
function display(id){
document.getElementById(id).style.display = '';
}
function hide(id){
document.getElementById(id).style.display = 'none';
}
</script>
-->


<!--<p id="text"></p>-->

<h1>iPerf 3 test</h1>

<form action="./testexec.php">

    <label>Choose iperf3 Mode:</label>

    <input type="radio" name="mode" id="client_mode" value="client" checked="checked" onclick='document.getElementById("client_text").style.display=""; document.getElementById("server_text").style.display="none";document.getElementById("repeat_text").style.display="none";document.getElementById("stop_text").style.display="none"' />
    <label for="client_mode">Client Mode</label>

    <input type="radio" name="mode" id="server_mode" value="server" onclick='document.getElementById("server_text").style.display="";document.getElementById("client_text").style.display="none";document.getElementById("repeat_text").style.display="none";document.getElementById("stop_text").style.display="none"' />
    <label for="server_mode">Server Mode</label>

    <input type="radio" name="mode" id="repeat_mode" value="repeat" onclick='document.getElementById("client_text").style.display="";document.getElementById("server_text").style.display="none";document.getElementById("repeat_text").style.display="";document.getElementById("stop_text").style.display="none"' />
    <label for="repeat_mode">Client Repeat Mode</label>

    <input type="radio" name="mode" id="stop_mode" value="stop" onclick='document.getElementById("client_text").style.display="none";document.getElementById("server_text").style.display="none";document.getElementById("repeat_text").style.display="none";document.getElementById("stop_text").style.display=""' />
    <label for="stop_mode" style="color:red">Stop Iperf3</label>

    <div id ="client_text">
    <br>
    <label>Enter iperf3 server ip address:</label>
    <input type="text" name="ip" id="ip">
    <br>
    <label>Enter iperf3 server port number:</label>
    <input type="number" name="port" id="port" value="5201">
    <br>
    <label>Enter additional options if needed (eg. -R):</label>
    <input type="text" id="options" name="options">

    </div>

    <div id ="repeat_text" style="display:none">
    <br>
    <label>Enter interval in seconds:</label>
    <input type="number" id="seconds" name="seconds" value="30">
    <br>
    <label>Client repeat mode will stop when stop mode is run, client mode is run, server mode is run, or device reboot.</label>
    </div>

    <div id ="server_text" style="display:none">
    <br>
    <label>This device will operate in server mode. Server mode will stop when stop mode is run, client mode is run, or device reboot.</label>
    </div>

    <div id ="stop_text" style="display:none">
    <br>
    <label style="color:red">Stop any Iperf3 processes.</label>
    </div>

    <!--
    <label>Client Mode:</label>

    <label>Enter iperf3 server ip address:</label>
    <input type="text" name="ip" id="ip">
    <br>
    <label>Enter iperf3 server port number:</label>
    <input type="number" name="port" id="port" value="5201">
    <br><br>
    -->
    <br><br>
    <input id="submitbutton" type="submit" value="Submit" onclick='document.getElementById("text").innerHTML = "Please Wait. Running iperf3...";document.getElementById("submitbutton").style.display="none";'>
</form>

<!--<h3>Result:</h3>-->
<br>
<p id="text"></p>


<?php
$mode = $_GET['mode'];

if ($mode == "client") {
    passthru("pkill iperf3");
    passthru("killall iperf_repeat_client.sh");
    passthru("killall iperf_server.sh");
    passthru("killall iperf_client.sh");
    passthru("echo '' > /var/log/iperf3.log");
    $ip = $_GET['ip'];
    $port = $_GET['port'];
    $options = $_GET['options'];


    echo '<h4 id="result">Result:</h4>';


    //passthru("iperf3 -c $ip -p $port $options --connect-timeout 5000 --logfile /var/log/iperf3.log");


    proc_close( proc_open( "./iperf_client.sh $ip $port $options &", array(), $foo ) );


    echo '<pre>';
    $handle = popen("tail -f /var/log/iperf3.log 2>&1", 'r');
    while(!feof($handle)) {
        $buffer = fgets($handle);
        //echo "$buffer<br/>\n";
        echo "$buffer";
        ob_flush();
        flush();
    }
    pclose($handle);
    echo '</pre>';


} elseif ($mode == "server") {
    passthru("pkill iperf3");
    passthru("killall iperf_repeat_client.sh");
    passthru("killall iperf_server.sh");
    passthru("killall iperf_client.sh");
    passthru("echo '' > /var/log/iperf3.log");
    //passthru("rm -f /var/log/iperf3.log");
    echo '<h4 id="result">Result:';

    //$output = shell_exec("iperf3 -s | tee /var/log/iperf3.log");
    //$output = shell_exec("iperf3 -s -D");
    //echo("<pre>$output</pre>");

    //echo '<pre>';
    //passthru("iperf3 -s --logfile /var/log/iperf3.log");

    //popen("iperf3 -s --logfile /var/log/iperf3.log", "r");
    //$cmd = "iperf3 -s -D --logfile /var/log/iperf3.log";
    //exec(sprintf("%s > %s 2>&1 & echo $! >> %s", $cmd, $outputfile, $pidfile));
    proc_close( proc_open( "./iperf_server.sh &", array(), $foo ) );
    echo "<br>Now running in server mode";

    echo "<br>Server mode will stop when stop mode is run, client mode is run, client mode repeat is run, or device reboot.";

    echo "<br><br>Listening on port 5201. Logs shown below";
    //passthru("tail -f /var/log/iperf3.log");
    //exec("iperf3 -s", $output, $return_var);
    //print_r($output);
    //echo '</pre>';
    echo '</h4>';
    //include 'check_server.php';

    $handle = popen("tail -f /var/log/iperf3.log 2>&1", 'r');
    while(!feof($handle)) {
        $buffer = fgets($handle);
        echo "$buffer<br/>\n";
        ob_flush();
        flush();
    }
    pclose($handle);

} elseif ($mode == "repeat") {
    passthru("pkill iperf3");
    passthru("killall iperf_repeat_client.sh");
    passthru("killall iperf_server.sh");
    passthru("killall iperf_client.sh");
    passthru("echo '' > /var/log/iperf3.log");
    $ip = $_GET['ip'];
    $port = $_GET['port'];
    $options = $_GET['options'];
    $seconds = $_GET['seconds'];
    //passthru("rm -f /var/log/iperf3.log");
    echo '<h4 id="result">Result:';

    //$output = shell_exec("iperf3 -s | tee /var/log/iperf3.log");
    //$output = shell_exec("iperf3 -s -D");
    //echo("<pre>$output</pre>");

    //echo '<pre>';
    //passthru("iperf3 -s --logfile /var/log/iperf3.log");

    //popen("iperf3 -s --logfile /var/log/iperf3.log", "r");
    //$cmd = "iperf3 -s -D --logfile /var/log/iperf3.log";
    //exec(sprintf("%s > %s 2>&1 & echo $! >> %s", $cmd, $outputfile, $pidfile));
    proc_close( proc_open( "./iperf_repeat_client.sh $ip $port $seconds $options &", array(), $foo ) );
    echo "<br>Now running in client repeat mode for server $ip port number $port and options $options every $seconds second(s)";

    echo "<br>Client repeat mode will stop when stop mode is run, client mode is run, server mode is run, or device reboot.";

    //echo "<br><br>Listening on port 5201";
    //passthru("tail -f /var/log/iperf3.log");
    //exec("iperf3 -s", $output, $return_var);
    //print_r($output);
    //echo '</pre>';
    echo '</h4>';
    //include 'check_server.php';

    $handle = popen("tail -f /var/log/iperf3.log 2>&1", 'r');
    while(!feof($handle)) {
        $buffer = fgets($handle);
        echo "$buffer<br/>\n";
        ob_flush();
        flush();
    }
    pclose($handle);

}elseif ($mode == "stop") {
    //proc_terminate($process);
    passthru("pkill iperf3");
    passthru("killall iperf_repeat_client.sh");
    passthru("killall iperf_server.sh");
    passthru("killall iperf_client.sh");
    echo '<h4 style="color:red">All Iperf3 processes are now stopped</h4>';

    $handle = popen("tail -f /var/log/iperf3.log 2>&1", 'r');
    while(!feof($handle)) {
        $buffer = fgets($handle);
        echo "$buffer<br/>\n";
        ob_flush();
        flush();
    }
    pclose($handle);
}

//pgrep -l iperf3
//pkill iperf3
//$ip = $_GET['ip'];
//$port = $_GET['port'];
//echo $ip;

//$output = shell_exec("iperf3 -c $ip -p $port 2>&1 --connect-timeout 5000 | tee /var/log/iperf3.log");
//echo("<pre>$output</pre>");
?>




</html>


