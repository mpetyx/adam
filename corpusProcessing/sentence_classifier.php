<?php
class corpusCreator{
protected $corpus;
private function hitFormPost($loginURL, $loginFields, $referer, $cookieString){
     	$ch = curl_init();
     	curl_setopt($ch, CURLOPT_COOKIEJAR, "cookies.txt");
     	curl_setopt($ch, CURLOPT_COOKIEFILE, "cookies.txt");   
    	curl_setopt($ch, CURLOPT_COOKIESESSION, true);
    	curl_setopt($ch, CURLOPT_FAILONERROR, false);
     	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
     	curl_setopt($ch, CURLOPT_VERBOSE, 0);
     	curl_setopt($ch, CURLOPT_ENCODING, 'gzip,deflate,sdch');
     	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
     	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
     	curl_setopt($ch, CURLOPT_FRESH_CONNECT, true);
     	curl_setopt($ch, CURLOPT_HEADER, false);
     	curl_setopt($ch, CURLOPT_POST, true);
     	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
     	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept-Language: en-US,en;q=0.8','Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8','Accept-Charset: ISO-8859-1,utf-8;q=0.7,*;q=0.3'));
     	     	curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 6.1) AppleWebKit/535.11 (KHTML, like Gecko) Chrome/17.0.963.78 Safari/535.11");
     	curl_setopt($ch, CURLOPT_URL, $loginURL);
     	curl_setopt($ch, CURLOPT_REFERER, $referer);
     	curl_setopt($ch, CURLOPT_POSTFIELDS, $loginFields);
     	$ret = curl_exec($ch);
     	curl_close($ch);
     	return $ret;
}

function __construct($term) {
echo "Creating\n";
       $this->corpus=$term;
   }


public function get_sentences(){
echo "Tokenising Sentences\n";
preg_match_all('~(\S.+?[.!?])(?=\s+|$)~',$this->corpus,$m);
return $m;}
public function tokenize_sentence($sentence){
preg_match_all('~([\w.,]+)~',substr($sentence,0,-1),$m);
return $m;}
public function GetKeyPhrs($array){
$words_actual=json_decode( $this->hitFormPost("http://avimc1.interhost.co.il/wiki/interface.php",'data='.json_encode(array($array,$array)), "", ""),true);
$max=max ($words_actual);
return $max;}
public function AnalyseCorpus(){
$total=array();
$sentences=$this->get_sentences();
foreach($sentences[1] as $key=>$sentence){
$words=$this->tokenize_sentence($sentence);
$max=$this->GetKeyPhrs($words[1]);
$total[$sentence]=$max;
}
arsort($total);
return $total;
}

}

$cc= new corpusCreator("It seems that the first Macedonian state emerged in the 8th or early 7th century BC under the Argead Dynasty, who, according to legend, migrated to the region from the Greek city of Argos in Peloponnesus (thus the name Argead). Herodotus mentions this founding myth when Alexander I was asked to prove his Greek descent in order to participate in the Olympic Games, an athletic event in which only men of Greek origin were entitled to participate. Alexander proved his (Argead) descent and was allowed to compete by the Hellanodikai: “And that these descendants of Perdiccas are Greeks, as they themselves say, I happen to know myself, and not only so, but I will prove in the succeeding history that they are Greeks. Moreover the Hellanodicai, who manage the games at Olympia, decided that they were so: for when Alexander wished to contend in the games and had descended for this purpose into the arena, the Greeks who were to run against him tried to exclude him, saying that the contest was not for Barbarians to contend in but for Greeks: since however Alexander proved that he was of Argos, he was judged to be a Greek, and when he entered the contest of the foot-race his lot came out with that of the first.\"[7] The Macedonian tribe ruled by the Argeads, was itself called Argead (which translates as \"descended from Argos\"). I also saw a cow today.");

print_r($cc->AnalyseCorpus());

//$words_actual=json_decode( $this->hitFormPost("http://avimc1.interhost.co.il/wiki/interface.php","data=".json_encode(array($unstemmed,$stemmed)), "", ""),true);


?>