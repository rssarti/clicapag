<?php

namespace App\Services;

use App\Models\Transaction;
use App\Models\User;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class Utils
{
    public static function validaCPF($cpf)
    {

        // Extrai somente os números
        $cpf = preg_replace('/[^0-9]/is', '', $cpf);

        // Verifica se foi informado todos os digitos corretamente
        if (strlen($cpf) != 11) {
            return false;
        }

        // Verifica se foi informada uma sequência de digitos repetidos. Ex: 111.111.111-11
        if (preg_match('/(\d)\1{10}/', $cpf)) {
            return false;
        }

        // Faz o calculo para validar o CPF
        for ($t = 9; $t < 11; $t++) {
            for ($d = 0, $c = 0; $c < $t; $c++) {
                $d += $cpf[$c] * (($t + 1) - $c);
            }
            $d = ((10 * $d) % 11) % 10;
            if ($cpf[$c] != $d) {
                return false;
            }
        }

        return true;

    }

    public static function validarCNPJ($cnpj)
    {
        $cnpj = preg_replace('/[^0-9]/', '', (string) $cnpj);

        // Valida tamanho
        if (strlen($cnpj) != 14) {
            return false;
        }

        // Verifica se todos os digitos são iguais
        if (preg_match('/(\d)\1{13}/', $cnpj)) {
            return false;
        }

        // Valida primeiro dígito verificador
        for ($i = 0, $j = 5, $soma = 0; $i < 12; $i++) {
            $soma += $cnpj[$i] * $j;
            $j = ($j == 2) ? 9 : $j - 1;
        }

        $resto = $soma % 11;

        if ($cnpj[12] != ($resto < 2 ? 0 : 11 - $resto)) {
            return false;
        }

        // Valida segundo dígito verificador
        for ($i = 0, $j = 6, $soma = 0; $i < 13; $i++) {
            $soma += $cnpj[$i] * $j;
            $j = ($j == 2) ? 9 : $j - 1;
        }

        $resto = $soma % 11;

        return $cnpj[13] == ($resto < 2 ? 0 : 11 - $resto);
    }

    public static function verificaCep($cep)
    {
        if (strlen($cep) == 9) {

            $cep = str_replace('-', '', $cep);
            $response = Http::acceptJson()->get('https://viacep.com.br/ws/'.$cep.'/json/');
            $data = json_decode($response->body(), true);

            return $data;

        }
    }

    public static function removeCaracteres($data)
    {
        return preg_replace('/[^0-9]/', '', $data);
    }

    public static function convertAddressTextToLatLng($text)
    {

        $url = 'https://maps.googleapis.com/maps/api/geocode/json?address='.$text.'&key='.config('app.google_key_maps');

        $body = Http::get($url);
        $data = json_decode($body->body(), true);

        return $data['results'][0]['geometry']['location'];

    }

    public static function convertAddressTextToGeocode($text)
    {

        $url = 'https://maps.googleapis.com/maps/api/geocode/json?address='.$text.'&key='.config('app.google_key_maps');

        $body = Http::get($url);
        $data = json_decode($body->body(), true);

        return $data['results'][0];

    }

    public static function wallet(User $user)
    {
        return Transaction::where('user_id', $user->id)
            ->where('status', 'succeeded')
            ->sum('amount');
    }

    static function consultaCep($cep)
    {
        $response = \Http::get('viacep.com.br/ws/'.Str::remove('-', $cep).'/json/');
        return json_decode($response->body());

    }
}
