<?php
class PDOFactory
{
    private static $host = "vmapp02";
    private static $dbname = "webReporting";
    private static $user = "web_reporting";
    private static $password = "vmapp02WEB";

    public static function getMysqlConnexion()
    {
        $strConnexion = 'mysql:host='.self::$host.';dbname='.self::$dbname;

        $db = new PDO($strConnexion, self::$user, self::$password);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $db;
    }

    public static function doADump($name){
        $db_server = self::$host;
        $db_name =  self::$dbname;
        $db_username =  self::$user;
        $db_password = self::$password;
        $fichierdump =  '../DUMP/DUMP'.date('dmY').'_'.$name.'.sql';
        system("mysqldump --host=$db_server --user=$db_username --password=$db_password $db_name > $fichierdump");
        system("gzip $fichierdump");
    }
}