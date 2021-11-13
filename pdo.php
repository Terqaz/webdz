<?php

namespace DBConnect;

use PDO;

function getWeb3kursPdo()
{
    $pdoConfig = parse_ini_file('.\\config\\pdo.ini');

    return new PDO(
        'mysql:host='.$pdoConfig['host'].';dbname='.$pdoConfig['dbname'],
        $pdoConfig['login'],
        $pdoConfig['password'],
        array( PDO::ATTR_PERSISTENT => true)
    );
}
