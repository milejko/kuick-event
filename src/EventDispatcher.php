<?php

/**
 * Kuick Event (https://github.com/milejko/kuick-event)
 *
 * @link      https://github.com/milejko/kuick-event
 * @copyright Copyright (c) 2010-2025 Mariusz Miłejko (mariusz@milejko.pl)
 * @license   https://en.wikipedia.org/wiki/BSD_licenses New BSD License
 */

namespace Kuick\Event;

class EventDispatcher implements EventDispatcherInterface
{
    public function __construct(private ListenerProviderInterface $listenerProvider = new ListenerProvider())
    {
    }

    public function subscribe(string $eventNameOrPattern, callable $listener, int $priority = ListenerPriority::NORMAL): void
    {
        $this->listenerProvider->registerListener($eventNameOrPattern, $listener, $priority);
    }

    public function dispatch(object $event): object
    {
        foreach ($this->listenerProvider->getListenersForEvent($event) as $listener) {
            $listener($event);
        }
        return $event;
    }
}
