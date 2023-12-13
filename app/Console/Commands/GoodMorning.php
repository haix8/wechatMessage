<?php

namespace App\Console\Commands;

use App\Service\WechatService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class GoodMorning extends Command
{

    protected $signature = 'good_morning';
    protected $description = '早安';

    public function handle(): void
    {

        $boy = 'oz87L51lKZniaMvmwJtQKPAOs3pY';
        (new WechatService())->good_morning($boy);

        $girl = 'oz87L5wzkwqaL37Lv2teK8zqcMfo';
        (new WechatService())->good_morning($girl);

    }
}
