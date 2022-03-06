<?php
/**
 * @author           Pierre-Henry Soria <phy@hizup.uk>
 * @copyright        (c) 2015-2017, Pierre-Henry Soria. All Rights Reserved.
 * @license          Lesser General Public License <http://www.gnu.org/copyleft/lesser.html>
 * @link             http://hizup.uk
 */

namespace Model;
use Libs\Config;
use PDO;



/**
 * Class MainModel
 * @package PhpMVC\Model
 */
// Singleton to connect db.
  class MainModel
{
    // Hold the class instance.
    private static $instance = null;
    private $conn;

    private $host = Config::DB_HOST;
    private $user = Config::DB_USR;
    private $pass = Config::DB_PWD;
    private $name = Config::DB_NAME;

    // The db connection is established in the private constructor.
    private function __construct()
    {
        $this->conn = new PDO("mysql:host={$this->host};
    dbname={$this->name}", $this->user, $this->pass,
            array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
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

