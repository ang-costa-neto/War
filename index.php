<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>ChuWar</title>
    <link rel="stylesheet" href="static/css/bootstrap.min.css">
    <link rel="stylesheet" href="static/css/bootstrap-select.min.css">
</head>
<body>
    <div class="container">
        <h1 align="center">ChuWar</h1>
        <div class="row">
            <div class="col-md-6">
                <form method="POST" action="acoes/RealizarLogin.php">
                    <div class="form-group">
                        <label for="nome">Nome</label>
                        <input class="form-control" type="text" placeholder="Nome" name="nome">
                    </div>
                    <button type="submit" class="btn btn-default">Iniciar</button>
                </form>
            </div>
        </div>
    </div>

    <script type="application/javascript" src="static/js/jquery.min.js"></script>
    <script type="application/javascript" src="static/js/bootstrap.min.js"></script>
    <script type="application/javascript" src="static/js/bootstrap-select.min.js"></script>
</body>
</html>