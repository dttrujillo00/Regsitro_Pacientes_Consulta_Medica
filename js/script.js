(function() {
    document.addEventListener('DOMContentLoaded', function(){
        
        //DECLARACION DE VARIABLES
        var tablaPacientes = document.querySelector('#tabla'),
            formularioAgregar = document.querySelector('.form-agregar');

        eventListeners();


//DEFINICION DE FUNCIONES
function eventListeners() {
    tablaPacientes.addEventListener('click', eliminarPaciente);
    formularioAgregar.addEventListener('submit', leerFormulario);
}

function leerFormulario(e) {
    e.preventDefault();

    //leer datos de los inputs
    var nombre = document.querySelector('#nombre_apellido').value,
        sexo = document.querySelector('#sexo').value,
        fechaNacimiento = document.querySelector('#fecha_nacimiento').value,
        nivelEducacional = document.querySelector('#nivel_educacional').value,
        direccion = document.querySelector('#direccion').value,
        grupoDisp = document.querySelector('#grupo_disp').value,
        manzana = document.querySelector('#manzana').value,
        diagnostico = document.querySelector('#diagnostico').value;
        if (diagnostico === '') {
            diagnostico = 'Sano';
        }

        if(nombre === '' || fechaNacimiento === '' || nivelEducacional === '' || direccion === '' || manzana === ''){
            mostrarNotificacion('Todos los campos son obligatorios', 'error');
        }else{
            var infoPaciente = new FormData();
                infoPaciente.append('nombre_apellido', nombre);
                infoPaciente.append('sexo', sexo);
                infoPaciente.append('fecha_nacimiento', fechaNacimiento);
                infoPaciente.append('nivel_educacional', nivelEducacional);
                infoPaciente.append('direccion', direccion);
                infoPaciente.append('grupo_disp', grupoDisp);
                infoPaciente.append('manzana', manzana);
                infoPaciente.append('diagnostico', diagnostico);

                if(window.XMLHttpRequest){
                    var xhr = new XMLHttpRequest();
                }else{
                    var xhr = new ActiveXObject("Microsoft.XMLHTTP");
                }

                xhr.open('POST', 'agregarPaciente.php', true);

                xhr.onload = function(){
                    if(this.status == 200){
                        respuestaAjax = JSON.parse(xhr.responseText);
                        console.log(respuestaAjax);

                        var colorPaciente;
                        switch(respuestaAjax.datos.grupo_disp){
                            case '1':
                                colorPaciente = "I";
                                break;
                            case '2':
                                colorPaciente = "II";
                                break;
                            case '3':
                                colorPaciente = "III";
                                break;
                            case '4':
                                colorPaciente = "IV";
                                break;
                            default:
                                colorPaciente = "desconocido";
                                break;
                        }
                        console.log(colorPaciente);

                        var nuevoPaciente = document.createElement('tr');
                        nuevoPaciente.classList.add(colorPaciente);

                        nuevoPaciente.innerHTML = `
                            <td>${respuestaAjax.datos.nombre}</td>
                            <td>${respuestaAjax.datos.sexo}</td>
                            <td>${colorPaciente}</td>
                            <td>${respuestaAjax.datos.direccion}</td>
                            <td>${respuestaAjax.datos.edad}</td>
                            <td>${respuestaAjax.datos.nivel_educacional}</td>
                            <td>${respuestaAjax.datos.manzana}</td>
                            <td>${respuestaAjax.datos.diagnostico}</td>
                        `;
                        //TD EDITAR
                        var tdEditar = document.createElement('td');

                        //ICONO EDITAR
                        var iconoEditar = document.createElement('i');
                        iconoEditar.classList.add('icon-pencil', 'icono-editar-eliminar');

                        //ENLACE A PAGINA DE EDITAR
                        var enlaceEditar = document.createElement('a');
                        enlaceEditar.appendChild(iconoEditar);
                        enlaceEditar.href = `index.php?id=${respuestaAjax.datos.id_insertado}#editar`;
                        console.log(`editar.php?id=${respuestaAjax.datos.id_insertado}#editar`);

                        //AGREGARLO AL PADRE
                        tdEditar.appendChild(enlaceEditar);

                        //AGREGARLO A LA FILA
                        nuevoPaciente.appendChild(tdEditar);

                        //TD ELIMINAR
                        var tdEliminar = document.createElement('td');

                        //BOTON DE ELIMINAR
                        var btnEliminar = document.createElement('button');
                        btnEliminar.setAttribute('data-id', respuestaAjax.datos.id_insertado);
                        btnEliminar.classList.add('icono-editar-eliminar', 'btn-borrar', 'icon-trash-empty');

                        //AGREGARLO AL PADRE
                        tdEliminar.appendChild(btnEliminar);

                        //AGREGARLO A LA FILA
                        nuevoPaciente.appendChild(tdEliminar);

                        //AGREGARLO A LA TABLA
                        tablaPacientes.appendChild(nuevoPaciente);




                        mostrarNotificacion('Paciente creado correctamente', 'correcto');

                        document.querySelector('.form-agregar').reset();
                    }
                }

                xhr.send(infoPaciente);
        }

}

function eliminarPaciente(e){
    console.log(e.target);
    if(e.target.parentElement.classList.contains('btn-borrar')){
        
        var id = e.target.parentElement.getAttribute('data-id');
        console.log(id);

        var respuesta = confirm('Está seguro (a) que desea eliminar a este paciente?');

        if(respuesta){
            var xhr = new XMLHttpRequest();

            xhr.open('GET', `eliminar.php?id=${id}`, true);

            xhr.onload = function(){
                if(this.status == 200){
                    e.target.parentElement.parentElement.parentElement.remove();

                    mostrarNotificacion('Paciente eliminado de la base de datos', 'correcto');
                }
            }

            xhr.send();
        }
    }
}

function mostrarNotificacion(mensaje, clase){
    var notificacion = document.createElement('div');
    notificacion.classList.add(clase, 'notificacion', 'sombra');
    notificacion.textContent = mensaje;

    tablaPacientes.insertBefore(notificacion, document.querySelector('#tabla thead'));

    // Ocultar y mostar la notificacion

    setTimeout(() => {
        notificacion.classList.add('visible');

        setTimeout(() => {
            notificacion.classList.remove('visible');

            setTimeout(() => {
                notificacion.remove();

            },500);
        }, 3000);
    }, 100);
}

            

    });

    /**Llamado AJAX PARA ACTUALIZAR LAS EDADES DE LOS PACIENTES DESDE actualizarEdad.php  */

    if(window.XMLHttpRequest){
        var xhr = new XMLHttpRequest();
    }else{
        var xhr = new ActiveXObject("Microsoft.XMLHTTP");
    }

    xhr.open('GET', 'actualizarEdad.php', true);

    xhr.onload = function (){
        if(this.status == 200){
            console.log(xhr.responseText);
        }
    }

    xhr.send();

/**FIN AJAX ACTUALIZAR */
})();

// confirm("hola")


