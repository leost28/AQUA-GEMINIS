<?php

// CONECTAR A BD
include ('core/bd/class.php');


/*------------------------------------------------------------------*/
/* GLOBALES
/*------------------------------------------------------------------*/

function plural($num, $singular, $plural){
    if ($num <= 1) $resultado = $num.' '.$singular;
    else $resultado = $num.' '.$plural;

    return $resultado;
}

function contar($tabla, $where){
    $base = new BD();
    $sql = " SELECT * FROM ".$tabla." ";
    if( !empty($where)) $sql .= " WHERE ".$where." ";
    $resultados = $base->query($sql);
    /*---*/
    $total = count($resultados);
        
    return $total;
}




/*------------------------------------------------------------------*/
/* DECODE
/*------------------------------------------------------------------*/

function decode_estado($estado_num){
    
    switch ($estado_num) {
        case 0:
            $decode = "Desactivado";
            break;
        case 1:
            $decode = "Activo";
            break;
    }

    return $decode;
}

function decode_role($role_num){
    
    switch ($role_num) {
        case 0:
            $decode = "Sin permisos";
            break;
        case 1:
            $decode = "Usuario";
            break;
        case 2:
            $decode = "Editor";
            break;
        case 3:
            $decode = "Administrador";
            break;
        case 4:
            $decode = "Súper administrador";
            break;
    }

    return $decode;
}

