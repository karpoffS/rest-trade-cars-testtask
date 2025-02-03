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

final class RequiredException extends \DomainException
{
    public function __construct($fieldName)
    {
        parent::__construct(sprintf('validation.required.$1', $fieldName));
    }
}
