<?php
include_once 'Core/Ssh/Ssh.php';
$o_ssh  = new Ssh('xxx.xxx.xxx.xxx','xxxx','xxxx','xxxx');
try {
    echo $o_ssh->command('ifconfig');
} catch (Exception $e) {
    echo $e;
}
