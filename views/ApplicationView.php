<?php

namespace view;

class ApplicationView
{
    private static $resultQueryString = "result";
    private static $URLCookieName = "url";
    private static $bookTableURL = "book";
//    private static $titleQueryString = "title";
//    private static $timeQueryString = "time";
//    private static $dayQueryString = "day";

    public function wantsTooBookTable()
    {
        return isset($_GET[self::$bookTableURL]);
    }

//    public function wantsToSeeAvailableTables()
//    {
//        if (isset($_GET[self::$titleQueryString]) && isset($_GET[self::$timeQueryString]) &&
//        isset($_GET[self::$dayQueryString])) {
//            return true;
//        }
//
//        return false;
//    }

    public function onScrapeResultPage()
    {
        return isset($_GET[self::$resultQueryString]);
    }

//    /**
//     * Provides info to show on table reservation page.
//     */
//    public function getInfoForReservation()
//    {
//        $movieTitle = $_GET[self::$titleQueryString];
//        $time = $_GET[self::$timeQueryString];
//        $day = $_GET[self::$dayQueryString];
//
//        return new \model\CinemaShow($movieTitle, $day, $time, 1);
//    }

    public function getReservationTime()
    {
        return $_GET[self::$bookTableURL];
    }

    public function redirectToResultPage()
    {
        $host = $_SERVER['HTTP_HOST'];
        $uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
        header("Location: http://$host$uri/?".self::$resultQueryString);
        exit();
    }

    /**
     * Saves url to be used after post.
     * @param $url
     */
    public function saveURLInCookie($url)
    {
        setcookie(self::$URLCookieName, $url, -1);
    }

    /**
     * @param $keep boolean true if cookie is to be kept.
     * @return string
     */
    public function getURLFromCookie($keep)
    {
        $ret = isset($_COOKIE[self::$URLCookieName]) ? $_COOKIE[self::$URLCookieName] : "";

        if (!$keep) {
            setcookie(self::$URLCookieName, "", time()-1);
        }

        return $ret;
    }
}