<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class TableBackup extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'backup:table {table?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates a backup of the table';

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
		if(!empty($this->argument('table'))) {
			$tableName = $this->argument('table');
		} else {
			$choices = DB::select('SHOW TABLES');
			array_walk($choices, function(&$item) {
				$item = get_object_vars($item)['Tables_in_epg-dev'];
			});
			$tableName = $this->choice('Which table you want to backup ?', $choices);
		}
		$this->info('Backing up '.$tableName.' table');
		exec('mysqldump -u '.config('database.connections.mysql.username').' -p '.config('database.connections.mysql.database').' '.$tableName.' > '.database_path().'/backups/'.$tableName.'_'.Carbon::now()->toDateString().'_backup.sql', $result, $code);
		if($code === 0) {
			$this->info($tableName.' table successfully backed up!');
		} else {
			$this->error('Error while backing up '.$tableName.' table');
		}
        return $code;
    }
}
