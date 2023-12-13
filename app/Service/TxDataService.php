<?php
/**
 * DataService.php
 * Author: K
 * Date: 2022/12/30 18:59
 */

namespace App\Service;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

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
                    'key' => '58fee8fd45acfe90ff02ed11b6ae4bd9',//参数
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
                    'key' => '58fee8fd45acfe90ff02ed11b6ae4bd9',//参数
                ]
            ]);

            $content = json_decode($response->getBody()->getContents());

            return $content->result->content;
        } catch (\Exception $exception) {
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
                    'key' => '58fee8fd45acfe90ff02ed11b6ae4bd9',//参数
                    'city' => '郑州',
                    'type' => '1'
                ]
            ]);

            return json_decode($response->getBody()->getContents())->result;
        } catch (\Exception $exception) {
            return '';
        }
    }
}
