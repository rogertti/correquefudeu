<?php
    $pyidpost = md5('idpost');
    $pytipo = md5('tipo');
    $pymidia = md5('midia');

    try {
        include_once('conexao.php');

        switch($_GET[''.$pytipo.'']) {
            case 'imagem':
                $sql = $pdo->prepare("UPDATE post SET midia = '' WHERE idpost = :idpost");
                $sql->bindParam(':idpost', $_GET[''.$pyidpost.''], PDO::PARAM_INT);
                $res = $sql->execute();

                    if(!$res) {
                        var_dump($sql->errorInfo());
                        exit;
                    }
                    else {
                        $unk = unlink('midiaPost/'.$_GET[''.$pymidia.''].'');

                            if(!$unk) {
                                die('Ocorreu um erro ao excluir a imagem.');
                            }
                            else {
                                header('location:editaPost.php?'.$pyidpost.'='.$_GET[''.$pyidpost.''].'');
                            }
                    }

                unset($sql,$res);
            break;

            case 'video':
                $sql = $pdo->prepare("UPDATE post SET midia = '' WHERE idpost = :idpost");
                $sql->bindParam(':idpost', $_GET[''.$pyidpost.''], PDO::PARAM_INT);
                $res = $sql->execute();

                    if(!$res) {
                        var_dump($sql->errorInfo());
                        exit;
                    }
                    else {
                        header('location:editaPost.php?'.$pyidpost.'='.$_GET[''.$pyidpost.''].'');
                    }

                unset($sql,$res);
            break;
        }

        unset($pdo);
    }
    catch(PDOException $e) {
        echo 'Erro ao conectar o servidor '.$e->getMessage();
    }
?>
