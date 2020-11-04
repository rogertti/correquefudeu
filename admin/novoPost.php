<?php require_once('config.php'); if(empty($_SESSION['key'])) { header ('location:./'); } $m = 2; ?>
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
        <link rel="stylesheet" href="css/icheck.min.css">
        <link rel="stylesheet" href="css/plupload.min.css">
        <link rel="stylesheet" href="css/select2.min.css">
        <link rel="stylesheet" href="css/blueimp-gallery.min.css">
        <link rel="stylesheet" href="css/image-gallery.min.css">
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
                    <h1>Novo post <small>(<i class="fa fa-asterisk"></i> Campo obrigat&oacute;rio)</small></h1>
                </section>

                <!-- Main content -->
                <section class="content">
                    <div class="box">
                        <form class="form-novo-post">
                            <div class="box-body">
                            <?php
                                //GERANDO A URL DO POST

                                $url = rand();
                                $url = base64_encode($url);
                                $url = md5($url);
                            ?>
                                <input type="hidden" id="idautor" value="<?php echo $_SESSION['id']; ?>">
                                <input type="hidden" id="hora" value="<?php echo date('H:i:s'); ?>">
                                <input type="hidden" id="url" value="<?php echo $url; ?>">
                                <input type="hidden" id="tag_select">

                                <div class="form-group">
                                    <label for="data"><i class="fa fa-asterisk"></i> Data</label>
                                    <div class="input-group col-md-2">
                                        <input type="text" id="datado" class="form-control" title="Data do post" value="<?php echo date('d/m/Y'); ?>" placeholder="Data" disabled>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>M&iacute;dia</label>
                                    <div class="input-group">
                                        <span class="form-icheck"><input type="radio" name="midia" id="cimagem" value="Imagem"> Imagem &uacute;nica</span>
                                        <span class="form-icheck"><input type="radio" name="midia" id="cvideo" value="Video"> Incorporar v&iacute;deo</span>
                                        <span class="form-icheck"><input type="radio" name="midia" id="cgaleria" value="Galeria"> Galeria</span>
                                        <span><a href="#" class="a-refresh-midia hide" title="Resetar para o estado original"><i class="fa fa-lg fa-refresh"></i></a></span>
                                    </div>
                                </div>
                                <div class="form-group gimagem hide">
                                    <label>Imagem &uacute;nica</label>
                                    <div class="input-group">
                                        <input type="file" id="imagem" title="Imagem &uacute;nica" placeholder="Imagem &uacute;nica">
                                        <p class="help-block">Tamanho m&aacute;ximo permitido: <strong>3MB</strong> - Tamanho ideal da foto: <strong>1280px por 830px</strong></p>
                                    </div>
                                </div>
                                <div class="form-group gvideo hide">
                                    <label>Incorporar v&iacute;deo</label>
                                    <div class="input-group">
                                        <input type="text" id="video" class="form-control" maxlength="255" title="Cole aqui a URL do v&iacute;deo" placeholder="Incorporar v&iacute;deo">
                                        <p class="help-block">Pode ser usado o <code><strong>&lt;iframe&gt;&lt;&#47;iframe&gt;</strong></code> ou a URL do v&iacute;deo. &Eacute; permitido v&iacute;deo do <strong>Youtube</strong> e do <strong>Vimeo</strong>.</p>
                                    </div>
                                </div>
                                <div class="form-group ggaleria hide">
                                    <label>Galeria</label>
                                    <div class="col-md-6">
                                        <p class="lead">Leia antes de carregar as fotos</p>
                                        <ul class="list-unstyled">
                                            <li>As fotos devem estar no formato <strong>JPG, PNG ou GIF</strong>.</li>
                                            <li>As fotos carregadas ser&atilde;o redimensionadas para <strong>1920px por 830px</strong>. <cite>(px significa pixel)</cite></li>
                                            <li>Evite usar fotos com tamanho menor que <strong>1920px por 830px</strong>.</li>
                                            <li>Para carregar as fotos, use o bot&atilde;o <strong>ADD</strong> ou <strong>ARRASTE</strong> as fotos para o quadro cinza, depois clique em <strong>INICIAR</strong>.</li>
                                        </ul>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="uploader"></div>
                                    </div>
                                    <?php
                                        //criando o diretorio
                                        $raiz = 'midiaPost';
                                        $pyfolder = md5('folder');

                                                if(!isset($_SESSION['folder'])) {
                                                    $_SESSION['folder'] = md5(microtime());
                                                    $folder = $_SESSION['folder'];
                                                }
                                                else {
                                                    $folder = $_SESSION['folder'];
                                                }

                                        //mostrando as fotos subidas
                                        $dir = ''.$raiz.'/'.$folder.'/';

                                            if(file_exists($dir)) {
                                                $pon = opendir($dir);

                                                    while ($nitens = readdir($pon)) {
                                                        $itens[] = $nitens;
                                                    }

                                                sort($itens);

                                                    foreach ($itens as $listar) {
                                                        if ($listar != "." && $listar != "..") {
                                                            $arquivos[] = $listar;
                                                        }
                                                    }

                                                    if (!empty($arquivos)) {
                                                        echo'
                                                        <div class="thumb">';

                                                            foreach($arquivos as $listar) {
                                                                if(!strstr($listar,'.DS')) {
                                                                    #$opt = substr($listar,3);
                                                                    print'
                                                                    <div class="col-md-2 thumbnail">
                                                                        <a href="'.$dir.''.$listar.'" title="Foto" data-gallery><img src="'.$dir.''.$listar.'"></a>
                                                                        <div class="caption">
                                                                            <a data-toggle="tooltip" data-placement="top" class="delphoto pull-right" id="del-'.$dir.''.$listar.'" title="Excluir a foto" href="#"><i class="fa fa-trash-o"></i></a>
                                                                            <input type="checkbox" name="foto[]" value="'.$dir.''.$listar.'" class="one-picture">
                                                                        </div>
                                                                    </div>';
                                                                }
                                                            }

                                                        echo'
                                                            <div class="all-pictures">
                                                                <input type="checkbox" id="select-all-pictures">
                                                                <span>Selecionar todas as fotos <a class="delete-selected-pictures hide" href="#" data-toggle="tooltip" data-placement="top" title="Excluir as fotos selecionadas"><i class="fa fa-trash-o"></i> Excluir as fotos selecionadas</a></span>
                                                            </div>
                                                        </div>';
                                                    }

                                                unset($pon,$nitens,$itens,$listar,$pastas,$n);
                                            }
                                    ?>
                                        <input type="hidden" id="album" value="<?php echo $folder; ?>">
                                </div>
                                <div class="form-group">
                                    <label for="titulo"><i class="fa fa-asterisk"></i> T&iacute;tulo</label>
                                    <div class="input-group col-md-4">
                                        <input type="text" id="titulo" class="form-control" maxlength="100" title="T&iacute;tulo do post" placeholder="T&iacute;tulo" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="texto"><i class="fa fa-asterisk"></i> Texto</label>
                                    <textarea id="texto" class="form-control" title="Escreva algo sobre voc&ecirc;" placeholder="Texto" required></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="tag">Tag</label>
                                    <select id="tag" class="form-control" title="Tags do post" multiple>
                                        <?php
                                            //SELECIONANDO AS TAGS

                                            include_once('conexao.php');

                                            try {
                                                $sql = $pdo->prepare("SELECT idtag,descricao FROM tag ORDER BY descricao");
                                                $sql->execute();
                                                $ret = $sql->rowCount();

                                                    if($ret > 0) {
                                                        while($lin = $sql->fetch(PDO::FETCH_OBJ)) {
                                                            echo'<option value="'.$lin->idtag.'">'.$lin->descricao.'</option>';
                                                        }

                                                        unset($lin);
                                                    }

                                                unset($pdo,$sql,$ret);
                                            }
                                            catch(PDOException $e) {
                                                echo 'Erro ao conectar o servidor '.$e->getMessage();
                                            }
                                        ?>
                                    </select>
                                </div>
                            <?php
                                unset($url);
                            ?>
                            </div><!-- /.box-body -->
                            <div class="box-footer">
                                <button type="submit" class="btn btn-primary btn-flat pull-right btn-submit-novo-post">Salvar</button>
                            </div><!-- /.box-footer -->
                        </form>
                    </div><!-- /.box -->
                </section><!-- /.content -->
            </div><!-- /.content-wrapper -->

            <!-- The Bootstrap Image Gallery lightbox, should be a child element of the document body -->
            <div id="blueimp-gallery" class="blueimp-gallery blueimp-gallery-controls" data-use-bootstrap-modal="false">
                <!-- The container for the modal slides -->
                <div class="slides"></div>
                <!-- Controls for the borderless lightbox -->
                <h3 class="title"></h3>
                <a class="prev">‹</a>
                <a class="next">›</a>
                <a class="close">×</a>
                <a class="play-pause"></a>
                <ol class="indicator"></ol>
                <!-- The modal dialog, which will be used to wrap the lightbox content -->
                <div class="modal fade">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" aria-hidden="true">&times;</button>
                                <h4 class="modal-title"></h4>
                            </div>
                            <div class="modal-body next"></div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default pull-left prev">
                                    <i class="glyphicon glyphicon-chevron-left"></i>
                                </button>
                                <button type="button" class="btn btn-primary next">
                                    <i class="glyphicon glyphicon-chevron-right"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!-- /.blueimp-gallery -->

            <!-- Main Footer -->
            <footer class="main-footer"><?php include_once('footer.php'); ?></footer>
        </div><!-- ./wrapper -->

        <script src="js/jquery-2.1.4.min.js"></script>
        <script defer src="js/bootstrap.min.js"></script>
        <script defer src="ckeditor/ckeditor.js"></script>
        <script defer src="js/ckeditor.init.min.js"></script>
        <script defer src="js/icheck.min.js"></script>
        <script defer src="js/plupload.min.js"></script>
        <script defer src="js/pluploadQueue.min.js"></script>
        <script defer src="js/blueimp-gallery.min.js"></script>
        <script defer src="js/image-gallery.min.js"></script>
        <script async src="js/smoke.min.js"></script>
        <script defer src="js/select2.min.js"></script>
        <script src="js/core.min.js"></script>
        <script async>
            $(document).ready(function () {
                /* UPLOAD */

                $(".uploader").pluploadQueue({
                    //General settings
                    runtimes : 'html5',
                    url : 'upload.php?<?php echo $pyfolder; ?>=<?php echo $folder; ?>&raiz=<?php echo $raiz; ?>',
                    max_file_size : '10mb',
                    chunk_size : '1mb',
                    unique_names : true,

                    // Resize images on clientside if we can
                    resize : {width : 1280, height : 830, quality : 50},

                    //Specify what files to browse for
                    filters : [
                       {title : "Image files", extensions : "jpg,jpeg,gif,png"},
                       {title : "Zip files", extensions : "zip"}
                    ],

                    init : {
                        UploadComplete: function(up, file, info) {
                            setTimeout(1000);
                            window.location.reload();
                        }
                    }
                });

                /* DELETE SINGLE FOTO */

                $(".delphoto").click(function () {
                    var click = this.id.split('-');
                    var id = click[1];

                        if(confirm('Quer mesmo excluir a foto?')) {
                            $.ajax({
                                url: "deleteFoto.php?<?php echo $pyfolder; ?>=" + id + "&raiz=<?php echo $raiz; ?>",
                                cache: false
                            })
                            .done(function () {
                                location.reload();
                            });
                        }

                    return true;
                });

                /* DELETE SELECTED FOTO */

                $(".delete-selected-pictures").click(function () {
                    var foto = $("input[name='foto[]']").serializeArray();
                    foto = new Array();
                    $("input[name='foto[]']:checked").each(function () {
                        foto.push($(this).val());
                    });

                    if(confirm('Quer mesmo excluir as fotos selecionadas?')) {
                        $.ajax({
                            url: "deleteFotoSelecionada.php?<?php echo $pyfolder; ?>=" + foto + "&raiz=<?php echo $raiz; ?>",
                            cache: false
                        })
                        .done(function () {
                            location.reload();
                        });
                    }

                    return true;
                });

                /* CONTROL CHECK */

                $("#cimagem").on("ifChecked", function(event){
                    $(".gimagem").removeClass("hide");
                    $("#imagem").attr("required", "true");
                    $(".gvideo").addClass("hide");
                    $("#video").removeAttr("required");
                    $(".ggaleria").addClass("hide");
                    $("#cvideo").iCheck("disable");
                    $("#cgaleria").iCheck("disable");
                    $('.a-refresh-midia').removeClass('hide');
                });

                $("#cvideo").on("ifChecked", function(event){
                    $(".gimagem").addClass("hide");
                    $("#imagem").removeAttr("required");
                    $(".gvideo").removeClass("hide");
                    $("#video").attr("required", "true");
                    $(".ggaleria").addClass("hide");
                    $("#cimagem").iCheck("disable");
                    $("#cgaleria").iCheck("disable");
                    $('.a-refresh-midia').removeClass('hide');
                });

                $("#cgaleria").on("ifChecked", function(event){
                    $(".gimagem").addClass("hide");
                    $("#imagem").removeAttr("required");
                    $(".gvideo").addClass("hide");
                    $("#video").removeAttr("required");
                    $(".ggaleria").removeClass("hide");
                    $("#cimagem").iCheck("disable");
                    $("#cvideo").iCheck("disable");
                    $('.a-refresh-midia').removeClass('hide');
                });

                $('.a-refresh-midia').click(function (e) {
                    //e.preventDefault;
                    $("#cimagem").iCheck("enable");
                    $("#cvideo").iCheck("enable");
                    $("#cgaleria").iCheck("enable");
                    $("#cimagem").iCheck("uncheck");
                    $("#cvideo").iCheck("uncheck");
                    $("#cgaleria").iCheck("uncheck");
                    $(".gimagem").addClass("hide");
                    $(".gvideo").addClass("hide");
                    $(".ggaleria").addClass("hide");
                    $('.a-refresh-midia').addClass('hide');
                });

            <?php
                if(!empty($arquivos)) {
            ?>
                    $("#cgaleria").iCheck("check", function(){
                        $(".gimagem").addClass("hide");
                        $("#imagem").removeAttr("required");
                        $(".gvideo").addClass("hide");
                        $("#video").removeAttr("required");
                        $(".ggaleria").removeClass("hide");
                        $("#cimagem").iCheck("disable");
                        $("#cvideo").iCheck("disable");
                        $('.a-refresh-midia').removeClass('hide');
                    });
            <?php
                }
            ?>
            });
        </script>
    </body>
</html>
<?php unset($pyfolder,$folder,$raiz,$arquivos); ?>
