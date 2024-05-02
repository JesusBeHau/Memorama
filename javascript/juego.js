var juegoPausado = false; // Para rastrear si el juego está en pausa
var tiempoRestante; // Para guardar el tiempo restante cuando se pausa

$(document).ready(function() {


    //Ver nombre del jugador con sesion iniciada
    $.get("../core/php/VerifyUserName.php").done(function(data) {
        var usuario = $.parseJSON(data);
        $("#nombre-jugador").text(usuario[0].nombre);
        idUsuario = usuario[0].id;
    });

    $("#pregunta-correctos").hide();
    $("#puntaje").val("0");
    asignarListenersPregunta();

    var tiempo = 150;
    var url = window.location.toString();
    var parametros = url.substring(url.indexOf("dif=") + 4).split('&');

    if (parametros.length < 2) {
        salirJuego();
    }

    dificultad = parametros[0];
    materia = parametros[1].substring(4);

    switch (dificultad) {
        case "facil":
            tiempo = 300;
            break;
        case "medio":
            tiempo = 250;
            break;
        case "dificil":
            tiempo = 5;
            break;
    }

    $("#pause-button").click(function() {
        pausarJuego();
    });

    $("#resume-button").click(function() {
        reanudarJuego(); // Reanudar el juego y cerrar el modal
    });

    $("#exit-button").click(function() {
        salirJuego(); // Salir del juego, redirigir al menú o a otra sección
    });

    pedirDatos(materia);
    iniciarContador(tiempo);
});

var dificultad;
var idUsuario;
var materia;
var cartas = [];

function pedirDatos(materia) {
    $.get("../core/php/ParejasJuegoDispatcher.php", {idmateria: materia}).done(function(data) {
        if (!data) {
            //No hay datos
            salirJuego();
        }

        var datos = $.parseJSON(data);

        if (datos.length < 9) {
            //datos incompletos
            salirJuego();
        }
        datos = revolver(datos);
        procesarDatos(datos);
    });
}


function procesarDatos(datos) {
    for (var i = 0; i < 9; i++) {
        crearCartas(datos[i].concepto, datos[i].descripcion, i);
    }
}

function crearCartas(concepto, descipcion, indice) {
    //cargamos la carta y le inyectamos los el concepto
    $.get("../sections/carta.html", function(data) {
        var htmlCarta = $.parseHTML(data);
//        $(htmlCarta).attr("id", "C" + indice + concepto);
        $(htmlCarta).attr("id", indice + concepto);
        $(htmlCarta).attr("tipo", "definicion");
        $(htmlCarta).find("#texto").append(concepto);
        $(htmlCarta).find("#img-correcta").hide();
        $(htmlCarta).find("#imagen-carta").attr("src", "../img/carta_uady.png");
        asignarListeners(htmlCarta);
        colocarCartas(htmlCarta);
    });

    //Luego creamos otra carta con la descripcion
    $.get("../sections/carta.html", function(data) {
        var htmlCarta = $.parseHTML(data);
//        $(htmlCarta).attr("id", "D" + indice + concepto);
        $(htmlCarta).attr("id", indice + concepto);
        $(htmlCarta).attr("tipo", "concepto");
        $(htmlCarta).find("#texto").append(descipcion);
        $(htmlCarta).find("#img-correcta").hide();
        $(htmlCarta).find("#imagen-carta").attr("src", "../img/carta_uady_c.png");
        asignarListeners(htmlCarta);
        colocarCartas(htmlCarta);
    });
}

var parejaSeleccionada = [];

function asignarListeners(carta) {
    $(carta).click(function() {
        console.log("click");

        //notify(1, this.id);

//        $(carta).toggleClass("flipped");
//        //Le quitamos el evento de click
//        $(carta).unbind("click");
        //Comprueba que no se haga click a la misma carta varias veces
//        for (var index in parejaSeleccionada) {
//
//            if (parejaSeleccionada[index] === carta) {
//                parejaSeleccionada.splice(index, 1);
//                return;
//            }
//        }


        if ($(carta).attr("tipo") !== $(parejaSeleccionada[0]).attr("tipo")) {
            $(carta).toggleClass("flipped");
            //Le quitamos el evento de click
            $(carta).unbind("click");
            parejaSeleccionada.push(carta);
        } else {
            //alert("Son iguales");
        }

        //Si es la segunda carta seleccionada
        if (parejaSeleccionada.length > 1) {
            bloquearCartas();
            $("#pregunta-correctos").show(500);
        }



    });
}

function confirmarRespuesta(respuesta, caso) {
    var divResultado = $("#resultado");
    divResultado.removeClass();


    $("#pregunta-correctos").hide(500);

    if (respuesta) {
        console.log("Correcto");
        divResultado.text("Correcto");
        divResultado.show(1000);
        divResultado.toggleClass("alert alert-success", true);

    } else {
        console.log("Inorrecto");
        divResultado.text("Incorrecto");
        divResultado.show(1000);
        divResultado.toggleClass("alert alert-danger", true);
    }


    /*
     * Casos:
     * 1-> Respuesta y conceptos iguales: Acertado
     * 2-> Respuesta y conceptos iguales: Fallo
     * 3-> Respuesta y conceptos NO iguales: Fallo
     * 4-> Respuesta y conceptos NO iguales: Acertado
     */

    switch (caso) {
        case 1:
            sumarPuntos(3);
            sacarCartas(parejaSeleccionada);
            break;
        case 2:
            sumarPuntos(-3);
            ocultarSeleccionados();
            break;
        case 3:
            sumarPuntos(-3);
            ocultarSeleccionados();
            break;
        case 4:
            sumarPuntos(1);
            ocultarSeleccionados();
            break;
    }

    desbloquearCartas();
    confirmarGane();
    //divResultado.hide(500);
    parejaSeleccionada = [];
}

function ocultarSeleccionados() {
    for (i = 0; i < parejaSeleccionada.length; i++) {
        $(parejaSeleccionada[i]).toggleClass("flipped");
    }
}

function sumarPuntos(puntos) {
    var puntaje = parseInt($("#puntaje").val());
    puntaje = puntaje + puntos;
    $("#puntaje").val(puntaje);
}

function sacarCartas(parejasSeleccionada) {
    for (var i = 0, max = parejasSeleccionada.length; i < max; i++) {
        for (var j = 0; j < cartas.length; j++) {
            var idSeleccionado = $(parejaSeleccionada[i]).attr("id");
            var idCarta = $(cartas[j]).attr("id");
            if (idSeleccionado === idCarta) {
                $(cartas[j]).find("#img-correcta").show();
                cartas.splice(j, 1);
                break;
            }
        }
    }

}

function confirmarGane() {
    if (cartas.length === 0) {
        clearInterval(intervaloContador);
        mostrarGanaste();
    }
}


function asignarListenersPregunta() {
    $("#respuesta-si").unbind("click");
    $("#respuesta-no").unbind("click");

    $("#respuesta-si").click(function() {
        var id1 = $(parejaSeleccionada[0]).attr("id");
        var id2 = $(parejaSeleccionada[1]).attr("id");


//        var idF1 = id1.substring(1);
//        var idF2 = id2.substring(1);

        if (id1 === id2) {
            confirmarRespuesta(true, 1);
        } else {
            confirmarRespuesta(false, 2);
        }




    });

    $("#respuesta-no").click(function() {
        var id1 = $(parejaSeleccionada[0]).attr("id");
        var id2 = $(parejaSeleccionada[1]).attr("id");

//        var idF1 = id1.substring(1);
//        var idF2 = id2.substring(1);

        if (id1 === id2) {
            confirmarRespuesta(false, 3);
        } else {
            confirmarRespuesta(true, 4);
        }
    });
}

function colocarCartas(carta) {
    //revolvemos las cartas
    cartas.push(carta);
    cartas = revolver(cartas);
    //Las colocamos en en tablero
    for (i = 0; i < cartas.length; i++) {
        $("#tablero").append(cartas[i]);
    }
}

function bloquearCartas() {
    for (i = 0; i < cartas.length; i++) {
        $(cartas[i]).unbind("click");
    }
}

function desbloquearCartas() {
    for (i = 0; i < cartas.length; i++) {
        asignarListeners(cartas[i]);
    }
}

var intervaloContador;

function iniciarContador(tiempo) {
    tiempoRestante = tiempo; // Guardar el tiempo restante
    $("#timer").text(tiempoRestante);
    intervaloContador = setInterval(function() {
        if (!juegoPausado) { // Solo decrementar si el juego no está pausado
            tiempoRestante--;
            if (tiempoRestante <= 0) {
                console.log("Se acabó el tiempo");
                clearInterval(intervaloContador);
                mostrarTiempoTerminado();
            }
            $("#timer").text(tiempoRestante);

            if (tiempoRestante === 100) {
                $("#timer").removeClass("buen-tiempo").addClass("poco-tiempo");
            }
        }

    }, 1000);
}

function pausarJuego() {
    juegoPausado = true;
    clearInterval(intervaloContador)
    // Mostrar el modal para la pausa
    $("#pause-modal").modal({
        backdrop: 'static', // Evita cerrar el modal haciendo clic fuera de él
        keyboard: false    // Evita cerrar el modal con la tecla Escape
    });
}

function reanudarJuego() {
    juegoPausado = false;
    iniciarContador(tiempoRestante); // Reanudar el cronómetro
    $("#pause-modal").modal("hide"); // Cerrar el modal
}

function salirJuego() {
    // Redirigir a la página de inicio o a un menú
    window.location.href = "MenuStudent.html";
}

function mostrarTiempoTerminado() {
    $("#titulo-modal").text("¡Se terminó el tiempo!");
    mostrarModal();
}

function mostrarGanaste() {
    $("#titulo-modal").text("¡Has Ganado!");
    mostrarModal();
}

function mostrarModal() {
    //Hacemos que el modal no se pueda cerrar
    $("#modal-jugar").click(function() {
        location.reload();
    });

    $("#modal-regresar").click(function() {
        window.location.href = "../sections/MenuStudent.html";
    });

    var texto = "Tu puntaje en el juego ha sido de " + $("#puntaje").val() + " puntos";
    $("#contenido-modal").text(texto);

    $("#modal-mensaje").modal({
        backdrop: 'static',
        keyboard: false
    });

    enviarDatosPuntaje();

    $("#modal-mensaje").modal('show');
}

function enviarDatosPuntaje() {
    //var usuario = $("#nombre-jugador").text();
    var puntaje = $("#puntaje").val();
    $.get("../core/php/IngresarPuntaje.php", {
        idUsuario: idUsuario,
        idMateria: materia,
        dificultad: dificultad,
        puntaje: puntaje,
        parejasEncontradas: 9 - cartas.length/2
    }).done(function(data) {

    });
}

function salirJuego() {
    location.href = "MenuStudent.html";
}

function revolver(array) {
    var currentIndex = array.length, temporaryValue, randomIndex;
    while (0 !== currentIndex) {
        randomIndex = Math.floor(Math.random() * currentIndex);
        currentIndex -= 1;
        temporaryValue = array[currentIndex];
        array[currentIndex] = array[randomIndex];
        array[randomIndex] = temporaryValue;
    }
    return array;
}