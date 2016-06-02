<?php

namespace adapt\markdown{
    
    /* Prevent direct access */
    defined('ADAPT_STARTED') or die;
    
    class markdown extends \parsedown\extra\ParsedownExtra{
        
        protected function blockFencedCodeComplete($block){
            $output = parent::blockFencedCodeComplete($block);
            
            if ($output['type'] == "FencedCode"){
                $matches = array();
                $lang = "";
                if (preg_match("/-([A-Za-z0-9]+)$/", $output['element']['text']['attributes']['class'], $matches)){
                    $lang = $matches[1];
                    $p = new \pygments_wrapper\pygmentize();
                    $lexers = $p->list_lexers();
                    
                    if (in_array($lang, $lexers)){
                        $text = $output['element']['text']['text'];
                        $text = $p->highlight_syntax($text, $lang, true);
                        $output['element']['text']['text'] = $text;
                    }
                    
                }
            }
            
            return $output;
        }
        
    }
    
}

?>