<?php

namespace Turbo\Handler;

class HtmlspecialcharsHandler implements HandlerInterface
{
    /**
     * @param string $string
     * @return string
     */
    public function execute(?string $string)
    {
        if ($string) {
            return htmlspecialchars($string);
        }

        return $string;
    }
}

