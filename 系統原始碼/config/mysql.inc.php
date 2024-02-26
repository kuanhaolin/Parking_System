<?php 
	//連接SQL
	function connectMySQL($host=MYSQL_HOST, $user=MYSQL_USER, $password=MYSQL_PASSWORD, $database=MYSQL_DATABASE, $port=MYSQL_PORT){
		$link=@mysqli_connect($host, $user, $password, $database, $port);

		if(mysqli_connect_errno()){
			exit(mysqli_connect_error());
		}
		mysqli_set_charset($link, 'utf8');
		return $link;
	}
	
	//執行一條SQL語句,返回結果集對像或者返回bool值
	function execute($link, $query){
		$result=mysqli_query($link, $query);

		if(mysqli_errno($link)){
			exit(mysqli_error($link));
		}
		return $result;
	}

	//執行一條SQL語句，只會返回bool值
	function execute_bool($link,$query){
		$bool=mysqli_real_query($link, $query);

		if(mysqli_errno($link)){
			exit(mysqli_error($link));
		}
		return $bool;
	}

	//一次性執行多條SQL語句
	/*
	一次性執行多條SQL語句
	$link：連接
	$arr_sqls：數組形式的多條sql語句
	$error：傳入一個變量，裡面會存儲語句執行的錯誤信息
	使用案例：
	$arr_sqls=array(
		'select * from sfk_father_module',
		'select * from sfk_father_module',
		'select * from sfk_father_module',
		'select * from sfk_father_module'
	);
	var_dump(execute_multi($link, $arr_sqls,$error));
	echo $error;
	*/

	function execute_multi($link, $arr_sqls, &$error){
		$sqls=implode(';', $arr_sqls).';';
		if(mysqli_multi_query($link, $sqls)){
			$data=array();
			$i=0;//計數
			do {
				if($result=mysqli_store_result($link)){
					$data[$i]=mysqli_fetch_all($result);
					mysqli_free_result($result);
				}else{
					$data[$i]=null;
				}
				$i++;
				if(!mysqli_more_results($link)) break;
			}while (mysqli_next_result($link));
			if($i==count($arr_sqls)){
				return $data;
			}else{
				$error="sql語句執行失敗：<br />&nbsp;數組下標為{$i}的語句:{$arr_sqls[$i]}執行錯誤<br />&nbsp;錯誤原因：".mysqli_error($link);
				return false;
			}
		}else{
			$error='執行失敗！請檢查首條語句是否正確！ <br />可能的錯誤原因：'.mysqli_error($link);
			return false;
		}
	}

	//獲取記錄數
	function num($link, $sql_count){
		$result=execute($link, $sql_count);
		$count=mysqli_fetch_row($result);
		return $count[0];
	}

	//數據入庫之前進行轉義，確保，數據能夠順利的入庫
	function escape($link,$data){
		if(is_string($data)){
			return mysqli_real_escape_string($link,$data);
		}
		if(is_array($data)){
			foreach ($data as $key=>$val){
				$data[$key]=escape($link,$val);
			}
		}
		return $data;
		//mysqli_real_escape_string($link,$data);
	}

	//關閉與數據庫的連接
	function close($link){
		mysqli_close($link);
	}
?>