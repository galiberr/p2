<?php
/*
 * Author:      Roland Galibert
 * Date:        February 18, 2016
 * For:         CSCI E-15 Dynamic Web Applications, Spring 2016 - Project 2
 * Purpose:     xkcd controller file for xkcd Password Generator
 */

require_once ('words.php');

class xkcd {

        /*
         * Default, min/max values
         */
        public static $MIN_CHAR_DEFAULT = 8;
        public static $MIN_CHAR_MAX = 32;
        public static $NUM_WORDS_DEFAULT = 4;
        public static $NUM_WORDS_MIN = 3;
        public static $NUM_WORDS_MAX = 8;
        public static $SEPARATOR_DEFAULT = "dash";
        public static $CASE_DEFAULT = "lower";
        public static $END_NUM_DEFAULT = "none";
        public static $ADD_THIS_NUM_DEFAULT = "";
        public static $END_SPECIAL_DEFAULT = "none";
        public static $ADD_THIS_CHAR_DEFAULT = "";

        /*
         * This function is called at the beginning of the index.php (i.e.
         * run first each time a user calls the page). It:
         *   - Initializes the word array if necessary
         *   - Calls functions for validating user input
         *   - Calls the function to regenerate the password if no user
         *     input errors have occurred.
         */
        public static function init() {
                /*
                 * If word array is empty, fill it
                 */
                if (!array_key_exists('words', $_SESSION)) {
                        $_SESSION['words'] = word_array();
                }
                self::validate_min_chars();
                self::validate_num_words();
                self::validate_separator();
                self::validate_case();
                self::validate_end_num();
                self::validate_end_special();
                if (!array_key_exists('errors', $_SESSION)) {
                        self::generate_password();
                }
        }

        /*
         * This is the actual function to generate a password based on
         * parameters
         */
        private static function generate_password() {
                
                /*
                 * Calculate actual minimum length required in consideration of
                 * minimum length, number of separators required, and
                 * final digit/special character specifications
                 */
                $min_length = (int) $_POST['min_chars'];
                $min_length = $min_length - (int) $_POST['num_words'] + 1;
                $min_length = $min_length - (strcmp($_POST['separator'], "none") == 0 ? 0 : 1);
                $min_length = $min_length - (strcmp($_POST['end_num'], "none") == 0 ? 0 : 1);
                $min_length = $min_length - (strcmp($_POST['end_special'], "none") == 0 ? 0 : 1);
                
                /*
                 * Initiate separator, final digit, final special characters.
                 */
                $separator = self::getSeparator();
                $end_num = self::getEndNum();
                $end_special = self::getEndSpecial();
                
                /*
                 * Create array of new words. These will be indices
                 * to the words array, and not the actual words
                 */
                $new_words = [];
                $new_words = self::generate_words($_POST['min_chars'], (int) $_POST['num_words']);
                
                /*
                 * Loop to generate password (kept in $_SESSION['password']), applying
                 * case.
                 */
                $_SESSION['password'] = "";
                for ($i = 0; $i < count($new_words); $i++) {
                        if (strlen($_SESSION['password']) == 0) {
                                $_SESSION['password'] = self::applyCase($_SESSION['words'][$new_words[$i]]);
                        } else {
                                $_SESSION['password'] = $_SESSION['password'].$separator.self::applyCase($_SESSION['words'][$new_words[$i]]);
                        }
                }
                
                /*
                 * Add any end values required
                 */
                if (strlen($end_num) > 0) {
                        $_SESSION['password'] = $_SESSION['password'].$end_num;
                }
                if (strlen($end_special) > 0) {
                        $_SESSION['password'] = $_SESSION['password'].$end_special;
                }
        }
        
        /*
         * This function accepts a word string and applies case to it
         * (lower, upper, camel case) on the basis of the value in
         * $_POST['case']
         */
        private static function applyCase($word) {
                switch ($_POST['case']) {
                        case "lower":
                                return strtolower($word);
                        case "upper":
                                return strtoupper($word);
                        case "camel":
                                return ucfirst($word);
                }
        }
        
        /*
         * This function returns an actual separator character on the basis
         * of the specification in $_POST['separator']
         */
        private static function getSeparator() {
                switch ($_POST['separator']) {
                        case "dash":
                                return "-";
                        case "underscore":
                                return "_";
                        case "period":
                                return ".";
                        case "hash":
                                return "#";
                        case "none":
                                return "";
                }
        }
        
        /*
         * This function generates or returns a final digit on the basis
         * of the specification in $_POST['end_num'].
         * In the case of a user-specified digit, this is stored in
         * $_POST['add_this_num']
         */
        private static function getEndNum() {
                switch ($_POST['end_num']) {
                        case "none":
                                return "";
                        case "random":
                                return strval(rand(0, 9));
                        case "specific":
                                return $_POST['add_this_num'];
                }
        }

        /*
         * This function generates or returns a final special end character
         * on the basis of the specification in $_POST['end_special'].
         * In the case of a user-specified digit, this is stored in
         * $_POST['add_this_char']
         */
        private static function getEndSpecial() {
                switch ($_POST['end_special']) {
                        case "none":
                                return "";
                        case "random":
                                $index = rand(0, 17);
                                switch ($index) {
                                        case 0:
                                                return "!";
                                        case 1:
                                                return "@";
                                        case 2:
                                                return "$";
                                        case 3:
                                                return "%";
                                        case 4:
                                                return "^";
                                        case 5:
                                                return "&";
                                        case 6:
                                                return "*";
                                        case 7:
                                                return "-";
                                        case 8:
                                                return "_";
                                        case 9:
                                                return "+";
                                        case 10:
                                                return "=";
                                        case 11:
                                                return ":";
                                        case 12:
                                                return "|";
                                        case 13:
                                                return "~";
                                        case 14:
                                                return "?";
                                        case 15:
                                                return "/";
                                        case 16:
                                                return ".";
                                        case 17:
                                                return ";";
                                }
                                
                        case "specific":
                                return $_POST['add_this_char'];
                }
        }
        
        /*
         * This function generates words for use in the password on the basis
         * of the input parameters $min_length and $num_words. Note that it
         * returns an array of indices to the $_SESSION['words'] array and not
         * the actual words themselves.
         * 
         * The function will call itself recursively if the words it found in
         * its current while loop are not large enough to accommodate the
         * $min_length.
         * 
         */
         private static function generate_words($min_length, $num_words) {
             $total_words = count($_SESSION['words']);
             $word_index = [];
             $total_length = 0;
             while (count($word_index) < $num_words) {
                     $new_index = rand(0, $total_words - 1);
                     if (!in_array($new_index, $word_index)) {
                             $word_index[] = $new_index;
                             $total_length = $total_length + strlen($_SESSION['words'][$new_index]);
                     }
             }
             if ($total_length < ($min_length - $num_words + 1)) {
                     return self::generate_words($min_length, $num_words);
             } else {
                     return $word_index;
             }
        }
        
        /*
         * This function validates the value input for the minimum number of
         * characters required for the password, and also initially sets it
         * (i.e. the first time a user accesses the application)
         */
        private static function validate_min_chars() {
                if (!array_key_exists('min_chars', $_POST)) {
                        $_POST['min_chars'] = self::$MIN_CHAR_DEFAULT;
                } else {
                        if (preg_match("|[0-9]+|", $_POST['min_chars']) == 0) {
                                self::add_error("Min. overall length must be an integer between 8 and 32.");
                        } else {
                                if (((int) $_POST['min_chars'] < self::$MIN_CHAR_DEFAULT) || 
                                        ((int) $_POST['min_chars'] > self::$MIN_CHAR_MAX)) {
                                        self::add_error("Min. overall length must be an integer between 8 and 32.");
                                }
                        }
                }
        }

        /*
         * This function validates the value input for the number of
         * words required for the password, and also initially sets it
         * (i.e. the first time a user accesses the application)
         */
        private static function validate_num_words() {
                if (!array_key_exists('num_words', $_POST)) {
                        $_POST['num_words'] = self::$NUM_WORDS_DEFAULT;
                } else {
                        if (preg_match("|[0-9]+|", $_POST['num_words']) == 0) {
                                self::add_error("Number of words must be an integer between 3 and 8.");
                        } else {
                                if (((int) $_POST['num_words'] < self::$NUM_WORDS_MIN) || 
                                        ((int) $_POST['num_words'] > self::$NUM_WORDS_MAX)) {
                                        self::add_error("Number of words must be an integer between 3 and 8.");
                                }
                        }
                }
        }

        /*
         * This function validates the value input for the separator
         * character, and also initially sets it to the default
         * the first time a user accesses the application.
         */
        private static function validate_separator() {
                if (!array_key_exists('separator', $_POST)) {
                        $_POST['separator'] = self::$SEPARATOR_DEFAULT;
                }
        }

        /*
         * This function validates the value input for case specification
         * and also initially sets it to the default the first time a
         * user accesses the application.
         */
        private static function validate_case() {
                if (!array_key_exists('case', $_POST)) {
                        $_POST['case'] = self::$CASE_DEFAULT;
                }
        }

        /*
         * This function validates the value input for the end digit
         * and also initially sets it to the default the first time a
         * user accesses the application.
         */
        private static function validate_end_num() {
                if (!array_key_exists('end_num', $_POST)) {
                        $_POST['end_num'] = self::$END_NUM_DEFAULT;
                        $_POST['add_this_num'] = self::$ADD_THIS_NUM_DEFAULT;
                } else {
                        if ($_POST['end_num'] == "specific") {
                                if (preg_match("|^[0-9]$|", $_POST['add_this_num']) == 0) {
                                        self::add_error("End number must be a single digit from from 0 to 9.");
                                }
                        }
                }
        }

        /*
         * This function validates the value input for the final special character
         * and also initially sets it to the default the first time a
         * user accesses the application.
         */
        private static function validate_end_special() {
                if (!array_key_exists('end_special', $_POST)) {
                        $_POST['end_special'] = self::$END_SPECIAL_DEFAULT;
                        $_POST['add_this_char'] = self::$ADD_THIS_CHAR_DEFAULT;
                } else {
                        if ($_POST['end_special'] == "specific") {
                                if (preg_match("|^[\!\@\$\%\^\&\*\-\_\+\=\:\|\~\?\/\.\;]$|", $_POST['add_this_char']) == 0) {
                                        self::add_error("End character must be a character from the set !@$%^&*-_+=:|~?/.;");
                                }
                        }
                }
        }

        /*
         * This function adds the error message passed in to the array of 
         * error messages (stored in $_SESSION['errors']) and initiates it
         * if necessary.
         */
        private static function add_error($new_error_msg) {
                if (!array_key_exists('errors', $_SESSION)) {
                        $_SESSION['errors'] = [];
                }
                $_SESSION['errors'][] = $new_error_msg;
        }
}

?>