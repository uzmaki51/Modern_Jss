<?php namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Foundation\Inspiring;
use App\Models\Operations\BackupDB;
use DateTime;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;


class Restore extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'restore';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Restore DB';

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function handle()
	{
        try {
            $path = $this->argument('path');

            $ds = DIRECTORY_SEPARATOR;
			$database = env('DB_DATABASE', '');
			$user     = env('DB_USERNAME', 'root');
			$password = env('DB_PASSWORD', '');

			$mysqlPath = "C:\\xampp/mysql/bin/mysql";

			if ($password != "") {
				$command = sprintf('%s -h localhost -u %s -p%s %s < %s', $mysqlPath, $user, $password, $database, $path);
			}
			else {
				$command = sprintf('%s -h localhost -u %s %s < %s', $mysqlPath, $user, $database, $path);
			}

			
			$result = exec($command);

            //$this->info($command);
			//$this->info('The restore has been proceed successfully.');

            return 1;

        } catch (ProcessFailedException $exception) {
            $this->error('The backup process has been failed.');
        }
	}

    protected function getArguments()
    {
        return [
            ['path', InputArgument::REQUIRED, '(require) File Path'],
        ];
    }

}
