<?php

namespace Kuick\Event;

use Psr\EventDispatcher\EventDispatcherInterface as PsrEventDispatcherInterface;

interface EventDispatcherInterface extends PsrEventDispatcherInterface
{
    /**
     * @param string $eventNameOrPattern The name of the event or a pattern to match against event names
     */
    public function subscribe(string $eventNameOrPattern, callable $listener, int $priority = ListenerPriority::NORMAL): void;
}
