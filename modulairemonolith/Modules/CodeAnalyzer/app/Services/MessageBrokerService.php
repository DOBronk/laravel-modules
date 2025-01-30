<?php

namespace Modules\CodeAnalyzer\Services;

class MessageBrokerService
{
    public function __construct(public MessageBroker $broker)
    {
    }

}