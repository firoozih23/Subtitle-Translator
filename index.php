<?php
/*
 * Subtitle Translator
 * Translate English subtitle to Farsi ( using targoman.ir )
 * https://github.com/itstaha/Subtitle-Translator/
*/

require_once("lib.php");

$sub = new subtitle;
$list = $sub->load('sub.srt');
$translate = $sub->translate($list);
echo json_encode($translate);