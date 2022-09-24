<?php

namespace App\Library;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AppHelper
{
    public static function limpaCPF_CNPJ($valor)
    {
        $valor = trim($valor);
        $valor = str_replace(".", "", $valor);
        $valor = str_replace(",", "", $valor);
        $valor = str_replace("-", "", $valor);
        $valor = str_replace("/", "", $valor);
        return $valor;
    }

    public static function formatarCPF_CNPJ($valor)
    {
        $valorFormatado = '';
        $valor = preg_replace("/[^0-9]/", "", $valor);

        if (strlen($valor) === 11) {
            $valorFormatado = substr($valor, 0, 3) . '.' .
                substr($valor, 3, 3) . '.' .
                substr($valor, 6, 3) . '-' .
                substr($valor, 9, 2);
        } else {
            $valorFormatado = substr($valor, 0, 2) . '.' .
                substr($valor, 2, 3) . '.' .
                substr($valor, 5, 3) . '/' .
                substr($valor, 8, 4) . '-' .
                substr($valor, -2);
        }
        return $valorFormatado;
    }

    public static function isGerenteDoSistema()
    {
        $usuarioEncontrado = User::getRoleByUserId(Auth::user()->id);
        return $usuarioEncontrado?->nome == 'Admin';
    }

    public static function numericParaReal($valorNumeric)
    {
        return number_format($valorNumeric, 2, ',', '.');
    }

    public static function realParaNumeric($valorReal)
    {
        $valorRealString = str_replace(".", "", $valorReal);
        $valorReal = str_replace(",", ".", $valorRealString);

        return number_format((float)$valorReal, 2, '.', '');
    }

    /**
     * formatToDateMonthYearTimestamp
     *
     * Receives a string Date like '2021-12-31 08:32:00'
     * and formats it to a timestamp like '2021-12-01 00:00:00'
     * to be stored in Databases
     *
     * @param String $stringDate Date string to be formatted.
     * @return Int timestamp.
     */
    public static function formatToDateMonthYearTimestamp($stringDate)
    {
        $mes = substr($stringDate, 0, 2);
        $ano = substr($stringDate, 3);

        $dateStr = $ano . '-' . $mes . '-' . '01' .  '00:00:00';

        return strtotime($dateStr);
    }

    public static function str_icontains($haystack, $needle)
    {
        $smallhaystack = strtolower($haystack);  // make the haystack lowercase, which essentially makes it case insensitive
        $smallneedle = strtolower($needle);  // makes the needle lowercase, which essentially makes it case insensitive
        if (str_contains($smallhaystack, $smallneedle)) {  // compares the lowercase strings
            return true;  // returns true (wow)
        }

        return false;  // returns false (wow)

    }

    public static function generateSodiumKeybyteString()
    {
        $keyByte = random_bytes(SODIUM_CRYPTO_SECRETBOX_KEYBYTES);
        return bin2hex($keyByte);
    }

    public static function getSodiumKeyByteFromHexString($keyHexString)
    {
        return hex2bin($keyHexString);
    }

    public static function encodeString($stringToEncode, $key)
    {
        $nonce = random_bytes(SODIUM_CRYPTO_SECRETBOX_NONCEBYTES);
        $encrypted_result = sodium_crypto_secretbox($stringToEncode, $nonce, $key);
        $encoded = base64_encode($nonce . $encrypted_result);

        return $encoded;
    }

    public static function decodeString($stringToDecode, $key)
    {
        $decoded = base64_decode($stringToDecode);
        $nonce = mb_substr($decoded, 0, SODIUM_CRYPTO_SECRETBOX_NONCEBYTES, '8bit');
        $encrypted_result = mb_substr($decoded, SODIUM_CRYPTO_SECRETBOX_NONCEBYTES, null, '8bit');
        $plaintext = sodium_crypto_secretbox_open($encrypted_result, $nonce, $key);

        return $plaintext;
    }

    public static function formatDate($date, $formatInput, $formatOutPut)
    {
        $monthNames = [
            'Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho',
            'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'
        ];
        if ($formatOutPut === 'YY-MM-dd' && $formatInput === 'YY-mm-dd') {
            $explodeDate = explode('-', $date);
            $explodeDate[1] = $monthNames[$explodeDate[1] - 1];
            return implode('-', $explodeDate);
        }
    }
}
