<?php

namespace Advans\Api\Lco;

use DateTime;
use Exception;

/**
 * @property DateTime $fecha
 * @property string $cantidad_rfcs
 * @property string $cantidad_certificados
 * @property DateTime $created_at
 */
class Historial extends Model {

    /**
     * @throws Exception
     */
    protected function getFecha(): DateTime {
        return new DateTime($this->attributes['fecha']);
    }

    /**
     * @throws Exception
     */
    protected function getCreatedAt(): DateTime {
        return new DateTime($this->attributes['created_at']);
    }

}