<?php

class Database extends PDO{

    private static  $_instance;


    // Constructor
    public function __construct($DB_HOST, $DB_NAME, $DB_USER, $DB_PASS)
    {
        try {
            parent::__construct('mysql:host='.$DB_HOST.';dbname='.$DB_NAME.';charset=utf8', $DB_USER, $DB_PASS);
            $this->exec('SET CHARACTER SET utf8mb4');

            // comment this line if you don't want error reporting
            $this->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);

        } catch (PDOException $e) {
            die ( 'Connection failed: ' . $e->getMessage() );
        }
    }


    private function __clone(){}


    public static function getInstance(): Database
    {
        // create instance if doesn't exist
        if ( self::$_instance === null )
            self::$_instance = new self(DB_HOST, DB_NAME, DB_USER, DB_PASS);

        return self::$_instance;
    }


}
