<?php
class DateValidator
{
    private $dateFormats;

    /**
     * @param string[] $formats
     */
    public function __construct($formats = [])
    {
        // If no custom formats provided, use these defaults:
        $this->dateFormats = !empty($formats) ? $formats : [
            'Y-m-d',   // 2024-12-01
            'd/m/Y',   // 01/12/2024
            'm/d/Y',   // 12/01/2024
            'd F Y',   // 01 December 2024
        ];
    }

    /**
     * Validate and normalize a date string to 'YYYY-MM-DD'.
     * @param string $dateString An untrusted date string to parse.
     */
    public function validateAndFixDate($dateString)
    {
        foreach ($this->dateFormats as $format) {
            $dateObj = \DateTime::createFromFormat($format, $dateString);
            $errors  = \DateTime::getLastErrors();

            if ($dateObj instanceof \DateTime
                && $errors['warning_count'] === 0
                && $errors['error_count'] === 0
            ) {

                return $dateObj->format('Y-m-d');
            }
        }

        return false;
    }
}
