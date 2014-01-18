<?php
class page
{
    // Idea_ prepei na dino megalitero varos se lexis pu xekinane me kefaleo
    
    
    public $Stemminst;
    function page()
    {
        include("stem.php"); //agglikos stemmer
        
        
        $this->Stemminst = new Stemmer();
    }
    
    // Mem saving
    function return_cut($array2d)
    {
        
        for ($k = 0; $array2d[$k][0] != '*{'; $k++) {
            $b[$k][0] = $array2d[$k][0];
            $b[$k][1] = $array2d[$k][1];
        }
        $b[$k][0]     = '*{';
        $b[$k][1]     = 0;
        $b[$k + 1][0] = '*{';
        $b[$k + 1][1] = 0;
        return $b;
    }
    
    
    
    
    // psaksimo se 2d array boolean
    function is_in($array2d, $word)
    {
        $b = false;
        for ($k = 0; $array2d[$k][0] != '*{'; $k++)
            if ($array2d[$k][0] == $word)
                $b = true;
        return $b;
    }
    // removing stopwords
    function removeCommonWords($input)
    {
        
        $commonWords = array(
            '0',
            '1',
            '2',
            '3',
            '4',
            '5',
            '6',
            '7',
            '8',
            '9',
            'a',
            'able',
            'about',
            'above',
            'abroad',
            'according',
            'accordingly',
            'across',
            'actually',
            'adj',
            'after',
            'afterwards',
            'again',
            'against',
            'ago',
            'ahead',
            'ain\'t',
            'all',
            'allow',
            'allows',
            'almost',
            'alone',
            'along',
            'alongside',
            'already',
            'also',
            'although',
            'always',
            'am',
            'amid',
            'amidst',
            'among',
            'amongst',
            'an',
            'and',
            'another',
            'any',
            'anybody',
            'anyhow',
            'anyone',
            'anything',
            'anyway',
            'anyways',
            'anywhere',
            'apart',
            'appear',
            'appreciate',
            'appropriate',
            'are',
            'aren\'t',
            'around',
            'as',
            'a\'s',
            'aside',
            'ask',
            'asking',
            'associated',
            'at',
            'available',
            'away',
            'awfully',
            'b',
            'back',
            'backward',
            'backwards',
            'be',
            'became',
            'because',
            'become',
            'becomes',
            'becoming',
            'been',
            'before',
            'beforehand',
            'begin',
            'behind',
            'being',
            'believe',
            'below',
            'beside',
            'besides',
            'best',
            'better',
            'between',
            'beyond',
            'both',
            'brief',
            'but',
            'by',
            'c',
            'came',
            'can',
            'cannot',
            'cant',
            'can\'t',
            'caption',
            'cause',
            'causes',
            'certain',
            'certainly',
            'changes',
            'clearly',
            'c\'mon',
            'co',
            'co.',
            'com',
            'come',
            'comes',
            'concerning',
            'consequently',
            'consider',
            'considering',
            'contain',
            'containing',
            'contains',
            'corresponding',
            'could',
            'couldn\'t',
            'course',
            'c\'s',
            'currently',
            'd',
            'dare',
            'daren\'t',
            'definitely',
            'described',
            'despite',
            'did',
            'didn\'t',
            'different',
            'directly',
            'do',
            'does',
            'doesn\'t',
            'doing',
            'done',
            'don\'t',
            'down',
            'downwards',
            'during',
            'e',
            'each',
            'edu',
            'eg',
            'eight',
            'eighty',
            'either',
            'else',
            'elsewhere',
            'end',
            'ending',
            'enough',
            'entirely',
            'especially',
            'et',
            'etc',
            'even',
            'ever',
            'evermore',
            'every',
            'everybody',
            'everyone',
            'everything',
            'everywhere',
            'ex',
            'exactly',
            'example',
            'except',
            'f',
            'fairly',
            'far',
            'farther',
            'few',
            'fewer',
            'fifth',
            'first',
            'five',
            'followed',
            'following',
            'follows',
            'for',
            'forever',
            'former',
            'formerly',
            'forth',
            'forward',
            'found',
            'four',
            'from',
            'further',
            'furthermore',
            'g',
            'get',
            'gets',
            'getting',
            'given',
            'gives',
            'go',
            'goes',
            'going',
            'gone',
            'got',
            'gotten',
            'greetings',
            'h',
            'had',
            'hadn\'t',
            'half',
            'happens',
            'hardly',
            'has',
            'hasn\'t',
            'have',
            'haven\'t',
            'having',
            'he',
            'he\'d',
            'he\'ll',
            'hello',
            'help',
            'hence',
            'her',
            'here',
            'hereafter',
            'hereby',
            'herein',
            'here\'s',
            'hereupon',
            'hers',
            'herself',
            'he\'s',
            'hi',
            'him',
            'himself',
            'his',
            'hither',
            'hopefully',
            'how',
            'howbeit',
            'however',
            'hundred',
            'i',
            'i\'d',
            'ie',
            'if',
            'ignored',
            'i\'ll',
            'i\'m',
            'immediate',
            'in',
            'inasmuch',
            'inc',
            'inc.',
            'indeed',
            'indicate',
            'indicated',
            'indicates',
            'inner',
            'inside',
            'insofar',
            'instead',
            'into',
            'inward',
            'is',
            'isn\'t',
            'it',
            'it\'d',
            'it\'ll',
            'its',
            'it\'s',
            'itself',
            'i\'ve',
            'j',
            'just',
            'k',
            'keep',
            'keeps',
            'kept',
            'know',
            'known',
            'knows',
            'l',
            'last',
            'lately',
            'later',
            'latter',
            'latterly',
            'least',
            'less',
            'lest',
            'let',
            'let\'s',
            'like',
            'liked',
            'likely',
            'likewise',
            'little',
            'look',
            'looking',
            'looks',
            'low',
            'lower',
            'ltd',
            'm',
            'made',
            'mainly',
            'make',
            'makes',
            'many',
            'may',
            'maybe',
            'mayn\'t',
            'me',
            'mean',
            'meantime',
            'meanwhile',
            'merely',
            'might',
            'mightn\'t',
            'mine',
            'minus',
            'miss',
            'more',
            'moreover',
            'most',
            'mostly',
            'mr',
            'mrs',
            'much',
            'must',
            'mustn\'t',
            'my',
            'myself',
            'n',
            'name',
            'namely',
            'nd',
            'near',
            'nearly',
            'necessary',
            'need',
            'needn\'t',
            'needs',
            'neither',
            'never',
            'neverf',
            'neverless',
            'nevertheless',
            'new',
            'next',
            'nine',
            'ninety',
            'no',
            'nobody',
            'non',
            'none',
            'nonetheless',
            'noone',
            'no-one',
            'nor',
            'normally',
            'not',
            'nothing',
            'notwithstanding',
            'novel',
            'now',
            'nowhere',
            'o',
            'obviously',
            'of',
            'off',
            'often',
            'oh',
            'ok',
            'okay',
            'old',
            'on',
            'once',
            'one',
            'ones',
            'one\'s',
            'only',
            'onto',
            'opposite',
            'or',
            'other',
            'others',
            'otherwise',
            'ought',
            'oughtn\'t',
            'our',
            'ours',
            'ourselves',
            'out',
            'outside',
            'over',
            'overall',
            'own',
            'p',
            'particular',
            'particularly',
            'past',
            'per',
            'perhaps',
            'placed',
            'please',
            'plus',
            'possible',
            'presumably',
            'probably',
            'provided',
            'provides',
            'q',
            'que',
            'quite',
            'qv',
            'r',
            'rather',
            'rd',
            're',
            'really',
            'reasonably',
            'recent',
            'recently',
            'regarding',
            'regardless',
            'regards',
            'relatively',
            'respectively',
            'right',
            'round',
            's',
            'said',
            'same',
            'saw',
            'say',
            'saying',
            'says',
            'second',
            'secondly',
            'see',
            'seeing',
            'seem',
            'seemed',
            'seeming',
            'seems',
            'seen',
            'self',
            'selves',
            'sensible',
            'sent',
            'serious',
            'seriously',
            'seven',
            'several',
            'shall',
            'shan\'t',
            'she',
            'she\'d',
            'she\'ll',
            'she\'s',
            'should',
            'shouldn\'t',
            'since',
            'six',
            'so',
            'some',
            'somebody',
            'someday',
            'somehow',
            'someone',
            'something',
            'sometime',
            'sometimes',
            'somewhat',
            'somewhere',
            'soon',
            'sorry',
            'specified',
            'specify',
            'specifying',
            'still',
            'sub',
            'such',
            'sup',
            'sure',
            't',
            'take',
            'taken',
            'taking',
            'tell',
            'tends',
            'th',
            'than',
            'thank',
            'thanks',
            'thanx',
            'that',
            'that\'ll',
            'thats',
            'that\'s',
            'that\'ve',
            'the',
            'their',
            'theirs',
            'them',
            'themselves',
            'then',
            'thence',
            'there',
            'thereafter',
            'thereby',
            'there\'d',
            'therefore',
            'therein',
            'there\'ll',
            'there\'re',
            'theres',
            'there\'s',
            'thereupon',
            'there\'ve',
            'these',
            'they',
            'they\'d',
            'they\'ll',
            'they\'re',
            'they\'ve',
            'thing',
            'things',
            'think',
            'third',
            'thirty',
            'this',
            'thorough',
            'thoroughly',
            'those',
            'though',
            'three',
            'through',
            'throughout',
            'thru',
            'thus',
            'till',
            'to',
            'together',
            'too',
            'took',
            'toward',
            'towards',
            'tried',
            'tries',
            'truly',
            'try',
            'trying',
            't\'s',
            'twice',
            'two',
            'u',
            'un',
            'under',
            'underneath',
            'undoing',
            'unfortunately',
            'unless',
            'unlike',
            'unlikely',
            'until',
            'unto',
            'up',
            'upon',
            'upwards',
            'us',
            'use',
            'used',
            'useful',
            'uses',
            'using',
            'usually',
            'v',
            'value',
            'various',
            'versus',
            'very',
            'via',
            'viz',
            'vs',
            'w',
            'want',
            'wants',
            'was',
            'wasn\'t',
            'way',
            'we',
            'we\'d',
            'welcome',
            'well',
            'we\'ll',
            'went',
            'were',
            'we\'re',
            'weren\'t',
            'we\'ve',
            'what',
            'whatever',
            'what\'ll',
            'what\'s',
            'what\'ve',
            'when',
            'whence',
            'whenever',
            'where',
            'whereafter',
            'whereas',
            'whereby',
            'wherein',
            'where\'s',
            'whereupon',
            'wherever',
            'whether',
            'which',
            'whichever',
            'while',
            'whilst',
            'whither',
            'who',
            'who\'d',
            'whoever',
            'whole',
            'who\'ll',
            'whom',
            'whomever',
            'who\'s',
            'whose',
            'why',
            'will',
            'willing',
            'wish',
            'with',
            'within',
            'without',
            'wonder',
            'won\'t',
            'would',
            'wouldn\'t',
            'x',
            'y',
            'yes',
            'yet',
            'you',
            'you\'d',
            'you\'ll',
            'your',
            'you\'re',
            'yours',
            'yourself',
            'yourselves',
            'you\'ve',
            'z',
            'zero',
            'cached',
            'similar'
        );
        
        return preg_replace('/\b(' . implode('|', $commonWords) . ')\b/', '', $input);
    }
    
    function strip_punctuation($text)
    {
        $urlbrackets    = '\[\]\(\)';
        $urlspacebefore = ':;\'_\*%@&?!' . $urlbrackets;
        $urlspaceafter  = '\.,:;\'\-_\*@&\/\\\\\?!#' . $urlbrackets;
        $urlall         = '\.,:;\'\-_\*%@&\/\\\\\?!#' . $urlbrackets;
        
        $specialquotes = '\'"\*<>';
        
        $fullstop      = '\x{002E}\x{FE52}\x{FF0E}';
        $comma         = '\x{002C}\x{FE50}\x{FF0C}';
        $arabsep       = '\x{066B}\x{066C}';
        $numseparators = $fullstop . $comma . $arabsep;
        
        $numbersign   = '\x{0023}\x{FE5F}\x{FF03}';
        $percent      = '\x{066A}\x{0025}\x{066A}\x{FE6A}\x{FF05}\x{2030}\x{2031}';
        $prime        = '\x{2032}\x{2033}\x{2034}\x{2057}';
        $nummodifiers = $numbersign . $percent . $prime;
        
        return preg_replace(array(
            // Remove separator, control, formatting, surrogate,
            // open/close quotes.
            '/[\p{Z}\p{Cc}\p{Cf}\p{Cs}\p{Pi}\p{Pf}]/u',
            // Remove other punctuation except special cases
            '/\p{Po}(?<![' . $specialquotes . $numseparators . $urlall . $nummodifiers . '])/u',
            // Remove non-URL open/close brackets, except URL brackets.
            '/[\p{Ps}\p{Pe}](?<![' . $urlbrackets . '])/u',
            // Remove special quotes, dashes, connectors, number
            // separators, and URL characters followed by a space
            '/[' . $specialquotes . $numseparators . $urlspaceafter . '\p{Pd}\p{Pc}]+((?= )|$)/u',
            // Remove special quotes, connectors, and URL characters
            // preceded by a space
            '/((?<= )|^)[' . $specialquotes . $urlspacebefore . '\p{Pc}]+/u',
            // Remove dashes preceded by a space, but not followed by a number
            '/((?<= )|^)\p{Pd}+(?![\p{N}\p{Sc}])/u',
            // Remove consecutive spaces
            '/ +/'
        ), ' ', $text);
    }
    
    
    
    
    
    function getPage($url, $referer, $agent, $header, $timeout)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, $header);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        // curl_setopt($ch, CURLOPT_PROXY, $proxy);
        // curl_setopt($ch, CURLOPT_HTTPPROXYTUNNEL, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
        curl_setopt($ch, CURLOPT_REFERER, $referer);
        curl_setopt($ch, CURLOPT_USERAGENT, $agent);
        
        $result['EXE'] = curl_exec($ch);
        $result['INF'] = curl_getinfo($ch);
        $result['ERR'] = curl_error($ch);
        
        curl_close($ch);
        
        return $result;
    }
    
    
    
    
    
    function firstcome($i) // dino megalitero varos stis protes lexeis tis selidas
    {
        
        if ($i > 2)
            return 1;
        else
            return 1;
    }
    
    function ccln($url)
    {
        $U = explode(' ', $url);
        foreach ($U as $k => $u) {
            if ((strpos($u, '?') != false && strpos($u, '=') != false) || (strpos($u, '.') != false && strpos($u, '/') != false))
                unset($U[$k]);
        }
        return implode(' ', $U);
    }
    function cleaner($url)
    {
        $U = explode(' ', $url);
        
        $W = array();
        foreach ($U as $k => $u) {
            
            if (stristr($u, 'http') || (count(explode('.', $u)) > 1)) {
                unset($U[$k]);
                return $this->cleaner(implode(' ', $U));
            }
        }
        return implode(' ', $U);
    }
    
    function calc($address)
    {
        error_reporting(0);
        
        //error_reporting(E_ALL | E_STRICT);
        ini_set('memory_limit', '-1');
        set_time_limit(3000);
        
        //$aa = $this->ccln($this -> cleaner($address));
        $aa = $address;
        //$aa = $this -> cleaner($address);
        
        /**
         * Strip HTML tags
         */
        $aa = strip_tags($aa);
        
        /**
         * Decode HTML entities
         */
        $aa = html_entity_decode($aa, ENT_NOQUOTES, "UTF-8");
        
        
        /**
         * Remove punctuation
         */
        $aa   = $this->strip_punctuation($aa);
        $aa   = preg_replace("/[^a-zA-Z|\s]/", '', $aa);
        $aa   = preg_replace("/[\s]+/", ' ', $aa);
        // $aa=strip_tags($aa);//stripping html tags
        $aa   = strtolower($aa); //all lowercase
        $aa   = $this->removeCommonWords($aa); //removing stopwords
        // $aa=substr($aa, 0, 4000);// cut the string and get the first 4000 characters
        // $aa=explode(" ",$aa);
        $site = $this->Stemminst->stem_list($aa); //stemming remaining text
        
        
        unset($Stemminst);
        for ($i = 0; $i < 100; $i++) {
            $ff[$i][1] = 0;
            $ff[$i][0] = '*{';
        } //stixio sentinel
        // algoritmos metrisis epatalipseon kenurgion lexeon h twn synonimon tus
        $index = 0;
        $size  = sizeof($site);
        // $size=3;
        //echo $size . "\n";
        if ($size > 60)
            $cutoff = 1;
        else
            $cutoff = 0; //piramatikos ari8mos epanalipseon panw apo tis opoies epitrepume tin xrisi tis lexis
        for ($i = 0; $i < $size; $i++) {
            $counter = 1;
            
            if (!$this->is_in($ff, $site[$i]) && $index < 99) {
                
                for ($j = $i + 1; $j < $size; $j++)
                    if ($site[$j] == $site[$i])
                        $counter++;
                $weight = $counter / $size;
                if ($counter > $cutoff && strlen($site[$i]) > 2) {
                    $ff[$index][0] = $site[$i];
                    $ff[$index][1] = $weight * $this->firstcome($index);
                    $index++;
                }
            }
        }
        $ff = $this->return_cut($ff);
        return $ff;
    }
    
    
    
    
    
    
    
}


?>