<?php
ini_set('memory_limit', '-1');




$file = fopen("corpus_equalized.txt", "r");


$index = 0;
while (!feof($file) && $index<5000) {
    $index++;
    $line       = fgets($file);
    $subcat     = explode("||SEPARATOR||", $line);
    $snippets[] = $subcat[1];
    $urls[]     = $subcat[0];
}

fclose($file);







echo "Data Unset\n";
//print_r($urls);
include("FLSI.php");

$lsi = new LatentSem();

$lsi->latent($snippets, $urls, array(), '');









?>