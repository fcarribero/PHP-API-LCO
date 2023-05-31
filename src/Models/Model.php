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

        $name = str_replace('_', ' ', $name);
        $name = ucwords($name);
        $name = str_replace(' ', '', $name);
        $name = lcfirst($name);

        $method_name = 'get' . $name;
        if (method_exists($this, $method_name)) {
            return $this->$method_name();
        }
        return $this->attributes[$name];
    }
}