<?php require_once('config.php'); if(empty($_SESSION['key'])) { header ('location:./'); } $m = 4; ?>
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
                    <h1>Sobre <small>(<i class="fa fa-asterisk"></i> Campo obrigat&oacute;rio)</small></h1>
                </section>

                <!-- Main content -->
                <section class="content">
                    <div class="box">
                        <form class="form-sobre">
                            <div class="box-body">
                            <?php
                                include_once('conexao.php');

                                try {
                                    $sql = $pdo->prepare("SELECT sobre.idsobre,sobre.autor_idautor,sobre.texto,sobre.midia FROM sobre,autor WHERE sobre.autor_idautor = autor.idautor AND autor.idautor = :idautor");
                                    $sql->bindParam(':idautor', $_SESSION['id'], PDO::PARAM_INT);
                                    $sql->execute();
                                    $ret = $sql->rowCount();

                                        if($ret > 0) {
                                            $lin = $sql->fetch(PDO::FETCH_OBJ);
                            ?>
                                <input type="hidden" id="idsobre" value="<?php echo $lin->idsobre; ?>">
                                <input type="hidden" id="idautor" value="<?php echo $lin->autor_idautor; ?>">
                                <input type="hidden" id="img" value="<?php echo $lin->midia; ?>">
                                <input type="hidden" id="action" value="updateSobre.php">

                                <div class="form-group">
                                    <img src="<?php echo "midiaSobre/".$lin->midia; ?>" class="img-responsive img-height-200" title="Foto de capa" alt="Foto de capa">
                                </div>

                                <div class="form-group">
                                    <label for="midia"><i class="fa fa-asterisk"></i> Trocar a foto de capa</label>
                                    <input type="file" id="midia" title="Trocar a foto de capa" placeholder="Foto">
                                    <p class="help-block">Tamanho m&aacute;ximo permitido: <strong>2MB</strong> - Largura ideal da foto: <strong>815px</strong></p>
                                </div>
                                <div class="form-group">
                                    <label for="texto"><i class="fa fa-asterisk"></i> Texto</label>
                                    <textarea id="texto" class="form-control" title="Escreva algo sobre voc&ecirc;" placeholder="Texto" required><?php echo $lin->texto; ?></textarea>
                                </div>
                            <?php
                                            unset($lin);
                                        }
                                        else {
                            ?>
                                <input type="hidden" id="idautor" value="<?php echo $_SESSION['id']; ?>">
                                <input type="hidden" id="action" value="insertSobre.php">

                                <div class="form-group">
                                    <label for="midia"><i class="fa fa-asterisk"></i> Foto de capa</label>
                                    <input type="file" id="midia" title="Foto de capa" placeholder="Foto" required>
                                    <p class="help-block">Tamanho m&aacute;ximo permitido: <strong>2MB</strong> - Largura ideal da foto: <strong>815px</strong></p>
                                </div>
                                <div class="form-group">
                                    <label for="texto"><i class="fa fa-asterisk"></i> Texto</label>
                                    <textarea id="texto" class="form-control" title="Escreva algo sobre voc&ecirc;" placeholder="Texto" required></textarea>
                                </div>
                            <?php
                                        }

                                    unset($pdo,$sql,$ret);
                                }
                                catch(PDOException $e) {
                                    echo 'Erro ao conectar o servidor '.$e->getMessage();
                                }
                            ?>
                            </div><!-- /.box-body -->
                            <div class="box-footer">
                                <button type="submit" class="btn btn-primary btn-flat pull-right btn-submit-sobre">Salvar</button>
                            </div><!-- /.box-footer -->
                        </form>
                    </div><!-- /.box -->
                </section><!-- /.content -->
            </div><!-- /.content-wrapper -->

            <!-- Main Footer -->
            <footer class="main-footer"><?php include_once('footer.php'); ?></footer>
        </div><!-- ./wrapper -->

        <script src="js/jquery-2.1.4.min.js"></script>
        <script defer src="js/bootstrap.min.js"></script>
        <script defer src="ckeditor/ckeditor.js"></script>
        <script defer src="js/ckeditor.init.min.js"></script>
        <script async src="js/smoke.min.js"></script>
        <script async src="js/core.min.js"></script>
    </body>
</html>
