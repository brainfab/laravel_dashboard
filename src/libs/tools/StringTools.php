<?php
namespace SmallTeam\Admin;
class StringTools extends \Illuminate\Support\Str {

    /**
     * Cyrillic letters
     */
    static private $cyr = array(
        "Щ",  "Ш", "Ч", "Ц","Ю", "Я", "Ж", "А","Б","В","Г","Д","Е", "Ё", "Ж", "З","И","Й","I","Ї", "Є", "Ґ", "К","Л","М","Н","О","П","Р","С","Т","У","Ф","Х", "Ъ","Ы","Ь","Э","Ю" ,"Я",
        "щ",  "ш", "ч", "ц","ю", "я", "ж", "а","б","в","г","д","е", "ё", "ж", "з","и","й","i","ї", "є", "ґ", "к","л","м","н","о","п","р","с","т","у","ф","х", "ъ","ы","ь","э","ю" ,"я"
    );

    /**
     * Latin letters for transliteration
     */
    static private $lat = array(
        "Sch","Sh","Ch","C","Ju","Ja","Zh","A","B","V","G","D","Je","Jo","Zh","Z","I","J","I","Ji","Je","G","K","L","M","N","O","P","R","S","T","U","F","Kh","'","Y","`","E","Je","Ji",
        "sch","sh","ch","c","ju","ja","zh","a","b","v","g","d","je","jo","zh","z","i","j","i","ji","je","g","k","l","m","n","o","p","r","s","t","u","f","kh","'","y","`","e","je","ji"
    );

    /**
     * Do text transliteration
     *
     * @static
     * @param string $text Text to transliteration
     * @return string transliterated text
     * @author Alexandr Tereschenkov <a.tereschenkov@gmail.com>
     */
    static public function transliterate($text) {
        for($i = 0; $i < count(self::$cyr); $i++) {
            $c_cyr = self::$cyr[$i];
            $c_lat = self::$lat[$i];
            $text = str_replace($c_cyr, $c_lat, $text);
        }

        $text = preg_replace("/([qwrtpsdfghklzxcvbnmQWRTPSDFGHKLZXCVBNM]+)[jJ]e/", "\${1}e", $text);
        $text = preg_replace("/([qwrtpsdfghklzxcvbnmQWRTPSDFGHKLZXCVBNM]+)[jJ]/", "\${1}'", $text);
        $text = preg_replace("/([eyuioaEYUIOA]+)[Kk]h/", "\${1}h", $text);
        $text = preg_replace("/^kh/", "h", $text);
        $text = preg_replace("/^Kh/", "H", $text);

        return $text;
    }

    /**
     * Convert $text to string acceptable for URL using
     * @static
     * @param string $text
     * @return string Slugified text
     * @author Alexandr Tereschenkov <a.tereschenkov@gmail.com>
     */
    static public function slugify($text) {
        $text = self::transliterate($text);
        // replace non letter or digits by -
        $text = preg_replace('~[^\\pL\d\s]+~u', '_', $text);

        // trim
        $text = trim($text, '-');

        $text = strtolower($text);

        // remove unwanted characters
        $text = preg_replace('~[^A-z0-9]+~', '_', $text);
        $text = preg_replace('#_+#','_',$text);
        if (empty($text)) {
            return 'n-a';
        }
        return $text;
    }



    /**
     * Make from string function name
     *
     * @static
     * @param string $name
     * @return string result
     */
    static public function functionalize($name) {
        $name = explode(' ', str_replace(array('_', '/', '-'), ' ', $name));

        for ($i = 0; $i < count($name); $i++) {
            $name[$i] = ucfirst($name[$i]);
        }

        $name = implode('', $name);
        return $name;
    }

    /**
     * Make from Class named directory name
     *
     * @static
     * @param string $name
     * @return string result
     */
    static public function directorize($name) {
        $res = strtolower($name[0]);
        for ($i = 1; $i < strlen($name); $i++) {
            if (($name[$i] >= 'A') && ($name[$i] <= 'Z')) {
                $res .= '_' . strtolower($name[$i]);
            } else {
                $res .= $name[$i];
            }
        }

        return $res;
    }

    /**
     * Pluralize word
     *
     * @static
     * @param string $word
     * @return string pluralize type of word
     */
    static public function pluralize($word) {
        $corePluralRules = array(
            '/(s)tatus$/i' => '\1\2tatuses',
            '/(quiz)$/i' => '\1zes',
            '/^(ox)$/i' => '\1\2en',
            '/([m|l])ouse$/i' => '\1ice',
            '/(matr|vert|ind)(ix|ex)$/i'  => '\1ices',
            '/(x|ch|ss|sh)$/i' => '\1es',
            '/([^aeiouy]|qu)y$/i' => '\1ies',
            '/(hive)$/i' => '\1s',
            '/(?:([^f])fe|([lr])f)$/i' => '\1\2ves',
            '/sis$/i' => 'ses',
            '/([ti])um$/i' => '\1a',
            '/(p)erson$/i' => '\1eople',
            '/(m)an$/i' => '\1en',
            '/(c)hild$/i' => '\1hildren',
            '/(buffal|tomat)o$/i' => '\1\2oes',
            '/(alumn|bacill|cact|foc|fung|nucle|radi|stimul|syllab|termin|vir)us$/i' => '\1i',
            '/us$/' => 'uses',
            '/(alias)$/i' => '\1es',
            '/(ax|cri|test)is$/i' => '\1es',
            '/s$/' => 's',
            '/^$/' => '',
            '/$/' => 's');

        $coreUninflectedPlural = array(
            '.*[nrlm]ese', '.*deer', '.*fish', '.*measles', '.*ois', '.*pox', '.*sheep', 'Amoyese',
            'bison', 'Borghese', 'bream', 'breeches', 'britches', 'buffalo', 'cantus', 'carp', 'chassis', 'clippers',
            'cod', 'coitus', 'Congoese', 'contretemps', 'corps', 'debris', 'diabetes', 'djinn', 'eland', 'elk',
            'equipment', 'Faroese', 'flounder', 'Foochowese', 'gallows', 'Genevese', 'Genoese', 'Gilbertese', 'graffiti',
            'headquarters', 'herpes', 'hijinks', 'Hottentotese', 'information', 'innings', 'jackanapes', 'Kiplingese',
            'Kongoese', 'Lucchese', 'mackerel', 'Maltese', 'media', 'mews', 'moose', 'mumps', 'Nankingese', 'news',
            'nexus', 'Niasese', 'Pekingese', 'People', 'Piedmontese', 'pincers', 'Pistoiese', 'pliers', 'Portuguese', 'proceedings',
            'rabies', 'rice', 'rhinoceros', 'salmon', 'Sarawakese', 'scissors', 'sea[- ]bass', 'series', 'Shavese', 'shears',
            'siemens', 'species', 'swine', 'testes', 'trousers', 'trout', 'tuna', 'Vermontese', 'Wenchowese',
            'whiting', 'wildebeest', 'Yengeese');

        $coreIrregularPlural = array(
            'atlas' => 'atlases',
            'beef' => 'beefs',
            'brother' => 'brothers',
            'child' => 'children',
            'corpus' => 'corpuses',
            'cow' => 'cows',
            'ganglion' => 'ganglions',
            'genie' => 'genies',
            'genus' => 'genera',
            'graffito' => 'graffiti',
            'hoof' => 'hoofs',
            'loaf' => 'loaves',
            'man' => 'men',
            'money' => 'monies',
            'mongoose' => 'mongooses',
            'move' => 'moves',
            'mythos' => 'mythoi',
            'numen' => 'numina',
            'occiput' => 'occiputs',
            'octopus' => 'octopuses',
            'opus' => 'opuses',
            'ox' => 'oxen',
            'penis' => 'penises',
            'person' => 'people',
            'sex' => 'sexes',
            'soliloquy' => 'soliloquies',
            'testis' => 'testes',
            'trilby' => 'trilbys',
            'turf' => 'turfs');

        $regexUninflected = '(?:' . (join( '|', $coreUninflectedPlural)) . ')';
        $regexIrregular = '(?:' . (join( '|', array_keys($coreIrregularPlural))) . ')';
        $pluralRules['regexUninflected'] = $regexUninflected;
        $pluralRules['regexIrregular'] = $regexIrregular;

        $regs = array();

        if (preg_match('/(.*)\\b(' . $regexIrregular . ')$/i', $word, $regs)) {
            return $regs[1] . substr($word, 0, 1) . substr($coreIrregularPlural[strtolower($regs[2])], 1);
        }
        if (preg_match('/^(' . $regexUninflected . ')$/i', $word, $regs)) {
            return $word;
        }
        foreach ($corePluralRules as $rule => $replacement) {
            if (preg_match($rule, $word)) {
                return preg_replace($rule, $replacement, $word);
            }
        }
        return $word;
    }

    /**
     * Singularize word
     *
     * @static
     * @param string $word
     * @return string singular type of word
     */
    static public function singularize($word) {
        $coreSingularRules =
            array(
                '/(s)tatuses$/i' => '\1\2tatus',
                '/(quiz)zes$/i' => '\\1',
                '/(matr)ices$/i' => '\1ix',
                '/(vert|ind)ices$/i' => '\1ex',
                '/^(ox)en/i' => '\1',
                '/(alias)(es)*$/i' => '\1',
                '/([octop|vir])i$/i' => '\1us',
                '/(cris|ax|test)es$/i' => '\1is',
                '/(shoe)s$/i' => '\1',
                '/(o)es$/i' => '\1',
                '/ouses$/' => 'ouse',
                '/uses$/' => 'us',
                '/([m|l])ice$/i' => '\1ouse',
                '/(x|ch|ss|sh)es$/i' => '\1',
                '/(m)ovies$/i' => '\1\2ovie',
                '/(s)eries$/i' => '\1\2eries',
                '/([^aeiouy]|qu)ies$/i' => '\1y',
                '/([lr])ves$/i' => '\1f',
                '/(tive)s$/i' => '\1',
                '/(hive)s$/i' => '\1',
                '/(drive)s$/i' => '\1',
                '/([^f])ves$/i' => '\1fe',
                '/(^analy)ses$/i' => '\1sis',
                '/((a)naly|(b)a|(d)iagno|(p)arenthe|(p)rogno|(s)ynop|(t)he)ses$/i' => '\1\2sis',
                '/([ti])a$/i' => '\1um',
                '/(p)eople$/i' => '\1\2erson',
                '/(m)en$/i' => '\1an',
                '/(c)hildren$/i' => '\1\2hild',
                '/(n)ews$/i' => '\1\2ews',
                '/s$/i' => '');

        $coreUninflectedSingular = array(
            '.*[nrlm]ese', '.*deer', '.*fish', '.*measles', '.*ois', '.*pox', '.*sheep', '.*us', '.*ss', 'Amoyese',
            'bison', 'Borghese', 'bream', 'breeches', 'britches', 'buffalo', 'cantus', 'carp', 'chassis', 'clippers',
            'cod', 'coitus', 'Congoese', 'contretemps', 'corps', 'debris', 'diabetes', 'djinn', 'eland', 'elk',
            'equipment', 'Faroese', 'flounder', 'Foochowese', 'gallows', 'Genevese', 'Genoese', 'Gilbertese', 'graffiti',
            'headquarters', 'herpes', 'hijinks', 'Hottentotese', 'information', 'innings', 'jackanapes', 'Kiplingese',
            'Kongoese', 'Lucchese', 'mackerel', 'Maltese', 'media', 'mews', 'moose', 'mumps', 'Nankingese', 'news',
            'nexus', 'Niasese', 'Pekingese', 'Piedmontese', 'pincers', 'Pistoiese', 'pliers', 'Portuguese', 'proceedings',
            'rabies', 'rice', 'rhinoceros', 'salmon', 'Sarawakese', 'scissors', 'sea[- ]bass', 'series', 'Shavese', 'shears',
            'siemens', 'species', 'swine', 'testes', 'trousers', 'trout', 'tuna', 'Vermontese', 'Wenchowese',
            'whiting', 'wildebeest', 'Yengeese',);

        $coreIrregularSingular = array(
            'atlases' => 'atlas',
            'beefs' => 'beef',
            'brothers' => 'brother',
            'children' => 'child',
            'corpuses' => 'corpus',
            'cows' => 'cow',
            'ganglions' => 'ganglion',
            'genies' => 'genie',
            'genera' => 'genus',
            'graffiti' => 'graffito',
            'hoofs' => 'hoof',
            'loaves' => 'loaf',
            'men' => 'man',
            'menus' => 'menu',
            'monies' => 'money',
            'mongooses' => 'mongoose',
            'moves' => 'move',
            'mythoi' => 'mythos',
            'numina' => 'numen',
            'occiputs' => 'occiput',
            'octopuses' => 'octopus',
            'opuses' => 'opus',
            'oxen' => 'ox',
            'penises' => 'penis',
            'people' => 'person',
            'sexes' => 'sex',
            'soliloquies' => 'soliloquy',
            'testes' => 'testis',
            'trilbys' => 'trilby',
            'turfs' => 'turf',);

        $regexUninflected =  '(?:' . (join( '|', $coreUninflectedSingular)) . ')';
        $regexIrregular =  '(?:' . (join( '|', array_keys($coreIrregularSingular))) . ')';
        $SingularRules['regexUninflected'] = $regexUninflected;
        $SingularRules['regexIrregular'] = $regexIrregular;

        $regs = array();
        if (preg_match('/(.*)\\b(' . $regexIrregular . ')$/i', $word, $regs)) {
            return $regs[1] . substr($word, 0, 1) . substr($coreIrregularSingular[strtolower($regs[2])], 1);
        }
        if (preg_match('/^(' . $regexUninflected . ')$/i', $word, $regs)) {
            return $word;
        }
        foreach ($coreSingularRules as $rule => $replacement) {
            if (preg_match($rule, $word)) {
                return preg_replace($rule, $replacement, $word);
            }
        }
    }

    static public function getTimestamp($string, $format = '#(?P<d>\d\d)(?P<m>\d\d)(?P<y>\d\d\d\d)#') {
        $m = array();
        preg_match($format, $string, $m);
        if (empty($m['m']) || empty($m['d']) || empty($m['y'])) return null;
        return strtotime($m['d'].'-'.$m['m'].'-'.$m['y']);
    }


    static private function num2str($number, $strip_float, $str, $sex, $forms, $nol) {
        $out = $tmp = array();
        // Поехали!
        $tmp = explode('.', str_replace(',','.', $number));
        $rub = number_format($tmp[ 0], 0,'','-');
        if ($rub== 0) $out[] = $nol;
        // нормализация копеек
        $kop = isset($tmp[1]) ? substr(str_pad($tmp[1], 2, '0', STR_PAD_RIGHT), 0,2) : '00';
        $segments = explode('-', $rub);
        $offset = sizeof($segments);
        if ((int)$rub== 0) { // если 0 рублей
            $o[] = $nol;
            $o[] = self::morph( 0, $forms[1][ 0],$forms[1][1],$forms[1][2]);
        }
        else {
            foreach ($segments as $k=>$lev) {
                $sexi= (int) $forms[$offset][3]; // определяем род
                $ri = (int) $lev; // текущий сегмент
                if ($ri== 0 && $offset>1) {// если сегмент==0 & не последний уровень(там Units)
                    $offset--;
                    continue;
                }
                // нормализация
                $ri = str_pad($ri, 3, '0', STR_PAD_LEFT);
                // получаем циферки для анализа
                $r1 = (int)substr($ri, 0,1); //первая цифра
                $r2 = (int)substr($ri,1,1); //вторая
                $r3 = (int)substr($ri,2,1); //третья
                $r22= (int)$r2.$r3; //вторая и третья
                // разгребаем порядки
                if ($ri>99) $o[] = $str[100][$r1]; // Сотни
                if ($r22>20) {// >20
                    $o[] = $str[10][$r2];
                    $o[] = $sex[ $sexi ][$r3];
                }
                else { // <=20
                    if ($r22>9) $o[] = $str[11][$r22-9]; // 10-20
                    elseif($r22> 0) $o[] = $sex[ $sexi ][$r3]; // 1-9
                }
                // Рубли
                $o[] = self::morph($ri, $forms[$offset][ 0],$forms[$offset][1],$forms[$offset][2]);
                $offset--;
            }
        }
        // Копейки
        if (!$strip_float) {
            $o[] = $kop;
            $o[] = self::morph($kop,$forms[ 0][ 0],$forms[ 0][1],$forms[ 0][2]);
        }
        return preg_replace("/\s{2,}/",' ',implode(' ',$o));
    }

    static public function num2str_ua($number, $strip_float = false) {
        $nol = 'нуль';
        $str[100]= array('','сто','двісті','триста','чотириста','п\'ятсот','шістсот', 'сімсот', 'вісімсот','дев\'ятьсот');
        $str[11] = array('','десять','одинадцять','дванадцять','тринадцять', 'чотирнадцять','п\'ятнадцять','шістнадцять','сімнадцять', 'вісімнадцять','дев\'ятнадцять','двадцять');
        $str[10] = array('','десять','двадцять','тридцять','сорок','п\'ятьдесят', 'шістдесят','сімдесят','вісімдесят','дев\'яносто');
        $sex = array(
            array('','один','два','три','чотири','п\'ять','шість','сім', 'вісем','дев\'ять'),// m
            array('','одна','дві','три','чотири','п\'ять','шість','сім', 'вісем','дев\'ять') // f
        );
        $forms = array(
            array('копійка', 'копійки', 'копійок', 1), // 10^-2
            array('гривна', 'гривні', 'гривень',  0), // 10^ 0
            array('тисяча', 'тисячи', 'тисяч', 1), // 10^ 3
            array('мильйон', 'мильйона', 'мильйонів',  0), // 10^ 6
            array('мильйард', 'мильйарда', 'мильйардів',  0), // 10^ 9
            array('триліон', 'триліона', 'триліона',  0), // 10^12
        );
        return self::num2str($number, $strip_float, $str, $sex, $forms, $nol);
    }

    static public function num2str_ru($number, $strip_float = false) {
        $nol = 'ноль';
        $str[100]= array('','сто','двести','триста','четыреста','пятьсот','шестьсот', 'семьсот', 'восемьсот','девятьсот');
        $str[11] = array('','десять','одиннадцать','двенадцать','тринадцать', 'четырнадцать','пятнадцать','шестнадцать','семнадцать', 'восемнадцать','девятнадцать','двадцать');
        $str[10] = array('','десять','двадцать','тридцать','сорок','пятьдесят', 'шестьдесят','семьдесят','восемьдесят','девяносто');
        $sex = array(
            array('','один','два','три','четыре','пять','шесть','семь', 'восемь','девять'),// m
            array('','одна','две','три','четыре','пять','шесть','семь', 'восемь','девять') // f
        );
        $forms = array(
            array('копейка', 'копейки', 'копеек', 1), // 10^-2
            array('гривна', 'гривны', 'гривен',  0), // 10^ 0
            array('тысяча', 'тысячи', 'тысяч', 1), // 10^ 3
            array('миллион', 'миллиона', 'миллионов',  0), // 10^ 6
            array('миллиард', 'миллиарда', 'миллиардов',  0), // 10^ 9
            array('триллион', 'триллиона', 'триллионов',  0), // 10^12
        );
        return self::num2str($number, $strip_float, $str, $sex, $forms, $nol);
    }


    static public function morph($n, $f1, $f2, $f5) {
        $n = abs($n) % 100;
        $n1= $n % 10;
        if ($n>10 && $n<20) return $f5;
        if ($n1>1 && $n1<5) return $f2;
        if ($n1==1) return $f1;
        return $f5;
    }

    static public function monthName( $data, $lang = null ) {
        $cur_lang = 'ru';
        $en = array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');
        $ru = array('Января', 'Февраля', 'Марта', 'Апреля', 'Мая', 'Июня', 'Июля', 'Августа', 'Сентября', 'Октября', 'Ноября', 'Декабря');
        $ua = array('Січня', 'Лютого', 'Березня', 'Квітня', 'Травня', 'Червня', 'Липня', 'Серпня', 'Вересня', 'Жовтня', 'Листопада', 'Грудня');
        if ( ff::getProjectConfig('use_localization', false) && is_null($lang) ) {
            $cur_lang = MLT::getActiveLanguageAlias();
        } else if (is_null($lang)){
            $cur_lang = 'ru';
        } else {
            $cur_lang = $lang;
        }
        switch ($cur_lang) {
            case 'ru': $res = str_replace($en, $ru, $data); break;
            case 'ua': $res = str_replace($en, $ua, $data); break;
            default: $res = $data; break;
        }
        return $res;
    }

}