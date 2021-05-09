<?php namespace Mercator\ThemeUpdater\Console;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Cms\Classes\Theme;
use Mercator\ThemeUpdater\Classes\Instructions;
use Mercator\ThemeUpdater\Console\Copy;

class Copy extends Command
{
    /**
     * @var string The console command name.
     */
    protected $name = 'theme:copy';

    /**
     * @var string The console command description.
     */
    protected $description = 'Copy a theme.';

	
	
    /**
     * Execute the console command.
     * @return void
     */
    public function handle()
    {
        	
    	$arguments = $this->argument();
    		
    	$source_theme=themes_path(strtolower($arguments["source_theme"]));
    	$target_theme=$target_theme=themes_path(strtolower($arguments["target_theme"]));
    	
    	$updater = new Instructions($source_theme, $target_theme);
    	
    	if (!file_exists($source_theme)) {	
    		$this->output->writeln("Error: Source theme does not exist - cannot create a theme out of thin air.");
    		return;
    	}
    	
    	if (file_exists($target_theme)) {	
    		$this->output->writeln("Error: Target theme already exist - remove it first to continue.");
    		return;
    	}
    	
    	// Copy complete theme
    	$updater->mastercopy("/", "/");
        
        $script_path = $target_theme . "/themekeeping/install.php";
    
    	if (file_exists($script_path)) {
        	$this->output->writeln("Theme installation instructions found... executing $script_path");
        	require $script_path;
        	
        	$this->output->writeln("Theme installation instructions excuted - all done.");
        }
        	
        else
        	$this->output->writeln('No theme installation instructions - all done.');
        	
        return;
    }

    /**
     * Get the console command arguments.
     * @return array
     */
    protected function getArguments()
    {
        return [
        	['source_theme', InputArgument::REQUIRED, 'Source theme.'],
        	['target_theme', InputArgument::REQUIRED, 'Target theme.']
        ];
    }

    /**
     * Get the console command options.
     * @return array
     */
    protected function getOptions()
    {
        return [];
    }
}
