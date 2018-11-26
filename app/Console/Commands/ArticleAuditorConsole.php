<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Redis;


/**
 * Class ArticleAuditorConsole
 * @package App\Console\Commands
 * 审核人运营数据统计
 */
class ArticleAuditorConsole extends Command
{
    /**
     * The name and signature of the console command.
     * @var string
     */
    protected $signature = 'laravel:article_auditor_operate';

    /**
     * The console command description.
     * @var string
     */
    protected $description = '审核人运营数据统计';
    protected $_key_prefix;
    protected $_articleAuditor;

    public function __construct()
    {
       parent::__construct();
    }

    /**
     * Execute the console command.
     * @return mixed
     */
    public function handle()
    {
        $this->main();
    }

    /**
     * 实时的账户总余额数据存放到json文件中
     * @return array
     */
    public function main()
    {

    }
}