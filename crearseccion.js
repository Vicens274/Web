$(document).ready(function(){
    localStorage.removeItem('secciones');

    // Función para cargar las secciones desde Local Storage
    function cargarSeccionesDesdeLocalStorage() {
        var secciones = JSON.parse(localStorage.getItem('secciones')) || [];
        
        // Recorre todas las secciones almacenadas y crea las cajas correspondientes
        secciones.forEach(function(seccion) {
            var newCard = `
                <div class="col">
                    <div class="card h-100">
                        <div class="card-body">
                            <h5 class="card-title">${seccion.nombre}</h5>
                            <p class="card-text">${seccion.descripcion}</p>
                        </div>
                    </div>
                </div>
            `;
            $('#sectionContainer .row').append(newCard);
        });
    }

    // Cargar las secciones al cargar la página
    cargarSeccionesDesdeLocalStorage();

    $('#crearSeccion').click(function(){
        var categoria = $('.form-select').val();
        var nombre = $('#exampleFormControlInput1').val();
        var descripcion = $('#exampleFormControlTextarea1').val();

        var seccion = {
            nombre: nombre,
            descripcion: descripcion
        };

        // Agregar la nueva sección al contenedor
        var newCard = `
            <div class="col">
                <div class="card h-100">
                    <div class="card-body">
                        <h5 class="card-title">${nombre}</h5>
                        <p class="card-text">${descripcion}</p>
                    </div>
                </div>
            </div>
        `;
        $('#sectionContainer .row').append(newCard);

        // Guardar la nueva sección en Local Storage
        var secciones = JSON.parse(localStorage.getItem('secciones')) || [];
        secciones.push(seccion);
        localStorage.setItem('secciones', JSON.stringify(secciones));

        // Limpiar el formulario
        $('.form-select').val('Selecciona una categoría');
        $('#exampleFormControlInput1').val('');
        $('#exampleFormControlTextarea1').val('');
    });
});

