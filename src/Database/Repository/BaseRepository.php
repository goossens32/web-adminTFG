<?php declare( strict_types=1 );

namespace src\Database\Repository;

use src\Container;
use src\Database\Connection;
use PDO;

class BaseRepository
{
    protected ?Connection $connection;

    public function __construct()
    {
        $this->connection = Container::service()->getConnection();
    }
    
}