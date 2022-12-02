<?php

namespace Advans\Api\Lco;

use DateTime;

/**
 * Class Contribuyente
 * @package Advans\Api\Lco
 * @property string $serial
 * @property bool $validez_obligaciones
 * @property string $estatus_certificado
 * @property string $rfc
 * @property DateTime $fecha_inicio
 * @property DateTime $fecha_fin
 */
class Contribuyente {

    protected $attributes;

    public function __construct($attributes) {
        $this->attributes = $attributes;
    }

    public function isEstatusActive() {
        return $this->attributes['estatus_certificado'] == 'A';
    }

    public function isEstatusRevocado() {
        return $this->attributes['estatus_certificado'] == 'R';
    }

    public function isEstatusCancelado() {
        return $this->attributes['estatus_certificado'] == 'C';
    }

    public function toArray() {
        return $this->attributes;
    }

    public function toJson() {
        return json_encode($this->attributes);
    }

    protected function getFechaInicio() {
        return new DateTime($this->attributes['fecha_inicio']);
    }

    protected function getFechaFin() {
        return new DateTime($this->attributes['fecha_fin']);
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