<?php

/*
 * This file is part of test work.
 *
 * (c) Karpov Sergey <sergi.me@yandex.ru>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace App\Common\Domain\Exceptions;

final class MaximumValueException extends \DomainException
{
    public function __construct($fieldName, $value)
    {
        parent::__construct(sprintf("The maximum value for $1 is $2", $fieldName, $value));
    }
}
