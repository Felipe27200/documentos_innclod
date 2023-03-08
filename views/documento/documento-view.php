<?php
session_start();

if (isset($_SESSION["login"]) && $_SESSION['login'] == true) :
?>
<?php require_once "../layout/header-view.php"; ?>
    <div class="row justify-content-center">
        <div class="col-auto">
            <h2 class="mt-2">Documentos</h2>
        </div>
    </div>

    <div class="row d-flex mx-1">
        <div class="col-md-4">
            <form id="agregarDocumento">
                <div class="mb-3">
                    <label for="" class="form-label">Nombre Documento: </label>
                    <input type="text" id="doc_nombre" required class="form-control"/>
                </div>

                <div class="mb-3">
                    <label for="" class="form-label">Tipo Documento: </label>

                    <select type="text" id="doc_id_tipo" required class="form-select">

                    </select> 
                </div>

                <div class="mb-3">
                    <label for="" class="form-label">Proceso Documento: </label>

                    <select type="text" id="doc_id_proceso" required class="form-select">

                    </select> 
                </div>

                <div class="mb-3">
                    <label for="" class="form-label">Contenido Documento: </label>

                    <textarea class="form-control" id="doc_contenido"></textarea>
                </div>

                <div class="d-grid gap-2">
                    
                    <input type="submit" value="Registrar Documento" class="btn btn-primary" id="btn-eliminar">

                    <button class="btn btn-secondary cancelDocumento" type="button">
                        Cancelar Edición
                    </button>
                    
                    <input type="hidden" value="registrarDocumento" id="metodo">
                    <input type="hidden" id="documentoId">
                </div>                    
            </form> 
        </div>

        <div class="col-md-8">
            <div class="table-responsive">
                <table class="table table-bordered" id="listaDocumentos">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Código</th>
                            <th>Tipo</th>
                            <th>Proceso</th>
                            <th>Contenido</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody id="documentos">

                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <?php require_once "../layout/footer-view.php"; ?>
<?php 
else: 
    header("Location: ../sesion.php")
?>
<?php endif; ?>
