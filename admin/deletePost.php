<?php
    ini_set('display_errors','on');
    try {
        include_once('conexao.php');

        $py = md5('idpost');

        /* EXCLUIR TAGS DO POST */

        $sql = $pdo->prepare("SELECT post_has_tag.post_idpost,post.midia FROM post_has_tag,post WHERE post_has_tag.post_idpost = post.idpost AND post.idpost = :idpost");
        $sql->bindParam(':idpost', $_GET[''.$py.''], PDO::PARAM_INT);
        $res = $sql->execute();
        $ret = $sql->rowCount();

            if($ret > 0) {
                $sql = $pdo->prepare("DELETE FROM post_has_tag WHERE post_idpost = :idpost");
                $sql->bindParam(':idpost', $_GET[''.$py.''], PDO::PARAM_INT);
                $res = $sql->execute();

                    if(!$res) {
                        var_dump($sql->errorInfo());
                        exit;
                    }
                    else {
                        // SELECIONANDO A MIDIA DO POST

                        $sql = $pdo->prepare("SELECT midia FROM post WHERE idpost = :idpost");
                        $sql->bindParam(':idpost', $_GET[''.$py.''], PDO::PARAM_INT);
                        $res = $sql->execute();
                        $ret = $sql->rowCount();

                            if($ret > 0) {
                                $lin = $sql->fetch(PDO::FETCH_OBJ);
                                $midia = $lin->midia;
                            }

                        // EXCLUIR O POST

                        $sql = $pdo->prepare("DELETE FROM post WHERE idpost = :idpost");
                        $sql->bindParam(':idpost', $_GET[''.$py.''], PDO::PARAM_INT);
                        $res = $sql->execute();

                            if(!$res) {
                                var_dump($sql->errorInfo());
                                exit;
                            }
                            else {
                                // EXCLUIR MIDIA

                                if((strstr($midia,'.jpg')) or (strstr($midia,'.jpeg')) or (strstr($midia,'.png'))) {
                                    $unk = unlink('midiaPost/'.$midia.'');

                                        if(!$unk) {
                                            die('Ocorreu um erro ao excluir a imagem.');
                                        }
                                        else {
                                            header('location:inicio');
                                        }

                                    unset($unk);
                                }
                                else {
                                    $dir = 'midiaPost/'.$midia.'/';

                                        if(file_exists($dir)) {
                                            $pon = opendir($dir);

                                                while ($nitens = readdir($pon)) {
                                                    $itens[] = $nitens;
                                                }

                                            sort($itens);

                                                foreach ($itens as $listar) {
                                                    if ($listar != "." && $listar != "..") {
                                                        //$arquivos[] = $listar;
                                                        unlink($dir.$listar);
                                                    }
                                                }

                                            rmdir($dir);
                                            header('location:inicio');
                                        }

                                    unset($dir,$exp,$pon,$nitens,$itens,$listar,$arquivos);
                                } // else
                            } // else
                    } //else
            } // $ret
            else {
                // SELECIONANDO A MIDIA DO POST

                $sql = $pdo->prepare("SELECT midia FROM post WHERE idpost = :idpost");
                $sql->bindParam(':idpost', $_GET[''.$py.''], PDO::PARAM_INT);
                $res = $sql->execute();
                $ret = $sql->rowCount();

                    if($ret > 0) {
                        $lin = $sql->fetch(PDO::FETCH_OBJ);
                        $midia = $lin->midia;
                    }

                // EXCLUIR O POST

                $sql = $pdo->prepare("DELETE FROM post WHERE idpost = :idpost");
                $sql->bindParam(':idpost', $_GET[''.$py.''], PDO::PARAM_INT);
                $res = $sql->execute();

                    if(!$res) {
                        var_dump($sql->errorInfo());
                        exit;
                    }
                    else {
                        // EXCLUIR MIDIA

                        if((strstr($midia,'.jpg')) or (strstr($midia,'.jpeg')) or (strstr($midia,'.png'))) {
                            $unk = unlink('midiaPost/'.$midia.'');

                                if(!$unk) {
                                    die('Ocorreu um erro ao excluir a imagem.');
                                }
                                else {
                                    header('location:inicio');
                                }

                            unset($unk);
                        }
                        else {
                            $dir = 'midiaPost/'.$midia.'/';

                                if(file_exists($dir)) {
                                    $pon = opendir($dir);

                                        while ($nitens = readdir($pon)) {
                                            $itens[] = $nitens;
                                        }

                                    sort($itens);

                                        foreach ($itens as $listar) {
                                            if ($listar != "." && $listar != "..") {
                                                //$arquivos[] = $listar;
                                                unlink($dir.$listar);
                                            }
                                        }

                                    rmdir($dir);
                                    header('location:inicio');
                                }

                            unset($dir,$exp,$pon,$nitens,$itens,$listar,$arquivos);
                        } // else
                    } // else
            } //else

        unset($pdo,$sql,$ret,$res,$py,$lin,$midia);
    }
    catch(PDOException $e) {
        echo 'Erro ao conectar o servidor '.$e->getMessage();
    }
?>
