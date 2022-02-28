<?php
/**
 * @author           Pierre-Henry Soria <phy@hizup.uk>
 * @copyright        (c) 2015-2017, Pierre-Henry Soria. All Rights Reserved.
 * @license          Lesser General Public License <http://www.gnu.org/copyleft/lesser.html>
 * @link             http://hizup.uk
 */

namespace PhpMVC\Libs;
/**
 * klasa konfigujacji  wykorzytywana przy otwarciu polacxzeniaz DB
 * Class Config
 * @package TestProject\Libs
 */
final class Config
{
    // Database info (if you want to test the script, please edit the below constants with yours)
    const
        DB_HOST = 'localhost',
        DB_NAME = 'mymvcblog',
        DB_USR = 'mymvcblog',
        DB_PWD = 'mymvcblog',

        // Title of the site
        SITE_NAME = 'My Simple Blogklkl!';
}