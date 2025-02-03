<?php

namespace App\Domain\Requests;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

abstract class BaseRequest
{
    protected ValidatorInterface $validator;
    protected \ReflectionClass $reflectionClass;

    /**
     * @param ValidatorInterface $validator
     */
    public function __construct(ValidatorInterface $validator)
    {
        $this->validator = $validator;
        $this->reflectionClass = new \ReflectionClass(static::class);
        $this->populate();
    }

    public function validate(): ConstraintViolationListInterface
    {
        return $this->validator->validate($this);
    }

    public function getRequest(): Request
    {
        return Request::createFromGlobals();
    }

    protected function populate(): void
    {
        foreach ($this->getRequest()->toArray() as $key => $value) {
            if ($this->reflectionClass->hasProperty($key) && $this->reflectionClass->getProperty($key)->isPublic()) {
                $this->{$key} = $value;
            }
            if ($this->reflectionClass->hasMethod('set'.ucfirst($key)) && $this->reflectionClass->getMethod($key)->isPublic()) {
                call_user_func([$this, 'set'.ucfirst($key)], $value);
            }
        }
    }
}
