# Project 2 XKCD Password Generator

## Live URL
<http://p2.pyxisweb.me>

## Description
This php web application implements a xkcd password generator
whose basic concept was devised by the xkcd
website (specific page at <http://xkcd.com/936/>). My password generator will
generate a word-based password either on the basis of default parameters, or
based on the following parameters, any or all which may be specified by the user:

* Minimum overall length (8 to 32 characters, default 8)
* Number of words desired (3 to 8, default 4)
* Separator character (none -_.# default is - dash)
* Word case (lower (default), upper, camel case)
* Append digit to end of password (none (default), random, specific)
* Append special character to end of password(none (default), random, specific of !@$%^&*-_+=:|~?/.;)

The application remembers previous settings should the user wish to generate another
password.

In case of input errors (e.g. user specifies a number of words over the maximum
allowed, etc.) the application will display appropriate errors and also display the last
successfully generated password (a password is automatically generated the first time
a user visits the application).

## Project 2 Screencast
<http://screencast.com/t/L0qwPPWPswZ>

## Details for Teaching Team
### Session, Persistence
As some elements in the password generation application persist, the application creates a
session for user interaction. These persistent elements include the word array (described below)
and previous user selections (e.g., if a user specifies password parameters of 5 words
in camel case, the application will remember this and show these selections appropriately
(e.g. in radio buttons) in case the user should wish to generate another password).

### Word Array, Screenscraping
The application maintains an array of words ($_SESSION['words']) for use in generating passwords.
The application expects to find a text file (files/words.txt) of words to read into this array
the initial time a user visits the web application (the application will afterwards of course
just use the array).  It is expected that this file has one word
per line, though the application will skip over blank words (such as when the final line of the
file is blank).

If files/words.txt does not exist or is empty, the application will go out and scrape the words from the
Paul Noll website described in the assignment specifications (<http://www.paulnoll.com/Books/Clear-English/>).
The application will read these words into the word array and also create files/words.txt accordingly.

### Separation of concerns
The application separates out code into the following php files 
(all files except index.php in classes/ folder):

* index.php - Application display file consisting mostly of HTML code as well as appropriate PHP code islands.
* xkcd.php - php (class) file with code specifying parameter defaults, minimum values and maximum values,
 and functions for initialization, validation, password generation and error handling.
* words.php - Functions for creating words array and create/read/write words file.
* paul_noll.php - Functions for scraping Paul Noll word website.

## Credits
I would like to credit the following sources, both cited in the project specifications:

<http://www.paulnoll.com/Books/Clear-English/> for its list of common words.

<https://xkpasswd.net/s/> for its list of special characters.

In addition, I visited <http://php.net> and <http://w3schools.com> regularly to find out
how to implement various features.

## Outside Code
None used (I started to play around with purecss but didn't have time to implement it fully).