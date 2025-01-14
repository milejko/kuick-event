<?php

/**
 * Kuick Event (https://github.com/milejko/kuick-event)
 *
 * @link      https://github.com/milejko/kuick-event
 * @copyright Copyright (c) 2010-2025 Mariusz Miłejko (mariusz@milejko.pl)
 * @license   https://en.wikipedia.org/wiki/BSD_licenses New BSD License
 */

namespace Kuick\Event;

use Psr\EventDispatcher\ListenerProviderInterface;

class ListenerProvider implements ListenerProviderInterface
{
    /**
     * @var array<array{pattern: string, listener: callable, priority: int}>
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
        $this->listeners[] = [
            'pattern' => $eventNameOrPattern,
            'listener' => $listener,
            'priority' => $priority,
        ];
        usort($this->listeners, [$this, 'compare']);
        return $this;
    }

    /**
     * @return array<callable>
     */
    public function getListenersForEvent(object $event): array
    {
        $eventName = get_class($event);
        $listeners = [];
        // array is already sorted by priority
        foreach ($this->listeners as $listener) {
            if (!$this->matchWildcard($listener['pattern'], $eventName)) {
                continue;
            }
            $listeners[] = $listener['listener'];
        }
        return $listeners;
    }

    private function matchWildcard($pattern, $string): bool
    {
        $pattern = preg_quote($pattern, '/');
        $pattern = str_replace('\*', '.*', $pattern);
        return (bool) preg_match('/^' . $pattern . '$/', $string);
    }

    private function compare(array $listener1, array $listener2): int
    {
        return $listener1['priority'] <=> $listener2['priority'];
    }
}
