<?php
    /* CONTROLE DE VARIAVEL */

    $msg = "Campo obrigat&oacute;rio vazio.";

        if(empty($_POST['rand'])) {die("Vari&aacute;vel de controle nula."); }
        if(empty($_POST['idautor'])) {die("Vari&aacute;vel de controle nula."); }
        if(empty($_FILES['midia'])) { die($msg); } else {
            $filtro = 1;

            if($_FILES['midia']['size'] > '2000000') {
                die('Essa foto ultrapassa 2MB.');
            }
            elseif(($_FILES['midia']['type'] == 'image/jpg') or ($_FILES['midia']['type'] == 'image/jpeg') or ($_FILES['midia']['type'] == 'image/png')) {
                $dir = 'midiaSobre/';
                $remete  = $_FILES['midia']['tmp_name'];
                $destino  = $dir.$_FILES['midia']['name'];
                $move = move_uploaded_file($remete,$destino);

                    if(!$move) {
                        die('Erro ao fazer o upload.');
                    }
                    else {
                        $py = md5($_FILES['midia']['tmp_name']);
                        $ext = strrchr($_FILES['midia']['name'],'.');
                        $ren = rename($destino,$dir.$py.$ext);

                            if(!$ren) {
                                if (file_exists($destino)) {
                                    $del = unlink($destino);
                                    unset($del);
                                    die('A imagem '.$py.$ext.' j&aacute; existe.');
                                }

                                die('Erro ao renomear a imagem.');
                            }
                            else {
                                $midia = $py.$ext;
                                include_once('thumbnail.php');
                                thumbnail($dir,$midia,815,600);
                            }

                        unset($py,$ext,$ren);
                    }

                unset($dir,$remete,$destino,$move);
            }
            else {
                die('Esse tipo de arquivo n&atilde;o &eacute; suportado.');
            }
        }
        if(empty($_POST['texto'])) { die($msg); } else {
            $filtro++;

            $_POST['texto'] = str_replace("'","&#39;",$_POST['texto']);
            $_POST['texto'] = str_replace('"','&#34;',$_POST['texto']);
            $_POST['texto'] = str_replace('%','&#37;',$_POST['texto']);
        }

        if($filtro == 2) {
            try {
                include_once('conexao.php');

                /* TENTA INSERIR NO BANCO */

                $sql = $pdo->prepare("INSERT INTO sobre (autor_idautor,midia,texto) VALUES (:idautor,:midia,:texto)");
                $sql->bindParam(':idautor', $_POST['idautor'], PDO::PARAM_INT);
                $sql->bindParam(':midia', $midia, PDO::PARAM_STR);
                $sql->bindParam(':texto', $_POST['texto'], PDO::PARAM_STR);
                $res = $sql->execute();

                    if(!$res) {
                        var_dump($sql->errorInfo());
                        exit;
                    }
                    else {
                        echo'true';
                    }

                unset($pdo,$sql,$res,$midia);
            }
            catch(PDOException $e) {
                echo'Falha ao conectar o servidor '.$e->getMessage();
            }
        } //if filtro

    unset($msg,$filtro);
?>
