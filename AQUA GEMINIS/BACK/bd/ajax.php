<?php

// CONECTAR A BD
include_once ( 'class.php');

/*------------------------------------------------------------------*/
/* LOGIN
/*------------------------------------------------------------------*/

if(isset($_REQUEST['login'])){

  $usuario = $_POST['usuario'];
  $pass = $_POST['pass'];
  /*---*/
  $sql = "SELECT * 
          FROM vol_usuarios 
          WHERE usuario = '$usuario' AND pass = '$pass'
          LIMIT 1";
  $base = new BD();
  $resultados = $base->query($sql);

  if(!empty($resultados)){
    $ID = $resultados[0]['id'];
    $token =  $ID .'.'. date_timestamp_get(date_create());
    $time = time()+3600*24*15;
    /*---*/
    unset($campos);
    unset($valores);
    $campos = [
      'token'
    ];
    $valores =[
      $token
    ];
    $base = new BD();
    $base->update_BD('vol_usuarios', $ID, $campos, $valores);
    /*---*/
    setcookie("token", $token, $time);
    echo 'ok';
  } else {
    echo 'empty';
  }
}


if(isset($_REQUEST['login_verif'])){

  $token = $_COOKIE['token'];
  /*---*/
  if( !empty($token)) {
  $sql = "SELECT * 
          FROM vol_usuarios 
          WHERE token = $token
          LIMIT 1";
  $base = new BD();
  $resultados = $base->query($sql);
  }
  
  if(!empty($resultados)){
    echo 'ok';
  } else {
    echo 'empty';
  }
}

if(isset($_REQUEST['logout'])){

  $token = $_COOKIE['token'];
  /*---*/
  if( !empty($token)) {
  $sql = "SELECT * 
          FROM vol_usuarios 
          WHERE token = $token
          LIMIT 1";
  $base = new BD();
  $resultados = $base->query($sql);
  }
  
  if(!empty($resultados)){
    unset($campos);
    unset($valores);
    $campos = [
      'token'
    ];
    $valores =[
      ''
    ];
    $base = new BD();
    $base->update_BD('vol_usuarios', $resultados[0]['id'], $campos, $valores);
    /*---*/
    setcookie("token", '', $time);
    echo 'ok';
  } else {
    echo 'empty';
  }
}


/*------------------------------------------------------------------*/
/* VALVULAS
/*------------------------------------------------------------------*/


if(isset($_REQUEST['cargar_valvulas'])){

    $sql = "SELECT * 
            FROM vol_valvulas 
            ORDER BY id";
    $base = new BD();
    $resultados = $base->query($sql);

    if(!empty($resultados)){
      echo json_encode($resultados);    
    } else {
      echo 'empty';
    }
}


if(isset($_REQUEST['update_valvulas'])){

  $ID = $_POST['ID'];
  $estado = $_POST['estado'];
  /*---*/
  unset($campos);
  unset($valores);
  $campos = [
      'estado'
  ];
  $valores =[
      $estado
  ];
  $base = new BD();
  $base->update_BD('vol_valvulas', $ID, $campos, $valores);
  
  echo json_encode('ok');    
}



/*------------------------------------------------------------------*/
/* DEPOSITOS
/*------------------------------------------------------------------*/


if(isset($_REQUEST['cargar_depositos'])){

  $sql = "SELECT * 
          FROM vol_depositos 
          ORDER BY id";
  $base = new BD();
  $resultados = $base->query($sql);

  if(!empty($resultados)){
    echo json_encode($resultados);    
  } else {
    echo 'empty';
  }
}


if(isset($_REQUEST['update_depositos'])){

$ID = $_POST['ID'];
$estado = $_POST['estado'];
/*---*/
unset($campos);
unset($valores);
$campos = [
    'estado'
];
$valores =[
    $estado
];
$base = new BD();
$base->update_BD('vol_depositos', $ID, $campos, $valores);

echo json_encode('ok');    
}

if(isset($_REQUEST['mideDepositos'])){
  //S1
  $campos = [
      'capacidad'
  ];
  $valores =[
      $_REQUEST['S1']
  ];
  $base = new BD();
  $base->update_BD('vol_depositos', 1, $campos, $valores);
  //S2
  $campos = [
    'capacidad'
];
$valores =[
    $_REQUEST['S2']
];
$base = new BD();
$base->update_BD('vol_depositos', 2, $campos, $valores);
//S3
$campos = [
  'capacidad'
];
$valores =[
  $_REQUEST['S3']
];
$base = new BD();
$base->update_BD('vol_depositos', 3, $campos, $valores);


  echo json_encode('ok');    
  }

