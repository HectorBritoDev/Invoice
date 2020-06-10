<?php

namespace App\Imports;

use App\Client;
use App\ClientUser;
use Maatwebsite\Excel\Concerns\ToModel;

class ClientsImport implements ToModel
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        $client = Client::create([
            'ruc' => $row[0],
            'client_name' => $row[1],
            'client_email' => $row[2],
            'client_cellphone' => $row[3],
            'sunat_situation' => $row[4],

        ]);
        return ClientUser::create(['user_id' => auth()->user()->id, 'client_id' => $client->id]);
    }
}
