<?php

/**
 * DataService.php
 * Author: K
 * Date: 2022/12/30 18:59
 */

namespace App\Service;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Log;

class TxDataService
{


    /**
     * 土味情话
     * @return string
     * @throws GuzzleException
     */
    public static function saylove()
    {

        try {
            $uri = 'https://apis.tianapi.com/saylove/index';
            $client = new Client();
            $response = $client->get($uri, [
                'query' => [
                    'key' => env('TIANXING_KEY'), //参数
                ]
            ]);

            $content = json_decode($response->getBody()->getContents());

            return $content->result->content;
        } catch (\Exception $exception) {
            return '';
        }
    }

    /**
     * 彩虹屁
     * @return string
     * @throws GuzzleException
     */
    public static function caihongpi()
    {

        try {
            $uri = 'https://apis.tianapi.com/caihongpi/index';
            $client = new Client();
            $response = $client->get($uri, [
                'query' => [
                    'key' => env('TIANXING_KEY'), //参数
                ]
            ]);

            $content = json_decode($response->getBody()->getContents());

            return $content->result->content;
        } catch (\Exception $exception) {
            return '';
        }
    }

    public static function tianqi2($city = '郑州')
    {
        $appid = '48264857';
        $appsecret = 'OsH63sMQ';
        try {
            $uri = 'http://gfeljm.tianqiapi.com/api';
            $client = new Client();
            $response = $client->get($uri, [
                'query' => [
                    'appid' => $appid,
                    'appsecret' => $appsecret,
                    'version' => 'v63',
                    'city' => $city,
                    'unescape' => 1
                ]
            ]);
            $result = json_decode($response->getBody()->getContents());
            return $result;
        } catch (\Exception $exception) {
            Log::debug($exception->getMessage());
            return '';
        }
    }


    public static function tianqi()
    {

        try {
            $uri = 'https://apis.tianapi.com/tianqi/index';
            $client = new Client();
            $response = $client->get($uri, [
                'query' => [
                    'key' => env('TIANXING_KEY'), //参数
                    'city' => '郑州',
                    'type' => '1'
                ]
            ]);
            $result = json_decode($response->getBody()->getContents());
            if ($result->code != 200) {
                throw new \Exception($result->msg);
            }
            return $result->result;
        } catch (\Exception $exception) {
            Log::debug($exception->getMessage());
            return '';
        }

        /**

        {
            "code": 200,
            "msg": "success",
            "result": {
                "date": "2023-12-13",
                "week": "星期三",
                "province": "河南",
                "area": "郑州",
                "areaid": "101180101",
                "weather": "阴",
                "weatherimg": "yin.png",
                "weathercode": "yin",
                "real": "-0.5℃",
                "lowest": "-1℃",
                "highest": "0℃",
                "wind": "东北风",
                "windspeed": "11",
                "windsc": "2级",
                "sunrise": "07:23",
                "sunset": "17:15",
                "moonrise": "",
                "moondown": "",
                "pcpn": "0",
                "uv_index": "0",
                "aqi": "104",
                "quality": "轻度",
                "vis": "1",
                "humidity": "96",
                "alarmlist": [
                    {
                    "province": "河南省",
                    "city": "",
                    "level": "黄色",
                    "type": "道路结冰",
                    "content": "河南省气象台2023年12月12日16时00分继续发布道路结冰黄色预警：预计12月12日16时到13日16时，西部、北中部有雨夹雪或中雪，局部大雪或暴雪，部分县市伴有冻雨；其他县市有小到中雨。全省大部县市路表温度低于0℃，将出现对交通有较大影响的道路结冰，其中黄河以北及三门峡、洛阳、郑州、开封、许昌北部、平顶山北部影响较严重。请注意防范。\n防御指南：\n1.交通运输、公安等部门应按照职责做好道路结冰应对准备工作；\n2.驾驶人员应当注意路况，安全行驶；\n3.行人减少外出，必要外出时尽量少骑自行车，注意防滑。（预警信息来源：国家预警信息发布中心）",
                    "time": "2023-12-12 16:00:00"
                    }
                ],
                "tips": "天气寒冷，冬季着装：棉衣、羽绒服、冬大衣、皮夹克加羊毛衫、厚呢外套、呢帽、手套等；年老体弱者尽量少外出。空气质量较差，敏感人群建议减少体力消耗类户外活动。"
            }
        }
         */
    }
}
