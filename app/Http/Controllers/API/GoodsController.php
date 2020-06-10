<?php

namespace App\Http\Controllers\API;

use App\Good;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class GoodsController extends Controller
{
    public function search(Request $request)
    {

        $id = $request['id'];
        $details = Good::find($id)->details()->get();
        // $options = $details
        $prices = Good::find($id)->prices()->get();
//$info = dd(json_decode($details, true));
        if ($details === null) {
            $details = array(0 => 'nada');
            echo json_encode($details);
        } else {

            echo json_encode(array('details' => $details, 'prices' => $prices));

        }

    }

}
