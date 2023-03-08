const procesoController = "../../controller/ProcesoController.php";
let tabla = null;

$(document).ready(function () {
    let editar = false;

    $("#agregarProceso .cancelProceso").hide();

    if ($("#listaProcesos").length > 0)
        listarProcesos();

    $("#agregarProceso .cancelProceso").off("click");
    $("#agregarProceso .cancelProceso").on("click", function () {
        $("#agregarProceso")[0].reset();
        $("#agregarProceso .cancelProceso").hide();
        $("#agregarProceso #btn-eliminar").val("Registrar Proceso");
        $("#agregarProceso #procesoId").val("");

        editar = false;
    });

    $("#agregarProceso").off("submit");
    $("#agregarProceso").on("submit", function (event) {
        event.preventDefault();

        $.ajax({
            type: "POST",
            url: procesoController,
            data: {
                metodo: $("#metodo").val(),
                pro_prefijo: $("#pro_nombre").val(),
                pro_nombre: $("#pro_prefijo").val(),
                id: $("#procesoId").val(),
            },
        }).done(function(data) {
            data = JSON.parse(data);
            
            alert(data.mensaje);

            if (data.response == "successful")
            {
                $("#agregarProceso .cancelProceso").hide();
                $("#agregarProceso")[0].reset();
                $("#agregarProceso #btn-eliminar").val("Registrar Proceso");
                $("#agregarProceso #procesoId").val("");
    
                editar = false;
    
                listarProcesos();
            }
        });
    });

    $("#listaProcesos #editarProceso").off("click");
    $("#listaProcesos").on("click", "#editarProceso", function () {
        let element = $(this).parent().parent().parent();        
        let id = element.attr("procesoId");

        $.ajax({
            type: "GET",
            url: procesoController,
            data: {
                metodo: "obtenerProceso",
                id: id
            }
        }).done(function (response) {
            let proceso = JSON.parse(response);
            console.dir(proceso);

            if (proceso.response == "unsuccessful")
            {
                alert(proceso.mensaje);
                return;
            }

            $("#agregarProceso #pro_nombre").val(proceso.procesos.pro_nombre);
            $("#agregarProceso #pro_prefijo").val(proceso.procesos.pro_prefijo);
            $("#agregarProceso #procesoId").val(proceso.procesos.pro_id);
            
            $("#agregarProceso #btn-eliminar").val("Editar Proceso");
            $("#agregarProceso .cancelProceso").show();

            editar = true;
        });
    });

    $("#listaProcesos #eliminarProceso").off("click");
    $("#listaProcesos").on("click", "#eliminarProceso", function () {
        let element = $(this).parent().parent().parent();

        if (confirm(`¿Desea eliminar el proceso <<< ${element.find("td")[1].innerHTML} >>>?`))
        {
            let id = element.attr("procesoId");
            console.dir(id)

            $.ajax({
                type: "POST",
                url: procesoController,
                data: {
                    metodo: "eliminarProceso",
                    id: id
                }
            }).done(function (response) {
                response = JSON.parse(response);

                alert(response.mensaje)

                if (response.response == "successful")
                {
                    listarProcesos();
                }
            });
        }
    });
});

function listarProcesos() {
    $.ajax({
        type: "GET",
        url: procesoController,
        data: {
            metodo: "obtenerProcesos"
        }
    }).done(function (response) {
        response = JSON.parse(response);

        if (response.response != "successful")
        {
            alert("No se consiguieron datos");
            return;
        }

        let template = "";

        response.procesos.forEach(proceso => {
            template += `
                <tr procesoId="${proceso.id}">
                    <td>${proceso.id}</td>
                    <td>${proceso.nombre}</td>
                    <td>${proceso.prefijo}</td>
                    <td>
                        <div class="btn-group" role="group" aria-label="Basic example">
                            <button type="button" id="editarProceso" class="btn btn-primary">Editar</button>
                            <button type="button" id="eliminarProceso" class="btn btn-danger">Eliminar</button>
                        </div>
                    </td>
                </tr>
            `;
        });

        $("#procesos").html(template);

        tabla = $('#listaProcesos').DataTable();
    });
}
