<?php

namespace Turbo\Handler;

class RemoveSpacesHandler implements HandlerInterface
{
    /**
     * @param string $string
     * @return string
     */
    public function execute(?string $string)
    {
        if ($string) {
            return str_replace(' ', '', $string);
        }

        return $string;
    }
}

