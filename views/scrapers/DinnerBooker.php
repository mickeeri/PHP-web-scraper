<?php

namespace scraper;


class DinnerBooker
{
    private static $userName = 'zeke';
    private static $password = 'coys';
    private static $loginURL = 'dinner/login';
    private $url;

    public function __construct($url)
    {
        $this->url = $url.self::$loginURL;
       // $this->url = "http://localhost:8080/dinner/login.php";
    }

    public function curlPostRequest($query)
    {



        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);

        $post_arr = array(
            'group1' => $query,
            'username' => self::$userName,
            'password' => self::$password,
            'submit' => 'login'
        );

        d($post_arr);

        $postString = "group1=$query&username=zeke&password=coys&submit=login";

        curl_setopt($ch, CURLOPT_POSTFIELDS, $postString);
//        curl_setopt($ch, CURLOPT_HEADER, 1);
//        curl_setopt($ch, CURLINFO_HEADER_OUT, true);

        //curl_setopt($ch, CURLOPT_COOKIEJAR, dirname(__FILE__) . "/kaka.txt");

        $data = curl_exec($ch);


        $header = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        d($data);
        d($header);


        curl_close($ch);



        //d($data);
    }
}