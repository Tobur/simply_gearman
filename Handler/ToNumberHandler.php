<?php

namespace Turbo\Handler;

class ToNumberHandler implements HandlerInterface
{
    /**
     * @param string $string
     * @return integer
     */
    public function execute(?string $string)
    {
        if ($string) {
            preg_match_all('!\d+!', $string, $matches);

            return !empty($matches[0]) ? reset($matches[0]) : '';
        }

        return $string;
    }
}

