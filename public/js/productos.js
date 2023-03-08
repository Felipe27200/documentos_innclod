const productoController = "../../controllers/ProductoController.php";

$(document).ready(function () {
    let editar = false;

    obtenerCategorias();

    $("#agregarProducto .cancelProducto").hide();

    if ($("#table_productos").length > 0)
        listarProductos();

    $("#agregarProducto .cancelProducto").off("click");
    $("#agregarProducto .cancelProducto").on("click", function () {
        $("#agregarProducto")[0].reset();
        $("#agregarProducto .cancelProducto").hide();
        editar = false;
    });

    $("#agregarProducto").off("submit");
    $("#agregarProducto").on("submit", function (event) {
        event.preventDefault();

        metodo = editar === false ? $("#metodo").val() : "editarProducto";

        // Agregar categoria
        $.ajax({
            type: "POST",
            url: productoController,
            data: {
                metodo: metodo,
                categoria_id: $("#categoria_id").val(),
                nombre: $("#nombre").val(),
                referencia: $("#referencia").val(),
                precio: $("#precio").val(),
                peso: $("#peso").val(),
                stock: $("#stock").val(),
                fecha_creacion: $("#fecha_creacion").val(),
                id: $("#productoId").val()
            },
        }).done(function(data) {
            console.dir(JSON.parse(data));

            data = JSON.parse(data);

            if (data == "empty")
                alert("Todos los campos deben estar diligenciados!!!")
            else if (data == "negative")
                alert("No se aceptan valores negativos en los campos numéricos")
            else
            {
                $("#agregarProducto .cancelProducto").hide();
                $("#agregarProducto")[0].reset();
    
                editar = false;
    
                listarProductos();
            }
        });
    })

    $("#table_productos #eliminarProducto").off("click");
    $("#table_productos").on("click", "#eliminarProducto", function () {
        let element = $(this).parent().parent().parent();

        if (confirm(`¿Desea eliminar el producto <<< ${element.find("td").html()} >>>?`))
        {
            let id = element.attr("productoId");

            $.ajax({
                type: "POST",
                url: productoController,
                data: {
                    metodo: "eliminarProducto",
                    id: id
                }
            }).done(function (response) {
                listarProductos();
            });
        }
    });

    $("#table_productos #editarProducto").off("click");
    $("#table_productos").on("click", "#editarProducto", function () {
        let element = $(this).parent().parent().parent();
        let id = element.attr("productoId");

        $.ajax({
            type: "GET",
            url: productoController,
            data: {
                metodo: "obtenerProducto",
                id: id
            }
        }).done(function (response) {
            let producto = JSON.parse(response);

            $("#agregarProducto #productoId").val(producto[0].id);
            $("#agregarProducto #categoria_id").val(producto[0].categoria_id);
            $("#agregarProducto #nombre").val(producto[0].nombre);
            $("#agregarProducto #referencia").val(producto[0].referencia);
            $("#agregarProducto #precio").val(producto[0].precio);
            $("#agregarProducto #peso").val(producto[0].peso);
            $("#agregarProducto #stock").val(producto[0].stock);
            $("#agregarProducto #fecha_creacion").val(producto[0].fecha_creacion);

            $("#agregarProducto .cancelProducto").show();

            editar = true;
        });
    });
});

function listarProductos() {
    $.ajax({
        type: "GET",
        url: productoController,
        data: {
            metodo: "listarProductos"
        }
    }).done(function (response) {
        let productos = JSON.parse(response);
        let template = "";

        productos.forEach(producto => {
            template += `
                <tr productoId="${producto.id}">
                    <td>${producto.id}</td>
                    <td>${producto.nombre}</td>
                    <td>${producto.categoria_id}</td>
                    <td>${producto.referencia}</td>
                    <td>${producto.precio}</td>
                    <td>${producto.peso}</td>
                    <td>${producto.stock}</td>
                    <td>${producto.fecha_creacion}</td>
                    <td>
                        <div class="btn-group" role="group" aria-label="Basic example">
                            <button type="button" id="editarProducto" class="btn btn-primary">Editar</button>
                            <button type="button" id="eliminarProducto" class="btn btn-danger">Eliminar</button>
                        </div>
                    </td>
                </tr>
            `;
        });

        $("#productos").html(template);

        $('#table_productos').DataTable();
    });
}

function obtenerCategorias()
{
    $.ajax({
        type: "POST",
        url: categoriaController,
        data: { metodo: "listarCategorias" }
    }).done(function (response) {
        let categorias = JSON.parse(response);
        let template = "<option value=''>Seleccione...</option>";

        categorias.forEach(categoria => {
            template += `
                <option value="${categoria.id}">${categoria.nombre}</option>
            `;
        });

        $("#categoria_id").html(template);
    });
}