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

use Carbon\Carbon;
use App\Common\Domain\Exceptions\RequiredException;
use App\Common\Domain\ValueObject;

final class EndDate extends ValueObject
{
    public Carbon $date;

    public function __construct(?Carbon $date)
    {
        if (!$date) {
            throw new RequiredException('created_at');
        }
        $this->date = $date;
    }

    public function __toString(): string
    {
        return $this->date->format('d.m.Y hh:mm:ss');
    }

    public static function fromString(string $date): self
    {
        return new self(Carbon::parse($date));
    }

    public function jsonSerialize(): string
    {
        return $this->date->toJSON();
    }
}
