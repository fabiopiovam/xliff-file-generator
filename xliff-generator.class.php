<?php
class XliffGenerator {

    private $_project_folder;
    private $_languages;
    private $_arr_words;
    private $_extensions;
    private $_path_store;
    
    public  $regex;

    function __construct() {
        $this->regex        = array();
        $this->_arr_words   = array();
        $this->_extensions  = array('');
        $this->_path_store  = __DIR__ . '/generated/';
    }
    
    public function setFolder($folder) {
        $this->_project_folder = $folder;
    }

    public function setLanguages(Array $langs) {
        $this->_languages = $langs;
    }
    
    public function setExtensions(Array $exts) {
        $this->_extensions = $exts;
    }

    public function addRegex($regex) {
        array_push($this->regex, "($regex)");
    }

    public function getWords() {
        
        if($this->_arr_words)
            return $this->_arr_words;

        $path       = realpath($this->_project_folder);
        $to_trans   = array();
        $regex      = implode('|', $this->regex); 
        
        $objects = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($path), 
            RecursiveIteratorIterator::SELF_FIRST
        );
        
        function _readContentFile($input,&$to_trans,$regex) {
            
            return preg_replace_callback(
                "/$regex/iU", 
                function($matches) use (&$to_trans) {
                    for ($i=2; $i <= count($matches); $i+=2) 
                        if ($item = $matches[$i]) break;
                    
                    if(!in_array($item, $to_trans))
                        array_push($to_trans, $item);
                }, 
                $input
            );
        }
        
        foreach ($objects as $name => $object) {
            
            $ext    = $object->getExtension();
            
            if (is_dir($name) || !in_array($ext, $this->_extensions)) 
                continue;
            
            $content = file_get_contents($name);
            
            _readContentFile($content,$to_trans,$regex);
        }
        
        $this->_arr_words = $to_trans;
        return $to_trans;
    }
    
    /*
     * @param $mode
     * a - append content of i18n file content (default)
     * n - new i18n file
     * */
    public function generate($mode='a') {
        if ($mode == 'n')
            $this->create_xliff();
        else
            $this->update_xliff();
    }
    
    public function create_xliff($langs='') {
        if (!$langs)
            $langs = $this->_languages;
        else
            $langs = (is_array($langs)) ? : array($langs);
            
        $dir_store = $this->_path_store . str_replace('/', '-', preg_replace('/^\/(.*)\/$/i', '$1', $this->_project_folder)) . '/';
        if ((!is_dir($dir_store)))
            mkdir($dir_store, 0777, true);
        
        $arr_words = $this->getWords();
        
        $xliff = '<?xml version="1.0"?><xliff version="1.2" xmlns="urn:oasis:names:tc:xliff:document:1.2"><file source-language="en" datatype="plaintext" original="file.ext"><body>';
        
        foreach ($arr_words as $key => $value) 
            $xliff .= '<trans-unit id="' . $key . '"><source>' . $value . '</source><target></target></trans-unit>';
        
        $xliff .= '</body></file></xliff>';
        
        foreach ($langs as $lang) 
            file_put_contents($dir_store . $lang . '.xlf', $xliff);
        
        return true;
    }
    
    public function update_xliff() {
        
        $dir_store = $this->_path_store . str_replace('/', '-', preg_replace('/^\/(.*)\/$/i', '$1', $this->_project_folder)) . '/';
        if ((!is_dir($dir_store)))
            return $this->create_xliff();
        
        $arr_words = $this->getWords(); 
        
        foreach ($this->_languages as $lang) {
            $file = $dir_store . $lang . '.xlf';
            if (!file_exists($file)) {
                $this->create_xliff($lang);
                continue;
            }
            
            if (!$xliff = simplexml_load_file($file)) {
                $e = "Can't read data. Please, verify the xliff file \n $file \n";
                foreach(libxml_get_errors() as $error)
                    $e .=  "\n\t" . $error->message;
                
                throw new Exception($e, 1001);
            }
            
            $arr_xliff      = json_decode(json_encode($xliff), TRUE);
            $arr_trans_unit = $arr_xliff["file"]["body"]["trans-unit"];
            $arr_trash_keys = array_keys($arr_trans_unit);
            
            $count_xliff    = count($xliff->file->body[0])-1;
            if($count_xliff = $xliff->file->body->children()->$count_xliff->attributes()->id->__toString())
               $count_xliff = intval($count_xliff);
            
            foreach ($arr_words as $key => $value) {
                
                if ($arr_item = array_filter($arr_trans_unit, function ($obj) use ($value) { return $obj["source"] == $value; } )){
                    $arr_trash_keys = array_diff($arr_trash_keys, array($key));
                    continue;
                }
                
                $count_xliff++;
                
                $add_item = $xliff->file->body->addChild('trans-unit');
                $add_item->addAttribute('id',$count_xliff);
                $add_item->addChild('source',$value);
                $add_item->addChild('target','');
            }
            
            $n = 0;
            foreach ($arr_trash_keys as $k) {
                $item = &$xliff->file->body->children();
                $i = intval($k) - $n;
                unset($item->$i);
                $n++;
            }
            
            file_put_contents($file, $xliff->asXML());
        }

        return true;
    } 

}