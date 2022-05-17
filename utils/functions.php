<?php

/**
 * Función encargada de obtener el valor de las
 * claves que se encuentran en el archivo de
 * env.php
 *
 * @param string $key recibe un string con el nombre de la clave
 * @return void
 */
function obtenerVariableDelEntorno($key)
{
    if (defined("_ENV_CACHE")) {
        $vars = _ENV_CACHE;
    } else {
        $file = "../env.php";
        if (!file_exists($file)) {
            throw new Exception("El archivo de las variables de entorno ($file) no existe. Favor de crearlo");
        }
        $vars = parse_ini_file($file);
        define("_ENV_CACHE", $vars);
    }
    if (isset($vars[$key])) {
        return $vars[$key];
    } else {
        throw new Exception("La clave especificada (" . $key . ") no existe en el archivo de las variables de entorno");
    }
}


/**
 * Función encargada de iniciar un phpsession
 * en caso de que no exista
 *
 * @return void
 */
function startSessionIfNotExist()
{
    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
    }
}

function is_session_started()
{
    if (php_sapi_name() !== 'cli') {
        if (version_compare(phpversion(), '5.4.0', '>=')) {
            return session_status() === PHP_SESSION_ACTIVE ? TRUE : FALSE;
        } else {
            return session_id() === '' ? FALSE : TRUE;
        }
    }
    return FALSE;
}

function gen_uid($l=10){
    return substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyz"), 0, $l);
}

