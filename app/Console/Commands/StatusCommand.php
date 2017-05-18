<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class StatusCommand extends Command {
	protected $signature = 'post:status';
	protected $description = 'Post a status';

	public function __construct() {
		parent::__construct();
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function handle() {
		
	}
}
