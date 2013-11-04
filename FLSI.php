<?php
class LatentSem
{
    
    function is_ini($array, $word)
    {
        $b   = false;
        $max = sizeof($array);
        for ($k = 0; $k < $max; $k++)
            if ($array[$k] == $word)
                $b = true;
        
        return $b;
    }
    
    
    function mmult($rows, $cols, $m1, $m2)
    {
        for ($i = 0; $i < $rows; $i++) {
            for ($j = 0; $j < $cols; $j++) {
                $val = 0;
                for ($k = 0; $k < $cols; $k++) {
                    $val += $m1[$i][$k] * $m2[$k][$j];
                }
                $m3[$i][$j] = $val;
            }
        }
        return $m3;
    }
    
    
    
    function gzfile_get_contents($filename, $use_include_path = 0)
    {
        // File does not exist
        if (!@file_exists($filename)) {
            return false;
        }
        
        // Read and imploding the array to produce a one line string
        $data = gzfile($filename, $use_include_path);
        $data = implode($data);
        return $data;
    }
    
    function wordify($array, $word)
    {
        if ($word == null || $word == "*{")
            return $array;
        else
            $b = sizeof($array);
        if (!$this->is_ini($array, $word))
            $array[$b] = $word;
        
        return $array;
    }
    public $finalvec = null;
    public $words = null;
    
    function latent($a, $urls, $from, $search_query)
    {
        //error_reporting(E_ALL | E_STRICT);
        //ini_set('display_errors', true);
        
        
        ini_set('memory_limit', '-1');
        set_time_limit(3000);
        include("crawler.nodatabase.php");
        
        $site = new page();
        
        $size = sizeof($a);
        //echo "CRAWLING " . $size . " result websites\n";
        $t    = time();
        for ($i = 1; $a[$i] != null; $i++) {
            //echo $i . " of " . $size . " " . $urls[$i] . " size: ";
            $all[$i] = $site->calc($a[$i], $urls[$i]);
			echo $i." ";
        }
        //echo "Crawling took " . floor((time() - $t) / 60) . " : " . ((time() - $t) % 60) . "\n";
        $t = time();
        file_put_contents("track.txt", "<del>Finished Gathering</del><br><del>Starting LSI</del><br><b>Calculating TF-IDF of the corpus gathered</b>");
        //echo "Calculating TF-IDF of the corpus gathered\n";
        /**
         * **************MPERDEMA begins!!!!********************
         */
        echo "DONE!";
        $size        = sizeof($all);
        $D           = $size;
        $this->words = null;
        for ($j = 1; $j <= $size; $j++) // for each document
            for ($i = 0; $all[$j][$i][0] != "*{"; $i++) { // for each word
                if ( /**
                 * $all[$j][$i][0]!="*{" &&
                 */ $all[$j][$i][0] != null && $vector[$all[$j][$i][0]][0] == null) /**
                 * if the document freq value has not been iniciated
                 */ 
                    $vector[$all[$j][$i][0]][0] = 1;
                else
                    $vector[$all[$j][$i][0]][0]++; //document frequency
                
                
                $vector[$all[$j][$i][0]][$j] = $all[$j][$i][1]; //term freq in document j
                $this->words                 = $this->wordify($this->words, $all[$j][$i][0]);
             echo $all[$j][$i][0]." ";   
            }
        
        echo "DONE!";
        /**
         * ************smartcleaning***************
         */
        $all     = null;
        $ss      = sizeof($this->words);
        //echo "size is " . $ss . "\n";
        $k       = 0; //k leksi
        $cleaned = 0;
        unset($all);
        $FileName = "tokens_removed.tv";
        $FileHandle = fopen($FileName, 'w') or die("can't open file");
        while ($this->words[$k] != null) {
            
            if (($vector[$this->words[$k]][0] / $D) < 50 / $D && ($vector[$this->words[$k]][0] / $D) > 1 / $D) {
                $wordbuffer[] = $this->words[$k];
                $cleaned++;
            } else {
                $str = $this->words[$k] . "\n";
                fwrite($FileHandle, (string) $str);
            }
            $k++;echo $this->words[$k]."\n";   
        }echo "DONE!";
        fclose($FileHandle);
        $this->words = null;
        $this->words = $wordbuffer;
        //echo $ss - $cleaned . " words removed\n";
        $ss          = sizeof($wordbuffer);
        //echo "size is " . $ss . "\n";
        unset($wordbuffer);
        /**
         * ************smartcleaning***************
         */
        
        $k = 0; //k leksi
        
        
        while ($this->words[$k] != null) {
            
            for ($j = 1; $j <= $size; $j++) {
                if ($vector[$this->words[$k]][$j] != null)
                    $this->finalvec[$k][$j] = $vector[$this->words[$k]][$j] * log($D / $vector[$this->words[$k]][0], 10);
                else
                    $this->finalvec[$k][$j] = 0;
            }
            
            $k++;echo $this->words[$k]."//";
        }
        
        
        /**
         * **************MPERDEMA ends!!!!**********************
         */
        //echo "Calculating TF-IDF of the corpus took " . floor((time() - $t) / 60) . " : " . ((time() - $t) % 60) . "\n";
        // postprocessing
        $finalvec1 = $this->finalvec;
        $words1    = $this->words;
        unset($this->finalvec);
        unset($this->words);
        //echo "<b>Outputing to matlab</b>" . "\n";
        
        $t = time();
        file_put_contents("tokens.txt", json_encode($words1));
        echo count($words1);
        $FileName = "matlab.txt";
        $FileHandle = fopen($FileName, 'w') or die("can't open file");
        
        echo "EXPORTING";
        for ($i = 0; $i < $ss; $i++) {
            
            for ($j = 1; $j <= $D; $j++) {
                $str = $finalvec1[$i][$j] . " ";
                fwrite($FileHandle, (string) $str);
            }
            fwrite($FileHandle, "\n");
        }
        
        fclose($FileHandle);
        goto end;
        //echo "<b>Outputing to matlab took:" . floor((time() - $t) / 60) . " : " . ((time() - $t) % 60) . "\n";
        $t = time();
        //echo "Calculating SVD \n";
        file_put_contents("track.txt", "<del>Finished Gathering</del><br><del>Starting LSI</del><br><del>Calculating TF-IDF of the corpus gathered</del><br><b>Calculating SVD</b>");
        
        /**
         * ***********SVD-PHP************************
         * include("SingularValueDecomposition.php");
         * 
         * 
         * for($j=1;$j<=$D;$j++){
         * 
         * 
         * for($i=0;$i<$ss;$i++){
         * $As[$i][$j-1]=$finalvec1[$i][$j];
         * 
         * }
         * }
         * 
         * 
         * 
         * $y=$ss;
         * $x=$D;
         * 
         * 
         * $Ass=new ArrayObject($As);
         * unset($As);
         * $svd=new SingularValueDecomposition($Ass,$y,$x);
         * $Deg=sqrt($D);
         * $res= $svd->getU();
         * 
         * $res1= $svd->getS();
         * 
         * $res2= $svd->getV();
         * unset($Ass);
         * for ($i=0;$i<$y;$i++){
         * for ($j=0;$j<$Deg-1;$j++)  $resA[$i][$j]=$res[$i][$j];
         * }
         * 
         * for ($i=0;$i<$Deg-1;$i++){
         * for ($j=0;$j<$Deg-1;$j++)  $res1A[$i][$j]=$res1[$i][$j];
         * }
         * 
         * for ($i=0;$i<$Deg-1;$i++){
         * for ($j=0;$j<$x;$j++)  $res2A[$i][$j]=$res2[$j][$i];//anapoda giati V'
         * }
         * unset($res);
         * unset($res1);
         * unset($res2);
         * $mul= mmult($y, $x, $resA, $res1A);
         * $mul= mmult($y, $x, $mul, $res2A);
         * 
         * 
         * for($j=0;$j<=$D;$j++){
         * 
         * 
         * for($i=0;$i<$ss;$i++){
         * $finalvec1[$i][$j+1]=$mul[$i][$j];
         * 
         * }
         * }
         * unset($mul);
         * /************SVD-MatLab***********************
         */
        
        
        $kapa    = floor(sqrt($ss)); //k
        // $kapa=10;
        $command = "C:\wamp\www\constr\latentsnippet\singular.exe " . $kapa;
        
        exec($command);
        
        
        
        
        
        $fil = file_get_contents('C:\som\matlab1.txt');
        $fil = explode("\n", $fil);
        for ($i = 0; $i < $ss; $i++) {
            $fil[$i] = str_replace("  ", " ", $fil[$i]);
            $fil[$i] = explode(" ", $fil[$i]);
        }
        
        for ($i = 0; $i < $ss; $i++) {
            
            for ($j = 1; $j <= $D; $j++) {
                $finalvec1[$i][$j] = (float) $fil[$i][$j];
            }
        }
        // $finalvec1=$fil;
        unset($fil);
        
        
        
        
        
        /**
         * ***********SVD-MatLab***********************
         */
        
        /**
         * *************Checking result*******************
         * 
         * 
         * $FileName = "C:/wamp/www/constr/som/matlabv1.txt";
         * $FileHandle = fopen($FileName, 'w') or die("can't open file");
         * 
         * 
         * for($i=0;$i<$ss;$i++){
         * 
         * for($j=1;$j<=$D;$j++){
         * $str=$finalvec1[$i][$j]." ";
         * fwrite($FileHandle,(string)$str);
         * }
         * fwrite($FileHandle,"\n");
         * }
         * 
         * fclose($FileHandle);
         * 
         * 
         * 
         * 
         * /**************Checking result******************
         */
        //echo "Calculating SVD took:" . floor((time() - $t) / 60) . " : " . ((time() - $t) % 60) . "\n";
        $k   = 0;
        $max = 0;
        for ($i = 0; $i < $ss; $i++) {
            // //echo $i." ".$words1[$i]." ";
            for ($j = 1; $j <= $D; $j++) {
                // //echo " | ".$finalvec1[$i][$j];
                if ($finalvec1[$i][$j] != 0)
                    $k++;
                if ($finalvec1[$i][$j] > $max)
                    $max = $finalvec1[$i][$j];
            }
            // //echo"\n";
        }
        //echo "<b>SPARCITY: </b>" . $k / ($ss * $D) . "\n";
        // //echo $max;
        /**
         * ***************NORMALIZING**************** //cant normalize when we have negatives in the resulting svd
         * 
         * 
         * 
         * for($i=0;$i<$ss;$i++){
         * 
         * for($j=1;$j<=$D;$j++){
         * $finalvec1[$i][$j]=$finalvec1[$i][$j] / $max;
         * }
         * 
         * }
         * 
         * 
         * 
         * 
         * /****************NORMALIZING****************
         */
        
        
        
        
        $FileName = "C:/wamp/www/constr/som/snippet_vectors.vec";
        $FileHandle = fopen($FileName, 'w') or die("can't open file");
        
        $k = 0;
        
        fwrite($FileHandle, '$TYPE' . " vec\n" . '$XDIM' . " $D\n" . '$YDIM' . " 1\n" . '$VEC_DIM' . " $ss\n");
        
        for ($j = 1; $j <= $D; $j++) {
            
            
            for ($i = 0; $i < $ss; $i++) {
                $str = $finalvec1[$i][$j] . " ";
                fwrite($FileHandle, (string) $str);
            }
            fwrite($FileHandle, str_replace("/", "/", "$urls[$j]") . "^" . $from[$j]);
            // fwrite($FileHandle,str_replace("/","/","$urls[$j]"));
            fwrite($FileHandle, "\r\n");
        }
        
        fclose($FileHandle);
        
        $FileName = "C:/wamp/www/constr/som/tokens.tv";
        $FileHandle = fopen($FileName, 'w') or die("can't open file");
        
        $k = 0;
        
        fwrite($FileHandle, '$TYPE' . " vec\n" . '$XDIM' . " 2\n" . '$YDIM' . " $D\n" . '$VEC_DIM' . " $ss\n");
        
        
        
        
        for ($i = 0; $i < $ss; $i++) {
            $str = $i . " " . $words1[$i] . "\n";
            fwrite($FileHandle, (string) $str);
        }
        fclose($FileHandle);
        file_put_contents("track.txt", "<del>Finished Gathering</del><br><del>Starting LSI</del><br><del>Calculating TF-IDF of the corpus gathered</del><br><del>Calculating SVD</del><br><b>Training SOM</b>");
        
        //echo "Outputing to files took " . floor((time() - $t) / 60) . " : " . ((time() - $t) % 60) . "\n";
        
        exec("C:\wamp\www\constr\som\somtoolbox.bat GrowingSOM -h C:\wamp\www\constr\som\sites.prop");
        //exec("C:\wamp\www\constr\som\somtoolbox.bat GHSOM -h C:\wamp\www\constr\som\sites.prop");
        file_put_contents("extra.txt", serialize(array(
            $site,
            $finalvec1,
            $urls,
            $ss,
            $words1,
            $D,
            $from,
            $search_query
        )));
        include("clustering.php");
        $pp = new postprocessing();
        file_put_contents("track.txt", "<del>Finished Gathering</del><br><del>Starting LSI</del><br><del>Calculating TF-IDF of the corpus gathered</del><br><del>Calculating SVD</del><br><del>Training SOM</del><br><b>PostProcessing<b>");
        
        $pp->process($site, $finalvec1, $urls, $ss, $words1, $D, $from, $search_query);
        file_put_contents("extra.txt", serialize(array(
            $site,
            $finalvec1,
            $urls,
            $ss,
            $words1,
            $D,
            $from,
            $search_query
        )));
        //exec("C:\wamp\www\constr\som\somtoolbox.bat SOMViewer -u C:\wamp\www\constr\som\sites.unit.gz -w C:\wamp\www\constr\som\sites.wgt.gz --dw C:\wamp\www\constr\som\sites.dwm.gz -c C:\wamp\www\constr\som\sites.cls");
        
end:
        
        
        
    }
}

?>