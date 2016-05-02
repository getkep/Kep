<?php

namespace GetKep\Kep\headers;

class header
{
    public static function allowOrigin($domain)
    {
        header("access-control-allow-origin: {$domain}");
    }

    public static function contentType($content)
    {
        header("content-type: {$content}");
    }

    public static function allowCredentials($true)
    {
        header("access-control-allow-credentials: {$true}");
    }

    public static function allowHeaders($content)
    {
        header("Access-Control-Allow-Headers: {$content}");
    }

    public static function accessMethods($methods)
    {
        header("Access-Control-Allow-Methods: {$methods}");
    }
}
