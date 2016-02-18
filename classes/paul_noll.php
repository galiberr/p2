<?php
/*
 * Author:      Roland Galibert
 * Date:        February 18, 2016
 * For:         CSCI E-15 Dynamic Web Applications, Spring 2016 - Project 2
 * Purpose:     file for screenscraping common English words listed at
 *              Paul Noll website (http://www.paulnoll.com)
 */

class paul_noll {

        public static $WEBSITE = "http://www.paulnoll.com";
        
        /*
         * This function scrapes all pages of the most common English words
         * found at the Paul Noll website and returns an array of those words.
         */
        public static function scrape_all() {
                $words = [];
                for ($i = 1; $i < 30; $i = $i + 2) {
                        $words = array_merge($words, scrape_page(self::$WEBSITE
                                        . "/" . "Books/Clear-English/words-"
                                        . make_two_digits($i)
                                        . "-"
                                        . make_two_digits($i + 1)
                                        . "-hundred.html"));
                }
                $total_matches = count($words);
                echo "Scraped " . $total_matches . " words from Paul Noll site.<br />";
                for ($i = 0; $i < $total_matches; $i++) {
                        echo $words[$i];
                        echo "<br />";
                }
                return $words;
        }

        /*
         * This function scrapes the single page passsed it to it (of course in the
         * current HTML format of the Paul Noll page) and retunrs an array
         * of the words in it.
         */
        public static function scrape_page($page) {
                $words = [];

                preg_match_all("|<li>[\s]*([A-Za-z]+)[\s.]*</li>|U", file_get_contents($page), $matches, PREG_PATTERN_ORDER);
                $total_matches = count($matches[1]);
                for ($i = 0; $i < $total_matches; $i++) {
                        $words[] = $matches[1][$i];
                }
                return $words;
        }

        /*
         * This helper function returns a two-digit string version of the number
         * passed into it, adding a leading zero if necessary. It is expected
         * the number passed in will be a two-digit number.
         */
        private static function make_two_digits($number) {
                if ($number < 10) {
                        return "0" . $number;
                } else {
                        return $number;
                }
        }
}
