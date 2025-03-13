<?php

namespace Eren\Lms\Classes;

use Carbon\Carbon;

class LmsCarbon
{
    /**
     * Calculate the difference between two dates in days.
     *
     * @param string $date1
     * @param string $date2
     * @return int
     */
    private static $date_form = "Y-m-d";
    private static $db_date_form = "Y-m-d H:i:s";

    public static function  setDate($date)
    {
        return Carbon::parse($date);
    }

    public static function diffInDays($date1, $date2)
    {
        $date1 = self::parse($date1);
        $date2 = self::parse($date2);

        return $date1->diffInDays($date2);
    }
    public static function is_day_future($date1, $date2)
    {
        $date1 = self::parse($date1);
        $date2 = self::parse($date2);

        return $date1->greaterThan($date2);
    }

    public static function now($toDateString = false)
    {
        return $toDateString ? Carbon::now()->toDateString() : Carbon::now();
    }

    /**
     * Calculate the difference between two dates in hours.
     *
     * @param string $date1
     * @param string $date2
     * @return int
     */
    public static function diffInHours($date1, $date2)
    {
        $date1 = Carbon::parse($date1);
        $date2 = Carbon::parse($date2);

        return $date1->diffInHours($date2);
    }

    /**
     * Calculate the difference between two dates in minutes.
     *
     * @param string $date1
     * @param string $date2
     * @return int
     */
    public static function diffInMinutes($date1 = "", $date2 = "")
    {
        if (empty($date1)) {
            $date1 = Carbon::now();
        }

        if (empty($date2)) {
            $date2 = Carbon::now();
        }

        $date1 = Carbon::parse($date1);
        $date2 = Carbon::parse($date2);

        return $date1->diffInMinutes($date2);
    }

    /**
     * Get a human-readable difference between two dates.
     *
     * @param string $date1
     * @param string $date2
     * @return string
     */
    public static function diffForHumans($date1, $date2)
    {
        $date1 = self::parse($date1);
        $date2 = self::parse($date2);

        return $date1->diffForHumans($date2);
    }

    public static function parse($value, $format = false)
    {
        return $format ? Carbon::parse($value)->format($format) : Carbon::parse($value);
    }

    public static function dateFormat($value)
    {
        return self::parse($value)->format(self::$date_form);
    }

    public static function dbDateFormat($value)
    {
        return self::parse($value)->format(self::$db_date_form);
    }

    public static function startOfMonth()
    {
        return self::now()->startOfMonth();
    }

    public static function currentYear()
    {
        return self::now()->year;
    }

    public static function currentMonth()
    {
        return self::now()->month;
    }

    public static function createFromTimestamp($time)
    {
        return Carbon::createFromTimestamp($time);
    }
}
