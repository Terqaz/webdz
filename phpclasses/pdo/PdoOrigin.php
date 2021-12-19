<?php

class PdoOrigin
{
    private const PDO_CONFIG_PATH = 'config/pdo.ini';

    public function __construct()
    {
        $pdoConfig = parse_ini_file(self::PDO_CONFIG_PATH);
        if (!$pdoConfig) {
            throw new Exception("PDO config parsing failed", 1);
        }

        $this->pdo = new PDO(
            'mysql:host='.$pdoConfig['host'].
                ';dbname='.$pdoConfig['dbname'],
            $pdoConfig['login'],
            $pdoConfig['password'],
            array( PDO::ATTR_PERSISTENT => true )
        );
    }

    public function generateId()
    {
        return substr(uniqid('', true), 0, 8);
    }
}
