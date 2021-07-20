<?php


class Download
{

    public static function getDownload ( string $namePlot, string $pathDiks ): string
    {
        $redCard = 'enp11s0,enp12s0';
        return " /home/ubuntu/chia/MID '--output-file' '".trim($pathDiks)."/".trim($namePlot)."' '--url' 'http://transfer1.chia.webmerica.com/storage/farm/".trim($namePlot)."' '--scheduler-algorithm' 'ALL' '--max-parallel-downloads' '64' '--interfaces' '".trim($redCard)."' ";
    }

}