<?php

namespace App\Http\Controllers\API;

use App\Client;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ClientsController extends Controller
{

    public function sunat(Request $request)
    {
        $ruc = $request['ruc'];
        $data = file_get_contents("https://api.sunat.cloud/ruc/" . $ruc);
        $info = json_decode($data, true);
        if ($data === '[]' || $info['fecha_inscripcion'] === '--') {
            $datos = array(0 => 'nada');
            echo json_encode($datos);
        } else {
            $datos = array(
                0 => $info['ruc'],
                1 => $info['razon_social'],
                2 => $info['contribuyente_condicion'],
                3 => $info['domicilio_fiscal'],
            );

            echo json_encode($datos);
        }

    }

    public function ruc(Request $request)
    {
        $ruc = $request['ruc'];
        $client = Client::where('ruc', $ruc)->with('adresses')->orWhere('dni', $ruc)->first();
        //$info = dd(json_decode($data, true));
        if ($client === null) {
            $client = array(0 => 'nada');
            echo json_encode($client);
        } else {

            echo json_encode($client);
        }

    }

    public function name(Request $request)
    {

        $name = $request['name'];
        $client = Client::where('client_name', 'LIKE', "%$name%")->first();
        $adresses = $client->adresses;

        if ($client === null) {
            $client = array(0 => 'nada');
            echo json_encode($client);
        } else {

            //echo json_encode($client);
            echo json_encode(array('client' => $client, 'adresses' => $adresses));

        }

    }
}
