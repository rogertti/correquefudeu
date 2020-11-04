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
                    <h1>Edita post <small>(<i class="fa fa-asterisk"></i> Campo obrigat&oacute;rio)</small></h1>
                </section>

                <!-- Main content -->
                <section class="content">
                    <div class="box">
                        <?php
                            try {
                                include_once('conexao.php');

                                /* BUSCA DADOS DO POST */

                                $py = md5('idpost');
                                $sql = $pdo->prepare("SELECT idpost,datado,titulo,texto,midia FROM post WHERE idpost = :idpost");
                                $sql->bindParam(':idpost', $_GET[''.$py.''], PDO::PARAM_INT);
                                $sql->execute();
                                $ret = $sql->rowCount();

                                    if($ret > 0) {
                                        $lin = $sql->fetch(PDO::FETCH_OBJ);

                                        //INVERTENDO A DATA

                                        $ano = substr($lin->datado,0,4);
                                        $mes = substr($lin->datado,5,2);
                                        $dia = substr($lin->datado,8);
                                        $lin->datado = $dia."/".$mes."/".$ano;
                                        unset($ano,$mes,$dia);

                                        //CONTROLE DE GALERIA

                                        $raiz = 'midiaPost';
                                        $pyfolder = md5('folder');

                                        //SELECIONANDO AS TAG EXISTENTES

                                        $sql = $pdo->prepare("SELECT tag.idtag FROM post,post_has_tag,tag WHERE post_has_tag.post_idpost = post.idpost AND post_has_tag.tag_idtag = tag.idtag AND post.idpost = :idpost");
                                        $sql->bindParam(':idpost', $lin->idpost, PDO::PARAM_INT);
                                        $sql->execute();
                                        $ret2 = $sql->rowCount();

                                            if($ret2 > 0) {
                                                $lin2 = $sql->fetchAll(PDO::FETCH_ASSOC);
                                                $tags = array_column($lin2, 'idtag');
                                                $idtag = implode(',', $tags);
                                            }
                                            else {
                                                $idtag = '';
                                            }
                        ?>
                        <form class="form-edita-post">
                            <div class="box-body">
                                <input type="hidden" id="idpost" value="<?php echo $lin->idpost; ?>">
                                <input type="hidden" id="hora" value="<?php echo date('H:m:s'); ?>">
                                <input type="hidden" id="tag_select_original" value="<?php echo $idtag; ?>">
                                <input type="hidden" id="tag_select" value="<?php echo $idtag; ?>">

                                <div class="form-group">
                                    <label for="data"><i class="fa fa-asterisk"></i> Data</label>
                                    <div class="input-group col-md-2">
                                        <input type="text" id="datado" class="form-control" title="Data do post" value="<?php echo $lin->datado; ?>" placeholder="Data" disabled>
                                    </div>
                                </div>
                                <?php
                                    if((strstr($lin->midia,'.jpg')) or (strstr($lin->midia,'.jpeg')) or (strstr($lin->midia,'.png'))) {
                                        echo'
                                        <div class="form-group gimagem">
                                            <label>Foto</label>
                                            <div class="input-group">
                                                <img src="midiaPost/'.$lin->midia.'" class="img-height-200 responsive" title="Imagem" alt="Imagem">
                                                <p class="help-block"><a data-toggle="tooltip" data-placement="top" class="delmidia" id="del-'.$py.'-'.$lin->idpost.'-imagem-'.$lin->midia.'" title="Excluir a foto" href="#"><i class="fa fa-trash-o"></i></a></p>
                                            </div>
                                        </div>
                                        <input type="hidden" id="hmidia" value="'.$lin->midia.'">';
                                    }
                                    elseif(strstr($lin->midia,'<iframe')) {
                                        $lin->midia = str_replace('width="852"', 'width="300"', $lin->midia);
                                        $lin->midia = str_replace('height="480"', 'height="170"', $lin->midia);
                                        echo'
                                        <div class="form-group gvideo">
                                            <label>V&iacute;deo</label>
                                            <div class="input-group">
                                                '.$lin->midia.'
                                                <p class="help-block"><a data-toggle="tooltip" data-placement="top" class="delmidia" id="del-'.$py.'-'.$lin->idpost.'-video-video" title="Excluir o v&iacute;deo" href="#"><i class="fa fa-trash-o"></i></a></p>
                                            </div>
                                        </div>';

                                        $lin->midia = str_replace("'","&#39;", $lin->midia);
                                        $lin->midia = str_replace('"','&#34;', $lin->midia);

                                        echo'<input type="hidden" id="hmidia" value="'.$lin->midia.'">';
                                    }
                                    else {
                                        if(!empty($lin->midia)) {
                                            echo'
                                            <div class="form-group ggaleria-switch">
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
                                                </div>';

                                                $folder = $lin->midia;
                                                $dir = ''.$raiz.'/'.$folder.'/';

                                                    if(file_exists($dir)) {
                                                        $pon = opendir($dir);

                                                            while ($nitens = readdir($pon)) {
                                                                $itens[] = $nitens;
                                                            }

                                                        sort($itens);

                                                            foreach ($itens as $listar) {
                                                                if ($listar != "." && $listar != "..") {
                                                                    $arquivos2[] = $listar;
                                                                }
                                                            }

                                                            if (!empty($arquivos2)) {
                                                                echo'
                                                                <div class="thumb">';

                                                                    foreach($arquivos2 as $listar) {
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

                                                unset($dir);

                                            echo'
                                            </div>
                                            <input type="hidden" id="hmidia" value="'.$lin->midia.'">';
                                        }
                                        else {
                                            $cmidia = 1;
                                        }
                                    }
                                ?>
                                <div class="form-group midia-control hide">
                                    <label>M&iacute;dia</label>
                                    <div class="input-group">
                                        <span class="form-icheck"><input type="radio" name="midia" id="cimagem" value="Imagem"> Imagem &uacute;nica</span>
                                        <span class="form-icheck"><input type="radio" name="midia" id="cvideo" value="Video"> Incorporar v&iacute;deo</span>
                                        <span class="form-icheck"><input type="radio" name="midia" id="cgaleria" value="Galeria"> Galeria</span>
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
                                        if(empty($folder)) {
                                            if(!isset($_SESSION['folder'])) {
                                                $_SESSION['folder'] = md5(microtime());
                                                $folder = $_SESSION['folder'];
                                            }
                                            else {
                                                $folder = $_SESSION['folder'];
                                            }
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
                                                                            <a class="delphoto pull-right" id="del-'.$dir.''.$listar.'" title="Excluir a foto" href="#"><i class="fa fa-trash-o"></i></a>
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
                                        <input type="text" id="titulo" class="form-control" value="<?php echo $lin->titulo; ?>" maxlength="100" title="T&iacute;tulo do post" placeholder="T&iacute;tulo" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="texto"><i class="fa fa-asterisk"></i> Texto</label>
                                    <textarea id="texto" class="form-control" title="Escreva algo sobre voc&ecirc;" placeholder="Texto" required><?php echo $lin->texto; ?></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="tag">Tag</label>
                                    <select id="tag" class="form-control" title="Tags do post" multiple>
                                    <?php
                                        //SELECIONANDO AS TAGS

                                        $sql = $pdo->prepare("SELECT idtag,descricao FROM tag ORDER BY descricao");
                                        $sql->execute();
                                        $ret2 = $sql->rowCount();

                                            if($ret2 > 0) {
                                                $lin2 = $sql->fetchAll(PDO::FETCH_ASSOC);
                                                $tags = array_column($lin2, 'idtag');
                                                $sql = $pdo->prepare("SELECT post_has_tag.tag_idtag FROM post,post_has_tag,tag WHERE post_has_tag.post_idpost = post.idpost AND post_has_tag.tag_idtag = tag.idtag AND post.idpost = :idpost");
                                                $sql->bindParam(':idpost', $lin->idpost, PDO::PARAM_INT);
                                                $sql->execute();
                                                $ret3 = $sql->rowCount();

                                                    if($ret3 > 0) {
                                                        $lin3 = $sql->fetchAll(PDO::FETCH_ASSOC);
                                                        $tags2 = array_column($lin3, 'tag_idtag');

                                                        $equal = array_intersect($tags,$tags2);
                                                        $dqual = array_diff($tags,$tags2);

                                                        $idtag = implode(',', $equal);
                                                        $sql = sprintf("SELECT idtag,descricao FROM tag WHERE idtag IN(%s)", $idtag);
                                                        $sql = $pdo->prepare($sql);
                                                        $sql->execute();
                                                        $ret4 = $sql->rowCount();

                                                            if($ret4 > 0) {
                                                                while($lin4 = $sql->fetch(PDO::FETCH_OBJ)) {
                                                                    echo'<option value="'.$lin4->idtag.'" selected>'.$lin4->descricao.'</option>';
                                                                }

                                                                unset($lin4);
                                                            }

                                                            if(!empty($dqual)) {
                                                                $idtag = implode(',', $dqual);
                                                                $sql = sprintf("SELECT idtag,descricao FROM tag WHERE idtag IN(%s)", $idtag);
                                                                $sql = $pdo->prepare($sql);
                                                                $sql->execute();
                                                                $ret5 = $sql->rowCount();

                                                                    if($ret5 > 0) {
                                                                        while($lin5 = $sql->fetch(PDO::FETCH_OBJ)) {
                                                                            echo'<option value="'.$lin5->idtag.'">'.$lin5->descricao.'</option>';
                                                                        }

                                                                        unset($lin5);
                                                                    }

                                                                unset($tags2,$lin3,$equal,$dqual,$idtag,$ret4,$ret5);
                                                            }
                                                    }
                                                    else {
                                                        $sql = $pdo->prepare("SELECT idtag,descricao FROM tag ORDER BY descricao");
                                                        $sql->execute();
                                                        $ret2 = $sql->rowCount();

                                                            if($ret2 > 0) {
                                                                while($lin2 = $sql->fetch(PDO::FETCH_OBJ)) {
                                                                    echo'<option value="'.$lin2->idtag.'">'.$lin2->descricao.'</option>';
                                                                }
                                                            }

                                                        unset($sql,$ret2,$lin2);
                                                    }

                                                unset($lin2,$tags,$ret3);
                                            }

                                        unset($sql,$ret2);
                                    ?>
                                    </select>
                                </div>
                            </div><!-- /.box-body -->
                            <div class="box-footer">
                                <button type="submit" class="btn btn-primary btn-flat pull-right btn-submit-edita-post">Salvar</button>
                            </div><!-- /.box-footer -->
                        </form>
                        <?php
                                    unset($lin);
                                }
                                else {
                                    echo'
                                    <div class="callout">
                                        <h4>Par&acirc;mentro incorreto</h4>
                                    </div>';
                                }

                            unset($pdo,$sql,$ret,$py);
                        }
                        catch(PDOException $e) {
                            echo'Falha ao conectar o servidor '.$e->getMessage();
                        }
                    ?>
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
                /* CONTROL MIDIA */

                <?php
                    if(!empty($cmidia)) {
                ?>
                        $(".midia-control").removeClass("hide");
                <?php
                    }
                ?>

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
                });

                $("#cvideo").on("ifChecked", function(event){
                    $(".gimagem").addClass("hide");
                    $("#imagem").removeAttr("required");
                    $(".gvideo").removeClass("hide");
                    $("#video").attr("required", "true");
                    $(".ggaleria").addClass("hide");
                    $("#cimagem").iCheck("disable");
                    $("#cgaleria").iCheck("disable");
                });

                $("#cgaleria").on("ifChecked", function(event){
                    $(".gimagem").addClass("hide");
                    $("#imagem").removeAttr("required");
                    $(".gvideo").addClass("hide");
                    $("#video").removeAttr("required");
                    $(".ggaleria").removeClass("hide");
                    $("#cimagem").iCheck("disable");
                    $("#cvideo").iCheck("disable");
                });

            <?php
                if((!empty($arquivos)) and (!empty($arquivos2))){
            ?>
                    $("#cgaleria-switch").iCheck("check", function(){
                        $(".gimagem").addClass("hide");
                        $("#imagem").removeAttr("required");
                        $(".gvideo").addClass("hide");
                        $("#video").removeAttr("required");
                        $(".ggaleria").removeClass("hide");
                        $("#cimagem").iCheck("disable");
                        $("#cvideo").iCheck("disable");
                    });
            <?php
                }
                else {
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
                    });
            <?php
                    }
            ?>
            <?php
                    if(!empty($arquivos2)) {
            ?>
                    $("#cgaleria-switch").iCheck("check", function(){
                        $(".gimagem").addClass("hide");
                        $("#imagem").removeAttr("required");
                        $(".gvideo").addClass("hide");
                        $("#video").removeAttr("required");
                        $(".ggaleria-switch").removeClass("hide");
                        $("#cimagem").iCheck("disable");
                        $("#cvideo").iCheck("disable");
                    });
            <?php
                    }
                }
            ?>
            });
        </script>
    </body>
</html>
<?php unset($pyfolder,$folder,$raiz,$arquivos,$arquivos2,$cmidia); ?>
