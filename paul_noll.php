<?php

$website = "http://www.paulnoll.com";
$resource = "Books/Clear-English/words-29-30-hundred.html";

function scrape_all() {
        
        global $website;

        $words = [];
        for ($i = 1; $i < 30; $i = $i + 2) {
                $words = array_merge($words,
                        scrape_page($website
                                ."/"."Books/Clear-English/words-"
                                .make_two_digits($i)
                                ."-"
                                .make_two_digits($i + 1)
                                ."-hundred.html"));
                 
        }
        $total_matches = count($words);
        echo "Scraped ".$total_matches." words from Paul Noll site.<br />";
        for ($i = 0; $i < $total_matches; $i++) {
                echo $words[$i];
                echo "<br />";
        }
        return $words;
}

function scrape_page ($page) {
        $words = [];
        
        preg_match_all("|<li>[\s]*([A-Za-z]+)[\s.]*</li>|U", file_get_contents($page), $matches, PREG_PATTERN_ORDER);
        $total_matches = count($matches[1]);
        for ($i = 0; $i < $total_matches; $i++) {
                $words[] = $matches[1][$i];
        }
        return $words;
}

function make_two_digits($number) {
        if ($number < 10) {
                return "0".$number;
        } else {
                return $number;
        }
}