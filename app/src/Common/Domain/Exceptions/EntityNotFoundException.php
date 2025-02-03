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

class EntityNotFoundException extends \DomainException
{
    public function __construct(string $message = 'Entity not found')
    {
        parent::__construct($message);
    }
}
