<?php

namespace App\Domain\Model\Entry;

class RequestEntry
{
    private bool $success;
    private ?string $message;

    /**
     * @param bool $success
     */
    public function __construct(bool $success, ?string $message = null)
    {
        $this->success = $success;
        $this->message = $message;
    }

    public function getSuccess(): bool
    {
        return $this->success;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }
}