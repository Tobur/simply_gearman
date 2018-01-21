<?php

namespace Turbo\Handler;

class ReplaceSpacesToEolHandler implements HandlerInterface
{
    /**
     * @param string $string
     * @return string
     */
    public function execute(?string $string)
    {
        if ($string) {
            return str_replace(' ', PHP_EOL, $string);
        }

        return $string;
    }
}

