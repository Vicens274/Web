document.addEventListener('DOMContentLoaded', function () {
    var addButton = document.getElementById('crearPregunta');

    addButton.addEventListener('click', function () {
        var nombrePregunta = document.getElementById('exampleFormControlInput1').value;
        var descripcionPregunta = tinymce.get('exampleFormControlTextarea1').getContent();
        var videoFile = document.getElementById('videoUpload').files[0]; // Obtiene el archivo de video

        var newItem = document.createElement('div');
        newItem.classList.add('accordion-item');

        var newCollapseId = 'collapse' + (document.querySelectorAll('.accordion-item').length + 1);

        var videoURL = ''; // Variable para guardar la URL del video
        if (videoFile) {
            // Si se ha seleccionado un archivo de video, crear una URL de objeto para el video
            videoURL = URL.createObjectURL(videoFile);
        }

        newItem.innerHTML = `
            <h2 class="accordion-header">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#${newCollapseId}" aria-expanded="false">
                    ${nombrePregunta}
                </button>
            </h2>
            <div id="${newCollapseId}" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                <div class="accordion-body">
                    ${descripcionPregunta}
                    <video controls style="border: 2px solid #3552A6 !important; border-radius: 5px !important;">
                        <source src="${videoURL}" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>
                </div>
            </div>
        `;

        var accordion = document.getElementById('accordionExample');
        accordion.appendChild(newItem);

        document.getElementById('exampleFormControlInput1').value = '';
        tinymce.get('exampleFormControlTextarea1').setContent('');
        document.getElementById('videoUpload').value = ''; // Limpia el input de archivo de video después de agregar la pregunta
    });
});

