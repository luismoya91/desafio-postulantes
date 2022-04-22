<?php

namespace App\Http\Controllers;

use Goutte\Client;
use Illuminate\Http\Request;

class ScrapingController extends Controller
{
    public function index(Client $client)
    {
        $headers = [
            "Connection: keep-alive",
            "Accept: application/json, text/javascript, */*; q=0.01",
            "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/65.0.3325.181 Safari/537.36",
            "DNT: 1",
            "Accept-Language: pt,en-US;q=0.9,en;q=0.8,pt-PT;q=0.7,pt-BR;q=0.6",
        ];
        $ch = curl_init();
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,"https://www.sii.cl/servicios_online/1047-nomina_inst_financieras-1714.csv");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $archivocsv = curl_exec ($ch);
        curl_close ($ch);
        // $array_archivocsv = explode(";",$archivocsv);
        $array_archivocsv = str_getcsv($archivocsv,"\n");
        $array_salida = [];
        $titles = str_getcsv($array_archivocsv[0],";");

        foreach ($array_archivocsv as $key => $value) {
            if ($key > 0) {
                $array_value = str_getcsv($value,";");
                $array_salida[] = [
                    $titles[0] => $array_value[0],
                    $titles[1] => $array_value[1],
                    $titles[2] => $array_value[2],
                    $titles[3] => $array_value[3],
                    $titles[4] => $array_value[4],
                    $titles[5] => $array_value[5],
                    $titles[6] => $array_value[6],
                    $titles[7] => $array_value[7],
                    $titles[8] => $array_value[8],
                    $titles[9] => $array_value[9],
                    $titles[10] => $array_value[10],
                ];
            }
        }
        return response()->json($array_salida,200);
    }
}
