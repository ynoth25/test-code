<?php
class AveragePointsCalculator
{
    private $queryHelper;
    private  $dateValidator;

    /**
     * @param DatabaseQueryResultHelper $queryHelper
     * @param DateValidator $dateValidator
     */
    public function __construct(
        DatabaseQueryResultHelper $queryHelper,
        DateValidator $dateValidator
    ) {
        $this->queryHelper  = $queryHelper;
        $this->dateValidator = $dateValidator;
    }

    /**
     * @param string $startDate Untrusted date string (could be '2024-12-01' or another format)
     * @param string $endDate   Untrusted date string
     */
    public function getAveragePoints($startDate, $endDate)
    {
        $startDateFixed = $this->dateValidator->validateAndFixDate($startDate);
        $endDateFixed   = $this->dateValidator->validateAndFixDate($endDate);

        if ($startDateFixed === false) {
            throw new \InvalidArgumentException("Invalid start date: {$startDate}");
        }
        if ($endDateFixed === false) {
            throw new \InvalidArgumentException("Invalid end date: {$endDate}");
        }

        $sql = "
            SELECT
                sub.user_group,
                ROUND(AVG(sub.max_point)) AS average
            FROM
            (
                SELECT 
                    USERS.\"group\" AS user_group,
                    EXAMS.user_id,
                    MAX(EXAMS.point) AS max_point
                FROM exams EXAMS
                JOIN users USERS ON EXAMS.user_id = USERS.id
                WHERE EXAMS.date
                      BETWEEN TO_DATE(\$1, 'YYYY-MM-DD')
                      AND     TO_DATE(\$2, 'YYYY-MM-DD')
                GROUP BY USERS.\"group\", EXAMS.user_id
            ) AS sub
            GROUP BY sub.user_group
            ORDER BY AVG(sub.max_point)
        ";
        $groupedAverageData = $this->queryHelper->getData($sql, [$startDate, $endDate]);

        return array_column($groupedAverageData, 'average', 'user_group');
    }
}