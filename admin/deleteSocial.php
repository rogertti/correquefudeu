<?php
    /* EXCLUIR REDE SOCIAL */

    try {
        include_once('conexao.php');

        $py = md5('idsocial');
        $sql = $pdo->prepare("DELETE FROM social WHERE idsocial = :idsocial");
        $sql->bindParam(':idsocial', $_GET[''.$py.''], PDO::PARAM_INT);
        $res = $sql->execute();

            if(!$res) {
                var_dump($sql->errorInfo());
                exit;
            }
            else {
                header('location:social');
            }

        unset($pdo,$sql,$res,$py);
    }
    catch(PDOException $e) {
        echo 'Erro ao conectar o servidor '.$e->getMessage();
    }
?>
