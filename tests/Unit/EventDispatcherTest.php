<?php

namespace Kuick\Event\Tests\Unit;

use Kuick\Event\EventDispatcher;
use Kuick\Event\ListenerPriority;
use PHPUnit\Framework\TestCase;
use Kuick\Event\ListenerProvider;
use stdClass;
use Tests\Kuick\Event\Mocks\MockEvent;
use Tests\Kuick\Event\Mocks\StoppableEvent;

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
        $provider->registerListener(MockEvent::class, $listener1);
        $provider->registerListener(MockEvent::class, $listener2);
        $eventDispatcher = new EventDispatcher($provider);
        $this->assertEquals(new MockEvent(), $eventDispatcher->dispatch(new MockEvent()));
        $this->assertEquals(new stdClass(), $eventDispatcher->dispatch(new stdClass()));
        $this->assertEquals(['foo', 'bar'], $data);
    }

    public function testIfStoppableEventsAreHandledCorrectly(): void
    {
        $provider = new ListenerProvider();
        $data = [];
        $listener1 = function (StoppableEvent $event) use (&$data) {
            $event->stopPropagation();
            $data[] = 'foo';
        };
        $listener2 = function () use (&$data) {
            $data[] = 'bar';
        };
        $provider->registerListener(StoppableEvent::class, $listener1);
        $provider->registerListener(StoppableEvent::class, $listener2);

        $eventDispatcher = new EventDispatcher($provider);
        $this->assertInstanceOf(StoppableEvent::class, $eventDispatcher->dispatch(new StoppableEvent()));
        $this->assertEquals(['foo'], $data);
    }
}
