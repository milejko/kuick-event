<?php

namespace Kuick\Event\Tests\Unit;

use Kuick\Event\ListenerPriority;
use PHPUnit\Framework\TestCase;
use Kuick\Event\ListenerProvider;
use stdClass;
use Tests\Kuick\Event\Mocks\MockEvent;

/**
 * @covers \Kuick\Event\ListenerProvider
 */
class ListenerProviderTest extends TestCase
{
    public function testIfAddedListenerCanBeRetrieved(): void
    {
        $provider = new ListenerProvider();
        $listener = function () {
        };
        $provider->registerListener(MockEvent::class, $listener);
        $this->assertEquals([$listener], $provider->getListenersForEvent(new MockEvent()));
    }

    public function testIfListenerPriorityWorks(): void
    {
        $provider = new ListenerProvider();
        $listener1 = function () {
        };
        $listener2 = function () {
        };
        $listener3 = function () {
        };
        $provider->registerListener(MockEvent::class, $listener1, ListenerPriority::HIGH);
        $provider->registerListener(MockEvent::class, $listener2, ListenerPriority::LOW);
        $provider->registerListener(MockEvent::class, $listener3);
        $this->assertEquals([$listener2, $listener3, $listener1], $provider->getListenersForEvent(new MockEvent()));
        $this->assertEmpty($provider->getListenersForEvent(new stdClass()));
    }

    public function testIfWildcardRegistrationWorks(): void
    {
        $provider = new ListenerProvider();
        $listener1 = function () {
        };
        $listener2 = function () {
        };
        $listener3 = function () {
        };
        $listener4 = function () {
        };
        $provider->registerListener('WillNotMatchAThing*', $listener1, ListenerPriority::HIGH);
        $provider->registerListener(MockEvent::class, $listener2, ListenerPriority::LOW);
        $provider->registerListener('*', $listener3);
        $provider->registerListener('std*', $listener4);
        $this->assertEquals([$listener2, $listener1], $provider->getListenersForEvent(new MockEvent()));
        $this->assertEquals([$listener3, $listener4], $provider->getListenersForEvent(new stdClass()));
    }
}
