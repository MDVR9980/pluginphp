<?php

namespace BasicPages;
use \Model\Model;

defined('ROOT') or die("Direct script access denied");

/**
 * Content class
 */
class Content extends Model {

	protected $table = 'contents';
	public $primary_key = 'id';

	protected $allowedColumns = [
		'column1',
		'date_created',
	];
	
	protected $allowedUpdateColumns = [
		'column1',
		'date_updated',
		'date_deleted',
		'deleted',
	];


	public function extract_images(string $content):string {
		$folder = plugin_path('uploads/');
		if(!file_exists($folder))
			mkdir($folder,0777,true);

 		preg_match_all("/<img[^>]+/", $content, $matches);

 		if(is_array($matches[0])) {

 			foreach ($matches[0] as $img_tag) {
 				
 				if(strstr($img_tag, 'src="http'))
 					continue;
 				
 				preg_match("/src=\"[^\"]+/", $img_tag,$src_match);
 				if(!empty($src_match[0])) {

 					$parts = explode(";base64,", $src_match[0]);
 					preg_match("/data-filename=\"[^\"]+/", $img_tag,$original_filename);

 					$original_filename = str_replace('data-filename="', "", $original_filename[0]);
 					$filename = $folder . $original_filename;
 					if(file_exists($filename))
 						$filename = $folder  .rand(0,100). $original_filename;

 					file_put_contents($filename, base64_decode($parts[1]));
 					$content = str_replace($src_match[0], 'src="'.$filename, $content);

 					//resize image
 					$img = new \Core\Image;
 					$img->resize($filename,1000);
 				}
 			}
 		}
 		return $content;
	}

	public function delete_unused_images(string $old_content, string $new_content) {
		$folder = plugin_path('uploads/');
		if(!file_exists($folder))
			mkdir($folder,0777,true);

 		preg_match_all("/<img[^>]+/", $old_content, $matches);

 		if(is_array($matches[0])) {

 			foreach ($matches[0] as $img_tag) {

 				preg_match("/src=\"[^\"]+/", $img_tag,$src_match);
 				if(!empty($src_match[0])) {

 					$path = str_replace('src="', '', $src_match[0]);
 					if(!strstr($new_content, $path)) {
 						if(file_exists($path))
 							unlink($path);
 					}
 				}
 			}
 		}
	}

	public function add_root(string $content):string {

		$content = preg_replace("/src=\"/", 'src="'.ROOT.'/', $content);
		return $content;
	}

	public function remove_root(string $content):string {

		$content = str_replace('src="'.ROOT.'/', 'src="', $content);
		return $content;
	}
}