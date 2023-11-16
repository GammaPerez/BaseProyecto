<?php
    class CC2{
        public $connection;
        public function __construct()
        {
            $server = "localhost";
            $user = "sa";
            $password = "t33n3k";
            $connectionInfo = array( "UID"=>$user,
                                    "PWD"=>$password,
                                    "Database"=>"dm_lth",
                                    "CharacterSet" => "UTF-8");
            $this->connection = sqlsrv_connect($server, $connectionInfo);
            if($this->connection){
                echo "Conexion establecida";
            }else{
                echo "FALLO";
                die(print_r( sqlsrv_errors(), true));
            }
        }
        
        public function getCC(){
            return $this->connection;
        }
        public function __destruct(){
            sqlsrv_close($this->connection);
        }


        public function sqlRequest($query){
            $stmt = sqlsrv_query($this->connection, $query);
            $rows = sqlsrv_num_rows($stmt);
            sqlsrv_free_stmt($stmt);
            return $rows;
        }

        public function getDataRows($query){
            $res = sqlsrv_query($this->connection,$query);
            $data=[];
            while ($row=sqlsrv_fetch_array($res, SQLSRV_FETCH_ASSOC))             
                $data[]=$row;
            return $data;
        }

        public function getDataWP($query, $params) {
            $result = pg_query_params($this->connection, $query, $params);
            $data = [];
            while ($row=pg_fetch_array($result, NULL,PGSQL_ASSOC))             
                $data[]=$row;
            return $data;
        }

        public function aNum($val) {
            if (is_numeric($val))
                return $val + 0;
            return 0;
        }

        public function getObject($res){
            $result = pg_query($this->connection, $res);
            if(pg_num_rows($result)>0)
            {
                $obj=pg_fetch_object($result);
            }
            return $obj;
        }

        public function getRegister($res){
            if(pg_num_rows($res) >0)
                while ($row=pg_fetch_array($res,NULL,PGSQL_ASSOC))
                    return $row;
        }
        
        public function translateQuery($query, $modulo){
            $strFind = "insert into";
            $pos = stripos($query, $strFind);
            $tipo = 0;
            $tipoAux="";
            
            if($pos !== false){
                $tipo = 1;
                $tipoAux = "Nuevo Registro";
                $query = str_ireplace("values", "Valores", $query);
                $band = true;
            }
            else{
                $strFind = "delete from";
                $pos = stripos($query, $strFind);
                if($pos !== false){
                    $tipo = 2;
                    $tipoAux = "Borrar Registro";
                    $band = true;
                }
                else{
                    $strFind = "update";
                    $pos = stripos($query, $strFind);
                    if($pos !== false){
                        $tipo = 3;
                        $tipoAux = "Actualizar Registro";
                        $band = true;
                    }
                    else{
                        $tipo = 4;
                        $tipoAux = "Consultar Registro";
                    }
                }
            }
            if($tipo != 4){
                 // $query;
                $query = str_ireplace($strFind, "", $query);
                $query = trim($query);
                //echo $query;
                $query = substr_replace($query, "[", 0, 0);
                switch($tipo){
                    case 1: 
                        $posAux = strpos($query, "(");
                        break;
                    default:
                        $posAux = strpos($query, " ");
                        $posAux += 1;
                        break;
                }
                $query = substr_replace($query, "] ", $posAux, 0);
            }
            $query = str_ireplace(" set ", " ", $query);
            $query = str_ireplace(" where ", " condiciones: ", $query);
            $query = str_ireplace(" from ", " de ", $query);
            $query = str_ireplace("select", "Selecciona", $query);
            $query = str_ireplace(" is not null ", " no es un valor nulo ", $query);
            $query = str_ireplace(" in ", " este en ", $query);
            $query = str_ireplace(" not ", " no ", $query);
            $query = str_ireplace(" group by ", " agrupar por ", $query);
            $query = str_ireplace(" like ", " similar a ", $query);
            $query = str_ireplace(" ilike ", " similar a ", $query);
            $query = str_ireplace(" min ", " minimo ", $query);
            $query = str_ireplace(" max ", " maximo ", $query);
            $query = str_ireplace(" avg ", " promedio ", $query);
            $query = str_ireplace(" order by ", " ordenar por ", $query);
            $query = str_ireplace(" and ", " y ", $query);
            $query = str_ireplace(" or ", " o ", $query);
            $query = str_replace("'", "''", $query);
        }
    }
?>