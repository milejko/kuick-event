<?php

namespace Kuick\Event\Tests\Unit;

use Kuick\Event\EventDispatcher;
use Kuick\Event\ListenerPriority;
use PHPUnit\Framework\TestCase;
use Kuick\Event\ListenerProvider;
use stdClass;
use Tests\Kuick\Event\Mocks\MockEvent;

/**
 * @covers \Kuick\Event\EventDispatcher
 */
class EventDispatcherTest extends TestCase
{
    public function testIfAddedListenerCanBeRetrieved(): void
    {
        $provider = new ListenerProvider();
        $data = [];
        $listener1 = function () use (&$data) {
            $data[] = 'foo';
        };
        $listener2 = function () use (&$data) {
            $data[] = 'bar';
        };
        $eventDispatcher = new EventDispatcher($provider);
        $eventDispatcher->subscribe(MockEvent::class, $listener1);
        $eventDispatcher->subscribe(stdClass::class, $listener2);
        $this->assertEquals(new MockEvent(), $eventDispatcher->dispatch(new MockEvent()));
        $this->assertEquals(new stdClass(), $eventDispatcher->dispatch(new stdClass()));
        $this->assertEquals(['foo', 'bar'], $data);
    }
}
