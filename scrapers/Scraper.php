<?php

namespace scraper;

class Scraper
{
    /**
     * @param $url string url to scrape
     * @return string result of scrape
     * @throws \Exception if result of curl_exec is false.
     */
    protected function curlGetRequest($url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_USERAGENT, "me222wm");
        $data = curl_exec($ch);
        curl_close($ch);

        if($data === false) {
            throw new \Exception("Skrapningen klarade inte av att läsa sidan.");
        }

        return $data;
    }
}