<?php

namespace Tests\Kuick\EventDispatcher\Mocks;

use Psr\EventDispatcher\StoppableEventInterface;

class StoppableEvent implements StoppableEventInterface
{
    private bool $isPropagationStopped = false;

    public function isPropagationStopped(): bool
    {
        return $this->isPropagationStopped;
    }

    public function stopPropagation(): void
    {
        $this->isPropagationStopped = true;
    }
}
