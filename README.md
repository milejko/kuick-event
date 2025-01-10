# Kuick Event
[![Latest Version](https://img.shields.io/github/release/milejko/kuick-event.svg?cacheSeconds=3600)](https://github.com/milejko/kuick-event/releases)
[![PHP](https://img.shields.io/badge/PHP-8.2%20|%208.3%20|%208.4-blue?logo=php&cacheSeconds=3600)](https://www.php.net)
[![Total Downloads](https://img.shields.io/packagist/dt/kuick/event.svg?cacheSeconds=3600)](https://packagist.org/packages/kuick/event)
[![GitHub Actions CI](https://github.com/milejko/kuick-event/actions/workflows/ci.yml/badge.svg)](https://github.com/milejko/kuick-event/actions/workflows/ci.yml)
[![codecov](https://codecov.io/gh/milejko/kuick-event/graph/badge.svg?token=80QEBDHGPH)](https://codecov.io/gh/milejko/kuick-event)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?cacheSeconds=14400)](LICENSE)

## PSR-14 Event Dispatcher lightweight implementation

### Key features
1. PSR-14 compatibility
2. Easy to use listener registration
3. Support for wildcard listeners (ie. ClassName*)
4. Listener prioritization

### Examples
1. Registering listeners to the listener provider
```
<?php

use Kuick\Event\EventDispatcher;
use Kuick\Event\ListenerProvider;

$provider = new ListenerProvider();
$provider->registerListener(
    'some class name or pattern',
    function () {
        //handle the event
    }
);

$dispatcher = new EventDispatcher($provider);
// $dispatcher->dispatch(new SomeEvent());
```
2. Listener prioritization (using stdClass as event)
```
<?php

use stdClass;
use Kuick\Event\EventDispatcher;
use Kuick\Event\ListenerPriority;
use Kuick\Event\ListenerProvider;

$provider = new ListenerProvider();
$provider->registerListener(
    stdClass::class,
    function () {
        //handle the event
    },
    ListenerPriority::HIGH
);
$provider->registerListener(
    stdClass::class,
    function () {
        //handler the event
    },
    ListenerPriority::LOW
);
$dispatcher = new EventDispatcher($provider);
$dispatcher->dispatch(new stdClass());
```
3. Wildcards
```
<?php

use stdClass;
use Kuick\Event\EventDispatcher;
use Kuick\Event\ListenerProvider;

$provider = new ListenerProvider();
$provider->registerListener(
    '*',
    function () {
        //handle the event
    }
);
$provider->registerListener(
    'std*',
    function () {
        //handler the event
    }
);
$dispatcher = new EventDispatcher($provider);
// it should match both listeners
$dispatcher->dispatch(new stdClass());
```