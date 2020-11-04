<?php require_once('config.php'); if(empty($_SESSION['key'])) { header ('location:./'); } $m = 6; ?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <title><?php echo $cfg['titulo']; ?></title>
        <link rel="icon" type="image/png" href="img/favicon.png">
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <link rel="stylesheet" href="css/font-awesome.min.css">
        <link rel="stylesheet" href="css/ionicons.min.css">
        <link rel="stylesheet" href="css/smoke.min.css">
        <link rel="stylesheet" href="css/datatables.bootstrap.min.css">
        <link rel="stylesheet" href="css/datatables.responsive.bootstrap.min.css">
        <link rel="stylesheet" href="css/core.min.css">
        <link rel="stylesheet" href="css/skin-blue.min.css">
        <!--[if lt IE 9]><script src="js/html5shiv.min.js"></script><script src="js/respond.min.js"></script><![endif]-->
    </head>
    <body class="hold-transition skin-blue sidebar-mini sidebar-collapse">
        <div class="wrapper">
            <!-- Main Header -->
            <header class="main-header"><?php include_once('header.php'); ?></header>

            <!-- Left side column. contains the logo and sidebar -->
            <aside class="main-sidebar"><?php include_once('sidebar.php'); ?></aside>

            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>Autores
                    <?php
                        switch($_SESSION['acc']) {
                            case 'A':
                                echo'<span class="pull-right lead"><a data-toggle="modal" data-target="#novo-autor" href="#" title="Cadastre um novo autor"><i class="fa fa-user"></i> Novo autor</a></span>';
                            break;
                            case 'U':
                                echo'<span class="pull-right lead"></span>';
                            break;
                            default:
                                echo'<span class="pull-right lead"></span>';
                            break;
                        }
                    ?>
                    </h1>
                </section>

                <!-- Main content -->
                <section class="content">
                    <div class="box">
                        <div class="box-body">
                        <?php
                            include_once('conexao.php');

                            try {
                                $sql = $pdo->prepare("SELECT idautor,nome,usuario,email FROM autor ORDER BY usuario,email");
                                $sql->execute();
                                $ret = $sql->rowCount();

                                    if($ret > 0) {
                                        $py = md5('idautor');

                                        echo'
                                        <table class="table table-bordered table-hover table-data dt-responsive nowrap">
                                            <thead>
                                                <th style="width: 50px;"></th>
                                                <th>Nome</th>
                                                <th>Usu&aacute;rio</th>
                                                <th>Email</th>
                                            </thead>
                                            <tbody>';

                                            while($lin = $sql->fetch(PDO::FETCH_OBJ)) {
                                                switch($_SESSION['acc']) {
                                                    case 'A':
                                                        $html = '
                                                        <span><a data-toggle="modal" data-target="#edita-autor" data-placement="top" href="editaAutor.php?'.$py.'='.$lin->idautor.'" title="Editar os dados do autor"><i class="fa fa-pencil"></i></a></span>
                                                        <span><a data-toggle="tooltip" data-placement="top" href="#" class="delete-autor" id="'.$py.'-'.$lin->idautor.'" title="Excluir o autor"><i class="fa fa-trash-o"></i></a></span>';
                                                    break;
                                                    case 'U':
                                                        $html = '';
                                                    break;
                                                    default:
                                                        $html = '';
                                                    break;
                                                }

                                                echo'
                                                <tr>
                                                    <td class="text-center">
                                                        '.$html.'
                                                    </td>
                                                    <td>'.$lin->nome.'</td>
                                                    <td>'.base64_decode($lin->usuario).'</td>
                                                    <td>'.$lin->email.'</td>
                                                </tr>';

                                                unset($html);
                                            }

                                        echo'
                                            </tbody>
                                            <tfoot>
                                                <th></th>
                                                <th>Nome</th>
                                                <th>Usu&aacute;rio</th>
                                                <th>Email</th>
                                            </tfoot>
                                        </table>';

                                        unset($lin);
                                    }
                                    else {
                                        echo'
                                        <div class="callout">
                                            <h4>Nada encontrado</h4>
                                            <p>Nenhum autor foi cadastrado.</p>
                                        </div>';
                                    }

                                unset($pdo,$sql,$ret,$py);
                            }
                            catch(PDOException $e) {
                                echo 'Erro ao conectar o servidor '.$e->getMessage();
                            }
                        ?>
                        </div><!-- /.box-body -->
                    </div><!-- /.box -->
                </section><!-- /.content -->
            </div><!-- /.content-wrapper -->

            <!-- Modal -->
            <div class="modal fade" id="novo-autor" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form class="form-novo-autor">
                            <div class="modal-header">
                                <button type="button" class="close closed" data-dismiss="modal" aria-hidden="true">&times;</button>
                                <h4 class="modal-title">Novo autor <small>(<i class="fa fa-asterisk"></i> Campo obrigat&oacute;rio)</small></h4>
                            </div>
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="nome"><i class="fa fa-asterisk"></i> Nome</label>
                                    <input type="text" id="nome" class="form-control" maxlength="255" title="Digite o nome" placeholder="Nome" required>
                                </div>
                                <div class="form-group">
                                    <label for="usuario"><i class="fa fa-asterisk"></i> Usu&aacute;rio</label>
                                    <div class="input-group col-md-4">
                                        <input type="text" id="usuario" class="form-control" maxlength="10" title="Digite o usu&aacute;rio" placeholder="Usu&aacute;rio" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="senha"><i class="fa fa-asterisk"></i> Senha</label>
                                    <div class="input-group col-md-4">
                                        <input type="password" id="senha" class="form-control" maxlength="10" title="Digite a senha" placeholder="Senha" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="email"><i class="fa fa-asterisk"></i> Email</label>
                                    <input type="email" id="email" class="form-control" maxlength="100" title="Digite o email" placeholder="Email" required>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default btn-flat pull-left closed" data-dismiss="modal">Fechar</button>
                                <button type="submit" class="btn btn-primary btn-flat btn-submit-novo-autor">Salvar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="edita-autor" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content"></div>
                </div>
            </div><!-- /.modal -->

            <!-- Main Footer -->
            <footer class="main-footer"><?php include_once('footer.php'); ?></footer>
        </div><!-- ./wrapper -->

        <script src="js/jquery-2.1.4.min.js"></script>
        <script defer src="js/bootstrap.min.js"></script>
        <script defer src="js/datatables.min.js"></script>
        <script defer src="js/datatables.bootstrap.min.js"></script>
        <script defer src="js/datatables.responsive.min.js"></script>
        <script defer src="js/datatables.responsive.bootstrap.min.js"></script>
        <script async src="js/smoke.min.js"></script>
        <script async src="js/core.min.js"></script>
    </body>
</html>
