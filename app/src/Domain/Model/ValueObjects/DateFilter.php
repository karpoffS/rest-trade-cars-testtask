<?php

/*
 * This file is part of test work.
 *
 * (c) Karpov Sergey <sergi.me@yandex.ru>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace App\Domain\Model\ValueObjects;

use App\Common\Domain\ValueObject;

final class DateFilter extends ValueObject
{
    public StartDate $startDate;
    public EndDate $endDate;

    /**
     * @param StartDate $startDate
     * @param EndDate $endDate
     */
    public function __construct(StartDate $startDate, EndDate $endDate)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function __toString(): string
    {
        return implode(
            '|',
            [
                $this->startDate->format('d.m.Y hh:mm:ss'),
                $this->endDate->format('d.m.Y hh:mm:ss'),
            ]
        );
    }

    public static function fromCarbons(Carbon $startDate, Carbon $endDate): self
    {
        return new self(
            StartDate::fromString($startDate->toString()),
            EndDate::fromString($endDate->toString())
        );
    }

    public function jsonSerialize(): string
    {
        return (string) json_encode([
            $this->startDate->toJSON(),
            $this->endDate->toJSON(),
        ]);
    }
}
