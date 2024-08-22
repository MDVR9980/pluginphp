<?php

namespace Core;

defined('ROOT') or die("Direct script access denied");

/**
 * Pager class
 */
class Pager
{
	
	public $links 		= [];
	public $limit 		= 10;
	public $offset 		= 0;
	public $start 		= 1;
	public $end 		= 1;
	public $page_number = 1;

	public function __construct(int $limit = 10, $extras = 1)
	{
		$page_number = !empty($_GET['page']) ? (int)$_GET['page'] : 1;
		$page_number = $page_number < 1 ? 1 : $page_number;

		$this->start = $page_number - $extras;
		$this->end = $page_number + $extras;
		$this->start = $this->start < 1 ? 1 : $this->start;

		$this->page_number = $page_number;
		$this->offset = ($page_number - 1) * $limit;

		$url = $_GET['url'] ?? 'home';
		$query_string = str_replace("url=","",$_SERVER['QUERY_STRING']);
		$current_link = ROOT . '/'.$url . '?' . trim(str_replace($url, "", $query_string),'&');
		if(!strstr($current_link, "page="))
			$current_link .= '&page='.$page_number;

		$first_link = preg_replace("/page=[0-9]+/", "page=1", $current_link);
		$next_link = preg_replace("/page=[0-9]+/", "page=".($page_number + $extras + 1), $current_link);
		
		$this->links['current'] 	= $current_link;
		$this->links['first'] 		= $first_link;
		$this->links['next']	 	= $next_link;

	}

	public function display()
	{
		?>
		<nav aria-label="Page navigation example">
		  <ul class="pagination">
		    <li class="page-item"><a class="page-link" href="<?=$this->links['first']?>">First</a></li>

		    <?php for($x = $this->start;$x <= $this->end;$x++):?>
			    <li class="page-item <?=$x == $this->page_number ? 'active':''?>">
			    	<a class="page-link" href="<?=preg_replace("/page=[0-9]+/", "page=".$x, $this->links['current'])?>"><?=$x?></a>
			    </li>
			<?php endfor?>

		    <li class="page-item"><a class="page-link" href="<?=$this->links['next']?>">Next</a></li>
		  </ul>
		</nav>
		<?php
	}

	public function displayTailwind():string
	{
		?>
		<nav aria-label="Page navigation example">
		  <ul class="pagination">
		    <li class="page-item"><a class="page-link" href="<?=$this->links['first']?>">First</a></li>

		    <?php for($x = $this->start;$x <= $this->end;$x++):?>
			    <li class="page-item <?=$x == $this->page_number ? 'active':''?>">
			    	<a class="page-link" href="<?=preg_replace("/page=[0-9]+/", "page=".$x, $this->links['current'])?>"><?=$x?></a>
			    </li>
			<?php endfor?>

		    <li class="page-item"><a class="page-link" href="<?=$this->links['next']?>">Next</a></li>
		  </ul>
		</nav>
		<?php
	}

	public function displayCustom():string
	{
		?>
		<nav aria-label="Page navigation example">
		  <ul class="pagination">
		    <li class="page-item"><a class="page-link" href="<?=$this->links['first']?>">First</a></li>

		    <?php for($x = $this->start;$x <= $this->end;$x++):?>
			    <li class="page-item <?=$x == $this->page_number ? 'active':''?>">
			    	<a class="page-link" href="<?=preg_replace("/page=[0-9]+/", "page=".$x, $this->links['current'])?>"><?=$x?></a>
			    </li>
			<?php endfor?>

		    <li class="page-item"><a class="page-link" href="<?=$this->links['next']?>">Next</a></li>
		  </ul>
		</nav>
		<?php
	}

	
}