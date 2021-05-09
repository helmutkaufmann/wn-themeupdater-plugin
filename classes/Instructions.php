<?php namespace Mercator\ThemeUpdater\Classes;

class Instructions {

	protected $master_theme;
    protected $child_theme;

    public function __construct($source, $target) {
    	$this->master_theme=$source . "/";
    	$this->child_theme=$target . "/";

    }

    public function master_path()
    {
    	return $this->master_path;
    }

    public function child_path()
    {
    	return $this->child_path;
    }


	protected function recursive_copy($source, $destination) {

		if (is_file($source)) {
			@mkdir(dirname($destination), 0755, true);
			copy ($source, $destination);
			echo $destination ;
			return;
		}

		$dir = opendir($source);
		@mkdir($destination, 0755, true);
		while(( $file = readdir($dir)) ) {
			if (( $file != '.' ) && ( $file != '..' )) {
				if ( is_dir($source . '/' . $file) ) {
					$this->recursive_copy($source .'/'. $file, $destination .'/'. $file);
				}
				else {
					@mkdir($destination, 0755, true);
					@copy($source .'/'. $file, $destination .'/'. $file);
				}
			}
		}
		closedir($dir);

	}

	protected function rrmdir($dir)
   {
		if (is_dir($dir)) {
		 $objects = scandir($dir);
		 foreach ($objects as $object) {
		   if ($object != "." && $object != "..") {
			 if (is_dir("$dir/$object") && !is_link("$dir/$object"))
			   $this->rrmdir("$dir/$object");
			 else
			   unlink("$dir/$object");
		   }
		 }
		 rmdir($dir);
   		}
 	}

	// Backup files or directores of the theme to a safe place
	public function backup($source)
    {
    	$theme_path = $this->child_theme;
	 	$storage_path = storage_path("THEMES_BACKUP/");
    	$this->recursive_copy ($theme_path . $source, $storage_path . $source);
    }

    // Restore files or directores of the theme from a safe place
    public function restore($source)
    {
    	$theme_path = $this->child_theme;
	 	$storage_path = storage_path("THEMES_BACKUP/");
	 	if (is_file($storage_path . $source))
	 		$destination = $theme_path . $source;
	 	elseif (is_dir($storage_path . $source))
	 		$destination = $theme_path . ($source);
	 	else {
	 		echo ("Warning: Cannot restore $source as backup does not exist");
	 		return;
	 	}

    	$this->recursive_copy ($storage_path . $source, $destination);
    }

    // Remove theme files or directories
    public function remove($source)
    {

	 	$target = $this->child_theme . $source;

	 	if (is_file($target))
	 		unlink ($target);
	 	elseif (is_dir($target))
	 		$this->rrmdir ($target);
	 	else
	 		echo ("Cannot remove as inexistent: <<$target>>");
    }

    // Copy files or directories from the master theme to the theme
    public function mastercopy($source, $child)
    {
    	$this->recursive_copy ($this->master_theme . $source, $this->child_theme . $child);
    }

     // Copy files or directories flocally
    public function childcopy($source, $child)
    {
    	$this->recursive_copy ($this->child_theme . $source, $this->child_theme . $child);
    }

    // Test if a file or directory exists in the theme
    public function file_exists_child($source)
    {
    	return file_exists($this->child_theme . $source);

    }

    // Test if a file or directory exists in the master theme
    public function file_exists_master($source)
    {
    	return file_exists($this->master_theme . $source);

    }

    // Replace theme files and directoris in the theme with their equivalents in the master theme
    // This is identical to copy except that the any pre-existing files/directories are first deleted
    public function replace($source)
    {
    	@$this->remove($source);
	 	@$this->mastercopy($source, $source);

    }

}
