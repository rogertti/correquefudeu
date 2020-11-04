<?php
    /* EXCLUIR TAG */

    try {
        include_once('conexao.php');

        $py = md5('idtag');
        $sql = $pdo->prepare("DELETE FROM tag WHERE idtag = :idtag");
        $sql->bindParam(':idtag', $_GET[''.$py.''], PDO::PARAM_INT);
        $res = $sql->execute();

            if(!$res) {
                var_dump($sql->errorInfo());
                exit;
            }
            else {
                header('location:tag');
            }

        unset($pdo,$sql,$res,$py);
    }
    catch(PDOException $e) {
        echo 'Erro ao conectar o servidor '.$e->getMessage();
    }
?>
