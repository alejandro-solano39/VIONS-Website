<?php
function truncateWords($text, $maxWords = 40)
{
    $words = preg_split('/\s+/', trim($text), $maxWords + 1);
    if (count($words) > $maxWords) {
        array_pop($words); 
        $text = implode(' ', $words) . '...';
    }
    return $text;
}
