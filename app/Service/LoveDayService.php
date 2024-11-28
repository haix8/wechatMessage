<?php
/**
 * LoveDayService.php
 * Author: K
 * Date: 2022/12/30 19:22
 */

namespace App\Service;

use Carbon\Carbon;

class LoveDayService
{

    /**
     * 恋爱开始时间
     * @var string
     */
    public static $loveDays = '2022-01-01';

    /**
     * 生日
     * @var string
     */
    public static $birthday = '1996-8-28';

    public static $childBirthday = '2024-5-1';


    /**
     * 计算恋爱天数 days
     * @return int
     */
    public static function getLoveDays(): int
    {
        $start_date = self::$loveDays;

        return Carbon::now()->diffInDays($start_date);
    }

    /**
     * 是否恋爱周年
     * @return bool
     */
    public static function loveAnniversary(): bool
    {
        $x1 = Carbon::parse(self::$loveDays)->format('md');
        $x2 = Carbon::now()->format('md');
        return $x1 === $x2;
    }


    /**
     * 计算生日剩余天数 days
     * @return int
     */
    public static function getBirthDays($start_date): int
    {
//        $start_date = self::$birthday;

        $birthday = Carbon::parse($start_date);

        $birthday->year(date('Y'));

        $d = Carbon::now()->diffInDays($birthday, false);
        if ($d < 0) {
            //计算明年
            $birthday->year(date("Y", strtotime("+1 year")));
            $d = Carbon::now()->diffInDays($birthday, false);
        }

        return $d;
    }
}
