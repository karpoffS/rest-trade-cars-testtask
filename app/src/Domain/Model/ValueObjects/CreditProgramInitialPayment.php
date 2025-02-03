<?php

declare(strict_types=1);

/*
 * This file is part of test work.
 *
 * (c) Karpov Sergey <sergi.me@yandex.ru>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace App\Domain\Model\ValueObjects;

use App\Common\Domain\Exceptions\RequiredException;
use App\Common\Domain\ValueObject;

final class CreditProgramInitialPayment extends ValueObject
{
    private int $value;

    public function __construct(?int $value)
    {
        if (!$value) {
            throw new RequiredException('initialPayment');
        }

        $this->value = $value;
    }

    public function getValue(): int
    {
        return $this->value;
    }

    public function __toString(): string
    {
        return (string) $this->value;
    }

    public function jsonSerialize(): int
    {
        return $this->value;
    }
}
