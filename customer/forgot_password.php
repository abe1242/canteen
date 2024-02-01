<?php
ini_set("dispay_errors", 1);

function read_cb($ch, $fp, $length) {
    return fread($fp, $length);
}

$fp = fopen('php://memory', 'r+');
$string = "From: <no-reply@example.com>\r\n";
$string .= "To: <pesgoatmessi.10@gmail.com>\r\n";
$string .= "Date: " . date('r') . "\r\n";
$string .= "Subject: Test\r\n";
$string .= "\r\n";
$string .= "test from php\r\n";
$string .= "\r\n";
fwrite($fp, $string);
rewind($fp);

$ch = curl_init();
curl_setopt_array($ch, [
    CURLOPT_URL => 'smtps://smtp.gmail.com:465',
    CURLOPT_MAIL_FROM => '<no-reply@example.com>',
    CURLOPT_MAIL_RCPT => ['<pesgoatmessi.10@gmail.com>'],
    CURLOPT_USERNAME => 'canteengptc@gmail.com',
    CURLOPT_PASSWORD => 'zgjc lnju gidk qvke',
    CURLOPT_USE_SSL => CURLUSESSL_ALL,
    CURLOPT_READFUNCTION => 'read_cb',
    CURLOPT_INFILE => $fp,
    CURLOPT_UPLOAD => true,
    CURLOPT_VERBOSE => true,
]);

$x = curl_exec($ch);

if ($x === false) {
    echo curl_errno($ch) . ' = ' . curl_strerror(curl_errno($ch)) . PHP_EOL;
}

curl_close($ch);
fclose($fp);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
</head>
<body>
    Response - 
    <?php
    echo $response;
    ?>
</body>
</html>