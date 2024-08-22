<?php

namespace Core;
use \PDO;
use \PDOException;

defined('ROOT') or die("Direct script access denied");

/**
 * Database class
 */
class Database
{
	private static $query_id 	= '';
	public $affected_rows 		= 0;
	public $insert_id 			= 0;
	public $error 				= '';
	public $has_error 			= false;

	private function connect()
	{

		$VARS['DB_NAME'] 		= DB_NAME;
		$VARS['DB_USER'] 		= DB_USER;
		$VARS['DB_PASSWORD'] 	= DB_PASSWORD;
		$VARS['DB_HOST'] 		= DB_HOST;
		$VARS['DB_DRIVER'] 		= DB_DRIVER;

		$VARS = do_filter('before_db_connect',$VARS);

		$string = "$VARS[DB_DRIVER]:hostname=$VARS[DB_HOST];dbname=$VARS[DB_NAME]";

		try
		{
			$con = new PDO($string,$VARS['DB_USER'],$VARS['DB_PASSWORD']);
			$con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		} catch (PDOException $e) {
			
			die("Failed to connect to database with error " . $e->getMessage());
		}

		return $con;

	}

	public function get_row(string $query, array $data = [], string $data_type = 'object')
	{

		$result = $this->query($query,$data,$data_type);
		if(is_array($result) && count($result) > 0)
		{
			return $result[0];
		}

		return false;
	}

	public function query(string $query, array $data = [], string $data_type = 'object')
	{

		$query = do_filter('before_query_query',$query);
		$data = do_filter('before_query_data',$data);

		$this->error 				= '';
		$this->has_error 			= false;

		$con = $this->connect();

		try
		{
			$stm = $con->prepare($query);

			$result = $stm->execute($data);
			$this->affected_rows 	= $stm->rowCount();
			$this->insert_id 		= $con->lastInsertId();

			if($result)
			{
				if($data_type == 'object'){
					$rows = $stm->fetchAll(PDO::FETCH_OBJ);
				}else{
					$rows = $stm->fetchAll(PDO::FETCH_ASSOC);
				}

			}

		}catch(PDOException $e)
		{
			$this->error 				= $e->getMessage();
			$this->has_error 			= true;
		}


		$arr = [];
		$arr['query'] = $query;
		$arr['data'] = $data;
		$arr['result'] = $rows ?? [];
		$arr['query_id'] = self::$query_id;
		self::$query_id = '';

		$result = do_filter('after_query',$arr);

		if(is_array($result) && count($result) > 0)
		{
			return $result;
		}

		return false;
	}
}