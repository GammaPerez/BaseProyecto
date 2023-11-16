<?php
    header("Access-Control-Allow-Origin: *");
    class CC{
        public $connection;

        public function __construct(){
            $this->connection = mysqli_connect("localhost","root","","punto_venta") or die("No se pudo conectar a la base de datos".mysqli_connect_error());
            mysqli_set_charset($this->connection, "utf8");
        }
        
        public function getCC(){
            return $this->connection;
        }

        public function __destruct(){
            mysqli_close($this->connection);
        }

        public function sqlRequest($query){
            $result = mysqli_query($this->connection,$query) or die("Error ".mysqli_error($this->connection));
            if($result == true)
                return mysqli_affected_rows($this->connection);
            else
                return mysqli_affected_rows($result);
            
        }

        public function getDataRows($query){
            $res = mysqli_query($this->connection,$query);
            $data=[];
            while ($row=mysqli_fetch_array($res,MYSQLI_ASSOC))             
                $data[]=$row;
            return $data;
        }

        public function getDataWP($query, $params) {
            $result = mysqli_execute_query($this->connection, $query, $params);
            $data = [];
            while ($row=mysqli_fetch_array($result, MYSQLI_ASSOC))             
                $data[]=$row;
            return $data;
        }

        public function aNum($val) {
            if (is_numeric($val))
                return $val + 0;
            return 0;
        }

        public function getPriv($id){
            $priv = "";
            $data = [];
            $data = $this->getDataRows("Select accion as idaccion From accionusuario Where idusuario=".$id);
            for ($i = 0; $i < count($data); $i++)
                $priv .= '<'.$data[$i]['idaccion'].'>';
            return $priv;
        }

        public function getObject($res)
        {
            $result = mysqli_query($this->connection, $res);
            if(mysqli_num_rows($result)>0){
                $obj=mysqli_fetch_object($result);
            }
            return $obj;
        }

        public function getRegister($res){

            if(mysqli_num_rows($res) >0)
                while ($row=mysqli_fetch_array($res,MYSQLI_ASSOC))
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
                $query = str_ireplace($strFind, "", $query);
                $query = trim($query);
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