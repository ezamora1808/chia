<?php
include_once 'Core/Ssh/Ssh.php';
$o_ssh  = new Ssh('189.162.76.74','ubuntu','ubuntu','12322');
try {
    echo $o_ssh->command('ifconfig');
} catch (Exception $e) {
    echo $e;
}