<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class TableRestore extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'restore:table {table?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Restores a backup to database';

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

		exec('ls '.database_path('backups/').$tableName.'_*_backup.sql', $backupList, $code);
		array_walk($backupList, function(&$item) {
			$item = pathinfo($item)['basename'];
		});

		$backupFile = $this->choice('Which backup you want to restore ?', $backupList);

		$this->info('Restoring '.$backupFile);
		//mysql -u username -p db_name < /path/to/table_name.sql
		exec('mysql -u '.config('database.connections.mysql.username').' -p '.config('database.connections.mysql.database').' < '.database_path('backups/').$backupFile, $result, $code);
        if($code === 0) {
			$this->info($backupFile.' successfully restored!');
		} else {
			$this->error('Error while restoring '.$backupFile);
		}
        return $code;
    }
}
