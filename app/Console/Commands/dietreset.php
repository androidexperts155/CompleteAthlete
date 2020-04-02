<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Userdiet;
use DB;

class dietreset extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:dietreset';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Resets the user diet table to zero after 12 am everyday';

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
     * @return mixed
     */
    public function handle()
    {        
        
        DB::table('user_daily_diet')->update(['proteins'=>0,'fats'=>0,'carbs'=>0,'calories'=>0,'percentage'=>0]);
    }
}
