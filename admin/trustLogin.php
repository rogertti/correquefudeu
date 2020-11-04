<?php
    session_start();

    /* CONTROLE DE VARIAVEL */

    $msg = "Campo obrigat&oacute;rio vazio.";

        if(empty($_POST['rand'])) {die("Vari&aacute;vel de controle nula."); }
        if(empty($_POST['usuario'])) { die($msg); } else { $filtro = 1; }
        if(empty($_POST['senha'])) { die($msg); } else { $filtro++; }

        if($filtro == 2) {
            try {
                include_once('conexao.php');

                /* VALIDANDO O LOGIN */

                $sql = $pdo->prepare("SELECT idautor,chave,acesso FROM autor WHERE usuario = :usuario AND senha = :senha");
                $sql->bindParam(':usuario', $_POST['usuario'], PDO::PARAM_STR);
                $sql->bindParam(':senha', $_POST['senha'], PDO::PARAM_STR);
                $sql->execute();
                $ret = $sql->rowCount();

                    if($ret > 0) {
                        $lin = $sql->fetch(PDO::FETCH_OBJ);

                        $_SESSION['id'] = $lin->idautor;
                        $_SESSION['key'] = $lin->chave;
                        $_SESSION['acc'] = $lin->acesso;
                        echo'true';

                        unset($lin);
                    }
                    else {
                        die('Login inv&aacute;lido.');
                    }

                unset($pdo,$sql,$ret);
            }
            catch(PDOException $e) {
                echo'Falha ao conectar o servidor '.$e->getMessage();
            }
        } //if filtro

    unset($msg,$filtro);
?>
