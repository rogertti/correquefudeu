<?php require_once('config.php'); if(empty($_SESSION['key'])) { header ('location:./'); } $m = 5; ?>
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
                    <h1>Redes sociais <span class="pull-right lead response"><a data-toggle="modal" data-target="#novo-social" href="#" title="Cadastre uma nova rede social"><i class="fa fa-connectdevelop"></i> Nova rede social</a></span></h1>
                </section>

                <!-- Main content -->
                <section class="content">
                    <div class="box">
                        <div class="box-body">
                        <?php
                            include_once('conexao.php');

                            try {
                                $sql = $pdo->prepare("SELECT social.idsocial,social.rede,social.url FROM social,autor WHERE social.autor_idautor = autor.idautor AND autor.idautor = :idautor ORDER BY rede,url");
                                $sql->bindParam(':idautor', $_SESSION['id'], PDO::PARAM_INT);
                                $sql->execute();
                                $ret = $sql->rowCount();

                                    if($ret > 0) {
                                        $py = md5('idsocial');

                                        echo'
                                        <table class="table table-bordered table-hover table-social">
                                            <thead>
                                                <th style="width: 100px;"></th>
                                                <th style="width: 80px;">Logo</th>
                                                <th>Rede</th>
                                                <th>Url</th>
                                            </thead>
                                            <tbody>';

                                            while($lin = $sql->fetch(PDO::FETCH_OBJ)) {
                                                switch($lin->rede) {
                                                    case 'Dribbble': $sicon = '<span class="icon-social"><i class="ion ion-social-dribbble"></i></span>'; break;
                                                    case 'Facebook': $sicon = '<span class="icon-social"><i class="ion ion-social-facebook"></i></span>'; break;
                                                    case 'Google': $sicon = '<span class="icon-social"><i class="ion ion-social-googleplus"></i></span>'; break;
                                                    case 'Instagram': $sicon = '<span class="icon-social"><i class="ion ion-social-instagram"></i></span>'; break;
                                                    case 'LinkedIn': $sicon = '<span class="icon-social"><i class="ion ion-social-linkedin"></i></span>'; break;
                                                    case 'Pinterest': $sicon = '<span class="icon-social"><i class="ion ion-social-pinterest"></i></span>'; break;
                                                    case 'Twitter': $sicon = '<span class="icon-social"><i class="ion ion-social-twitter"></i></span>'; break;
                                                    case 'Youtube': $sicon = '<span class="icon-social"><i class="ion ion-social-youtube"></i></span>'; break;
                                                }

                                                echo'
                                                <tr>
                                                    <td class="text-center">
                                                        <span><a data-toggle="modal" data-target="#edita-social" data-placement="top" href="editaSocial.php?'.$py.'='.$lin->idsocial.'" title="Editar a rede social"><i class="fa fa-pencil"></i></a></span>
                                                        <span><a data-toggle="tooltip" data-placement="top" href="#" class="delete-social" id="'.$py.'-'.$lin->idsocial.'" title="Excluir a rede social"><i class="fa fa-trash-o"></i></a></span>
                                                    </td>
                                                    <td class="text-center">'.$sicon.'</td>
                                                    <td>'.$lin->rede.'</td>
                                                    <td>'.$lin->url.'</td>
                                                </tr>';

                                                unset($sicon);
                                            }

                                        echo'
                                            </tbody>
                                            <tfoot>
                                                <th></th>
                                                <th>Logo</th>
                                                <th>Rede</th>
                                                <th>Url</th>
                                            </tfoot>
                                        </table>';

                                        unset($lin);
                                    }
                                    else {
                                        echo'
                                        <div class="callout">
                                            <h4>Nada encontrado</h4>
                                            <p>Nenhuma rede social foi cadastrada.</p>
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
            <div class="modal fade" id="novo-social" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form class="form-novo-social">
                            <div class="modal-header">
                                <button type="button" class="close closed" data-dismiss="modal" aria-hidden="true">&times;</button>
                                <h4 class="modal-title">Nova rede social <small>(<i class="fa fa-asterisk"></i> Campo obrigat&oacute;rio)</small></h4>
                            </div>
                            <div class="modal-body">
                                <input type="hidden" id="idautor" value="<?php echo $_SESSION['id']; ?>">

                                <div class="form-group">
                                    <label for="rede"><i class="fa fa-asterisk"></i> Rede</label>
                                    <div class="input-group col-md-4">
                                        <select id="rede" class="form-control" required>
                                            <option value="" selected></option>
                                            <option value="Dribbble">Dribbble</option>
                                            <option value="Facebook">Facebook</option>
                                            <option value="Google">Google &#43;</option>
                                            <option value="Instagram">Instagram</option>
                                            <option value="LinkedIn">LinkedIn</option>
                                            <option value="Pinterest">Pinterest</option>
                                            <option value="Twitter">Twitter</option>
                                            <option value="Youtube">Youtube</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="url"><i class="fa fa-asterisk"></i> URL</label>
                                    <input type="url" id="url" class="form-control" maxlength="255" title="Digite o endere&ccedil;o web" placeholder="URL" required>
                                    <p class="help-block">Exemplo: <strong>https://www.exemplo.com</strong></p>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default btn-flat pull-left closed" data-dismiss="modal">Fechar</button>
                                <button type="submit" class="btn btn-primary btn-flat btn-submit-novo-social">Salvar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="edita-social" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content"></div>
                </div>
            </div><!-- /.modal -->

            <!-- Main Footer -->
            <footer class="main-footer"><?php include_once('footer.php'); ?></footer>
        </div><!-- ./wrapper -->

        <script src="js/jquery-2.1.4.min.js"></script>
        <script defer src="js/bootstrap.min.js"></script>
        <script async src="js/smoke.min.js"></script>
        <script async src="js/core.min.js"></script>
    </body>
</html>
