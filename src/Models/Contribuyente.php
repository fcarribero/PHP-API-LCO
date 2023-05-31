<?php

namespace Advans\Api\Lco;

use DateTime;
use Exception;

/**
 * @property string $serial
 * @property bool $validez_obligaciones
 * @property string $estatus_certificado
 * @property string $rfc
 * @property DateTime $fecha_inicio
 * @property DateTime $fecha_fin
 */
class Contribuyente extends Model {

    public function isEstatusActive(): bool {
        return $this->attributes['estatus_certificado'] == 'A';
    }

    public function isEstatusRevocado(): bool {
        return $this->attributes['estatus_certificado'] == 'R';
    }

    public function isEstatusCancelado(): bool {
        return $this->attributes['estatus_certificado'] == 'C';
    }

    /**
     * @throws Exception
     */
    protected function getFechaInicio(): DateTime {
        return new DateTime($this->attributes['fecha_inicio']);
    }

    /**
     * @throws Exception
     */
    protected function getFechaFin(): DateTime {
        return new DateTime($this->attributes['fecha_fin']);
    }

}