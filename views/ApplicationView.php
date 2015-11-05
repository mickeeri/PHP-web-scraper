<?php

namespace view;

class ApplicationView
{
    private static $resultQueryString = "result";
    private static $URLCookieName = "url";
    /**
     * ApplicationView constructor.
     */
    public function __construct()
    {
    }

    public function onScrapeResultPage()
    {
        return isset($_GET[self::$resultQueryString]);
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

    public function getURLFromCookie()
    {
        $ret = isset($_COOKIE[self::$URLCookieName]) ? $_COOKIE[self::$URLCookieName] : "";
        setcookie(self::$URLCookieName, "", time()-1);
        return $ret;
    }
}