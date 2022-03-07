<?php

namespace Model;

use Exception;
use Libs\Config;
use PDO;


/**
 * Class MainModel
 * @package Model
 */

class MainModel
{
    // Hold the class instance.
    private static  $instance = null;
    private PDO $conn;

    private string $host = Config::DB_HOST;
    private string $user = Config::DB_USR;
    private string $pass = Config::DB_PWD;
    private string $name = Config::DB_NAME;


    /**
     * MainModel constructor.
     */
    protected function __construct()
    {
        set_exception_handler(array($this, 'customException'));

        try {
            $this->conn = new PDO("mysql:host={$this->host};
    dbname={$this->name}", $this->user, $this->pass,
                array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));

        } catch (Exception $e) {
            self::customException($e);
            error_log('Error on line ' . $e->getLine() . '<br> in ' . $e->getFile()
                . ': <b><br>' . $e->getMessage() . '</br> connection error');
        }

    }

    public static function customException($exception)
    {
        $errorMsg = 'Error on line ' . $exception->getLine() . '<br> in ' . $exception->getFile()
            . ': <b><br>' . $exception->getMessage() . '</br> connection error';
        echo $errorMsg;
    }


    public static function getInstance()
    {
        if (!self::$instance) {
            self::$instance = new  MainModel();
        }

        return self::$instance;
    }

    public function getConnection()
    {
        return $this->conn;
    }
}

