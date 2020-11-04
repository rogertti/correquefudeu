<?php
    /* CONTROLE DE VARIAVEL */

    $msg = "Campo obrigat&oacute;rio vazio.";

        if(empty($_POST['rand'])) {die("Vari&aacute;vel de controle nula."); }
        if(empty($_POST['idautor'])) {die("Vari&aacute;vel de controle nula."); }
        if(empty($_POST['nome'])) { die($msg); } else {
            $filtro = 1;

            $_POST['nome'] = str_replace("'","&#39;",$_POST['nome']);
            $_POST['nome'] = str_replace('"','&#34;',$_POST['nome']);
            $_POST['nome'] = str_replace('%','&#37;',$_POST['nome']);
        }
        if(empty($_POST['usuario'])) { die($msg); } else { $filtro++; }
        if(empty($_POST['senha'])) { die($msg); } else { $filtro++; }
        if(empty($_POST['email'])) { die($msg); } else { $filtro++; }

        if($filtro == 4) {
            try {
                include_once('conexao.php');

                /* CONTROLE DE DUPLICATAS */

                $sql = $pdo->prepare("SELECT idautor FROM autor WHERE usuario = :usuario AND idautor <> :idautor");
                $sql->bindParam(':usuario', $_POST['usuario'], PDO::PARAM_STR);
                $sql->bindParam(':idautor', $_POST['idautor'], PDO::PARAM_INT);
                $sql->execute();
                $ret = $sql->rowCount();

                    if($ret > 0) {
                        die('Escolha outro nome de usu&aacute;rio.');
                    }

                unset($sql,$ret);

                /* TENTA ATUALIZAR NO BANCO */

                $sql = $pdo->prepare("UPDATE autor SET nome = :nome,usuario = :usuario,senha = :senha,email = :email WHERE idautor = :idautor");
                $sql->bindParam(':nome', $_POST['nome'], PDO::PARAM_STR);
                $sql->bindParam(':usuario', $_POST['usuario'], PDO::PARAM_STR);
                $sql->bindParam(':senha', $_POST['senha'], PDO::PARAM_STR);
                $sql->bindParam(':email', $_POST['email'], PDO::PARAM_STR);
                $sql->bindParam(':idautor', $_POST['idautor'], PDO::PARAM_INT);
                $res = $sql->execute();

                    if(!$res) {
                        var_dump($sql->errorInfo());
                        exit;
                    }
                    else {
                        echo'true';
                    }

                unset($pdo,$sql,$res,$chave);
            }
            catch(PDOException $e) {
                echo'Falha ao conectar o servidor '.$e->getMessage();
            }
        } //if filtro

    unset($msg,$filtro);
?>
