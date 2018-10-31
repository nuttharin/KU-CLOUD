<?php
/**
 * Created by PhpStorm.
 * User: TEAM
 * Date: 10/29/2018
 * Time: 6:05 PM
 */

namespace App\LogViewer;


class Pattern
{
    private $patterns = [
        'logs' => '/\[\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}([\+-]\d{4})?\].*/',
        'current_log' => [
            '/^\[(\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}([\+-]\d{4})?)\](?:.*?(\w+)\.|.*?)',
            ': (.*?)( in .*?:[0-9]+)?$/i'
        ],
        'files' => '/\{.*?\,.*?\}/i',
    ];

    public function all()
    {
        return array_keys($this->patterns);
    }

    public function getPattern($pattern, $position = null)
    {
        if ($position !== null) {
            return $this->patterns[$pattern][$position];
        }
        return $this->patterns[$pattern];

    }
}