<?php
    $pyfolder = md5('folder');
    $exp = explode('/',$_GET[''.$pyfolder.'']);
    $dir = $exp[0].'/'.$exp[1].'/';
    $del = unlink($_GET[''.$pyfolder.'']);

        if(!$del) {
            die('Erro ao excluir a foto.');
        }
        else {
            if(file_exists($dir)) {
                $pon = opendir($dir);

                    while ($nitens = readdir($pon)) {
                        $itens[] = $nitens;
                    }

                sort($itens);

                    foreach ($itens as $listar) {
                        if ($listar != "." && $listar != "..") {
                            $arquivos[] = $listar;
                        }
                    }

                    if(empty($arquivos)) {
                        rmdir($dir);
                        unset($_SESSION['folder']);
                    }
            }
        }

    unset($pyfolder,$del,$dir,$exp,$pon,$nitens,$itens,$listar,$arquivos);
?>
