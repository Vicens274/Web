$(document).ready(function() {

    localStorage.removeItem('preguntas');


    function agregarPreguntaAlAcordeon(nombrePregunta, descripcionPregunta, videoURL) {
        if ($('#pregunta' + nombrePregunta.replace(/\s+/g, '')).length === 0) {
            var nuevoTab = `
                <div class="accordion-item">
                    <h2 class="accordion-header" id="pregunta${nombrePregunta.replace(/\s+/g, '')}">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse${nombrePregunta.replace(/\s+/g, '')}" aria-expanded="false" aria-controls="collapse${nombrePregunta.replace(/\s+/g, '')}">
                            ${nombrePregunta}
                        </button>
                    </h2>
                    <div id="collapse${nombrePregunta.replace(/\s+/g, '')}" class="accordion-collapse collapse" aria-labelledby="pregunta${nombrePregunta.replace(/\s+/g, '')}" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            ${descripcionPregunta}
                            <br>
                            <video controls>
                                <source src="${videoURL}" type="video/mp4">
                                Your browser does not support the video tag.
                            </video>
                        </div>
                    </div>
                </div>
            `;

            $('#accordionExample').prepend(nuevoTab);

            var preguntasGuardadas = JSON.parse(localStorage.getItem('preguntas')) || [];
            preguntasGuardadas.push({ nombre: nombrePregunta, descripcion: descripcionPregunta, video: videoURL });
            localStorage.setItem('preguntas', JSON.stringify(preguntasGuardadas));
        }
    }

    $('#crearPregunta').click(function(event) {
        event.preventDefault(); // Evita que el formulario se envíe automáticamente

        var nombrePregunta = $('#exampleFormControlInput1').val();
        var descripcionPregunta = $('#exampleFormControlTextarea1').val();
        // Aquí obtén el video cargado
        var videoFile = $('#videoUpload').prop('files')[0];
        var videoURL = URL.createObjectURL(videoFile);
     
        agregarPreguntaAlAcordeon(nombrePregunta, descripcionPregunta, videoURL);

        $('.accordion-collapse').collapse('hide');
    });

    function cargarPreguntasDesdeLocalStorage() {
        var preguntasGuardadas = JSON.parse(localStorage.getItem('preguntas')) || [];
        preguntasGuardadas.forEach(function(pregunta) {
            agregarPreguntaAlAcordeon(pregunta.nombre, pregunta.descripcion, pregunta.video);
        });
    }

    cargarPreguntasDesdeLocalStorage();
});
