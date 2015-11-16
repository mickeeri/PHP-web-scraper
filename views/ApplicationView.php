<?php

namespace view;

class ApplicationView
{
    private static $resultQueryString = "result";
    private static $URLCookieName = "url";
    private static $bookTableURL = "book";
    /**
     * ApplicationView constructor.
     */
    public function __construct()
    {
    }

    public function wantsTooBookTable() {
        return isset($_GET[self::$bookTableURL]);
    }

    public function onScrapeResultPage()
    {
        return isset($_GET[self::$resultQueryString]);
    }

    public function getReservationTime() {
        return $_GET[self::$bookTableURL];
    }

    public function redirectToResultPage()
    {
        $host = $_SERVER['HTTP_HOST'];
        $uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
        header("Location: http://$host$uri/?".self::$resultQueryString);
        exit();
    }

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

    public function getCurrentURL()
    {
        $uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
        return $_SERVER["HTTP_HOST"].$uri;
    }
}