<?php
namespace Libs;


interface MainInterface
{
    public function getView($sViewName);

    public function _get($sFileName);

    public function __set($sKey, $mVal);

    public function isLogged();

    public static function isPageRefreshed();
}
