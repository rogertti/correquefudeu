<?php require_once('config.php'); if(empty($_SESSION['key'])) { header ('location:./'); } $m = 1; unset($_SESSION['folder']); ?>
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
                    <h1>In&iacute;cio <small>Todos os posts</small> <span class="pull-right lead response"><a href="novo-post" title="Cadastre um novo post"><i class="fa fa-file-text"></i> Novo post</a></span></h1>
                </section>

                <!-- Main content -->
                <section class="content">
                    <div class="box">
                        <div class="box-body">
                        <?php
                            include_once('conexao.php');

                            try {
                                $sql = $pdo->prepare("SELECT post.idpost,post.datado,post.titulo,post.midia FROM post,autor WHERE post.autor_idautor = autor.idautor AND autor.idautor = :idautor ORDER BY titulo");
                                $sql->bindParam(':idautor', $_SESSION['id'], PDO::PARAM_INT);
                                $sql->execute();
                                $ret = $sql->rowCount();

                                    if($ret > 0) {
                                        $py = md5('idpost');

                                        echo'
                                        <table class="table table-bordered table-hover table-data dt-responsive nowrap">
                                            <thead>
                                                <th style="width: 50px;"></th>
                                                <th style="width: 80px;">Data</th>
                                                <th>T&iacute;tulo</th>
                                                <th style="width: 200px;">M&iacute;dia</th>
                                            </thead>
                                            <tbody>';

                                            while($lin = $sql->fetch(PDO::FETCH_OBJ)) {
                                                //INVERTENDO A DATA

                                                $ano = substr($lin->datado,0,4);
                                                $mes = substr($lin->datado,5,2);
                                                $dia = substr($lin->datado,8);
                                                $lin->datado = $dia."/".$mes."/".$ano;
                                                unset($ano,$mes,$dia);

                                                //TRATANDO A MIDIA

                                                if((strstr($lin->midia,'.jpg')) or (strstr($lin->midia,'.jpeg')) or (strstr($lin->midia,'.png'))) {
                                                    $lin->midia = '<span><i class="fa fa-file-image-o"></i></span> Imagem &uacute;nica';
                                                }
                                                elseif(strstr($lin->midia,'<iframe')) {
                                                    $lin->midia = '<span><i class="fa fa-video-camera"></i></span> V&iacute;deo';
                                                }
                                                else {
                                                    if(!empty($lin->midia)) {
                                                        $lin->midia = '<span><i class="fa fa-picture-o"></i></span> Galeria';
                                                    }
                                                    else {
                                                        $lin->midia = '';
                                                    }
                                                }

                                                echo'
                                                <tr>
                                                    <td class="text-center">
                                                        <span><a data-toggle="modal" data-target="#open-post" data-placement="top" href="openPost.php?'.$py.'='.$lin->idpost.'" title="Ver o post formatado"><i class="fa fa-eye"></i></a></span>
                                                        <span><a data-toggle="tooltip" data-placement="top" href="editaPost.php?'.$py.'='.$lin->idpost.'" title="Editar os dados do post"><i class="fa fa-pencil"></i></a></span>
                                                        <span><a data-toggle="tooltip" data-placement="top" href="#" class="delete-post" id="'.$py.'-'.$lin->idpost.'" title="Excluir o post"><i class="fa fa-trash-o"></i></a></span>
                                                    </td>
                                                    <td>'.$lin->datado.'</td>
                                                    <td>'.$lin->titulo.'</td>
                                                    <td>'.$lin->midia.'</td>
                                                </tr>';
                                            }

                                        echo'
                                            </tbody>
                                            <tfoot>
                                                <th></th>
                                                <th>Data</th>
                                                <th>T&iacute;tulo</th>
                                                <th>M&iacute;dia</th>
                                            </tfoot>
                                        </table>';

                                        unset($lin);
                                    }
                                    else {
                                        echo'
                                        <div class="callout">
                                            <h4>Nada encontrado</h4>
                                            <p>Nenhum post foi cadastrado. <a href="novo-post" title="Criar o primeiro post">Crie um post</a></p>
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

            <!-- modal -->
            <div class="modal fade" id="open-post" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-lg">
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
        <script async src="js/core.min.js"></script>
    </body>
</html>
