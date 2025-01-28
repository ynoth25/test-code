<?php
class DatabaseConnection
{
    private $connection;

    public function __construct()
    {
        $dbHost = getenv('DB_HOST') ?: 'localhost';
        $dbPort = getenv('DB_PORT') ?: '5432';
        $dbName = getenv('DB_NAME') ?: 'my_database';
        $dbUser = getenv('DB_USER') ?: 'my_user';
        $dbPassword = getenv('DB_PASSWORD') ?: 'my_pass';

        $connectionString = "host={$dbHost} port={$dbPort} dbname={$dbName} user={$dbUser} password={$dbPassword}";

        $this->connection = pg_connect($connectionString);

        if (!$this->connection) {
            throw new \RuntimeException(
                'Failed to connect to PostgreSQL: ' . pg_last_error()
            );
        }
    }

    /**
     * Get the PostgreSQL connection resource.
     */
    public function getConnection()
    {
        return $this->connection;
    }
}