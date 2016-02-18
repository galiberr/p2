<?php
require_once('paul_noll.php');

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of words
 *
 * @author galiberr
 */
//put your code here

$word_file = "words.txt";

function word_array() {
        global $word_file;
        if (!file_exists($word_file)) {
                echo "Word file doesn't exist, scraping it in...<br>";
                $new_words = scrape_all();
                write_words($new_words);
                return $new_words;
        } else if (filesize($word_file) == 0) {
                echo "Word file size is 0, scraping words in...";
                write_words($new_words);
                return $new_words;
        } else {
                return read_words();
        }
}

// Reads words into $_SESSION['words']
function read_words() {
        global $word_file;
        $new_word_array = [];
        $word_file_ptr = fopen($word_file, 'r') or die('Unable to open words.txt initialization file.');
        while(!feof($word_file_ptr)) {
                $new_word_array[] = trim(fgets($word_file_ptr));
        }
        fclose($word_file_ptr);
        return $new_word_array;
}

function write_words($words) {
        global $word_file;
        $word_file_ptr = fopen($word_file, 'w') or die('Unable to open words.txt initialization file.');
        $total_words = count($words);
        for ($i = 0; $i < $total_words; $i++) {
                fwrite($word_file_ptr, $words[$i]."\n");
        }
        fclose($word_file_ptr);
}