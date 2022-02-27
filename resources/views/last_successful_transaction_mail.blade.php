<!DOCTYPE html>
<html>

<head>
    <title>Last Successful Transaction Monitoring Email</title>
</head>

<body>

    <h3>Transactions are currently <b>Failing!</b> No Successful transaction for a while now</h3>
    <p>Details.</p>
    <p>{!! str_replace('"', '', json_encode($currentTime, true)) !!}</p>
    <p>{!! str_replace('"', '', json_encode($timeFrame, true)) !!}</p>
    <p>{!! str_replace('"', '', json_encode($transaction_date, true)) !!}</p>
    <p>{!! str_replace('"', '', json_encode($processing_time, true)) !!}</p>
    <br>
    <p>Last Successful Transaction Infromation can be seen below.</p>
    <hr />
     <pre>
        <code>
            @json($transaction);
        </code>
    </pre>
</body>

</html>
