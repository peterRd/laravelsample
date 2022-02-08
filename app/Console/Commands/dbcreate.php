<?php

namespace App\Console\Commands;

use Illuminate\Support\Facades\Config;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class dbcreate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:create {name?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create db if not exist';

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
        $dbidentifier = 'database.connections.'.Config::get('database.default');
        $database = Config::get($dbidentifier);
        $schemaName = $this->argument('name') ?: $database['database'];

        config(["$dbidentifier.database" => null]);

        $query = "CREATE DATABASE IF NOT EXISTS $schemaName;";

        DB::statement($query);

        config(["$dbidentifier.database" => $schemaName]);
    }
}
