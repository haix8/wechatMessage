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


    public function good_morning($touser)
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


         */

        $weather = TxDataService::tianqi();
        $rainbow = TxDataService::caihongpi();
        $loveDays = LoveDayService::getLoveDays();
        $birthDays = LoveDayService::getBirthDays(LoveDayService::$birthday);
        $childBirthDay = LoveDayService::getBirthDays(LoveDayService::$childBirthday);
        $remark = ' ';
        if (LoveDayService::loveAnniversary()) {
            $remark = '今天是恋爱周年纪念日！永远爱你~';
        }

        $msg = [
            'touser' => $touser,
            'template_id' => '2-grcuQ9CVdf0mMrPjf_6ipXBiCN1t0XyVmhn6GC_YM',
            'data' => [
                'date' => [
                    date('Y-m-d') . $weather->week,
                    '#00BFFF'
                ],
                // "❤"
                'remark' => $remark,
                'city' => [
                    $weather->area,
                    ''
                ],
                'weather' => [
                    $weather->weather,
                    "#1f95c5"
                ],
                'minTemperature' => [
                    'value' => $weather->lowest,
                    'color' => '#0ace3c'
                ],
                'maxTemperature' => [
                    'value' => $weather->highest,
                    'color' => '#dc1010'
                ],
                'tips' => [
                    $weather->tips,
                    ""
                ],
                'loveDays' => [
                    $loveDays,
                    "#FFA500"
                ],
                'birthDay' => [
                    $birthDays,
                    "#FFA500"
                ],
                'childBirthDay' => [
                    $childBirthDay,
                    "#FFA500"
                ],
                'rainbow' => [
                    $rainbow,
                    "#FF69B4"
                ],
            ],
        ];
        $result = $this->app->template_message->send($msg);


        Log::debug('发送成功');
        Log::debug(json_encode($msg,JSON_UNESCAPED_UNICODE));
        Log::debug($result);
    }
}
