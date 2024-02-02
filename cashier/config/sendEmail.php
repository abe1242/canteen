<?php
ini_set("dispay_errors", 1);

function read_cb($ch, $fp, $length) {
    return fread($fp, $length);
}

function sendEmail($to, $subject, $msg) {
    $fp = fopen('php://memory', 'r+');
    $string = "From: <canteengptc@gmail.com>\r\n";
    $string .= "To: <$to>\r\n";
    $string .= "Date: " . date('r') . "\r\n";
    $string .= "Subject: $subject\r\n";
    $string .= "\r\n";
    $string .= "$msg\r\n";
    $string .= "\r\n";
    fwrite($fp, $string);
    rewind($fp);

    $ch = curl_init();
    curl_setopt_array($ch, [
        CURLOPT_URL => 'smtps://smtp.gmail.com:465',
        CURLOPT_MAIL_FROM => '<canteengptc@gmail.com>',
        CURLOPT_MAIL_RCPT => ["<$to>"],
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
}
?>