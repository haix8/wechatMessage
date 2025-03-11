<?php

/**
 * WechatService.php
 * Author: K
 * Date: 2022/12/30 17:05
 */

namespace App\Service;

use Carbon\Carbon;
use EasyWeChat\Factory;
use Illuminate\Support\Facades\Log;

class WechatService
{

    public $app;


    public function __construct()
    {

        $config = [
            'app_id' => env('WECHAT_APPID'),
            'secret' => env('WECHAT_KEY'),
            // 指定 API 调用返回结果的类型：array(default)/collection/object/raw/自定义类名
            'response_type' => 'array',
            //...
        ];
        $this->app = Factory::officialAccount($config);

        //        $templates = $this->app->template_message->getPrivateTemplates();

    }


    public function good_morning($touser, $city)
    {

        /*
❤早安吖❤
{{date.DATA}}{{remark.DATA}}
所在城市：{{city.DATA}}
今天天气：{{weather.DATA}}
气温变化：{{minTemperature.DATA}}~{{maxTemperature.DATA}}
今天建议：{{tips.DATA}}

今天是我们相恋De第{{loveDays.DATA}}天
距离大宝宝的生日还有{{birthDay.DATA}}天
距离小宝宝的生日还有{{childBirthDay.DATA}}天

{{rainbow.DATA}}


❤五一妈妈早安吖❤
所在城市：{{city.DATA}} 
今天天气：{{weather.DATA}} 
气温变化：{{minTemperature.DATA}}~{{maxTemperature.DATA}} 
今天建议：{{tips.DATA}} 
今天是我们相恋De第{{loveDays.DATA}}天 
距离大宝宝的生日还有{{birthDay.DATA}}天 
距离小宝宝的生日还有{{childBirthDay.DATA}}天 
每日一拍：{{rainbow.DATA}}

❤五一妈妈早安吖❤
所在城市：{{city.DATA}} 
今天天气：{{weather.DATA}} 
气温变化：{{minTemperature.DATA}}~{{maxTemperature.DATA}} 
今天建议：{{tips.DATA}} 
今天是我们相恋De第{{loveDays.DATA}}天 
距离大宝宝的生日还有{{birthDay.DATA}}天 
距离小宝宝的生日还有{{childBirthDay.DATA}}天 
五一爸爸说：{{rainbow.DATA}}

         */
        $weather       = TxDataService::tianqi2($city);
        $rainbow       = TxDataService::caihongpi();
        $loveDays      = LoveDayService::getLoveDays();
        $birthDays     = LoveDayService::getBirthDays(LoveDayService::$birthday);
        $childBirthDay = LoveDayService::getBirthDays(LoveDayService::$childBirthday);
        $remark        = $this->getHolidayRemark();


        // $rainbow = '测试一句话';
        // $weather = new stdClass();
        // $weather->city = '郑州';
        // $weather->wea = '晴';
        // $weather->tem1 = '20';
        // $weather->tem2 = '10';
        // $weather->air_tips = '空气很好';

        $msg = [
            'touser'      => $touser,
            'template_id' => 'kgko8h5OJvHOwxxwK6s9I5NjeLyzkJdX5IUzk6m8Ppc',

            'data' => [
                'city'           => $weather->city,
                'weather'        => $weather->wea,
                'minTemperature' => $weather->tem2,
                'maxTemperature' => $weather->tem1,
                'tips'           => $weather->air_tips,
                'loveDays'       => $loveDays,
                'birthDay'       => $birthDays,
                'childBirthDay'  => $childBirthDay,
                'rainbow'        => $remark ? $remark : $rainbow,
            ],
        ];
        try {
            $result = $this->app->template_message->send($msg);
            Log::debug('发送模版消息==>', $msg);
            Log::debug('发送结果==>', $result);
        } catch (\Exception $exception) {
            Log::error('发送异常==>', $exception->getMessage());
        }
    }

    private function getHolidayRemark()
    {
        // 恋爱纪念日
        if (LoveDayService::loveAnniversary()) {
            return '今天是恋爱周年纪念日！永远爱你~';
        }

        $today = Carbon::now();
        $currentDate = $today->format('m-d');

        $festivals = [
            '01-01' => '新年第一天，好运翻倍，幸福溜进门！',
            '02-14' => '今天不说情话，但比心的手停不下来❤️',
            // 元宵节（农历正月十五，这里用近似值）
            '02-15' => '元宵节快乐！吃汤圆的时候想着我哦～',
            
            '03-08' => '今天你最美，明天更美，后天美上天！',
            '03-12' => '种下一颗小树苗，等它长大好乘凉～',
            '04-01' => '今天说谎不要钱，但说爱你是真的！',
            '04-05' => '清明时节雨纷纷，愿你春日好心情！',
            '05-01' => '躺平休息日，咱们一起做快乐达人！',
            '06-01' => '今天做个长不大的小朋友，嘻嘻～',
            '09-10' => '未来的你，一定会是个好老师！',
            '10-01' => '祖国生日趴体，一起蹦迪庆祝吧！',

            //中秋节（需要农历计算，这里用近似值）
            '10-06' => '中秋节快乐！月亮都没你好看～',
            // 重阳节（农历九月九日，这里用近似值）
            '10-29' => '九月九日忆山东兄弟',

            '12-24' => '平安夜给你偷偷许了愿，要永远开开心心！',
            '12-25' => '圣诞老人告诉我你是最棒的礼物！',
        ];

        // 动态计算的节日
        // 母亲节（5月第二个星期日）
        if ($today->month == 5 && $today->weekOfMonth == 2 && $today->dayOfWeek == Carbon::SUNDAY) {
            return '母亲节快乐！五一妈妈您辛苦了！';
        }

        return $festivals[$currentDate] ?? '';
    }
}
