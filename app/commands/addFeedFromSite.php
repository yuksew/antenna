<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class addFeedFromSite extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'addFeedFromSite';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Command description.';

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
	 * @return void
	 */
	public function fire()
	{
		if ($id = $this->argument('site')) {
			$list = explode(',', $id);
		} else {
			$list = Site::lists('id');
		}
		if (empty($id)) {
			$this->error('Site is not found.');
			return NULL;
		}
		foreach ($list as $id) {
			Feed::addFeedFromSite($id);
		}
	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		return array(
			array('site', InputArgument::OPTIONAL, 'Site id.'),
		);
	}

	/**
	 * Get the console command options.
	 *
	 * @return array
	 */
	protected function getOptions()
	{
		return array(
			array('example', null, InputOption::VALUE_OPTIONAL, 'An example option.', null),
		);
	}
}