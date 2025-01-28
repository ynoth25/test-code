<?php

require_once 'DatabaseConnection.php';
require_once 'GetDatabaseQueryResultHelper.php';
require_once 'DateEntryValidation.php';
require_once 'AveragePointsCalculator.php';

try {
    $dateValidator = new DateValidator();
    $dbConnection = new DatabaseConnection();
    $queryHelper = new DatabaseQueryResultHelper($dbConnection);
    $calculator = new AveragePointsCalculator($queryHelper, $dateValidator);

    $startDate = '2024-12-01';
    $endDate   = '2024-12-31';
    $averages  = $calculator->getAveragePoints($startDate, $endDate);

    echo "<pre>";
    print_r($averages);
    echo "</pre>";

} catch (InvalidArgumentException $ex) {
    // Handle invalid dates
    echo "Invalid date: " . $ex->getMessage();
} catch (RuntimeException $ex) {
    // Handle DB or query issues
    echo "Error: " . $ex->getMessage();
} catch (Exception $ex) {
    // Catch-all for anything else
    echo "Unexpected error: " . $ex->getMessage();
}
