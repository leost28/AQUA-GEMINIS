<?php

class BD {
 
    private $servidor = '217.76.154.138';
    private $bd = 'aquaGeminis';
    private $usuario = 'voluta';
    private $pass = 'Boliche@0064';   


    // ACCESO BD
    public function acceso_BD() {
        try {
            $base = new PDO("mysql:host=$this->servidor;dbname=$this->bd", $this->usuario, $this->pass);
            $base->exec("set names utf8");
            $base->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $base;
        } catch (PDOException $e) {
           //echo $error_listado->getMessage();
        }
    }

    // QUERY
    public function query($sql){
        try {
            $base = $this->acceso_BD();       
            $consulta = $base->prepare($sql);
            $consulta->execute();
            $listado = $consulta->fetchAll();
            return $listado;
            $consulta = null;
        } catch (PDOException $error_listado) {
           //echo $error_listado->getMessage();
        }
   }

    public function consulta_BD($tabla, $campo, $where){
        try {
            $base = $this->acceso_BD();       
            $consulta = $base->prepare("SELECT ".$campo." FROM ".$tabla." WHERE ".$where."'");
            $consulta->execute();
            $listado = $consulta->fetchAll();
            return $listado[0][0];
            $consulta = null;
        } catch (PDOException $error_listado) {
            //echo $error_listado->getMessage();
        }
    }
   
   
    public function add_BD($tabla, $keys, $valores){
        
        try {
            //$Array asociativo
            $datos = $valores;
            $numCampos = count($datos);
            $sql = "INSERT INTO ".$tabla." (";
            for ($i = 0; $i < $numCampos; $i++){
                $sql .= $keys[$i];
                if ($i == $numCampos-1){
                    
                }else{
                   $sql.=", "; 
                }
            }
            $sql .= ") VALUES (";
            for ($i = 0; $i < $numCampos; $i++){
                $sql .= "'".$datos[$i]."'";
                if ($i == $numCampos-1){
                   $sql.=")";  
                }else{
                   $sql.=", "; 
                }
            }
            
            $base = $this->acceso_BD();
            $consulta = $base->prepare($sql);
            $consulta->execute();
            return $base->lastInsertId();
            $consulta = null;
        } catch (PDOException $error_listado) {
           //echo $error_listado->getMessage();
        }
    }


    public function update_BD($tabla, $ID, $keys, $valores){
        
        try {
            $datos = $valores;
            $numCampos = count($datos);
            $sql = "UPDATE ".$tabla." SET ";
            for ($i = 0; $i < $numCampos; $i++){
                $sql .= $keys[$i]. " = '".$valores[$i]."'";
                if ($i == $numCampos-1){
                
                } else {
                    $sql .= ", "; 
                }
            }
        
            $sql .= " WHERE id=".$ID; 
            $base = $this->acceso_BD();
            $consulta = $base->prepare($sql);
            $consulta->execute();
            return "ok";
            $consulta = null;
        } catch (PDOException $error_listado) {
            //return $error_listado->getMessage();
        }
    }


    public function delete_BD($tabla, $campo, $valor){
        try {
            $base = $this->acceso_BD();       
            $consulta = $base->prepare("DELETE FROM `".$tabla."` WHERE (`".$tabla."`.`".$campo."` = ".$valor.")");
            $consulta->execute();
            return "ok";
            $consulta = null;
        } catch (PDOException $error_listado) {
            //echo $error_listado->getMessage();
        }
    }



    public function create_ref($tabla, $prefijo){
        try {
            $anyo = substr( date('Y'), -2);
            /*---*/
            $base = $this->acceso_BD();  
            $consulta = $base->prepare("SELECT ref, REPLACE(ref,'".$prefijo."-".$anyo."-','') AS ref_num
                FROM ".$tabla." 
                WHERE ref LIKE '".$prefijo."-".$anyo."-%' 
                ORDER BY LENGTH(ref) DESC, ref DESC
                LIMIT 1");
            $consulta->execute();
            $resultado = $consulta->fetchAll();
            $total = count($resultado);
            /*---*/
            if($total >= 1){
                $ref_num = str_replace($prefijo.'-'.$anyo.'-', '', $resultado[0]['ref_num']);
                $ref_num++;
                $ref = $prefijo.'-'.$anyo.'-'.$ref_num;
            } else {
                $ref = $prefijo.'-'.$anyo.'-1';
            }
            
            return $ref;

        } catch (PDOException $error_listado) {
            //echo $error_listado->getMessage();
        }
    }


}
