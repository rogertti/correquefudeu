<?php
    /* CONTROLE DE VARIAVEL */

    $msg = "Campo obrigat&oacute;rio vazio.";

        if(empty($_POST['rand'])) {die("Vari&aacute;vel de controle nula."); }
        if(empty($_POST['idsocial'])) {die("Vari&aacute;vel de controle nula."); }
        if(empty($_POST['rede'])) { die($msg); } else { $filtro = 1; }
        if(empty($_POST['url'])) { die($msg); } else { $filtro++; }

        if($filtro == 2) {
            try {
                include_once('conexao.php');

                /* CONTROLE DE DUPLICATAS */

                $sql = $pdo->prepare("SELECT idsocial FROM social WHERE rede = :rede AND idsocial <> :idsocial");
                $sql->bindParam(':rede', $_POST['rede'], PDO::PARAM_STR);
                $sql->bindParam(':idsocial', $_POST['idsocial'], PDO::PARAM_STR);
                $sql->execute();
                $ret = $sql->rowCount();

                    if($ret > 0) {
                        die('Escolha outra rede social.');
                    }

                unset($sql,$ret);

                /* TENTA ATUALIZAR NO BANCO */

                $sql = $pdo->prepare("UPDATE social SET rede = :rede,url = :url WHERE idsocial = :idsocial");
                $sql->bindParam(':rede', $_POST['rede'], PDO::PARAM_STR);
                $sql->bindParam(':url', $_POST['url'], PDO::PARAM_STR);
                $sql->bindParam(':idsocial', $_POST['idsocial'], PDO::PARAM_INT);
                $res = $sql->execute();

                    if(!$res) {
                        var_dump($sql->errorInfo());
                        exit;
                    }
                    else {
                        echo'true';
                    }

                unset($pdo,$sql,$res);
            }
            catch(PDOException $e) {
                echo'Falha ao conectar o servidor '.$e->getMessage();
            }
        } //if filtro

    unset($msg,$filtro);
?>
