<?php

/**
 * Kuick Event (https://github.com/milejko/kuick-event)
 *
 * @link      https://github.com/milejko/kuick-event
 * @copyright Copyright (c) 2010-2025 Mariusz Miłejko (mariusz@milejko.pl)
 * @license   https://en.wikipedia.org/wiki/BSD_licenses New BSD License
 */

namespace Kuick\Event;

class ListenerProvider implements ListenerProviderInterface
{
    /**
     * @var array<int, array<string, array<callable>>>
     */
    private array $listeners = [];

    /**
     * @param string $eventNameOrPattern The name of the event or a pattern to match against event names
     */
    public function registerListener(
        string $eventNameOrPattern,
        callable $listener,
        int $priority = ListenerPriority::NORMAL
    ): self {
        $this->listeners[$priority][$eventNameOrPattern][] = $listener;
        ksort($this->listeners);
        return $this;
    }

    /**
     * @return array<callable>
     */
    public function getListenersForEvent(object $event): array
    {
        $eventName = get_class($event);
        $orderedListeners = [];
        // array is already sorted by priority
        foreach ($this->listeners as $prioritizedListeners) {
            foreach ($prioritizedListeners as $eventNameOrPattern => $listener) {
                if (!$this->matchWildcard($eventNameOrPattern, $eventName)) {
                    continue;
                }
                $orderedListeners = array_merge($orderedListeners, $listener);
            }
        }
        /**
         * @var array<callable> $orderedListeners
         */
        return $orderedListeners;
    }

    private function matchWildcard($pattern, $string): bool
    {
        $pattern = preg_quote($pattern, '/');
        $pattern = str_replace('\*', '.*', $pattern);
        return (bool) preg_match('/^' . $pattern . '$/', $string);
    }
}
