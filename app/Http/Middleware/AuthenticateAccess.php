<?php

namespace App\Http\Middleware;

use App\Core\Controller\Traits\CommonResponse;
use App\Core\Controller\Traits\Error;
use App\Core\Controller\Traits\LaravelResource;
use App\Core\Controller\Traits\LaravelResponse;
use App\Core\Controller\Traits\Meta;
use App\Core\Controller\Traits\Response;
use Closure;

class AuthenticateAccess
{
    use CommonResponse, Error, LaravelResource, LaravelResponse, Meta, Response;

    public function handle($request, Closure $next)
    {
        $allowedSecrets = explode(',', config('app.service_secret'));

        if ($request->hasHeader('Service-Authorization')) {
            $decryptKey = config('app.decrypt_key');
            $cipher = config('app.cipher');
            // pasos para desencriptar
            $password = substr(hash('sha256', $decryptKey, true), 0, 32);
            $iv = chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0);
            $decrypted = openssl_decrypt(base64_decode($request->header('Service-Authorization')), $cipher, $password, OPENSSL_RAW_DATA, $iv);

            if (in_array($decrypted, $allowedSecrets, true)) {
                return $next($request);
            }
        }

        return $this->errorUnauthorized("No está autorizado a consultar este servicio.");
    }
}
