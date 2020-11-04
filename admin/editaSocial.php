<?php
    try {
        include_once('conexao.php');

        /* BUSCA DADOS DA REDE SOCIAL */

        $py = md5('idsocial');
        $sql = $pdo->prepare("SELECT idsocial,rede,url FROM social WHERE idsocial = :idsocial");
        $sql->bindParam(':idsocial', $_GET[''.$py.''], PDO::PARAM_INT);
        $sql->execute();
        $ret = $sql->rowCount();

            if($ret > 0) {
                $lin = $sql->fetch(PDO::FETCH_OBJ);
?>
<form class="form-edita-social">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">Editar os dados da rede social <small>(<i class="fa fa-asterisk"></i> Campo obrigat&oacute;rio)</small></h4>
    </div>
    <div class="modal-body">
        <input type="hidden" id="idsocial" value="<?php echo $lin->idsocial; ?>">

        <div class="form-group">
            <label for="rede"><i class="fa fa-asterisk"></i> Rede</label>
            <div class="input-group col-md-4">
                <select id="rede-" class="form-control" required>
                <?php
                    if($lin->rede == "Dribbble") { echo'<option value="Dribbble" selected>Dribbble</option>'; } else { echo'<option value="Dribbble">Dribbble</option>'; }
                    if($lin->rede == "Facebook") { echo'<option value="Facebook" selected>Facebook</option>'; } else { echo'<option value="Facebook">Facebook</option>'; }
                    if($lin->rede == "Google") { echo'<option value="Google" selected>Google &#43;</option>'; } else { echo'<option value="Google">Google &#43;</option>'; }
                    if($lin->rede == "Instagram") { echo'<option value="Instagram" selected>Instagram</option>'; } else { echo'<option value="Instagram">Instagram</option>'; }
                    if($lin->rede == "LinkedIn") { echo'<option value="LinkedIn" selected>LinkedIn</option>'; } else { echo'<option value="LinkedIn">LinkedIn</option>'; }
                    if($lin->rede == "Pinterest") { echo'<option value="Pinterest" selected>Pinterest</option>'; } else { echo'<option value="Pinterest">Pinterest</option>'; }
                    if($lin->rede == "Twitter") { echo'<option value="Twitter" selected>Twitter</option>'; } else { echo'<option value="Twitter">Twitter</option>'; }
                    if($lin->rede == "Youtube") { echo'<option value="Youtube" selected>Youtube</option>'; } else { echo'<option value="Youtube">Youtube</option>'; }
                ?>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label for="url"><i class="fa fa-asterisk"></i> URL</label>
            <input type="url" id="url-" class="form-control" maxlength="255" value="<?php echo $lin->url; ?>" title="Digite o endere&ccedil;o web" placeholder="URL" required>
            <p class="help-block">Exemplo: <strong>https://www.exemplo.com</strong></p>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-default btn-flat pull-left closed" data-dismiss="modal">Fechar</button>
        <button type="submit" class="btn btn-primary btn-flat btn-submit-edita-social">Salvar</button>
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
