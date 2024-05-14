// Espera a que el DOM esté completamente cargado
document.addEventListener('DOMContentLoaded', function () {
    // Selecciona el botón "Añadir Pregunta"
    var addButton = document.getElementById('crearPregunta');

    // Añade un event listener para el clic en el botón
    addButton.addEventListener('click', function () {
        // Obtiene el valor de la pregunta y la descripción
        var nombrePregunta = document.getElementById('exampleFormControlInput1').value;
        var descripcionPregunta = tinymce.get('exampleFormControlTextarea1').getContent();
        console.log(descripcionPregunta); 

        // Crea un nuevo elemento de acordeón
        var newItem = document.createElement('div');
        newItem.classList.add('accordion-item');

        // Construye el HTML interno del nuevo elemento de acordeón
        newItem.innerHTML = `
            <h2 class="accordion-header">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" aria-expanded="false">
                    ${nombrePregunta}
                </button>
            </h2>
            <div class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                <div class="accordion-body">
                    ${descripcionPregunta}
                </div>
            </div>
        `;

        // Inserta el nuevo elemento en el acordeón
        var accordion = document.getElementById('accordionExample');
        accordion.appendChild(newItem);

        // Limpia los campos después de agregar la pregunta
        document.getElementById('exampleFormControlInput1').value = '';
        tinymce.get('exampleFormControlTextarea1').setContent('');        
    });
});
