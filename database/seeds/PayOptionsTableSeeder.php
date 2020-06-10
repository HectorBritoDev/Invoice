<?php

use App\PayOption;
use Illuminate\Database\Seeder;

class PayOptionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PayOption::create(['code' => '1', 'name' => 'DEPÓSITO EN CUENTA']);
        PayOption::create(['code' => '2', 'name' => 'GIRO']);
        PayOption::create(['code' => '3', 'name' => 'TRANSFERENCIA DE FONDOS']);
        PayOption::create(['code' => '4', 'name' => 'ORDEN DE PAGO']);
        PayOption::create(['code' => '5', 'name' => 'TARJETA DE DÉBITO']);
        PayOption::create(['code' => '6', 'name' => 'TARJETA DE CRÉDITO']);
        PayOption::create(['code' => '7', 'name' => 'CHEQUES CON LA CLÁUSULA DE "NO NEGOCIABLE", "INTRANSFERIBLES", "NO A LA ORDEN" U OTRA EQUIVALENTE, A QUE SE REFIERE EL INCISO F) DEL ARTICULO 5° DEL DECRETO LEGISLATIVO.']);
        PayOption::create(['code' => '8', 'name' => 'EFECTIVO, POR OPERACIONES EN LAS QUE NO EXISTE OBLIGACIÓN DE UTILIZAR MEDIOS DE PAGO']);
        PayOption::create(['code' => '9', 'name' => 'EFECTIVO, EN LOS DEMÁS CASOS']);
        PayOption::create(['code' => '10', 'name' => 'MEDIOS DE PAGO DE COMERCIO EXTERIOR']);
        PayOption::create(['code' => '11', 'name' => 'LETRAS DE CAMBIO']);
        PayOption::create(['code' => '101', 'name' => 'TRANSFERENCIAS - COMERCIO EXTERIOR']);
        PayOption::create(['code' => '102', 'name' => 'CHEQUES BANCARIOS  - COMERCIO EXTERIOR']);
        PayOption::create(['code' => '103', 'name' => 'ORDEN DE PAGO SIMPLE  - COMERCIO EXTERIOR']);
        PayOption::create(['code' => '104', 'name' => 'ORDEN DE PAGO DOCUMENTARIO  - COMERCIO EXTERIOR']);
        PayOption::create(['code' => '105', 'name' => 'REMESA SIMPLE  - COMERCIO EXTERIOR']);
        PayOption::create(['code' => '106', 'name' => 'REMESA DOCUMENTARIA  - COMERCIO EXTERIOR']);
        PayOption::create(['code' => '107', 'name' => 'CARTA DE CRÉDITO SIMPLE  - COMERCIO EXTERIOR']);
        PayOption::create(['code' => '108', 'name' => 'CARTA DE CRÉDITO DOCUMENTARIO  - COMERCIO EXTERIOR']);

    }
}
