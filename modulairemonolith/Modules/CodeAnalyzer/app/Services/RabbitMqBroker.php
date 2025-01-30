<?php

namespace Modules\CodeAnalyzer\Services;

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
class RabbitMqBroker extends MessageBroker
{
    public function addJob(string $message)
    {
        $connection = new AMQPStreamConnection($this->host, $this->port, $this->username, $this->password);
        $channel = $connection->channel();
        $channel->queue_declare($this->queue, false, false, false, false);
        $msg = new AMQPMessage($message);
        $channel->basic_publish($msg, '', $this->queue);
        $channel->close();
        $connection->close();
    }
}
