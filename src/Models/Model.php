<?php

namespace Advans\Api\Lco;

class Model {

    protected array $attributes;

    public function __construct($attributes) {
        $this->attributes = $attributes;
    }

    public function toArray() {
        return $this->attributes;
    }

    public function toJson() {
        return json_encode($this->attributes);
    }

    public function __get($name) {
        if (!isset($this->attributes[$name])) {
            return null;
        }

        $method_name = str_replace('_', ' ', $name);
        $method_name = ucwords($method_name);
        $method_name = str_replace(' ', '', $method_name);
        $method_name = lcfirst($method_name);
        $method_name = 'get' . $method_name;

        if (method_exists($this, $method_name)) {
            return $this->$method_name();
        }
        return $this->attributes[$name];
    }
}