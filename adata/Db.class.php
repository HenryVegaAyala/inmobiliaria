<?php
date_default_timezone_set('America/Lima');

class Db
{
    private $link;
    private $stmt;
    private $array;

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


    public function Db()
    {

    }

    private function conectar()
    {
        if (($_SERVER['SERVER_NAME'] == 'localhost') || ($_SERVER['SERVER_NAME'] == '127.0.0.1')) {
            $host = 'localhost';
            $port = '5432';
            $user = 'postgres';
            $password = 'root';
            $db = 'cinadsac_inmobiliaria';
        } else {
            $host = 'localhost';
            $port = '5432';
            $user = 'postgres';
            $password = 'root';
            $db = 'cinadsac_inmobiliaria';
        }

        $this->host = $host;
        $this->port = $port;
        $this->username = $user;
        $this->passwd = $password;
        $this->dbName = $db;

        $conn = pg_connect('host=' . $host . ' port=' . $port . ' dbname=' . $db . ' user=' . $user . ' password=' . $password);
        pg_set_client_encoding($conn, "UNICODE");

        $this->link = $conn;
    }

    private function desconectar()
    {
        pg_close($this->link);
    }

    private function obtener_filas($stmt)
    {
        $fetchrow = array();

        /*while ($row = pg_fetch_array($stmt, NULL, PGSQL_ASSOC))
            $fetchrow[] = array_map('utf8_encode', $row);*/

        while ($row = pg_fetch_array($stmt, null, PGSQL_ASSOC)) {
            $fetchrow[] = $row;
        }

        $this->array = $fetchrow;
        return $this->array;
    }

    public function exec_simple_sql($strsql)
    {
        $this->conectar();
        $rs_output = pg_query($this->link, $strsql);
        echo pg_last_error($this->link);
        $this->desconectar();

        return 1;
    }

    public function exec_sp_select($sp_name, $sp_params)
    {
        $strsql = 'SELECT * FROM ' . $sp_name . ' (';

        if (is_array($sp_params)) {
            $strsql .= '\'' . implode($sp_params, '\', \'') . '\'';
        }

        $strsql .= ')';

        $this->conectar();

        $rs_output = pg_query($this->link, $strsql);
        $result = $this->obtener_filas($rs_output);
        $this->stmt = $rs_output;
        pg_free_result($rs_output);

        /*echo $strsql;*/
        echo pg_last_error($this->link);
        $this->desconectar();

        return $result;
    }

    function exec_sp_one_value($sp_name, $sp_params, $sp_defaultvalue = "")
    {
        $onevalue = 0;
        $strsql = 'SELECT * FROM ' . $sp_name . ' (';

        if (is_array($sp_params)) {
            $strsql .= '\'' . implode($sp_params, '\', \'') . '\'';
        } else {
            $strsql .= '\'' . $sp_params . '\'';
        }

        $strsql .= ') AS valor';

        $this->conectar();

        $rs_output = pg_query($this->link, $strsql);
        $result = $this->obtener_filas($rs_output);
        $this->stmt = $rs_output;
        pg_free_result($rs_output);

        echo pg_last_error($this->link);
        $this->desconectar();

        $countresult = count($result);
        if ($countresult > 0) {
            $onevalue = $result[0]['valor'];
        } else {
            $onevalue = $sp_defaultvalue;
        }
        return $onevalue;
    }

    public function exec_sp_iud($sp_name, $sp_params)
    {
        $strsql = 'SELECT * FROM ' . $sp_name . ' (';

        if (is_array($sp_params)) {
            $strsql .= '\'' . implode($sp_params, '\', \'') . '\'';
        } else {
            $strsql .= '\'' . $sp_params . '\'';
        }

        $strsql .= ')';

        $this->conectar();

        $rs_output = pg_query($this->link, $strsql);
        $result = $this->obtener_filas($rs_output);
        $this->stmt = $rs_output;
        pg_free_result($rs_output);

        /*echo $strsql;*/
        echo pg_last_error($this->link);
        $this->desconectar();

        return $result;
    }

    function set_select($campos, $tabla, $condicion = false, $orden = "")
    {
        $strsql = '';
        if (is_array($campos)) {
            $strsql = '' . implode($campos, ' ,') . '';
        } else {
            $strsql = $campos;
        }
        $condicion = ($condicion) ? ' WHERE ' . $condicion : '';
        $query = 'SELECT ' . $campos . ' FROM ' . $tabla . '' . $condicion . $orden;

        $this->conectar();
        $rs_output = pg_query($this->link, $query);
        if (!$rs_output) {
            if (empty($this->error)) {
                $this->error = 'PostgreSQL says: ' . @pg_errormessage();
                return $this->error;
            }
        }
        $result = $this->obtener_filas($rs_output);
        $this->stmt = $rs_output;
        pg_free_result($rs_output);
        echo pg_last_error($this->link);
        $this->desconectar();
        return $result;
    }
}

?>