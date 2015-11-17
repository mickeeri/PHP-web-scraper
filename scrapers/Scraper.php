<?php

namespace scraper;

class Scraper
{
    protected function curlGetRequest($url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_TIMEOUT_MS, 2000);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $data = curl_exec($ch);
        curl_close($ch);

        if($data === false) {
            throw new \Exception("Skrapningen klarade inte av att läsa sidan.");
        }

        return $data;
    }
}