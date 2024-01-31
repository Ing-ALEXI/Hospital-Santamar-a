function mostrarContenido(id) {
    // Ocultar todos los contenedores
    var contenedores = document.getElementsByClassName('content');
    for (var i = 0; i < contenedores.length; i++) {
        contenedores[i].style.display = 'none';
    }

    // Mostrar el contenedor correspondiente al elemento del menú seleccionado
    var contenedorSeleccionado = document.getElementById(id);
    if (contenedorSeleccionado) {
        contenedorSeleccionado.style.display = 'block';
    }
}
function mostrarFormulario(formulario) {
    if (formulario === 'form1') {
        document.getElementById('formulario1').style.display = 'block';
        document.getElementById('formulario2').style.display = 'none';
    } else if (formulario === 'form2') {
        document.getElementById('formulario1').style.display = 'none';
        document.getElementById('formulario2').style.display = 'block';
    }
}
