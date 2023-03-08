const tipoController = "../../controller/tipodocsController.php";

$(document).ready(function () {
    let editar = false;

    $("#agregarTipo .cancelTipo").hide();

    if ($("#listaTipos").length > 0)
        listarTipos();

    $("#agregarTipo .cancelTipo").off("click");
    $("#agregarTipo .cancelTipo").on("click", function () {
        $("#agregarTipo")[0].reset();
        $("#agregarTipo .cancelTipo").hide();
        $("#agregarTipo #btn-eliminar").val("Registrar Tipo");
        $("#agregarTipo #tipoId").val("");

        editar = false;
    });

    $("#agregarTipo").off("submit");
    $("#agregarTipo").on("submit", function (event) {
        event.preventDefault();

        $.ajax({
            type: "POST",
            url: tipoController,
            data: {
                metodo: $("#metodo").val(),
                tip_prefijo: $("#tip_nombre").val(),
                tip_nombre: $("#tip_prefijo").val(),
                id: $("#tipoId").val(),
            },
        }).done(function(data) {
            data = JSON.parse(data);
            
            alert(data.mensaje);

            if (data.response == "successful")
            {
                $("#agregarTipo .cancelTipo").hide();
                $("#agregarTipo")[0].reset();
                $("#agregarTipo #btn-eliminar").val("Registrar Tipo");
                $("#agregarTipo #tipoId").val("");
    
                editar = false;
    
                listarTipos();
            }
        });
    });

    $("#listaTipos #editarTipo").off("click");
    $("#listaTipos").on("click", "#editarTipo", function () {
        let element = $(this).parent().parent().parent();        
        let id = element.attr("tipoId");

        $.ajax({
            type: "GET",
            url: tipoController,
            data: {
                metodo: "obtenerTipo",
                id: id
            }
        }).done(function (response) {
            let tipo = JSON.parse(response);
            console.dir(tipo);

            if (tipo.response == "unsuccessful")
            {
                alert(tipo.mensaje);
                return;
            }

            $("#agregarTipo #tip_nombre").val(tipo.tipos.tip_nombre);
            $("#agregarTipo #tip_prefijo").val(tipo.tipos.tip_prefijo);
            $("#agregarTipo #tipoId").val(tipo.tipos.tip_id);
            
            $("#agregarTipo #btn-eliminar").val("Editar Tipo");
            $("#agregarTipo .cancelTipo").show();

            editar = true;
        });
    });

    $("#listaTipos #eliminarTipo").off("click");
    $("#listaTipos").on("click", "#eliminarTipo", function () {
        let element = $(this).parent().parent().parent();

        if (confirm(`¿Desea eliminar el tipo <<< ${element.find("td")[1].innerHTML} >>>?`))
        {
            let id = element.attr("tipoId");
            console.dir(id)

            $.ajax({
                type: "POST",
                url: tipoController,
                data: {
                    metodo: "eliminarTipo",
                    id: id
                }
            }).done(function (response) {
                response = JSON.parse(response);

                alert(response.mensaje)

                if (response.response == "successful")
                {
                    listarTipos();
                }
            });
        }
    });
});

function listarTipos() {
    $.ajax({
        type: "GET",
        url: tipoController,
        data: {
            metodo: "obtenerTipos"
        }
    }).done(function (response) {
        response = JSON.parse(response);

        if (response.response != "successful")
        {
            alert("No se consiguieron datos");
            return;
        }

        let template = "";

        response.tipos.forEach(tipo => {
            template += `
                <tr tipoId="${tipo.id}">
                    <td>${tipo.id}</td>
                    <td>${tipo.nombre}</td>
                    <td>${tipo.prefijo}</td>
                    <td>
                        <div class="btn-group" role="group" aria-label="Basic example">
                            <button type="button" id="editarTipo" class="btn btn-primary">Editar</button>
                            <button type="button" id="eliminarTipo" class="btn btn-danger">Eliminar</button>
                        </div>
                    </td>
                </tr>
            `;
        });

        $("#tipos").html(template);

        // tabla = $('#listaTipos').DataTable();
        $('#listaTipos').DataTable();
    });
}
