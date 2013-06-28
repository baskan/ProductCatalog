<?php namespace Davzie\ProductCatalog\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use File;
use Config;

class ClearCacheCommand extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'catalog:clear-cache';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Remove all cached image files from the server, they will auto regenerate';

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
		$clearableDirs = [ '/products' , '/categories' ];
		$base_path = public_path().'/'.Config::get('ProductCatalog::app.upload_base_path');
		$initialDirs = File::directories( $base_path );
		if( $initialDirs ){
			foreach( File::directories( $base_path ) as $key=>$path ){

				// If the path ends with one of the items in the clearable directories then we can clear it
				if( ends_with( $path , $clearableDirs ) ){

					// Go through each product / categorie's directory
					foreach( File::directories( $path ) as $key=>$path ){
						$toDelete = $path.'/cached';
						if( File::isDirectory( $toDelete ) ){
							File::deleteDirectory( $toDelete );
							$this->info("Deleted: ".$toDelete);
						}
					}

				}

			}		
			$this->info("All cache's deleted");
			return;
		}
		$this->error("No valid directories found.");
		return;
	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		return array();
	}

	/**
	 * Get the console command options.
	 *
	 * @return array
	 */
	protected function getOptions()
	{
		return array();
	}

}