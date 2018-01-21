<?php

namespace Turbo\Input;

class ArgvInput
{
    /**
     * @var array|null
     */
    protected $argv;
    /**
     * @var array
     */
    protected $parsed;

    /**
     * @param array|null $argv
     */
    public function __construct(array $argv)
    {
        // strip the application name
        array_shift($argv);
        $this->argv = $argv;
        $this->parse();
    }

    /**
     * {@inheritdoc}
     */
    protected function parse()
    {
        foreach($this->argv as $argument) {
            if (mb_substr($argument, 0, 2) === '--') {
                list($key, $value) = explode('=', mb_substr($argument, 2, mb_strlen($argument)));
                $this->parsed[$key] = empty($value) ? true : $value;
                continue;
            }
            if (strpos($argument, '=') !== false) {
                list ($key, $value) = explode('=', $argument);
                $this->parsed[$key] = $value;
                continue;
            }
            $this->parsed[] = $argument;
        }
    }

    /**
     * @param string $name
     * @return mixed|null
     */
    public function get($name) {
        if (isset($this->parsed[$name])) {
            return $this->parsed[$name];
        }
        return null;
    }

    /**
     * @return bool
     */
    public function isArgumentsExist()
    {
        return count($this->parsed) > 0 ? true : false;
    }
}

