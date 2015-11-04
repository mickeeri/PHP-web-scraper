<?php
/**
 * Created by PhpStorm.
 * User: Micke
 * Date: 2015-11-04
 * Time: 11:40
 */

// curl_cookie_handling("http://localhost:63342/1dv449_laboration1/index.php");
$data = curl_get_request("http://localhost:8080/calendar/mary.html");

$dom = new DOMDocument();



if ($dom->loadHTML($data)) {
    $xpath = new DOMXPath($dom);
    // Get all td tags.
    $availabilities = $xpath->query("//td");
    $days = $xpath->query("//th");

    for ($i = 0; $i < $days->length; $i++) {
        echo $days->item($i)->nodeValue . "-" . $availabilities->item($i)->nodeValue . "<br>";
    }

} else {
    die("Error while reading HTML");
}

function curl_cookie_handling($url) {
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);

    $post_arr = array(+
        "url" => "http://localhost:8080/"
    );

    curl_setopt($ch, CURLOPT_POSTFIELDS, $post_arr);

    $data = curl_exec($ch);
    curl_close($ch);

    var_dump($data);
}


function curl_get_request($url) {
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

    $data = curl_exec($ch);
    curl_close($ch);

    return $data;
}