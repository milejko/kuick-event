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
        $provider->registerListener(
            MockEvent::class,
            function () use (&$data) {
                $data[] = 'foo';
            }
        );
        $provider->registerListener(
            MockEvent::class,
            function () use (&$data) {
                $data[] = 'bar';
            }
        );
        $eventDispatcher = new EventDispatcher($provider);
        $this->assertEquals(new MockEvent(), $eventDispatcher->dispatch(new MockEvent()));
        $this->assertEquals(new stdClass(), $eventDispatcher->dispatch(new stdClass()));
        $this->assertEquals(['foo', 'bar'], $data);
    }

    public function testIfStoppableEventsAreHandledCorrectly(): void
    {
        $provider = new ListenerProvider();
        $data = [];
        $provider->registerListener(StoppableEvent::class, function (StoppableEvent $event) use (&$data) {
            //this listener should be the only one called
            $event->stopPropagation();
            $data[] = 'foo';
        });
        $provider->registerListener(StoppableEvent::class, function () use (&$data) {
            //this listener should not be called
            $data[] = 'bar';
        });
        $eventDispatcher = new EventDispatcher($provider);
        $this->assertInstanceOf(StoppableEvent::class, $eventDispatcher->dispatch(new StoppableEvent()));
        $this->assertEquals(['foo'], $data);
    }
}
