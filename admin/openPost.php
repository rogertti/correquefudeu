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

                $ano = substr($lin->datado,0,4);
                $mes = substr($lin->datado,5,2);
                $dia = substr($lin->datado,8);
                $lin->datado = $dia."/".$mes."/".$ano;
                unset($ano,$mes,$dia);
?>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h4 class="modal-title">Dados do post</h4>
</div>
<div class="modal-body">
    <div class="row">
        <div class="col-md-12">
        <?php
            if((strstr($lin->midia,'.jpg')) or (strstr($lin->midia,'.jpeg')) or (strstr($lin->midia,'.png'))) {
                echo'<img src="midiaPost/'.$lin->midia.'" class="img-width-850 responsive" title="Imagem" alt="Imagem">';
            }
            elseif(strstr($lin->midia,'<iframe')) {
                echo'<div class="object-center">'.$lin->midia.'</div>';
            }
            else {
                if(!empty($lin->midia)) {
                    //mostrando as fotos subidas
                    $dir = 'midiaPost/'.$lin->midia.'/';

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
                                    echo'<div class="thumb">';

                                        foreach($arquivos as $listar) {
                                            if(!strstr($listar,'.DS')) {
                                                #$opt = substr($listar,3);
                                                print'
                                                <div class="col-md-3 thumbnail">
                                                    <a href="'.$dir.''.$listar.'" title="Foto" data-gallery><img src="'.$dir.''.$listar.'"></a>
                                                </div>';
                                            }
                                        }

                                    echo'</div>';
                                }

                            unset($pon,$nitens,$itens,$listar,$pastas,$n);
                        }

                    unset($dir);
                }
            }
        ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 text-center">
            <h1><?php echo $lin->titulo; ?></h1>
        </div>
    </div>
    <?php
        //BUSCANDO AS TAGS

        $sql = $pdo->prepare("SELECT post_has_tag.tag_idtag FROM post,post_has_tag WHERE post_has_tag.post_idpost = post.idpost AND post.idpost = :idpost");
        $sql->bindParam(':idpost', $lin->idpost, PDO::PARAM_INT);
        $sql->execute();
        $ret2 = $sql->rowCount();

            if($ret2 > 0) {
                echo'
                <div class="row">
                    <div class="col-md-12 text-center text-uppercase">';

                    $lin2 = $sql->fetchAll(PDO::FETCH_ASSOC);
                    $tags = array_column($lin2, 'tag_idtag');
                    $idtag = implode(',', $tags);
                    $sql = sprintf("SELECT descricao FROM tag WHERE idtag IN(%s)", $idtag);
                    $sql = $pdo->prepare($sql);
                    $sql->execute();
                    $ret3 = $sql->rowCount();

                        if($ret3 > 0) {
                            while($lin3 = $sql->fetch(PDO::FETCH_OBJ)) {
                                echo'<code>['.$lin3->descricao.']</code>';
                            }

                            unset($lin3);
                        }

                    unset($tags,$idtag,$lin2,$ret3);

                echo'
                    </div>
                </div>
                <br>';
            }

        unset($ret2);
    ?>
    <div class="row">
        <div class="col-md-12">
            <?php echo '<p class="lead">'.$lin->datado.'</p>'; ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 text-justify">
            <?php echo $lin->texto; ?>
        </div>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-default btn-flat pull-left closed" data-dismiss="modal">Fechar</button>
    <a class="btn btn-primary btn-flat" href="editaPost.php?<?php echo $py.'='.$lin->idpost; ?>">Editar</a>
</div>
<script async src="js/apart.min.js"></script>
<?php
                unset($lin);
            }
            else {
                echo'
                <div class="callout">
                    <h4>Par&acirc;mentro incorreto</h4>
                </div>';
            }

        unset($sql,$ret,$py,$lin);
    }
    catch(PDOException $e) {
        echo'Falha ao conectar o servidor '.$e->getMessage();
    }
?>
