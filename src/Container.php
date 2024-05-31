<?php declare( strict_types=1 );

namespace src;

use src\Database\Connection;

class Container
{
    private static ?self $instance = null;
    private Connection $connection;
  
    public function __construct()
    {
    }

    public static function service(): self
    {
        if ( is_null( static::$instance ) ) {
            static::$instance = new static();
        }

        return static::$instance;
    }

    public function setConnection( Connection $connection ): self
    {
        $this->connection = $connection;
        return $this;
    }

    public function getConnection(): Connection
    {
        return $this->connection;
    }

 
}