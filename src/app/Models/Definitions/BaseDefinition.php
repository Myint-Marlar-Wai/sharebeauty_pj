<?php

declare(strict_types=1);

namespace App\Models\Definitions;

use App\Models\Support\Tbl;
use LogicException;
use ReflectionClass;
use ReflectionProperty;

abstract class BaseDefinition
{
    protected string $__baseName;

    protected array $__properties;

    protected null|string $__name;

    /**
     * @param string $name
     */
    public function __construct(string $name)
    {
        $name = $this->normalizeName($name);
        $this->__baseName = $name;
    }

    protected function normalizeName(string $name) : string
    {
        if (Tbl::isClass($name)) {
            $name = Tbl::table($name);
        }

        return $name;
    }

    public function initialize(?string $as) : static
    {
        $reflect = new ReflectionClass($this);
        $reflectProps = $reflect->getProperties(ReflectionProperty::IS_PUBLIC);
        $properties = [];
        foreach ($reflectProps as $reflectProp) {
            $property = $reflectProp->getName();
            $value = $reflectProp->isInitialized($this) ?
                $reflectProp->getValue($this) : null;
            if ($value === null) {
                $value = $property;
            }
            if (! is_string($value)) {
                throw new LogicException();
            }
            $properties[$property] = $value;
        }
        $this->__properties = $properties;

        return $this->alias($as);
    }

    public function alias(?string $as) : static
    {
        $this->__name = $as;
        $name = $as;
        if ($name === null) {
            $name = $this->__baseName;
        }
        $properties = $this->__properties;
        foreach ($properties as $property => $value) {
            $this->{$property} = $name.'.'.$value;
        }

        return $this;
    }

    public function noname() : static
    {
        $properties = $this->__properties;
        foreach ($properties as $property => $value) {
            $this->{$property} = $value;
        }

        return $this;
    }

    public function getTable() : string
    {
        $name = $this->__name;
        if ($name !== null) {
            return $this->__baseName.' as '.$name;
        } else {
            return $this->__baseName;
        }
    }
}
