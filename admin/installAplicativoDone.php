<?php require_once('config.php'); ?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title><?php echo $cfg['titulo']; ?></title>
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <link rel="stylesheet" href="css/font-awesome.min.css">
        <link rel="stylesheet" href="css/ionicons.min.css">
        <link rel="stylesheet" href="css/smoke.min.css">
        <link rel="stylesheet" href="css/core.min.css">
        <!--[if lt IE 9]><script src="js/html5shiv.min.js"></script><script src="js/respond.min.js"></script><![endif]-->
    </head>
    <body class="hold-transition login-page">
        <div class="login-box">
            <div class="login-logo">
                <strong>Instala&ccedil;&atilde;o</strong>
            </div><!-- /.login-logo -->
            <div class="login-box-body">
                <p class="login-box-msg">Configure o banco e crie o usu&aacute;rio principal</p>
                <form class="form-install">
                    <div class="form-group has-feedback">
                        <input type="text" id="servidor" class="form-control" value="localhost" title="Digite o nome do servidor" placeholder="Servidor" required>
                        <span class="glyphicon glyphicon-globe form-control-feedback"></span>
                    </div>
                    <div class="form-group has-feedback">
                        <input type="text" id="banco" class="form-control" value="blog" title="Digite o nome do banco de dados" placeholder="Banco de dados" required>
                        <span class="glyphicon glyphicon-hdd form-control-feedback"></span>
                    </div>
                    <div class="form-group has-feedback">
                        <input type="text" id="usuario_banco" class="form-control" value="root" title="Digite o nome do usu&aacute;rio do banco de dados" placeholder="Usu&aacute;rio do banco" required>
                        <span class="glyphicon glyphicon-user form-control-feedback"></span>
                    </div>
                    <div class="form-group has-feedback">
                        <input type="password" id="senha_banco" class="form-control" title="Digite a senha do banco de dados" placeholder="Senha do banco">
                        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                    </div>
                    <hr>
                    <div class="form-group has-feedback">
                        <input type="text" id="nome" class="form-control" title="Digite o nome do usu&aacute;rio principal" placeholder="Nome" required>
                        <span class="glyphicon glyphicon-user form-control-feedback"></span>
                    </div>
                    <div class="form-group has-feedback">
                        <input type="text" id="usuario" class="form-control" title="Digite o usu&aacute;rio principal" placeholder="Usu&aacute;rio" required>
                        <span class="glyphicon glyphicon-user form-control-feedback"></span>
                    </div>
                    <div class="form-group has-feedback">
                        <input type="password" id="senha" class="form-control" title="Digite a senha do usu&aacute;rio principal" placeholder="Senha" required>
                        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                    </div>
                    <div class="form-group has-feedback">
                        <input type="email" id="email" class="form-control" title="Digite o email do usu&aacute;rio principal" placeholder="Email" required>
                        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                    </div>
                    <div class="row">
                        <div class="col-xs-offset-8 col-xs-4">
                            <button type="submit" class="btn btn-primary btn-block btn-flat btn-submit-install">Instalar</button>
                        </div><!-- /.col -->
                    </div>
                </form>
            </div><!-- /.login-box-body -->
        </div><!-- /.login-box -->

        <script src="js/jquery-2.1.4.min.js"></script>
        <script defer src="js/bootstrap.min.js"></script>
        <script async src="js/smoke.min.js"></script>
        <script async src="js/apart.min.js"></script>
    </body>
</html>
