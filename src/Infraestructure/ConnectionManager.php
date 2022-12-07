<?php 
namespace TheStore\Infraestructure;

use Throwable;
use MongoDB\Client;

abstract class ConnectionManager
{
    private static $connnection;

    private static function handleConnect($driver): void
    {
        switch ($driver) {
            case 'mongodb':
                self::connectMongoDB();
                break;
        }
    }

    public static function connect()
    {
        self::handleConnect(DB_DRIVER);
        return self::$connnection;
    }

    private static function connectMongoDB()
    {
        try {
            $client = new Client();
            $connnection = $client->selectDatabase(DB_DATABASE);
            self::$connnection = $connnection;
        } catch(Throwable $e) {
            echo $e->getMessage();
        }
    }
}