<?php

/**
 * Kuick Event (https://github.com/milejko/kuick-event)
 *
 * @link      https://github.com/milejko/kuick-event
 * @copyright Copyright (c) 2010-2025 Mariusz Miłejko (mariusz@milejko.pl)
 * @license   https://en.wikipedia.org/wiki/BSD_licenses New BSD License
 */

namespace Kuick\Event;

use Psr\EventDispatcher\ListenerProviderInterface as PsrListenerProviderInterface;

interface ListenerProviderInterface extends PsrListenerProviderInterface
{
    /**
     * @param string $eventNameOrPattern The name of the event or a pattern to match against event names
     */
    public function registerListener(string $eventNameOrPattern, callable $listener, int $priority = ListenerPriority::NORMAL): void;
}
