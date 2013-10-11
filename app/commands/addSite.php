<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class addSite extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'addSite';

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
		try {
			$rss = file_get_contents($this->argument('feed_url'));
		} catch (exception $excp) {
			return NULL;
		}
		$rss = simplexml_load_string($rss);
		if ($site = Site::where('url', '=', $rss->channel->link)->first()) {
			$this->info('Site is already exists.');
		} else {
			$site = new Site();
			$site->url_feed = $this->argument('feed_url');
			if ($url = $this->argument('site_url')) {
				$site->url = $url;
			} else {
				$site->url = $rss->channel->link;
			}
			$site->name = $rss->channel->title;
			$site->save();
			$this->info('Add Site.');
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
			array('feed_url', InputArgument::REQUIRED, 'feed url.'),
			array('site_url', InputArgument::OPTIONAL, 'site url.'),
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