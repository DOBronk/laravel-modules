<?php

namespace Modules\CodeAnalyzer\Services;

use Closure;
use PhpAmqpLib\Connection\AMQPStreamConnection;

class RabbitMqService
{
    public function createQueue(string $queue, Closure $callback)
    {
        $connection = new AMQPStreamConnection('localhost', 5672, 'guest', 'guest');
        $channel = $connection->channel();
        $channel->queue_declare($queue, false, false, false, false);
        $channel->basic_consume($queue, '', false, true, false, false, $callback);
    }
}
