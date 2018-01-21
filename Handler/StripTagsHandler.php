<?php

namespace Turbo\Handler;

class StripTagsHandler implements HandlerInterface
{
    /**
     * @param string $string
     * @return string
     */
    public function execute(?string $string)
    {
        if ($string) {
            return strip_tags($string);
        }

        return $string;

    }
}

