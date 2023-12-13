<?php

namespace App\Console\Commands;

use App\Service\LoveDayService;
use App\Service\TxDataService;
use App\Service\WechatService;
use Carbon\Carbon;
use Illuminate\Console\Command;

class Test extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 't';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {

        $boy = 'oz87L51lKZniaMvmwJtQKPAOs3pY';
        $girl = 'oz87L5wzkwqaL37Lv2teK8zqcMfo';

        (new WechatService())->good_morning($boy);

//        var_dump(TxDataService::tianqi());
//        var_dump(LoveDayService::loveAnniversary());
    }
}
