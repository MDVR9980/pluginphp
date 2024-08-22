<?php

function set_value(string|array $key, mixed $value = ''):bool
{
	global $USER_DATA;

	$called_from = debug_backtrace();
	$ikey = array_search(__FUNCTION__, array_column($called_from, 'function'));
	$path = get_plugin_dir(debug_backtrace()[$ikey]['file']) . 'config.json';

	if(file_exists($path))
	{
		$json = json_decode(file_get_contents($path));
		$plugin_id = $json->id;

		if(is_array($key))
		{
			foreach ($key as $k => $value) {
				
				$USER_DATA[$plugin_id][$k] = $value;
			}
		}else
		{
			$USER_DATA[$plugin_id][$key] = $value;
		}


		return true;
	}

	return false;
}

function plugin_id():string
{
	$called_from = debug_backtrace();
	$ikey = array_search(__FUNCTION__, array_column($called_from, 'function'));
	$path = get_plugin_dir(debug_backtrace()[$ikey]['file']) . 'config.json';

	$json = json_decode(file_get_contents($path));
	return $json->id ?? '';
}

function get_value(string $key = ''):mixed
{
	global $USER_DATA;

	$called_from = debug_backtrace();
	$ikey = array_search(__FUNCTION__, array_column($called_from, 'function'));
	$path = get_plugin_dir(debug_backtrace()[$ikey]['file']) . 'config.json';

	if(file_exists($path))
	{
		$json = json_decode(file_get_contents($path));
		$plugin_id = $json->id;

		if(empty($key))
			return $USER_DATA[$plugin_id];

		return !empty($USER_DATA[$plugin_id][$key]) ? $USER_DATA[$plugin_id][$key] : null;
	}

	return null;

}

function APP($key = '')
{
	global $APP;

	if(!empty($key))
	{
		return !empty($APP[$key]) ? $APP[$key] : null;
	}else{

		return $APP;
	}

	return null;
}

function show_plugins()
{
	global $APP;
	
	$names = array_column($APP['plugins'], 'name');
	dd($names ?? []);

}

/**splits the query string in the url**/
function split_url($url)
{
	return explode("/", trim($url,'/'));
}

function URL($key = '')
{
	global $APP;

	if(is_numeric($key) || !empty($key))
	{
		if(!empty($APP['URL'][$key]))
		{
			return $APP['URL'][$key];
		}
	}else{
		return $APP['URL'];
	}

	return '';
}

function get_plugin_folders()
{
	$plugins_folder = 'plugins/';
	$res = [];
	$folders = scandir($plugins_folder);
	foreach ($folders as $folder) {
		if($folder != '.' && $folder != '..' && is_dir($plugins_folder . $folder))
			$res[] = $folder;
	}

	return $res;
}

function load_plugins($plugin_folders)
{
	global $APP;
	$loaded = false;
	
	foreach ($plugin_folders as $folder) {
		
		$file = 'plugins/' . $folder . '/config.json';
		if(file_exists($file))
		{
			$json = json_decode(file_get_contents($file));
			
			if(is_object($json) && isset($json->id))
			{
				if(!empty($json->active))
				{
					$file = 'plugins/' . $folder . '/plugin.php';
					if(file_exists($file) && valid_route($json))
					{
						$json->index = $json->index ?? 1;
						$json->index_file = $file;
						$json->path = 'plugins/' . $folder . '/';
						$json->http_path = ROOT . '/' . $json->path;

						$APP['plugins'][] = $json;

					}
				}
			}
		}
	}

	if(!empty($APP['plugins']))
	{
		$APP['plugins'] = sort_plugins($APP['plugins']);
		foreach ($APP['plugins'] as $json)
		{
			if(file_exists($json->index_file))
			{
				require_once $json->index_file;
				$loaded = true;
			}
		}
	}

	return $loaded;
}

function sort_plugins(array $plugins):array
{
	$to_sort = [];
	$sorted  = [];

	foreach ($plugins as $key => $obj) {
		$to_sort[$key] = $obj->index;
	}
	
	asort($to_sort);
	
	foreach ($to_sort as $key => $value) {
		$sorted[] = $plugins[$key];
	}

	return $sorted;
}

function valid_route(object $json):bool
{
	if(!empty($json->routes->off) && is_array($json->routes->off))
	{
		if(in_array(page(), $json->routes->off))
			return false;
	}

	if(!empty($json->routes->on) && is_array($json->routes->on))
	{
		if($json->routes->on[0] == 'all')
			return true;

		if(in_array(page(), $json->routes->on))
			return true;
	}

	return false;
}

function add_action(string $hook, mixed $func, int $priority = 10):bool
{

	global $ACTIONS;

	while(!empty($ACTIONS[$hook][$priority])) {
		$priority++;
	}

	$ACTIONS[$hook][$priority] = $func;

	return true;
}

function do_action(string $hook, array $data = [])
{
	global $ACTIONS;

	if(!empty($ACTIONS[$hook]))
	{
		ksort($ACTIONS[$hook]);
		foreach ($ACTIONS[$hook] as $key => $func) {
			$func($data);
		}
	}

}

function add_filter(string $hook, mixed $func, int $priority = 10):bool
{
	global $FILTER;

	while(!empty($FILTER[$hook][$priority])) {
		$priority++;
	}

	$FILTER[$hook][$priority] = $func;

	return true;
}

function do_filter(string $hook, mixed $data = ''):mixed
{
	global $FILTER;

	if(!empty($FILTER[$hook]))
	{
		ksort($FILTER[$hook]);
		foreach ($FILTER[$hook] as $key => $func) {
			$data = $func($data);
		}
	}

	return $data;
}

function dd($data)
{
	echo "<pre><div style='margin:1px;background-color:#444;color:white;padding:5px 10px'>";
	print_r($data);
	echo "</div></pre>";
}

function page()
{
	return URL(0);
}

function redirect($url)
{
	header("Location: ". ROOT .'/'. $url);
	die;
}

function plugin_path(string $path = '')
{
	$called_from = debug_backtrace();
	$key = array_search(__FUNCTION__, array_column($called_from, 'function'));
	return get_plugin_dir(debug_backtrace()[$key]['file']) . $path;
}

function plugin_http_path(string $path = '')
{
	$called_from = debug_backtrace();
	$key = array_search(__FUNCTION__, array_column($called_from, 'function'));
	
	return ROOT . DIRECTORY_SEPARATOR . get_plugin_dir(debug_backtrace()[$key]['file']) . $path;
}

function get_plugin_dir(string $filepath):string
{

	$path = "";

	$basename = basename($filepath);
	$path = str_replace($basename, "", $filepath);

	if(strstr($path, DIRECTORY_SEPARATOR.'plugins'.DIRECTORY_SEPARATOR))
	{
		$parts = explode(DIRECTORY_SEPARATOR.'plugins'.DIRECTORY_SEPARATOR, $path);
		$parts = explode(DIRECTORY_SEPARATOR, $parts[1]);
		$path = 'plugins' . DIRECTORY_SEPARATOR . $parts[0].DIRECTORY_SEPARATOR;

	}

	return $path;
}

function user_can(?string $permission):bool
{
	if(empty($permission)) return true;

	$ses = new \Core\Session;
	
	if($permission == 'logged_in')
	{
		if($ses->is_logged_in())
			return true;

		return false;
	}

	if($permission == 'not_logged_in')
	{
		if(!$ses->is_logged_in())
			return true;

		return false;
	}
	
	if($ses->is_admin())
		return true;

	global $APP;

	if(empty($APP['user_permissions']))
		$APP['user_permissions'] = [];

	$APP['user_permissions'] = do_filter('before_check_permissions',$APP['user_permissions']);
	
	if(in_array($permission, $APP['user_permissions']))
		return true;

	return false;
}

function old_value(string $key, string $default = '',string $type = 'post'):string
{
	$array = $_POST;
	if($type == 'get')
		$array = $_GET;

	if(!empty($array[$key]))
		return $array[$key];

	return $default;
}

function old_select(string $key, string $value, string $default = '',string $type = 'post'):string
{
	$array = $_POST;
	if($type == 'get')
		$array = $_GET;

	if(!empty($array[$key]))
	{
		if($array[$key] == $value)
			return ' selected ';
	}else
	{
		if($default == $value)
			return ' selected ';
	}

	return '';
}

function old_checked(string $key, string $value, string $default = '',string $type = 'post'):string
{
	$array = $_POST;
	if($type == 'get')
		$array = $_GET;

	if(!empty($array[$key]))
	{
		if($array[$key] == $value)
			return ' checked ';
	}else
	{
		if($default == $value)
			return ' checked ';
	}

	return '';
}

function csrf(string $sesKey = 'csrf', int $hours = 1):string
{
	$key = '';

	$ses = new \Core\Session;
	$key = hash('sha256', time() . rand(0,99));
	$expires = time() + ((60*60)*$hours);

	$ses->set($sesKey,[
		'key'=> $key,
		'expires'=>$expires
	]);

	return "<input type='hidden' value='$key' name='$sesKey' />";
}


function csrf_verify(array $post, string $sesKey = 'csrf'):mixed
{
	if(empty($post[$sesKey]))
		return false;

	$ses = new \Core\Session;
	$data = $ses->get($sesKey);
	if(is_array($data))
	{
		if($data['key'] !== $post[$sesKey])
			return false;

		if($data['expires'] > time())
			return true;

		$ses->pop($sesKey);
		
	}

	return false;
}


function get_image(string $path = '', string $type = 'post')
{
	if(file_exists($path))
		return ROOT . '/' . $path;
	
	if($type == 'post')
		return ROOT . '/assets/images/no_image.jpg';

	if($type == 'male')
		return ROOT . '/assets/images/user_male.jpg';

	if($type == 'female')
		return ROOT . '/assets/images/user_female.jpg';

	return ROOT . '/assets/images/no_image.jpg';
}

function esc(?string $str):?string
{
	return htmlspecialchars($str);
}

function get_date(string $date):string
{
	return date("jS M, Y", strtotime($date));
}

function message(string $msg = '', bool $erase = false):?string
{
	$ses = new \Core\Session;

	if(!empty($msg))
	{
		$ses->set('message',$msg);
	}else
	if(!empty($ses->get('message')))
	{
		$msg = $ses->get('message');

		if($erase)
			$ses->pop('message');

		return $msg;
	}

	return '';
}

