<?php

class Controller
{
    /**
     * @var array
     */
    protected $oPosts;

    public static function helloworld()
    {
        echo 'Hello World';
    }

    //error nie zadzila
    public static function baseroute()
    {
        echo 'base route';
    }

    public static function myroute()
    {
        echo 'my route';
    }

//uwaga!!! nie mozna nzwac metody i route index jest to njprwd nazwa zastrzezona!!!!
    public static function test()
    {
echo 'test';
        self::getView('index');
    }


    public function text($t1, $t2, $t3)
    {
        echo 'Text: ' . $t1 . $t2 . $t3;
    }

    public function path($path, $path2)
    {
        echo 'Current Path:' . $path;
        echo '<br />Current Path with parameters:' . $path2;
    }

    public function form_get()
    {
        echo '<form method="post"><input type="text" name="test" /><input type="submit" /></form>';
    }

    public function form_post()
    {
        var_dump($_POST);
    }


    private static function _get($sFileName, $sType)
    {
        $sFullPath = ROOT_PATH . $sType . '/' . $sFileName . '.php';
        if (is_file($sFullPath))
            require $sFullPath;
        else
            exit('The "' . $sFullPath . '" file doesn\'t exist');
    }

    public static function getView($sViewName)
    {
        self::_get($sViewName, 'View');
    }


}