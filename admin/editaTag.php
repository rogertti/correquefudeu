<?php
    try {
        include_once('conexao.php');

        /* BUSCA DADOS DA REDE SOCIAL */

        $py = md5('idtag');
        $sql = $pdo->prepare("SELECT idtag,descricao FROM tag WHERE idtag = :idtag");
        $sql->bindParam(':idtag', $_GET[''.$py.''], PDO::PARAM_INT);
        $sql->execute();
        $ret = $sql->rowCount();

            if($ret > 0) {
                $lin = $sql->fetch(PDO::FETCH_OBJ);
?>
<form class="form-edita-tag">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">Editar tag <small>(<i class="fa fa-asterisk"></i> Campo obrigat&oacute;rio)</small></h4>
    </div>
    <div class="modal-body">
        <input type="hidden" id="idtag" value="<?php echo $lin->idtag; ?>">

        <div class="form-group">
            <label for="tag"><i class="fa fa-asterisk"></i> Tag</label>
            <input type="text" id="descricao-" class="form-control" maxlength="45" title="Digite o nome da tag" value="<?php echo $lin->descricao; ?>" placeholder="Tag" required>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-default btn-flat pull-left closed" data-dismiss="modal">Fechar</button>
        <button type="submit" class="btn btn-primary btn-flat btn-submit-edita-tag">Salvar</button>
    </div>
</form>
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

        unset($pdo,$sql,$ret,$py);
    }
    catch(PDOException $e) {
        echo'Falha ao conectar o servidor '.$e->getMessage();
    }
?>
