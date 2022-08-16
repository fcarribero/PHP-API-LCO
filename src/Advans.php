<?php


namespace Advans\Api\Lco;

use Exception;

class Lco {

    protected $config = [];

    public function __construct($config) {
        $this->config = array_merge(['use_exceptions' => true], $config);

        if (!isset($this->config['endpoint'])) {
            throw new Exception('No se ha definido el endpoint de la API');
        }

        if (!isset($this->config['key'])) {
            throw new Exception('No se ha definido la clave de la API');
        }

        if (substr($this->config['endpoint'], -1, 1) != '/') {
            $this->config['endpoint'] .= '/';
        }
    }

    public function status() {
        return $this->call('status');
    }

    public function getBySerial($serial, $fecha = 'now') {
        return $this->call('v2/lco/by-serial/' . $serial);
    }

    public function getByRFC($rfc, $fecha = 'now') {
        return $this->call('v2/lco/by-rfc/' . $rfc);
    }

    public function getHistorial($limit, $offset) {
        return $this->call('v2/consultar/' . $limit . '/' . $offset);
    }

    protected function call($method, $verb = 'GET', $params = null) {
        $verb = strtoupper($verb);
        $url = $this->config['endpoint'] . $method;
        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => $url . ($verb == 'GET' && $params ? '?' . http_build_query($params) : ''),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => $verb,
            CURLOPT_POSTFIELDS => $verb == 'POST' && $params ? json_encode($params) : null,
            CURLOPT_XOAUTH2_BEARER => $this->config['key'],
        ]);
        $result = curl_exec($curl);
        $http_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);
        if ($http_code != 200 || $result === false) {
            if ($this->config['use_exceptions']) {
                throw new Exception('Error de conexión con la LCO');
            } else {
                return false;
            }
        }
        return @json_decode($result);
    }
}