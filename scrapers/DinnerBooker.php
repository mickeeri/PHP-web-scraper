<?php

namespace scraper;


class DinnerBooker
{
//    private static $userName = 'zeke';
//    private static $password = 'coys';
    private static $loginURL = 'dinner/login';
    private $url;

    public function __construct($url)
    {
        $this->url = $url.self::$loginURL;
    }

    public function curlPostRequest($query)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);

//        $post_arr = array(
//            'group1' => $query,
//            'username' => self::$userName,
//            'password' => self::$password,
//            'submit' => 'login'
//        );

        // The post fields as string.
        $postString = "group1=$query&username=zeke&password=coys&submit=login";

        curl_setopt($ch, CURLOPT_POSTFIELDS, $postString);

        curl_setopt($ch, CURLOPT_COOKIEJAR, dirname(__FILE__) . "/kaka.txt");

        $responseString = curl_exec($ch);
        $responseCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($responseCode !== 200) {
            throw new \Exception("Kunde inte boka bord.");
        }

        return $responseString;
    }
}