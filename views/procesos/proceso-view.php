<?php require_once "../layout/header-view.php"; ?>

    <div class="row justify-content-center">
        <div class="col-auto">
            <h2 class="mt-2">Procesos</h2>
        </div>
    </div>

    <div class="row d-flex">
        <div class="col-md-6">
            <form id="agregarProceso">
                <div class="mb-3">
                    <label for="" class="form-label">Nombre Proceso: </label>
                    <input type="text" id="pro_nombre" required class="form-control"/>
                </div>

                <div class="mb-3">
                    <label for="" class="form-label">Prefijo Proceso: </label>
                    <input type="text" id="pro_prefijo" required class="form-control"/>
                </div>

                <div class="d-grid gap-2">
                    
                    <input type="submit" value="Registrar Proceso" class="btn btn-primary" id="btn-eliminar">

                    <button class="btn btn-secondary cancelProceso" type="button">
                        Cancelar Edición
                    </button>
                    
                    <input type="hidden" value="registrarProceso" id="metodo">
                    <input type="hidden" id="procesoId">
                </div>                    
            </form> 
        </div>

        <div class="col-md-6">
            <div class="table-responsive">
                <table class="table table-bordered" id="listaProcesos">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Prefijo</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody id="procesos">

                    </tbody>
                </table>
            </div>
        </div>
    </div>

<?php require_once "../layout/footer-view.php"; ?>
