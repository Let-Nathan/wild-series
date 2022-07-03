<?php

namespace App\Service;

class Slugify
{
    public function generate(string $url): string
    {
        $str = '';
        if(empty($url)) {
            $str = 'unmatch';
        } else {
            $str = str_replace(' ', '-', $url);
        }
        return $str;
    }
}

