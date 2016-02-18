<?php
/*
 * Author:      Roland Galibert
 * Date:        February 18, 2016
 * For:         CSCI E-15 Dynamic Web Applications, Spring 2016 - Project 2
 * Purpose:     words file for maintaining xkcd Password Generator word array
 */

require_once('paul_noll.php');

class words {

        /*
         * Actual file location.
         */
        public static $WORD_FILE = "./files/words.txt";

        /*
         * This function returns an array of words to be used for the xkcd
         * password generator. If the word file specified above does not exist
         * or is empty, it calls scrape_all() (in paul_noll.php) to scrape
         * the Paul Noll website for words.
         */
        public static function word_array() {
                if (!file_exists(self::$WORD_FILE)) {
                        $new_words = scrape_all();
                        self::write_words($new_words);
                        return $new_words;
                } else if (filesize(self::$WORD_FILE) == 0) {
                        $new_words = scrape_all();
                        self::write_words($new_words);
                        return $new_words;
                } else {
                        return self::read_words();
                }
        }

        /*
         * This function reads in the words stored in the words text file
         * and returns an array of those words.
         */
        private static function read_words() {
                $new_word_array = [];
                $new_word = "";
                $word_file_ptr = fopen(self::$WORD_FILE, 'r') or die('Unable to open words.txt initialization file.');
                while (!feof($word_file_ptr)) {
                        $new_word = trim(fgets($word_file_ptr));
                        if (strlen($new_word) > 0) {
                                $new_word_array[] = $new_word;
                        }
                }
                fclose($word_file_ptr);
                return $new_word_array;
        }

        /*
         * This function creates (or overwrites) the word text file and
         * writes the words stored in the array passed to the function
         * to that file.
         */
        private static function write_words($words) {
                $word_file_ptr = fopen(self::$WORD_FILE, 'w') or die('Unable to open words.txt initialization file.');
                $total_words = count($words);
                for ($i = 0; $i < $total_words; $i++) {
                        fwrite($word_file_ptr, $words[$i] . "\n");
                }
                fclose($word_file_ptr);
        }
}
