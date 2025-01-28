<?php
class DatabaseQueryResultHelper
{
    private $databaseConnection;

    /**
     * @param DatabaseConnection $dbConnection
     */
    public function __construct(DatabaseConnection $dbConnection)
    {
        $this->databaseConnection = $dbConnection->getConnection();
    }

    /**
     * @param string $sql The SQL query to execute
     */
    public function getData($sql, $parameters)
    {
        $statement = 'stmt_' . uniqid();
        $prepareResult = pg_prepare($this->databaseConnection, $statement, $sql);
        if (!$prepareResult) {
            throw new \RuntimeException('Query preparation error: ' . pg_last_error($this->databaseConnection));
        }

        $result = pg_execute($this->databaseConnection , $statement, $parameters);
        if (!$result) {
            throw new \RuntimeException('Query execution error: ' . pg_last_error($this->databaseConnection));
        }

        $rows = [];
        while ($row = pg_fetch_assoc($result)) {
            $rows[] = $row;
        }

        return $rows;
    }
}