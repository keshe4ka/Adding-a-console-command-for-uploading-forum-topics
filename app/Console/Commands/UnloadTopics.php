<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;

class UnloadTopics extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'UnloadTopics {path}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Unloading all forum topics into a text document in the format: 
    "Topic Title i" - "number of replies to topic i"';

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
        $path = $this->argument('path'); //получаем путь введенный пользователем
        $filepath = $path . "UnloadTopics_result.txt"; //добавление названия
        $num_rows = DB::select('select count(*) from threads'); //количество строк в таблице
        for ($i = 1; $i <= $num_rows; $i++){
            $title = DB::select("select title from threads where id='$i'");
            $replies_count = DB::select("select replies_count from threadswhere id='$i'");
            $i_result = $title . " - " . $replies_count . "\n";
            file_put_contents($filepath, $i_result, FILE_APPEND);
        }
        echo "Completed";
    }
}
