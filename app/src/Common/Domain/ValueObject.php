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

namespace App\Common\Domain;

abstract class ValueObject implements \JsonSerializable
{
    public function splitField(?string $field, $max_length = 80): array
    {
        return explode(
            PHP_EOL,
            wordwrap(
                $field ?
                    (string) $this->{$field} :
                    $this->jsonSerialize(),
                $max_length,
                PHP_EOL
            )
        );
    }

    public function equals(self $other): bool
    {
        return $this->jsonSerialize() === $other->jsonSerialize();
    }
}
