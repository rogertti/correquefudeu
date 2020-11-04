<?php
    /* CONTROLE DE VARIAVEL */

    $msg = "Campo obrigat&oacute;rio vazio.";

        if(empty($_POST['rand'])) {die("Vari&aacute;vel de controle nula."); }
        if(empty($_POST['email'])) { die($msg); } else { $filtro = 1; }

        if($filtro == 1) {
            try {
                include_once('conexao.php');

                /* BUSCANDO A SENHA */

                $sql = $pdo->prepare("SELECT senha FROM autor WHERE email = :email");
                $sql->bindParam(':email', $_POST['email'], PDO::PARAM_STR);
                $sql->execute();
                $ret = $sql->rowCount();

                    if($ret > 0) {
                        $lin = $sql->fetch(PDO::FETCH_OBJ);

                        /* ENVIANDO A SENHA POR EMAIL */

                        #ini_set('SMTP','smtp.camboriu.sc.gov.br');
                        #ini_set('smtp_port',587);

                        $nome = "Blog SahSilva";
                        $remetente = "lab@embracore.com.br";
                        $assunto = "Recupere a sua senha";
                        $header = implode("\n",array("From: $nome <$remetente>","Subject: $assunto","Return-Path: $remetente","MIME-Version: 1.0","X-Priority: 3","Content-Type: text/html; charset=iso-8859-1"));
                        $conteudo = 'A sua senha é <strong>'.base64_decode($lin->senha).'</strong>';

                            if(!mail($_POST['email'],$assunto,$conteudo,$header)) {
                                die('A senha n&atilde;o foi enviada.');
                            }
                            else {
                                echo'true';
                            }

                        unset($lin,$nome,$remetente,$assunto,$header,$conteudo);
                    }

                unset($pdo,$sql,$ret);
            }
            catch(PDOException $e) {
                echo'Falha ao conectar o servidor '.$e->getMessage();
            }
        } //if filtro

    unset($msg,$filtro);
?>
