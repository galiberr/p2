<!DOCTYPE html>
<!--
Author:	  Roland Galibert
Date:	  February 18, 2016
For:	  CSCI E-15 Dynamic Web Applications, Spring 2016 - Project 2
Purpose:  xkcd Password Generator
-->
<?php
require_once('./classes/xkcd.php');
session_start();
xkcd::init();
?>
<html>
        <head>
                <title>xkcd Password Generator</title>
                <meta charset="UTF-8" />
                <meta name="viewport" content="width=device-width, initial-scale=1.0" />
                <link rel="stylesheet" type="text/css" href="./css/styles.css" />
        </head>
        <body>
                <h1>xkcd password generator</h1>
                <h2>Your new password is:</h2>
                
                <!-- Actual password generated -->
                <div class="password">
                        <?php echo $_SESSION['password'] ?>
                </div>
                
                <!-- Error message display -->
                <div class="errors">
                        <?php
                        if (array_key_exists('errors', $_SESSION)) {
                                echo "Please correct the following input customization errors (or just use the suggested password):";
                                echo "<ul class='errors'>";
                                foreach ($_SESSION['errors'] as $error) :
                                        echo "<li class='errors'>" . $error . "</li>";
                                endforeach;
                                echo "</ul>";
                                unset($_SESSION['errors']);
                        }
                        ?>
                </div>
                
                <!-- Parameter input form -->
                <form method="POST" action= "index.php">
                        <table class="custom">
                                <tr>
                                        <td class="customHeader" colspan="2">Customize your password:</td> 
                                </tr>
                                
                                <!-- Submit button -->
                                <tr>
                                        <td class="customHeader" colspan="2"><input type="submit" value="Submit">Submit your changes</td> 
                                </tr>
                                <tr>
                                        <td class="customColumn">
                                                <table>
                                                        
                                                        <!-- Minimum overall length -->
                                                        <tr>
                                                                <td class="customLabel">Min. overall length<br />(8 to 32)</td>
                                                                <td class="customField"><input type="text" name="min_chars" value="<?php echo $_POST['min_chars'] ?>"></td>
                                                        </tr>
                                                        
                                                        <!-- Number of words -->
                                                        <tr>
                                                                <td class="customLabel">Number of words<br />(3 to 8, default is 4):</td>
                                                                <td class="customField"><input type="text" name="num_words" value="<?php echo $_POST['num_words'] ?>"></td>
                                                        </tr>
                                                        
                                                        <!-- Separator -->
                                                        <tr>
                                                                <td class="customLabel">Separator:</td>
                                                                <td class="customField"><input type="radio" name="separator" value="dash" <?php if ($_POST['separator'] == 'dash') echo 'checked' ?>>- (default)<br>
                                                                        <input type="radio" name="separator" value="underscore" <?php if ($_POST['separator'] == 'underscore') echo 'checked' ?>>_<br>
                                                                        <input type="radio" name="separator" value="period" <?php if ($_POST['separator'] == 'period') echo 'checked' ?>>.<br>
                                                                        <input type="radio" name="separator" value="hash" <?php if ($_POST['separator'] == 'hash') echo 'checked' ?>>#<br>
                                                                        <input type="radio" name="separator" value="none" <?php if ($_POST['separator'] == 'none') echo 'checked' ?>>None
                                                                </td>
                                                        </tr>
                                                </table>    
                                        </td>
                                        <td class="customColumn">
                                                
                                                <table>
                                                        <!-- Word case -->
                                                        <tr>
                                                                <td class="customLabel">Word case:</td>
                                                                <td class="customField"><input type="radio" name="case" value="lower" <?php if ($_POST['case'] == 'lower') echo 'checked' ?>>lower case (default)<br>
                                                                        <input type="radio" name="case" value="upper" <?php if ($_POST['case'] == 'upper') echo 'checked' ?>>UPPER CASE<br>
                                                                        <input type="radio" name="case" value="camel" <?php if ($_POST['case'] == 'camel') echo 'checked' ?>>Camel Case (1st letter of each word capitalized)
                                                                </td>
                                                        </tr>
                                                        
                                                        <!-- Append digit -->
                                                        <tr>
                                                                <td class="customLabel">Append digit to password:</td>
                                                                <td class="customField"><input type="radio" name="end_num" value="none" <?php if ($_POST['end_num'] == 'none') echo 'checked' ?>>No (default)<br>
                                                                        <input type="radio" name="end_num" value="random" <?php if ($_POST['end_num'] == 'random') echo 'checked' ?>>Add random digit<br>
                                                                        <input type="radio" name="end_num" value="specific" <?php if ($_POST['end_num'] == 'specific') echo 'checked' ?>>Add this digit:<input type="text" name="add_this_num" value="<?php echo $_POST['add_this_num'] ?>"><br />Must be 0-9
                                                                </td>
                                                        </tr>
                                                        
                                                        <!-- Append special character -->
                                                        <tr>
                                                                <td class="customLabel">Append special character to password:</td>
                                                                <td class="customField"><input type="radio" name="end_special" value="none" <?php if ($_POST['end_special'] == 'none') echo 'checked' ?>>No (default)<br>
                                                                        <input type="radio" name="end_special" value="random" <?php if ($_POST['end_special'] == 'random') echo 'checked' ?>>Add random special character:<br>
                                                                        <input type="radio" name="end_special" value="specific" <?php if ($_POST['end_special'] == 'specific') echo 'checked' ?>>Add this special character:<input type="text" name="add_this_char" value="<?php echo $_POST['add_this_char'] ?>"><br />Must be one of !@$%^&*-_+=:|~?/.;
                                                                </td>
                                                        </tr>
                                                        
                                                </table>    
                                        </td>
                                </tr>
                        </table>
                </form>
</body>
</html>
