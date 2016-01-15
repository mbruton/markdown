#!/usr/bin/php
<?php

$input = "
# Markdown render
## Table of contents

This is a **paragraph** of *text* ***containing*** some `code snipit` and a [link](/foo)

```php
\$hello = \"world\";
```

This should still  
be a single paragrah with ~~this~~ word striked though
";

function render($markdown){
    /* Code blocks */
    $markdown = preg_replace("/^```php\n([^`]+)```/m", highlight_string("$1"), $markdown);
    
    /* Titles */
    $markdown = preg_replace("/^\#\s+(.*)$/m", "<h1>$1</h1>", $markdown);
    $markdown = preg_replace("/^\##\s+(.*)$/m", "<h2>$1</h2>", $markdown);
    $markdown = preg_replace("/^\###\s+(.*)$/m", "<h3>$1</h3>", $markdown);
    $markdown = preg_replace("/^\####\s+(.*)$/m", "<h4>$1</h4>", $markdown);
    $markdown = preg_replace("/^\#####\s+(.*)$/m", "<h5>$1</h5>", $markdown);
    $markdown = preg_replace("/^\######\s+(.*)$/m", "<h6>$1</h6>", $markdown);
    
    /* Inline statements */
    $markdown = preg_replace("/`([^`]+)`/m", "<code>$1</code>", $markdown);
    $markdown = preg_replace("/\*\*([^**]+)\*\*/m", "<strong>$1</strong>", $markdown);
    $markdown = preg_replace("/\*([^*]+)\*/m", "<em>$1</em>", $markdown);
    $markdown = preg_replace("/~~([^~]+)~~/m", "<s>$1</s>", $markdown);
    
    /* Links */
    $markdown = preg_replace("/\[([^\]]+)\]\(([^)]+)\)/m", "<a href=\"$2\">$1</a>", $markdown);
    
    /* Line breaks */
    $markdown = preg_replace("/[ ]{2,2}\n/", "<br>\n", $markdown);
    
    
    
    /* Paragraphs */
    $paragraphs = explode("\n\n", $markdown);
    $markdown = "";
    foreach($paragraphs as $p){
        $p = trim($p);
        if (preg_match("/^</", $p)){
            $markdown .= $p . "\n";
        }else{
            $markdown .= "<p>{$p}</p>\n";
        }
    }
    
    return $markdown;
}

print render($input);


?>