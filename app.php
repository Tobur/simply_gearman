<?php

namespace Turbo;

require './autoload.php';

use Turbo\Input\ArgvInput;
use Turbo\Processor\Client;
use Turbo\Processor\Worker;

$argvInput = new ArgvInput($argv);
$processor = $argvInput->get('processor');
//@TODO data should be get from arguments
//$data = $argvInput->get('data');

$data = json_encode(
    [
        'job' => [
            'text' => 'Привет, мне на <a href=\"test@test.ru\">test@test.ru</a> пришло приглашение встретиться, попить кофе с <strong>10%</strong> содержанием молока за <i>$5</i>, пойдем вместе!',
            'methods' => [
                'stripTags', 'removeSpaces', 'replaceSpacesToEol', 'htmlspecialchars', 'removeSymbols', 'toNumber'
            ]
        ]
    ]
);

switch ($processor) {
    case 'client':
        $gmc = new \GearmanClient();
        $gmc->addServer('gearmand', 4730);
        $client = new Client($gmc);
        $client->doWork($data, []);
        break;
    case 'worker':
        $gmworker= new \GearmanWorker();
        $gmworker->addServer('gearmand', 4730);
        $worker = new Worker($gmworker);
        $worker->start();
        break;
    default:
        throw new \Exception('Please specify type of processor (\'client\' or \'worker\').');
}
