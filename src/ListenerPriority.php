<?php

/**
 * Kuick Event (https://github.com/milejko/kuick-event)
 *
 * @link      https://github.com/milejko/kuick-event
 * @copyright Copyright (c) 2010-2025 Mariusz Miłejko (mariusz@milejko.pl)
 * @license   https://en.wikipedia.org/wiki/BSD_licenses New BSD License
 */

namespace Kuick\EventDispatcher;

class ListenerPriority
{
    public const LOWEST     = PHP_INT_MIN;
    public const LOW        = -100;
    public const NORMAL     = 0;
    public const HIGH       = 100;
    public const HIGHEST    = PHP_INT_MAX;
}
