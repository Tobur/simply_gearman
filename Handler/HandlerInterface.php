<?php

namespace Turbo\Handler;

interface HandlerInterface
{
    /**
     * @param string $string
     * @return string
     */
    public function execute(?string $string);
}

