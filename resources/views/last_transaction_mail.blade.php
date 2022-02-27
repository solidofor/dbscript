<!DOCTYPE html>
<html>

<head>
    <title>Monitoring Email</title>
</head>

<body>

    <h2><b>Alert!</b> No New transaction/successful for a while now</h2>
    <p>{!! str_replace('"', '', json_encode($currentTime, true)) !!}</p>
    <p>{!! str_replace('"', '', json_encode($timeFrame, true)) !!}</p>
    <p>{!! str_replace('"', '', json_encode($transaction_date, true)) !!}</p>
    <p>{!! str_replace('"', '', json_encode($successful_timeFrame, true)) !!}</p>
    <p>{!! str_replace('"', '', json_encode($successful_transaction_date, true)) !!}</p>
    <p>{!! str_replace('"', '', json_encode($processing_time, true)) !!}</p>
    <hr>
    <p>Connet to the server</p>
    <p>Check status to see error in log</p>
    <p>tail -f /var/log/tomcat8/catalina.out</p>
    <p>stop tomcat</p>
    <p>/etc/init.d/tomcat8 stop</p>
    <p>and start</p>
    <p>/etc/init.d/tomcat8 start</p>
    <br>
</body>

</html>
