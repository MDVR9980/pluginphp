<?php

namespace Thunder;

defined('FCPATH') or die("Direct script access denied");

/**
 * Thunder class
 */
class Thunder
{

	public function make(array $args)
	{

		$action 		= $args[1] ?? null;
		$folder 		= $args[2] ?? null;
		$class_name 	= $args[3] ?? null;

		if($action == 'make:plugin')
		{
			$original_folder = $folder;
			$folder = 'plugins/'.$folder;

			if(file_exists($folder))
				$this->message("That plugin folder already exists",true);

			/*main plugin folder*/
			mkdir($folder,0777,true);

			$css_folder = $folder . '/assets/css/';
			mkdir($css_folder,0777,true);

			$js_folder = $folder . '/assets/js/';
			mkdir($js_folder,0777,true);

			$fonts_folder = $folder . '/assets/fonts/';
			mkdir($fonts_folder,0777,true);

			$images_folder = $folder . '/assets/images/';
			mkdir($images_folder,0777,true);

			$controller_folder = $folder . '/controllers/';
			mkdir($controller_folder,0777,true);
			
			$view_folder = $folder . '/views/';
			mkdir($view_folder,0777,true);
			
			$migration_folder = $folder . '/migrations/';
			mkdir($migration_folder,0777,true);
			
			$models_folder = $folder . '/models/';
			mkdir($models_folder,0777,true);

			/*copy files*/
			
			/*plugin file*/
			$plugin_file = $folder . '/plugin.php';
			$plugin_file_source = 'app/thunder/samples/plugin-sample.php';
			
			if(file_exists($plugin_file_source)){
				copy($plugin_file_source, $plugin_file);
			}else{
				$this->message("plugin sample file not found in: ".$plugin_file_source);
			}

			/*controller file*/
			$controller_file = $folder . '/controllers/controller.php';
			$controller_file_source = 'app/thunder/samples/controller-sample.php';
			
			if(file_exists($controller_file_source)){
				copy($controller_file_source, $controller_file);
			}else{
				$this->message("controller sample file not found in: ".$controller_file_source);
			}

			/*view file*/
			$view_file = $folder . '/views/view.php';
			$view_file_source = 'app/thunder/samples/view-sample.php';
			
			if(file_exists($view_file_source)){
				copy($view_file_source, $view_file);
			}else{
				$this->message("view sample file not found in: ".$view_file_source);
			}
 
			/*js file*/
			$js_file = $folder . '/assets/js/plugin.js';
			$js_file_source = 'app/thunder/samples/js-sample.js';
			
			if(file_exists($js_file_source)){
				copy($js_file_source, $js_file);
			}else{
				$this->message("js sample file not found in: ".$js_file_source);
			}

			/*css file*/
			$css_file = $folder . '/assets/css/style.css';
			$css_file_source = 'app/thunder/samples/css-sample.css';
			
			if(file_exists($css_file_source)){
				copy($css_file_source, $css_file);
			}else{
				$this->message("css sample file not found in: ".$css_file_source);
			}
 			
 			/*config file*/
			$config_file = $folder . '/config.json';
			$config_file_source = 'app/thunder/samples/config-sample.json';
			
			if(file_exists($config_file_source)){
				copy($config_file_source, $config_file);
			}else{
				$this->message("config sample file not found in: ".$config_file_source);
			}
 
 			$this->message("Plugin creation complete! Plugin folder: ".$folder);	

		}else
		if($action == 'make:migration')
		{
			$original_folder = $folder;
			$folder = 'plugins/'.$folder.'/';

			if(!file_exists($folder))
				$this->message("Plugin folder not found",true);

			$migration_folder = $folder . "migrations/";
			if(!file_exists($migration_folder))
				mkdir($migration_folder,0777,true);

			$file_sample = 'app/thunder/samples/migration-sample.php';
			if(!file_exists($file_sample))
				$this->message("Sample migration file not found in: ". $file_sample,true); 

			if(empty($class_name))
			 	$this->message("Please provide a valid class name for your migration file",true); 

			$class_name = preg_replace("/[^a-zA-Z_\-]/", "", $class_name);
			$class_name = str_replace("-", "_", $class_name);
			$class_name = ucfirst($class_name);

			$table_name = strtolower($class_name);

			$content = file_get_contents($file_sample);
			$content = str_replace("{TABLE_NAME}", $table_name, $content);
			$content = str_replace("{CLASS_NAME}", $class_name, $content);

			$filename = $migration_folder . date("Y-m-d_His_") . $table_name . '.php';
			file_put_contents($filename, $content);

			$this->message("Migration file created. Filename: ".$filename,true);

		}else
		if($action == 'make:model')
		{

			$original_folder = $folder;
			$folder = 'plugins/'.$folder.'/';

			if(!file_exists($folder))
				$this->message("Plugin folder not found",true);

			$model_folder = $folder . "models/";
			if(!file_exists($model_folder))
				mkdir($model_folder,0777,true);

			$file_sample = 'app/thunder/samples/model-sample.php';
			if(!file_exists($file_sample))
				$this->message("Sample model file not found in: ". $file_sample,true); 

			if(empty($class_name))
			 	$this->message("Please provide a valid class name for your model file",true); 

			$class_name = preg_replace("/[^a-zA-Z_\-]/", "", $class_name);
			$class_name = str_replace("-", "_", $class_name);
			$class_name = ucfirst($class_name);

			$table_name = strtolower($class_name);

			$content = file_get_contents($file_sample);
			$content = str_replace("{TABLE_NAME}", $table_name, $content);
			$content = str_replace("{CLASS_NAME}", $class_name, $content);

			$filename = $model_folder . $class_name . '.php';
			file_put_contents($filename, $content);

			$this->message("Model file created. Filename: ".$filename,true);

		}else
		{
			$this->message("Unknown command ". $action);
		}
		
	}

	public function migrate(array $args)
	{
		$action 		= $args[1] ?? null;
		$folder 		= $args[2] ?? null;
		$file_name 		= $args[3] ?? null;

		if($action == 'migrate' || $action == 'migrate:rollback')
		{
			$folder = 'plugins/'.$folder.'/migrations/';

			if(!is_dir($folder))
				$this->message("No migration files found in that location",true);

			if(!empty($file_name))
			{
				/** run single file **/
				$file = $folder . $file_name;

				$this->message("Migrating file:". $file . "\n\r");

				require_once $file;

				$class_name = basename($file);
				preg_match("/[a-zA-Z]+\.php$/", $class_name, $match);
				$class_name = ucfirst(str_replace(".php", "", $match[0]));

				$myclass = new ("\Migration\\$class_name");

				if($action == 'migrate')
				{
					$myclass->up();
				}else
				{
					$myclass->down();
				}

				$this->message("Migration complete!");
				$this->message("File: " . $file_name);

			}else
			{
				/** get all files from folder **/
				$files = glob($folder.'*.php');

				if(!empty($files))
				{

					foreach ($files as $file)
					{

						$this->message("Migrating file:". $file . "\n\r");

						require_once $file;

						$class_name = basename($file);
						preg_match("/[a-zA-Z]+\.php$/", $class_name, $match);
						$class_name = ucfirst(str_replace(".php", "", $match[0]));

						$myclass = new ("\Migration\\$class_name");

						if($action == 'migrate')
						{
							$myclass->up();
						}else
						{
							$myclass->down();
						}

					}

					$this->message("Migration complete!");

				}else
				{
					$this->message("No migration files found in specified folder");
				}
			}
		}else
		if($action == 'migrate:refresh')
		{

			$this->migrate(['thunder','migrate:rollback',$folder,$file_name]);
			$this->migrate(['thunder','migrate',$folder,$file_name]);

		}
	}
	
	public function help(string|array $version):void
	{

		$version = is_array($version) ? $version[0] : $version;

		echo "

	ThunderPHP v$version Command Line Tool

	Database
	  migrate            Locates and runs a migration from the specified plugin folder.
	  migrate:refresh    Does a rollback followed by a migration.
	  migrate:rollback   Runs the 'down' method for a migration in the specifiled plugin folder.

	Generators
	  make:plugin        Generates a new folder with all essential plugin files.
	  make:migration     Generates a new migration file.
	  make:model         Generates a new model file.
			
			";
	}

	private function message(string $message, bool $die = false):void 
	{
		echo "\n\r" . ucfirst($message);
		ob_flush();

		if($die) return;
	}
}