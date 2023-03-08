<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../public/css/bootstrap.min.css">
</head>

<body>
    <div class="container-fluid">
        <div class="row d-flex justify-content-center">
            <div class="col-auto mt-5 mb-4">
                <h1>Iniciar Sesión</h1>
            </div>

        </div>

        <div class="row d-flex justify-content-center">
            <div class="col-md-4">
                <form id="login" method="POST" action="../controller/sesionController.php">
                    <div class="mb-2">
                        <label for="usuario" class="form-label">Usuario:</label>
                        <input type="text" class="form-control" name="usuario" id="usuario" required>
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Contraseña:</label>
                        <input type="password" class="form-control" name="password" id="password" required>
                    </div>

                    <div class="d-grid gap-2">
                        <button class="btn btn-success" type="submit">Iniciar Sesión</button>
                        <input type="hidden" name="metodo" value="login">
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="../public/js/popper.min.js"></script>
    <script src="../public/js/bootstrap.min.js"></script>
</body>

</html>