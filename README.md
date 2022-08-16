# advans/php-api-lco

[![Latest Stable Version](https://img.shields.io/packagist/v/advans/php-api-lco?style=flat-square)](https://packagist.org/packages/advans/php-api-lco)
[![Total Downloads](https://img.shields.io/packagist/dt/advans/php-api-lco?style=flat-square)](https://packagist.org/packages/advans/php-api-lco)

## Instalación usando Composer

```sh
$ composer require advans/php-api-lco
```

## Ejemplo

````
$lco = new \Advans\Api\Lco\Lco([
    'endpoint' => 'https://ws40.advans.mx/api-lco/',
    'key' => '**********************',
    'use_exceptions' => false,
]);

$serial = '00001000000514412260';
$response = $lco->getBySerial($serial);
````

## Configuración

| Parámetro | Valor por defecto | Descripción |
| :--- | :--- | :--- |
| endpoint | null | URL de la API |
| key | null | API Key |
| use_exceptions | true | Define si una respuesta con error dispara un Exception
