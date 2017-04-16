<?php require_once ('static/shared/header.php'); ?>
    <div class="container">
        <h1 align="center">ChuWar</h1>
        <div class="row">
            <div id="conteudo">
                <div class="col-md-6">
                    <form method="POST" action="actions/RealizarLogin.php">
                        <div class="form-group">
                            <label for="nome">Nome</label>
                            <input class="form-control" type="text" placeholder="Nome" name="nome">
                        </div>
                        <button type="submit" class="btn btn-default">Iniciar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

<?php require_once ('static/shared/footer.php'); ?>