<?php
    /* CONTROLE DE VARIAVEL */

    $msg = "Campo obrigat&oacute;rio vazio.";

        if(empty($_POST['rand'])) {die("Vari&aacute;vel de controle nula."); }
        if(empty($_POST['idautor'])) {die("Vari&aacute;vel de controle nula."); }
        if(empty($_POST['rede'])) { die($msg); } else { $filtro = 1; }
        if(empty($_POST['url'])) { die($msg); } else { $filtro++; }

        if($filtro == 2) {
            try {
                include_once('conexao.php');

                /* CONTROLE DE DUPLICATAS */

                $sql = $pdo->prepare("SELECT idsocial FROM social WHERE rede = :rede");
                $sql->bindParam(':rede', $_POST['rede'], PDO::PARAM_STR);
                $sql->execute();
                $ret = $sql->rowCount();

                    if($ret > 0) {
                        die('Escolha outra rede social.');
                    }

                unset($sql,$ret);

                /* TENTA INSERIR NO BANCO */

                $sql = $pdo->prepare("INSERT INTO social (autor_idautor,rede,url) VALUES (:idautor,:rede,:url)");
                $sql->bindParam(':idautor', $_POST['idautor'], PDO::PARAM_INT);
                $sql->bindParam(':rede', $_POST['rede'], PDO::PARAM_STR);
                $sql->bindParam(':url', $_POST['url'], PDO::PARAM_STR);
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
