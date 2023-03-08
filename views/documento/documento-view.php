<?php require_once "../layout/header-view.php"; ?>

    <div class="row justify-content-center">
        <div class="col-auto">
            <h2 class="mt-2">Tipos</h2>
        </div>
    </div>

    <div class="row d-flex">
        <div class="col-md-6">
            <form id="agregarTipo">
                <div class="mb-3">
                    <label for="" class="form-label">Nombre Tipo: </label>
                    <input type="text" id="tip_nombre" required class="form-control"/>
                </div>

                <div class="mb-3">
                    <label for="" class="form-label">Prefijo Tipo: </label>
                    <input type="text" id="tip_prefijo" required class="form-control"/>
                </div>

                <div class="d-grid gap-2">
                    
                    <input type="submit" value="Registrar Tipo" class="btn btn-primary" id="btn-eliminar">

                    <button class="btn btn-secondary cancelTipo" type="button">
                        Cancelar Edición
                    </button>
                    
                    <input type="hidden" value="registrarTipo" id="metodo">
                    <input type="hidden" id="tipoId">
                </div>                    
            </form> 
        </div>

        <div class="col-md-6">
            <div class="table-responsive">
                <table class="table table-bordered" id="listaTipos">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Prefijo</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody id="tipos">

                    </tbody>
                </table>
            </div>
        </div>
    </div>

<?php require_once "../layout/footer-view.php"; ?>
