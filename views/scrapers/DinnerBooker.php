<?php

namespace scraper;


class DinnerBooker
{
    public function curlPostRequest($url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);

        $post_arr = array(
            "username" => "zeke",
            "password" => "coys"
        );

        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_arr);
        $data = curl_exec($ch);
        curl_close($ch);
    }
}