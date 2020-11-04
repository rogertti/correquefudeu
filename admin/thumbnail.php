<?php
    //Thumbnail
    function thumbnail($diretorio,$imagem,$x,$y) {
        //$extensao = strtolower(end(explode('.', $imagem)));

        $value = explode(".", $imagem);
        $extensao = strtolower(array_pop($value));

        #$cp = copy($diretorio."/".$imagem,$diretorio."/"."tb-".$imagem);

            /*if (!$cp) {
                die('erro');
            }
            else {
                $imagem = "tb-".$imagem;
            }*/

        //Define o nome do novo thumbnail
        $thumbnail = explode('.', $imagem);
        #$thumbnail = $diretorio."/".$thumbnail[0]."_mini.".$extensao;
        $thumbnail = $diretorio."/".$thumbnail[0].".".$extensao;
        $imagem = $diretorio."/".$imagem;

            //Cria uma nova imagem da imagem original
            if ($extensao == 'jpg' || $extensao == 'jpeg'): $img_origem = imagecreatefromjpeg($imagem);
            elseif ($extensao == 'png'): $img_origem = imagecreatefrompng($imagem);
            elseif ($extensao == 'gif'): $img_origem = imagecreatefromgif($imagem);
            endif;

        //Recupera as dimensoes da imagem original
        $origem_x = imagesx($img_origem); //Largura
        $origem_y = imagesy($img_origem); //Altura

           //Se a imagem nao for proporcional ao thumbnail que se vai gerar
           //Pega a maior face e calcula a outra face proporcional a imagem original
           if ($origem_x > $origem_y): // Se a largura for maior que a altura
               $final_x = $x; //A largura sera a do thumbnail
               $final_y = floor( $x * $origem_y / $origem_x ); //Calculo a altura proporcional
               $f_x = 0; //Posiciono a imagem no x = 0
               $f_y = round( ( $y / 2 ) - ( $final_y / 2 ) ); //Centralizo a imagem no vertice y
           else: //Se a altura for maior ou igual a largura
               $final_y = $y; //A altura sera a do thumbnail
               $final_x = floor( $y * $origem_x / $origem_y ); //Calculo a largura proporcional
               $f_y = 0; //Posiciono a imagem no x = 0
               $f_x = round( ( $x / 2 ) - ( $final_x / 2 ) ); //Centralizo a imagem no vertice x
           endif;

        //Gero a nova imagem do thumbnail do tamanho $x X $y
        //$img_final = imagecreate($x,$y);
        $img_final = imagecreatetruecolor($x,$y);

        //background color
        //imagecolorallocate($img_final, 255, 255, 255);
        //imagefilter($img_final, IMG_FILTER_COLORIZE, 255, 255, 255);

        //Copio a imagem original para a imagem do thumbnail utilizando os dados que foram calculados
        imagecopyresized($img_final, $img_origem, $f_x, $f_y, 0, 0, $final_x, $final_y, $origem_x, $origem_y);

            //Salvo o novo thumbnail
            if ( $extensao == 'jpg' || $extensao == 'jpeg' ): imagejpeg($img_final, $thumbnail, 50);
            elseif ($extensao == 'png'): imagepng($img_final, $thumbnail);
            elseif ($extensao == 'gif'): imagegif($img_final, $thumbnail);
            endif;

        //progressive
        //imagejpeg($img_origem, $img_final, 50);
        imageinterlace($img_final, 1);

        //Destruo as imagens que foram utilizadas
        imagedestroy($img_origem);
        imagedestroy($img_final);

        unset($diretorio,$imagem,$x,$y,$extensao,$cp,$thumbnail,$img_origem,$img_final,$origem_x,$origem_y,$final_x,$final_y,$f_x,$f_y);
    }
?>
