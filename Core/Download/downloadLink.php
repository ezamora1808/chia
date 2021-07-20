<?php
include_once 'Download.php';

echo Download::getDownload($argv[1], $argv[2]);