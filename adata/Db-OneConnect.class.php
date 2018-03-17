<?php
class DbOneConnect {
	// private $link;
	// private $stmt;
	// private $array;

	var $host = '';
    /**
     * Username used to connect to database
     */
    var $port = '';
    /**
     * Port used to connect to database
     */
    var $username = '';
    /**
     * Password used to connect to database
     */
    var $passwd = '';
    /**
     * Database to backup
     */
    var $dbName = '';

	public function DbOneConnect()
	{
		
	}

	public function conectar()
	{
		if (($_SERVER['SERVER_NAME'] == 'localhost') || ($_SERVER['SERVER_NAME'] == '127.0.0.1') || ($_SERVER['SERVER_NAME'] == '192.168.1.64')){
			$host='127.0.0.1';
			$port = '5432';
			$user='postgres';
			$password='123@abc';
			$db='cinadsacv2';
		}
		else {
			$host='localhost';
			$port = '5432';
			$user='cinadsac_admin';
			$password='x813X7!O^u[%';
			$db='cinadsac_inmobiliaria';
		}
		
		$this->host     = $host;
		$this->port     = $port;
        $this->username = $user;
        $this->passwd   = $password;
        $this->dbName   = $db;

		$connect = pg_connect('host='.$host.' port='.$port.' dbname='.$db.' user='.$user.' password='.$password);
		pg_set_client_encoding($connect, "UNICODE");

		return $connect;
	}

	public function desconectar($connect)
	{
		pg_close($connect);
	}

	private function obtener_filas($stmt)
	{
		$fetchrow = array();

		/*while ($row = pg_fetch_array($stmt, NULL, PGSQL_ASSOC))
			$fetchrow[] = array_map('utf8_encode', $row);*/

		while ($row = pg_fetch_array($stmt, NULL, PGSQL_ASSOC))
			$fetchrow[] = $row;

		return $fetchrow;
	}

	public function exec_simple_sql($connect, $strsql)
	{
		$rs_output = pg_query($connect, $strsql);
		echo pg_last_error($connect);

		return 1;
	}

	public function exec_sp_select($connect, $sp_name, $sp_params)
	{
		$strsql = 'SELECT * FROM '.$sp_name.' (';

		if (is_array($sp_params))
			$strsql .= '\'' . implode($sp_params, '\', \'') . '\'';	
		
		$strsql .= ')';
		
		$rs_output = pg_query($connect, $strsql);
		$result = $this->obtener_filas($rs_output);
		$this->stmt = $rs_output;
		pg_free_result($rs_output);

		/*echo $strsql;*/
		echo pg_last_error($connect);

		return $result;
	}

	function exec_sp_one_value($connect, $sp_name, $sp_params, $sp_defaultvalue = "")
	{
		$onevalue = 0;
		$strsql = 'SELECT * FROM '.$sp_name.' (';

		if (is_array($sp_params))
			$strsql .= '\'' . implode($sp_params, '\', \'') . '\'';
		else
			$strsql .= '\'' .$sp_params . '\'';

		$strsql .= ') AS valor';
		
		$rs_output = pg_query($connect, $strsql);
		$result = $this->obtener_filas($rs_output);
		$this->stmt = $rs_output;
		pg_free_result($rs_output);

		echo pg_last_error($connect);

		$countresult = count($result);
		if ($countresult > 0)
			$onevalue = $result[0]['valor'];
		else
			$onevalue = $sp_defaultvalue;
		return $onevalue;
	}

	public function exec_sp_iud($connect, $sp_name, $sp_params)
	{
		$strsql = 'SELECT * FROM '.$sp_name.' (';

		if (is_array($sp_params))
			$strsql .= '\'' . implode($sp_params, '\', \'') . '\'';
		else
			$strsql .= '\'' .$sp_params . '\'';

		$strsql .= ')';
		
		$rs_output = pg_query($connect, $strsql);
		$result = $this->obtener_filas($rs_output);
		$this->stmt = $rs_output;
		pg_free_result($rs_output);

		/*echo $strsql;*/
		echo pg_last_error($connect);

		return $result;
	}

	function set_select($connect, $campos, $tabla, $condicion = false, $orden = ""){
		$strsql='';
		if (is_array($campos)){
		$strsql = '' . implode($campos, ' ,') . '';
		}else{
		$strsql=$campos;
		}
		$condicion = ($condicion) ? ' WHERE ' . $condicion : '';
		$query = 'SELECT ' . $campos . ' FROM ' . $tabla . '' . $condicion . $orden;

       $rs_output = pg_query($connect, $query);
       if ( ! $rs_output ){
            if( empty($this->error) ){
                $this->error = 'PostgreSQL says: '.@pg_errormessage();
                return $this->error;
            }
        }
        $result = $this->obtener_filas($rs_output);
        $this->stmt = $rs_output;
        pg_free_result($rs_output);
        echo pg_last_error($connect);
        return $result;
    }
}
?>