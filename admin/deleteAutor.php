<?php
    /* EXCLUIR AUTOR */

    try {
        include_once('conexao.php');

        $py = md5('idautor');

        //EXCLUINDO SOBRE

        $sql = $pdo->prepare("SELECT sobre.autor_idautor FROM autor,sobre WHERE sobre.autor_idautor = autor.idautor AND autor.idautor = :idautor");
        $sql->bindParam(':idautor', $_GET[''.$py.''], PDO::PARAM_INT);
        $res = $sql->execute();
        $ret = $sql->rowCount();

            if($ret > 0) {
                $sql = $pdo->prepare("DELETE FROM sobre WHERE autor_idautor = :idautor");
                $sql->bindParam(':idautor', $_GET[''.$py.''], PDO::PARAM_INT);
                $res = $sql->execute();

                    if(!$res) {
                        var_dump($sql->errorInfo());
                        exit;
                    }
            }

        unset($sql,$res,$ret);

        //EXCLUINDO SOCIAL

        $sql = $pdo->prepare("SELECT social.autor_idautor FROM autor,social WHERE social.autor_idautor = autor.idautor AND autor.idautor = :idautor");
        $sql->bindParam(':idautor', $_GET[''.$py.''], PDO::PARAM_INT);
        $res = $sql->execute();
        $ret = $sql->rowCount();

            if($ret > 0) {
                $sql = $pdo->prepare("DELETE FROM social WHERE autor_idautor = :idautor");
                $sql->bindParam(':idautor', $_GET[''.$py.''], PDO::PARAM_INT);
                $res = $sql->execute();

                    if(!$res) {
                        var_dump($sql->errorInfo());
                        exit;
                    }
            }

        unset($sql,$res,$ret);

        //EXCLUINDO POST

        $sql = $pdo->prepare("SELECT post.idpost FROM autor,post WHERE post.autor_idautor = autor.idautor AND autor.idautor = :idautor");
        $sql->bindParam(':idautor', $_GET[''.$py.''], PDO::PARAM_INT);
        $res = $sql->execute();
        $ret = $sql->rowCount();

            if($ret > 0) {
                $lin = $sql->fetchAll(PDO::FETCH_ASSOC);
                $posts = array_column($lin, 'idpost');
                $idpost = implode(',', $posts);
                $sql = sprintf("SELECT DISTINCT post_has_tag.post_idpost FROM post_has_tag,post WHERE post_has_tag.post_idpost = post.idpost AND post.idpost IN(%s)", $idpost);
                $sql = $pdo->prepare($sql);
                $sql->execute();
                $ret = $sql->rowCount();

                    if($ret > 0) {
                        while($lin = $sql->fetch(PDO::FETCH_OBJ)) {
                            $sql = $pdo->prepare("DELETE FROM post_has_tag WHERE post_idpost = :idpost");
                            $sql->bindParam(':idpost', $lin->post_idpost, PDO::PARAM_INT);
                            $res = $sql->execute();

                            if(!$res) {
                                var_dump($sql->errorInfo());
                                exit;
                            }
                        }
                    }

                $sql = $pdo->prepare("DELETE FROM post WHERE autor_idautor = :idautor");
                $sql->bindParam(':idautor', $_GET[''.$py.''], PDO::PARAM_INT);
                $res = $sql->execute();

                    if(!$res) {
                        var_dump($sql->errorInfo());
                        exit;
                    }

                unset($lin,$posts,$idpost);
            }

        unset($sql,$res,$ret);

        //EXCLUINDO O AUTOR

        $sql = $pdo->prepare("DELETE FROM autor WHERE idautor = :idautor");
        $sql->bindParam(':idautor', $_GET[''.$py.''], PDO::PARAM_INT);
        $res = $sql->execute();

            if(!$res) {
                var_dump($sql->errorInfo());
                exit;
            }
            else {
                header('location:sair');
            }

        unset($pdo,$sql,$res,$py);
    }
    catch(PDOException $e) {
        echo 'Erro ao conectar o servidor '.$e->getMessage();
    }
?>
