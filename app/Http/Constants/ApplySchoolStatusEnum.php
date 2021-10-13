<?php


namespace App\Http\Constants;


/**
 * 功能：审核状态
 *
 * @author: stevenv
 * @date: 2021-10-13
 **/
class ApplySchoolStatusEnum
{
    //状态：0待审核,1通过,2拒绝
    public const STATUS_WAIT = 0;
    public const STATUS_PASS = 1;
    public const STATUS_REJECT = 2;

    public static function getStatsDesc() {
        return [
            self::STATUS_WAIT   => '待审核',
            self::STATUS_PASS   => '通过',
            self::STATUS_REJECT => '拒绝',
        ];
    }
}