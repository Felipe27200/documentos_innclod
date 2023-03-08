const documentoController = "../../controller/documentoController.php";

let selectTipo = function (response) {    
    let template = "<option value=''>Seleccione...</option>";

    response.tipos.forEach(tipo => {
        template += `
            <option value="${tipo.id}">${tipo.nombre}</option>
        `;
    });

    $("#doc_id_tipo").html(template);
};

let selectProceso = function (response) {    
    let template = "<option value=''>Seleccione...</option>";

    response.procesos.forEach(proceso => {
        template += `
            <option value="${proceso.id}">${proceso.nombre}</option>
        `;
    });

    $("#doc_id_proceso").html(template);
};

$(document).ready(function () {
    let editar = false;

    $(document).off("click", "#cerrarSesion");
    $(document).on("click", "#cerrarSesion", function(){
        $.ajax({
            type: "POST",
            url: "../../controller/sesionController.php",
            data: {
                metodo: "logout"
            },
        }).done(function () {
            let url = window.location.origin + "/registro_docs/views/sesion.php";

            window.location.assign(url);

        });
    });

    obtenerTipos(selectTipo);
    obtenerProcesos(selectProceso);

    $("#agregarDocumento .cancelDocumento").hide();

    if ($("#listaDocumentos").length > 0)
        listarDocumentos();

    $("#agregarDocumento .cancelDocumento").off("click");
    $("#agregarDocumento .cancelDocumento").on("click", function () {
        $("#agregarDocumento")[0].reset();
        $("#agregarDocumento .cancelDocumento").hide();
        $("#agregarDocumento #btn-eliminar").val("Registrar Documento");
        $("#agregarDocumento #documentoId").val("");

        editar = false;
    });

    $("#agregarDocumento").off("submit");
    $("#agregarDocumento").on("submit", function (event) {
        event.preventDefault();

        $.ajax({
            type: "POST",
            url: documentoController,
            data: {
                metodo: $("#metodo").val(),
                doc_nombre: $("#doc_nombre").val(),
                doc_id_tipo: $("#doc_id_tipo").val(),
                doc_id_proceso: $("#doc_id_proceso").val(),
                doc_contenido: $("#doc_contenido").val(),
                id: $("#documentoId").val(),
            },
        }).done(function(data) {
            data = JSON.parse(data);
            
            alert(data.mensaje);

            if (data.response == "successful")
            {
                $("#agregarDocumento .cancelDocumento").hide();
                $("#agregarDocumento")[0].reset();
                $("#agregarDocumento #btn-eliminar").val("Registrar Documento");
                $("#agregarDocumento #documentoId").val("");
    
                editar = false;
    
                listarDocumentos();
            }
        });
    });

    $("#listaDocumentos #editarDocumento").off("click");
    $("#listaDocumentos").on("click", "#editarDocumento", function () {
        let element = $(this).parent().parent().parent();        
        let id = element.attr("documentoId");

        $.ajax({
            type: "GET",
            url: documentoController,
            data: {
                metodo: "obtenerDocumento",
                id: id
            }
        }).done(function (response) {
            let documento = JSON.parse(response);

            if (documento.response == "unsuccessful")
            {
                alert(documento.mensaje);
                return;
            }

            $("#agregarDocumento #doc_nombre").val(documento.documentos.doc_nombre);
            $("#agregarDocumento #doc_contenido").val(documento.documentos.doc_contenido);
            $("#agregarDocumento #documentoId").val(documento.documentos.doc_id);

            $("#agregarDocumento #doc_id_tipo").val(documento.documentos.doc_id_tipo);
            $("#agregarDocumento #doc_id_proceso").val(documento.documentos.doc_id_proceso);
            
            $("#agregarDocumento #btn-eliminar").val("Editar Documento");
            $("#agregarDocumento .cancelDocumento").show();

            editar = true;
        });
    });

    $("#listaDocumentos #eliminarDocumento").off("click");
    $("#listaDocumentos").on("click", "#eliminarDocumento", function () {
        let element = $(this).parent().parent().parent();

        if (confirm(`¿Desea eliminar el documento <<< ${element.find("td")[1].innerHTML} >>>?`))
        {
            let id = element.attr("documentoId");

            $.ajax({
                type: "POST",
                url: documentoController,
                data: {
                    metodo: "eliminarDocumento",
                    id: id
                }
            }).done(function (response) {
                response = JSON.parse(response);

                alert(response.mensaje)

                if (response.response == "successful")
                {
                    listarDocumentos();
                }
            });
        }
    });
});

function listarDocumentos() {
    $.ajax({
        type: "GET",
        url: documentoController,
        data: {
            metodo: "obtenerDocumentos"
        }
    }).done(function (response) {
        response = JSON.parse(response);

        if (response.response != "successful")
        {
            alert("No se consiguieron datos");
            return;
        }

        let template = "";

        response.documentos.forEach(documento => {
            template += `
                <tr documentoId="${documento.id}">
                    <td>${documento.id}</td>
                    <td>${documento.nombre}</td>
                    <td>${documento.tip_prefijo}-${documento.pro_prefijo}-${documento.codigo}</td>
                    <td>${documento.tip_prefijo}</td>
                    <td>${documento.pro_prefijo}</td>
                    <td>${documento.contenido}</td>
                    <td>
                        <div class="btn-group" role="group" aria-label="Basic example">
                            <button type="button" id="editarDocumento" class="btn btn-primary">Editar</button>
                            <button type="button" id="eliminarDocumento" class="btn btn-danger">Eliminar</button>
                        </div>
                    </td>
                </tr>
            `;
        });

        $("#documentos").html(template);

        // tabla = $('#listaDocumentos').DataTable();
        $('#listaDocumentos').DataTable();
    });
}


