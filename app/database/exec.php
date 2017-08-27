<?php

print $argv[2];

switch ($arg[2]) {
    case 'init':
        include 'dbinit.php';
        break;

    default:
        # code...
        break;
}
