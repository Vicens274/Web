$(document).ready(function(){
    // Función para obtener parámetros de la URL
    function getUrlParameter(name) {
        name = name.replace(/[\[]/, '\\[').replace(/[\]]/, '\\]');
        var regex = new RegExp('[\\?&]' + name + '=([^&#]*)');
        var results = regex.exec(location.search);
        return results === null ? '' : decodeURIComponent(results[1].replace(/\+/g, ' '));
    };

    // Obtener estado y rol de la URL
    var estado = getUrlParameter('estado');
    var rol = getUrlParameter('rol');

    // Manejar los datos recibidos
    console.log("Estado: " + estado + ", Rol: " + rol);
    if (estado === "success" && rol === "superadministrador") {
        $("#btnAñadirSeccion").show();
    } else {
        $("#btnAñadirSeccion").hide();
    }
});
