<?php


namespace Advans\Api\Lco;

use Exception;

class Lco {

    protected Config $config;

    /**
     * @param Config $config
     */
    public function __construct(Config $config) {
        $this->config = $config;
    }

    /**
     * @return bool|string
     * @throws LcoException
     */
    public function status() {
        return trim($this->call('status'));
    }

    /**
     * @param string $serial
     * @param string $fecha
     * @return Contribuyente
     * @throws LcoException
     */
    public function getBySerial(string $serial, string $fecha = 'now'): Contribuyente {
        $result = json_decode($this->call('v2/lco/by-serial/' . $fecha . '/' . $serial), true);
        return new Contribuyente($result);
    }

    /**
     * @param string $rfc
     * @param string $fecha
     * @return Contribuyente[]
     * @throws LcoException
     */
    public function getByRFC(string $rfc, string $fecha = 'now'): array {
        $result = json_decode($this->call('v2/lco/by-rfc/' . $fecha . '/' . $rfc), true);
        $contribuyentes = [];
        foreach ($result as $contribuyente) {
            $contribuyentes[] = new Contribuyente($contribuyente);
        }
        return $contribuyentes;
    }

    /**
     * @param int $limit
     * @param int $offset
     * @return Historial[]
     * @throws LcoException
     */
    public function getHistorial(int $limit, int $offset = 0): array{
        $result = json_decode($this->call('v2/historial/' . $limit . '/' . $offset), true);
        $historial = [];
        foreach ($result as $dia) {
            $historial[] = new Historial($dia);
        }
        return $historial;
    }

    /**
     * @throws LcoException
     */
    public function getCertificadoBySerial(string $serial): string {
        return $this->call('v2/certificado/by-serial/' . $serial);
    }

    /**
     * @throws LcoException
     */
    public function getCertificadoDetailsBySerial(string $serial): array {
        return json_decode($this->call('v2/certificado/details/by-serial/' . $serial), true);
    }

    /**
     * @param $method
     * @param string $verb
     * @param null $params
     * @return bool|string
     * @throws LcoException
     */
    protected function call($method, string $verb = 'GET', $params = null) {
        $verb = strtoupper($verb);
        $url = $this->config->base_url . $method;
        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => $url . ($verb == 'GET' && $params ? '?' . http_build_query($params) : ''),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => $verb,
            CURLOPT_POSTFIELDS => $verb == 'POST' && $params ? json_encode($params) : null,
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/json',
                'Authorization: Bearer ' . $this->config->key
            ]
        ]);
        $result = curl_exec($curl);
        $http_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);
        if ($http_code != 200 || $result === false) {
            throw new LcoException('Error de conexión con la LCO', $http_code);
        }
        return $result;
    }
}