<!DOCTYPE html>
<?php
require_once('xkcd.php');
session_start();
xkcd::init();
?>
<html>
        <head>
                <title>XKCD Password Generator</title>
                <meta charset="UTF-8" />
                <meta name="viewport" content="width=device-width, initial-scale=1.0" />
                <link rel="stylesheet" type="text/css" href="./css/styles.css" />
        </head>
        <body>
                <div>Your new password is <?php echo $_SESSION['password'] ?></div>
                <ul>
                <?php
                if (array_key_exists('errors', $_SESSION)) {
                foreach($_SESSION['errors'] as $error) :
                        echo "<li>".$error."</li>";
                endforeach;
                unset($_SESSION['errors']);
                }
                ?>
                </ul>
                <form method="POST" action= "index.php">
                        <table>
                                <tr>
                                        <td>Min. overall length:</td>
                                        <td><input type="text" name="min_chars" value="<?php echo $_POST['min_chars'] ?>"> (8 to 32)</td>
                                </tr>        
                                <tr>
                                        <td>Number of words<br />(3 to 8, default is 4):</td>
                                        <td><input type="text" name="num_words" value="<?php echo $_POST['num_words'] ?>"></td>
                                </tr>
                                <tr>
                                        <td>Separator:</td>
                                        <td><input type="radio" name="separator" value="dash" <?php if ($_POST['separator'] == 'dash') echo 'checked' ?>>- (default)<br>
                                        <input type="radio" name="separator" value="underscore" <?php if ($_POST['separator'] == 'underscore') echo 'checked' ?>>_<br>
                                        <input type="radio" name="separator" value="period" <?php if ($_POST['separator'] == 'period') echo 'checked' ?>>.<br>
                                        <input type="radio" name="separator" value="hash" <?php if ($_POST['separator'] == 'hash') echo 'checked' ?>>#<br>
                                        <input type="radio" name="separator" value="none" <?php if ($_POST['separator'] == 'none') echo 'checked' ?>>None
                                        </td>
                                </tr>
                                <tr>
                                        <td>Word case:</td>
                                        <td><input type="radio" name="case" value="lower" <?php if ($_POST['case'] == 'lower') echo 'checked' ?>>lower case (default)<br>
                                        <input type="radio" name="case" value="upper" <?php if ($_POST['case'] == 'upper') echo 'checked' ?>>UPPER CASE<br>
                                        <input type="radio" name="case" value="camel" <?php if ($_POST['case'] == 'camel') echo 'checked' ?>>Camel Case (1st letter of each words capitalized)
                                        </td>
                                </tr>
                                <tr>
                                        <td>Add digit to end:</td>
                                        <td><input type="radio" name="end_num" value="none" <?php if ($_POST['end_num'] == 'none') echo 'checked' ?>>No (default)<br>
                                        <input type="radio" name="end_num" value="random" <?php if ($_POST['end_num'] == 'random') echo 'checked' ?>>Add random digit<br>
                                        <input type="radio" name="end_num" value="specific" <?php if ($_POST['end_num'] == 'specific') echo 'checked' ?>>Add this digit:<input type="text" name="add_this_num" value="<?php echo $_POST['add_this_num'] ?>">Must be 0-9
                                        </td>
                                </tr>
                                <tr>
                                        <td>Add special character to end:</td>
                                        <td><input type="radio" name="end_special" value="none" <?php if ($_POST['end_special'] == 'none') echo 'checked' ?>>No (default)<br>
                                        <input type="radio" name="end_special" value="random" <?php if ($_POST['end_special'] == 'random') echo 'checked' ?>>Add random special character:<br>
                                        <input type="radio" name="end_special" value="specific" <?php if ($_POST['end_special'] == 'specific') echo 'checked' ?>>Add this special character:<input type="text" name="add_this_char" value="<?php echo $_POST['add_this_char'] ?>">Must be one of !@$%^&*-_+=:|~?/.;
                                        </td>
                                </tr>
                                <tr><td><input type="submit" value="Submit"></td><td></td></tr>
                        </table>
                </form>
        </p>
</body>
</html>
