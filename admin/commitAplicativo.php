<?php
    /* CONTROLE DE VARIAVEL */

    $msg = "Campo obrigat&oacute;rio vazio.";

        if(empty($_POST['rand'])) {die("Vari&aacute;vel de controle nula."); }
        if(empty($_POST['servidor'])) { die($msg); } else { $filtro = 1; }
        if(empty($_POST['banco'])) { die($msg); } else { $filtro++; }
        if(empty($_POST['usuario_banco'])) { die($msg); } else { $filtro++; }
        if(!empty($_POST['senha_banco'])) {
            $_POST['senha_banco'] = base64_decode($_POST['senha_banco']);
        }
        if(empty($_POST['nome'])) { die($msg); } else {
            $filtro++;

            $_POST['nome'] = str_replace("'","&#39;",$_POST['nome']);
            $_POST['nome'] = str_replace('"','&#34;',$_POST['nome']);
            $_POST['nome'] = str_replace('%','&#37;',$_POST['nome']);
        }
        if(empty($_POST['usuario'])) { die($msg); } else {
            $filtro++;
            $chave = md5($_POST['usuario']);
            $acesso = 'A';
        }
        if(empty($_POST['senha'])) { die($msg); } else { $filtro++; }
        if(empty($_POST['email'])) { die($msg); } else { $filtro++; }

        if($filtro == 7) {
            try {
                #$pdo = new PDO('mysql:host='.$_POST['servidor'].';dbname=mysql',$_POST['usuario_banco'],$_POST['senha_banco']);
                $pdo = new PDO('mysql:host='.$_POST['servidor'].';dbname=',$_POST['usuario_banco'],$_POST['senha_banco']);
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $pdo->exec("SET NAMES utf8");

                /*$sql = $pdo->prepare("CREATE DATABASE IF NOT EXISTS :banco DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci");
                $sql->bindParam(':banco', $_POST['banco'], PDO::PARAM_STR);
                $res = $sql->execute();*/
                $res = $pdo->query("CREATE DATABASE IF NOT EXISTS ".$_POST['banco']." DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci");

                    if(!$res) {
                        die(var_dump($sql->errorInfo()));
                    }
                    else {
                        $count = 0;
                        $pdo->query("use ".$_POST['banco']."");

                        $sql = $pdo->prepare("CREATE TABLE IF NOT EXISTS `autor` (
                          `idautor` BIGINT NOT NULL AUTO_INCREMENT,
                          `nome` VARCHAR(255) NOT NULL,
                          `usuario` VARCHAR(20) NOT NULL,
                          `senha` VARCHAR(20) NOT NULL,
                          `email` VARCHAR(100) NOT NULL,
                          `chave` VARCHAR(45) NOT NULL,
                          `acesso` CHAR(1) NOT NULL COMMENT 'A = admin; U = usuario;',
                          PRIMARY KEY (`idautor`))
                        ENGINE = MyISAM");
                        $res = $sql->execute();

                            if(!$res) {
                                die(var_dump($sql->errorInfo()));
                            }
                            else {
                                $count++;
                            }

                        $sql = $pdo->prepare("INSERT INTO autor (nome,usuario,senha,email,chave,acesso) VALUES (:nome,:usuario,:senha,:email,:chave,:acesso)");
                        $sql->bindParam(':nome', $_POST['nome'], PDO::PARAM_STR);
                        $sql->bindParam(':usuario', $_POST['usuario'], PDO::PARAM_STR);
                        $sql->bindParam(':senha', $_POST['senha'], PDO::PARAM_STR);
                        $sql->bindParam(':email', $_POST['email'], PDO::PARAM_STR);
                        $sql->bindParam(':chave', $chave, PDO::PARAM_STR);
                        $sql->bindParam(':acesso', $acesso, PDO::PARAM_STR);
                        $res = $sql->execute();

                            if(!$res) {
                                die(var_dump($sql->errorInfo()));
                            }
                            else {
                                $count++;
                            }

                        $sql = $pdo->prepare("CREATE TABLE IF NOT EXISTS `sobre` (
                          `idsobre` BIGINT NOT NULL AUTO_INCREMENT,
                          `autor_idautor` BIGINT NOT NULL,
                          `texto` LONGTEXT NOT NULL,
                          `midia` VARCHAR(100) NOT NULL,
                          PRIMARY KEY (`idsobre`),
                          INDEX `fk_sobre_autor1_idx` (`autor_idautor` ASC))
                        ENGINE = MyISAM");
                        $res = $sql->execute();

                            if(!$res) {
                                die(var_dump($sql->errorInfo()));
                            }
                            else {
                                $count++;
                            }

                        $sql = $pdo->prepare("CREATE TABLE IF NOT EXISTS `social` (
                          `idsocial` BIGINT NOT NULL AUTO_INCREMENT,
                          `autor_idautor` BIGINT NOT NULL,
                          `rede` VARCHAR(45) NOT NULL,
                          `url` VARCHAR(255) NOT NULL,
                          PRIMARY KEY (`idsocial`),
                          INDEX `fk_social_autor1_idx` (`autor_idautor` ASC))
                        ENGINE = MyISAM");
                        $res = $sql->execute();

                            if(!$res) {
                                die(var_dump($sql->errorInfo()));
                            }
                            else {
                                $count++;
                            }

                        $sql = $pdo->prepare("CREATE TABLE IF NOT EXISTS `post` (
                          `idpost` BIGINT NOT NULL AUTO_INCREMENT,
                          `autor_idautor` BIGINT NOT NULL,
                          `datado` DATE NOT NULL,
                          `hora` TIME NOT NULL,
                          `titulo` VARCHAR(100) NOT NULL,
                          `texto` LONGTEXT NOT NULL,
                          `midia` VARCHAR(255) NULL,
                          `url` VARCHAR(45) NOT NULL,
                          PRIMARY KEY (`idpost`),
                          INDEX `fk_post_autor1_idx` (`autor_idautor` ASC))
                        ENGINE = MyISAM");
                        $res = $sql->execute();

                            if(!$res) {
                                die(var_dump($sql->errorInfo()));
                            }
                            else {
                                $count++;
                            }

                        $sql = $pdo->prepare("CREATE TABLE IF NOT EXISTS `tag` (
                          `idtag` BIGINT NOT NULL AUTO_INCREMENT,
                          `descricao` VARCHAR(45) NOT NULL,
                          PRIMARY KEY (`idtag`))
                        ENGINE = MyISAM");
                        $res = $sql->execute();

                            if(!$res) {
                                die(var_dump($sql->errorInfo()));
                            }
                            else {
                                $count++;
                            }

                        $sql = $pdo->prepare("CREATE TABLE IF NOT EXISTS `post_has_tag` (
                          `post_idpost` BIGINT NOT NULL,
                          `tag_idtag` BIGINT NOT NULL,
                          PRIMARY KEY (`post_idpost`, `tag_idtag`),
                          INDEX `fk_post_has_tag_tag1_idx` (`tag_idtag` ASC),
                          INDEX `fk_post_has_tag_post_idx` (`post_idpost` ASC))
                        ENGINE = MyISAM");
                        $res = $sql->execute();

                            if(!$res) {
                                die(var_dump($sql->errorInfo()));
                            }
                            else {
                                $count++;
                            }

                            if($count == 7) {
                                //criando o arquivo de conex&atilde;o
                                $arquivo = fopen('conexao.php','w+');
                                fwrite($arquivo,'<?php'.PHP_EOL);
                                fwrite($arquivo,chr(9).'define("DB_TYPE","mysql");'.PHP_EOL);
                                fwrite($arquivo,chr(9).'define("DB_HOST","'.$_POST['servidor'].'");'.PHP_EOL);
                                fwrite($arquivo,chr(9).'define("DB_USER","'.$_POST['usuario_banco'].'");'.PHP_EOL);
                                fwrite($arquivo,chr(9).'define("DB_PASS","'.$_POST['senha_banco'].'");'.PHP_EOL);
                                fwrite($arquivo,chr(9).'define("DB_DATA","'.$_POST['banco'].'");'.PHP_EOL);
                                fwrite($arquivo,chr(9).''.PHP_EOL);
                                fwrite($arquivo,chr(9).'$pdo = new PDO("".DB_TYPE.":host=".DB_HOST.";dbname=".DB_DATA."",DB_USER,DB_PASS);'.PHP_EOL);
                                fwrite($arquivo,chr(9).'$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);'.PHP_EOL);
                                fwrite($arquivo,chr(9).'$pdo->exec("SET NAMES utf8");'.PHP_EOL);
                                fwrite($arquivo,'?>');
                                fclose($arquivo);

                                rename('installAplicativo.php','installAplicativoDone.php');
                                echo'true';
                            }
                            else {
                                die('Par&acirc;metro incorreto.');
                            }

                        unset($count,$chave,$acesso);
                    }

                unset($pdo,$sql,$res);
            }
            catch(PDOException $e) {
                echo'Falha ao conectar o servidor '.$e->getMessage();
            }
        } //if filtro

    unset($msg,$filtro);
?>
