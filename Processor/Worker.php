<?php

namespace Turbo\Processor;

use Turbo\Handler\HandlerInterface;

class Worker
{
    const JOB = 'job';
    const METHODS = 'methods';
    const TEXT = 'text';

    /**
     * @var \GearmanWorker
     */
    protected $worker;

    /**
     * Worker constructor.
     * @param \GearmanWorker $worker
     */
    public function __construct(\GearmanWorker $worker)
    {
        $this->worker = $worker;
        $this->worker->addFunction(
            'process',
            [$this, 'handleJob']
        );
    }

    public function start()
    {
        while ($this->worker->work()) {
            if ($this->worker->returnCode() != GEARMAN_SUCCESS) {
                echo "return_code: ".$this->worker->returnCode()."\n";
                echo "return_error: ".$this->worker->error()."\n";
            }
        }
    }

    /**
     * @param \GearmanJob $gearmanJob
     * @return string
     */
    public function handleJob(\GearmanJob $gearmanJob)
    {
        $data = json_decode($gearmanJob->workload(), true);

        if (!$this->isValidateData($data)) {
            $gearmanJob->sendException('Please specify data parameter.');
        }

        $job = $data[static::JOB];
        $text = $job[static::TEXT];
        echo 'Input: ' . $text . "\n";

        foreach ($job[static::METHODS] as $method) {
            echo 'Process by method: ' . $method . "\n";
            $className = sprintf('Turbo\Handler\%sHandler', ucfirst($method));
            if (!class_exists($className)) {
                $gearmanJob->sendException('Class doesn\'t exist: ' . $className);
            }
            /** @var HandlerInterface $handler */
            $handler = new $className();
            $text = $handler->execute($text);
            echo '{ text: '. $text . " }\n";
        }


        return json_encode(['text' => $text]);
    }

    /**
     * @param array $data
     * @return bool
     */
    protected function isValidateData(array $data)
    {
        if (!isset($data[static::JOB])) {
            return false;
        }
        $job = $data[static::JOB];
        if (!isset($job[static::TEXT])) {
            return false;
        }

        if (!isset($job[static::METHODS])) {
            return false;
        }

        if (count($job[static::METHODS]) === 0) {
            return false;
        }

        return true;
    }
}



