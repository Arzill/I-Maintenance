<?php

namespace App\Helpers;

use \Carbon\Carbon;

class DateHelper
{
    public static function getIndonesiaDate($data)
    {
        $parse = Carbon::parse($data);
        $month = $parse->format('m');
        $day = $parse->format('l');
        $date = $parse->format('d');
        $year = $parse->format('Y');
        $month_name = self::getMonthName($month);
        $day_name = self::getDayName($day);

        return "$date $month_name $year";
    }

    public static function getMonthName($month)
    {
        $month = (int) $month;
        $arrayMonth = [
            1 => 'Januari',
            2 => 'Februari',
            3 => 'Maret',
            4 => 'April',
            5 => 'Mei',
            6 => 'Juni',
            7 => 'Juli',
            8 => 'Agustus',
            9 => 'September',
            10 => 'Oktober',
            11 => 'November',
            12 => 'Desember',
        ];

        return $arrayMonth[$month];
    }

    public static function getCutMonthName($month)
    {
        $month = (int) $month;
        $arrayMonth = [
            1 => 'Jan',
            2 => 'Feb',
            3 => 'Mar',
            4 => 'Apr',
            5 => 'Mei',
            6 => 'Jun',
            7 => 'Jul',
            8 => 'Agust',
            9 => 'Sept',
            10 => 'Okt',
            11 => 'Nov',
            12 => 'Des',
        ];

        return $arrayMonth[$month];
    }

    public static function getDayName($day)
    {
        $day = (string) $day;
        $dayOfWeek = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
        $key = array_search($day, $dayOfWeek);
        $arrayDay = [
            0 => 'Minggu',
            1 => 'Senin',
            2 => 'Selasa',
            3 => 'Rabu',
            4 => 'Kamis',
            5 => 'Jumat',
            6 => 'Sabtu',
        ];

        return $arrayDay[$key];
    }

    public static function getFormatNumber($number)
    {
        $formattedNumber = number_format($number, 0, ',', '.');
        return "$formattedNumber";
    }
}
