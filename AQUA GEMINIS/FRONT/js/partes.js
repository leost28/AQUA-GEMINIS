/*------------------------------------------------------------------*/
/* CONTROL
/*------------------------------------------------------------------*/
// windows.location("/FRONT/login.html")
function existe(valor) {
    if (valor == "" | valor == undefined | valor == null | String(valor).trim() == "") {
        return false;
    } else {
        return true;
    }
}


/*------------------------------------------------------------------*/
/* LOGIN
/*------------------------------------------------------------------*/

function login() {
    var usuario = $("#form_login #usuario").val();
    var pass = $("#form_login #pass").val();
    /*---*/
    $.ajax({
        url: "https://aquageminis.voluta.es/BACK/bd/ajax.php",
        method: "POST",
        data: {
            login: "ok",
            usuario: usuario,
            pass: pass
        },
        async: false,
        error: function () {
            alert("No se puede conectar al Servidor o no estas registrado");
        },
        success: function (respuesta) {
            salida = respuesta;
            console.log(salida);
        },
        complete: function () {
            if (salida == 'ok') {
                window.open('https://aquageminis.voluta.es/index.html', '_self');
            } else {
                $("#form_login .msg-error").html('El usuario o la contraseña no son correctos');
                $("#form_login .msg-error").show();
            }
        }
    });
}

function login_verif() {
    $.ajax({
        url: "https://aquageminis.voluta.es/BACK/bd/ajax.php",
        method: "POST",
        data: {
            login_verif: "ok",
        },
        async: false,
        error: function () {
            alert("No se puede conectar al Servidor o no estas registrado");
        },
        success: function (respuesta) {
            salida = respuesta;
            console.log('login_verif: ' + salida);
        },
        complete: function () {
            if (salida != 'ok') {
                window.open('https://aquageminis.voluta.es/FRONT/login.html', '_self');
            }
        }
    });
}

function logout() {

    $.ajax({
        url: "https://aquageminis.voluta.es/BACK/bd/ajax.php",
        method: "POST",
        data: {
            logout: "ok",
        },
        async: false,
        error: function () {
            alert("No se puede conectar al Servidor o no estas registrado");
        },
        success: function (respuesta) {
            salida = respuesta;
            console.log(salida);
        },
        complete: function () {
            // if( salida == 'ok'){
            window.open('https://aquageminis.voluta.es/FRONT/login.html', '_self');
            // } 
        }
    });
}


/*------------------------------------------------------------------*/
/* VALVULAS
/*------------------------------------------------------------------*/

function cargar_valvulas() {
    $.ajax({
        url: "https://aquageminis.voluta.es/BACK/bd/ajax.php",
        method: "POST",
        data: {
            cargar_valvulas: "ok",
        },
        async: false,
        error: function () {
            alert("No se puede conectar al Servidor o no estas registrado");
        },
        success: function (respuesta) {
            salida = "";
            salida = JSON.parse(respuesta);
            console.log(salida);
        },
        complete: function () {
            if (existe(salida)) {
                $.each(salida, function (key, value) {
                    if (value['estado'] == 1) $('.valvula[valvulaID=' + value['id'] + ']').addClass('open');
                    else $('.valvula[valvulaID=' + value['id'] + ']').removeClass('open');

                });
            }
        }
    });
}

function update_valvulas(valvulaID, estado) {

    $.ajax({
        url: "https://aquageminis.voluta.es/BACK/bd/ajax.php",
        method: "POST",
        data: {
            update_valvulas: "ok",
            ID: valvulaID,
            estado: estado,
        },
        async: false,
        error: function () {
            alert("No se puede conectar al Servidor o no estas registrado");
        },
        success: function (respuesta) {
            salida = JSON.parse(respuesta);
            //console.log(salida);
        },
        complete: function () {
            if (salida == 'ok') {
                if (estado == 1) $('.valvula[valvulaID=' + valvulaID + ']').addClass('open');
                else $('.valvula[valvulaID=' + valvulaID + ']').removeClass('open');
            }
        }
    });
}


/*------------------------------------------------------------------*/
/* DEPOSITOS
/*------------------------------------------------------------------*/



function cargar_depositos() {
    $.ajax({
        url: "https://aquageminis.voluta.es/BACK/bd/ajax.php",
        method: "POST",
        data: {
            cargar_depositos: "ok",
        },
        async: false,
        error: function () {
            alert("No se puede conectar al Servidor o no estas registrado");
        },
        success: function (respuesta) {
            salida = "";
            salida = JSON.parse(respuesta);
            console.log(salida);
        },
        complete: function () {
            if (existe(salida)) {
                $.each(salida, function (key, value) {
                    $('.deposito[depositoID=' + value['id'] + ']  p.deposito_capacidad').html(value['capacidad'] + '%');
                });
            }
        }
    });
}
