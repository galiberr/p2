<?php

require_once 'words.php';

class xkcd {

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

        static public function init() {
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
        }

        static private function validate_min_chars() {
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

        static private function validate_num_words() {
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

        static private function validate_separator() {
                if (!array_key_exists('separator', $_POST)) {
                        $_POST['separator'] = self::$SEPARATOR_DEFAULT;
                }
        }

        static private function validate_case() {
                if (!array_key_exists('case', $_POST)) {
                        $_POST['case'] = self::$CASE_DEFAULT;
                }
        }

        static private function validate_end_num() {
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

        static private function validate_end_special() {
                if (!array_key_exists('end_special', $_POST)) {
                        $_POST['end_special'] = self::$END_CHAR_DEFAULT;
                        $_POST['add_this_char'] = self::$ADD_THIS_CHAR_DEFAULT;
                } else {
                        if ($_POST['end_special'] == "specific") {
                                if (preg_match("|^[\!\@\$\%\^\&\*\-\_\+\=\:\|\~\?\/\.\;]$|", $_POST['add_this_char']) == 0) {
                                        self::add_error("End character must be a character from the set !@$%^&*-_+=:|~?/.;");
                                }
                        }
                }
        }

        static private function add_error($new_error_msg) {
                if (!array_key_exists('errors', $_SESSION)) {
                        $_SESSION['errors'] = [];
                }
                $_SESSION['errors'][] = $new_error_msg;
        }

        /*
         * For test purposes
         */

        static public function print_array() {
                echo "<p>";
                echo "Size of words array = ";
                echo count($_SESSION['words']);
                echo "<br>";
                foreach ($_SESSION['words'] as $value) :
                        echo "$value<br />";
                endforeach;
                echo "</p>";
        }

}

?>