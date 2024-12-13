<?php

define('ANSI_RESET', "\033[0m");
define('ANSI_RED', "\033[1;31m");
define('ANSI_GREEN', "\033[1;32m");
define('ANSI_BLUE', "\033[1;34m");

function colorize($text, $color) {
    return "\033[{$color}m{$text}\033[0m\n";
}