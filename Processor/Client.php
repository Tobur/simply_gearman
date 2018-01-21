<?php

namespace Turbo\Processor;

class Client {

    /**
     * @var \GearmanClient
     */
    protected $client;

    /**
     * Client constructor.
     * @param \GearmanClient $client
     */
    public function __construct(\GearmanClient $client)
    {
        $this->client = $client;
        $this->client->setCompleteCallback(function ($task) {
            echo "COMPLETE: ".$task->unique()."\n\n Result:".$task->data()."\n";
        });
    }

    /**
     * @param string $data
     * @param array $context
     * @throws \Exception
     */
    public function doWork(string $data, array $context)
    {
        $this->client->addTaskBackground("process", $data, $context);

        if (!$this->client->runTasks()) {
            throw new \Exception($this->client->error());
        }
    }
}