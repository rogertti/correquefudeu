<?php
    $arquivo = fopen('conexao.php','w+');
                                fwrite($arquivo,'<?php'.PHP_EOL);
                                fwrite($arquivo,chr(9).'define("DB_TYPE","mysql");'.PHP_EOL);
                                fwrite($arquivo,chr(9).'define("DB_HOST","localhost");'.PHP_EOL);
                                fwrite($arquivo,chr(9).'define("DB_USER","root");'.PHP_EOL);
                                fwrite($arquivo,chr(9).'define("DB_PASS","root");'.PHP_EOL);
                                fwrite($arquivo,chr(9).'define("DB_DATA","sahsilva");'.PHP_EOL);
fwrite($arquivo,chr(9).''.PHP_EOL);
                                fwrite($arquivo,chr(9).'$pdo = new PDO("".DB_TYPE.":host=".DB_HOST.";dbname=".DB_DATA."",DB_USER,DB_PASS);'.PHP_EOL);
                                fwrite($arquivo,chr(9).'$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);'.PHP_EOL);
                                fwrite($arquivo,chr(9).'$pdo->exec("SET NAMES utf8");'.PHP_EOL);
                                fwrite($arquivo,'?>');
                                fclose($arquivo);
?>
