$(document).ready(function(){

    $.ajax({
        type: "POST",
        url: "./añadir/login.php",
        dataType: "json", // Asegúrate de esperar una respuesta JSON
        success: function(response){
            console.log(response);
            if(response.estado === "success" && response.rol === "superadministrador"){
                $("#btnAñadirSeccion").show();
            } else {
                $("#btnAñadirSeccion").hide();
            }
        },
        error: function(xhr, status, error){
            
            console.error(xhr.responseText);
        }
    });
});
