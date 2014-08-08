<?php
namespace SmallTeam\Admin;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use \Illuminate\Support\Facades\File;

class AdminInit extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'admin:init';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Init admin package. Copy files..etc';

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
	public function fire()
	{
        File::copyDirectory(__DIR__.'/../public/', public_path());
        File::makeDirectory(app_path().'/../admin/', 777, true, true);
        File::makeDirectory(app_path().'/../admin/modules', 777, true, true);
        File::makeDirectory(app_path().'/../admin/config', 777, true, true);
        File::copyDirectory(__DIR__.'/../config/', app_path().'/../admin/config');

        $this->info('Start migration...');
        exec('php artisan migrate --package=small-team/laravel-admin --force');
        $this->info('All done!');
    }

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		return array( );
	}

	/**
	 * Get the console command options.
	 *
	 * @return array
	 */
	protected function getOptions()
	{
		return array(
//			array('example', null, InputOption::VALUE_OPTIONAL, 'An example option.', null),
		);
	}

}
