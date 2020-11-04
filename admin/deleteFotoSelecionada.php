<?php
    $pyfolder = md5('folder');
    $arrayed = explode(',', $_GET[''.$pyfolder.'']);

        foreach($arrayed as $singled) {
            $arrayed2 = explode('/', $singled);
            $dir = $arrayed2[0].'/'.$arrayed2[1].'/';
            $del = unlink($singled);

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

                    unset($pon,$nitens,$itens,$listar,$arquivos);
                }

            unset($dir,$del);
        }

    unset($pyfolder,$arrayed,$arrayed2,$singled);
?>
