<?php


namespace Libs;


class Notificator
{

    public static function success($session,$msg)
    {


    }

    public static function error($session,$msg)
    {
        $session = $msg;
        error_log($msg);

    }


}