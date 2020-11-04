<?php
    try {
        include_once('conexao.php');

        /* BUSCA DADOS DO AUTOR */

        $py = md5('idautor');
        $sql = $pdo->prepare("SELECT idautor,nome,usuario,senha,email FROM autor WHERE idautor = :idautor");
        $sql->bindParam(':idautor', $_GET[''.$py.''], PDO::PARAM_INT);
        $sql->execute();
        $ret = $sql->rowCount();

            if($ret > 0) {
                $lin = $sql->fetch(PDO::FETCH_OBJ);
?>
<form class="form-edita-autor">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">Editar os dados do autor <small>(<i class="fa fa-asterisk"></i> Campo obrigat&oacute;rio)</small></h4>
    </div>
    <div class="modal-body">
        <input type="hidden" id="idautor" value="<?php echo $lin->idautor; ?>">

        <div class="form-group">
            <label for="nome"><i class="fa fa-asterisk"></i> Nome</label>
            <input type="text" id="nome-" class="form-control" maxlength="255" title="Digite o nome" value="<?php echo $lin->nome; ?>" placeholder="Nome" required>
        </div>
        <div class="form-group">
            <label for="usuario"><i class="fa fa-asterisk"></i> Usu&aacute;rio</label>
            <div class="input-group col-md-4">
                <input type="text" id="usuario-" class="form-control" maxlength="10" title="Digite o usu&aacute;rio" value="<?php echo base64_decode($lin->usuario); ?>" placeholder="Usu&aacute;rio" required>
            </div>
        </div>
        <div class="form-group">
            <label for="senha"><i class="fa fa-asterisk"></i> Senha</label>
            <div class="input-group col-md-4">
                <input type="password" id="senha-" class="form-control" maxlength="10" title="Digite a senha" value="<?php echo base64_decode($lin->senha); ?>" placeholder="Senha" required>
            </div>
        </div>
        <div class="form-group">
            <label for="email"><i class="fa fa-asterisk"></i> Email</label>
            <input type="email" id="email-" class="form-control" maxlength="100" title="Digite o email" value="<?php echo $lin->email; ?>" placeholder="Email" required>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-default btn-flat pull-left closed" data-dismiss="modal">Fechar</button>
        <button type="submit" class="btn btn-primary btn-flat btn-submit-edita-autor">Salvar</button>
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
