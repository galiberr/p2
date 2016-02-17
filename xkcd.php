<?php
        require_once 'words.php';
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of xkcd
 *
 * @author galiberr
 */
        //put your code here
        
        function init() {
                /*
                 * If word array is empty, fill it
                 */
                if (!array_key_exists('words', $_SESSION)) {
                        $_SESSION['words'] = word_array();
                        
                } else {
                        echo 'words is now in session<br>';
                }
        }
        
        function print_array() {
                echo "<p>";
                echo "Size of words array = ";
                echo count($_SESSION['words']);
                echo "<br>";
                foreach ($_SESSION['words'] as $value) :
                        echo "$value<br />";
                endforeach;
                echo "</p>";
        }
?>