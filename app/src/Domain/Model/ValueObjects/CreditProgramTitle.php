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

final class CreditProgramTitle extends ValueObject
{
    private string $value;

    public function __construct(?string $value)
    {
        if (!$value) {
            throw new RequiredException('credit_program_title');
        }

        $this->value = $value;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function __toString(): string
    {
        return $this->value;
    }

    public function jsonSerialize(): string
    {
        return $this->value;
    }
}
