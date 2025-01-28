<?php

namespace App\Domain\Model\Entry;

class RequestEntry
{
    private bool $success;

    /**
     * @param bool $success
     */
    public function __construct(bool $success)
    {
        $this->success = $success;
    }

    public function getSuccess(): bool
    {
        return $this->success;
    }
}