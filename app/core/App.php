<?php

namespace Core;

/**
 * App class
 */
class App
{
	public function index()
	{
 
		do_action('before_controller');
		do_action('controller');
		do_action('after_controller');

		ob_start();
		do_action('before_view');

		$before_content = ob_get_contents();
		do_action('view');
		$after_content = ob_get_contents();

		if(strlen($after_content) == strlen($before_content))
		{
			if(page() != '404'){
				redirect('404');
			}
		}

		do_action('after_view');

	}
}