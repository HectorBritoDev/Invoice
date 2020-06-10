<?php

use App\DocumentType;
use Illuminate\Database\Seeder;

class DocumentTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DocumentType::create(['code' => '1', 'name' => 'Factura']);
        DocumentType::create(['code' => '2', 'name' => 'Recibo por Honorarios']);
        DocumentType::create(['code' => '3', 'name' => 'Boleta de Venta']);
        DocumentType::create(['code' => '4', 'name' => 'Liquidación de compra']);
        DocumentType::create(['code' => '5', 'name' => 'Boleto de compañíade aviación comercial por el servicio de transporte aéreo de pasajeros']);
        DocumentType::create(['code' => '6', 'name' => 'Carta de porteaéreo por el servicio de transporte de carga aérea']);
        DocumentType::create(['code' => '7', 'name' => 'Nota de crédito']);
        DocumentType::create(['code' => '8', 'name' => 'Nota de débito']);
        DocumentType::create(['code' => '9', 'name' => 'Guía de remisión - remisión']);
        DocumentType::create(['code' => '10', 'name' => 'Recibo porArrendamiento']);
        DocumentType::create(['code' => '11', 'name' => 'Póliza emitida por las Bolsas de Valores, Bolsas de Productos o Agentes de Intermediación por operaciones realizadas en las Bolsas de Valores o Productos o fuera de las mismas, autorizadas por CONASEV']);
        DocumentType::create(['code' => '12', 'name' => 'Ticket o cinta emitido por máquina registradora']);
        DocumentType::create(['code' => '13', 'name' => 'Documento emitido por bancos, instituciones financieras, crediticias y de seguros que se encuentren bajo el control de la Superintendencia de Banca y Seguros']);
        DocumentType::create(['code' => '14', 'name' => 'Recibo por servicios públicos de suministro de energía eléctrica, agua, teléfono, telex y telegráficos y otros servicios complementarios que se incluyan en el recibo de servicio público']);
        DocumentType::create(['code' => '15', 'name' => 'Boleto emitido por las empresas de transporte público urbano de pasajeros']);
        DocumentType::create(['code' => '16', 'name' => 'Boleto de viaje emitido por las empresas de transporte público interprovincial de pasajeros dentro del país']);
        DocumentType::create(['code' => '17', 'name' => 'Documento emitido por la Iglesia Católica por el arrendamiento de bienes inmuebles']);
        DocumentType::create(['code' => '18', 'name' => 'Documento emitido por las Administradoras Privadas de Fondo de Pensiones que se encuentran bajo la supervisión de la Superintendencia de Administradoras Privadas de Fondos de Pensiones']);
        DocumentType::create(['code' => '19', 'name' => 'Boleto o entrada por atracciones y espectáculos públicos']);
        DocumentType::create(['code' => '20', 'name' => 'Comprobante de Retención']);
        DocumentType::create(['code' => '21', 'name' => 'Conocimiento de embarque por el servicio de transporte de carga marítima']);
        DocumentType::create(['code' => '22', 'name' => 'Comprobante por Operaciones No Habituales']);
        DocumentType::create(['code' => '23', 'name' => 'Pólizas de Adjudicación emitidas con ocasión del remate o adjudicación de bienes por venta forzada, por los martilleros o las entidades que rematen o subasten bienes por cuenta de terceros']);
        DocumentType::create(['code' => '24', 'name' => 'Certificado de pago de regalías emitidas por PERUPETRO S.A']);
        DocumentType::create(['code' => '25', 'name' => 'Documento de Atribución (Ley del Impuesto General a las Ventas e Impuesto Selectivo al Consumo, Art. 19º,último párrafo, R.S. N° 022-98-SUNAT)']);
        DocumentType::create(['code' => '26', 'name' => 'Recibo por el Pago de la Tarifa por Uso de Agua Superficial con fines agrarios y por el pago de la Cuota para la ejecución de una determinada obra o actividad acordada por la Asamblea General de la Comisión de Regantes o Resolución expedida por el Jefe de la Unidad de Aguas y de Riego (Decreto Supremo N° 003-90-AG, Arts. 28 y 48)']);
        DocumentType::create(['code' => '27', 'name' => 'Seguro Complementario de Trabajo de Riesgo']);
        DocumentType::create(['code' => '28', 'name' => 'Tarifa Unificada de Uso de Aeropuerto']);
        DocumentType::create(['code' => '29', 'name' => 'Documentos emitidos por la COFOPRI en calidad de oferta de venta de terrenos, los correspondientes a las subastas públicas y a la retribución de los servicios que presta']);
        DocumentType::create(['code' => '30', 'name' => 'Documentos emitidos por las empresas que desempeñan el rol adquirente en los sistemas de pago mediante tarjetas de crédito y débito']);
        DocumentType::create(['code' => '31', 'name' => 'Guía de Remisión - Transportista']);
        DocumentType::create(['code' => '32', 'name' => 'Documentos emitidos por las empresas recaudadoras de la denominada Garantía de Red Principal a la que hace referencia el numeral 7.6 del artículo 7° de la Ley N° 27133 – Ley de Promoción del Desarrollo de la Industria del Gas Natural']);
        DocumentType::create(['code' => '34', 'name' => 'Documento del Operador']);
        DocumentType::create(['code' => '35', 'name' => 'Documento del Partícipe']);
        DocumentType::create(['code' => '36', 'name' => 'Recibo de Distribución de Gas Natural']);
        DocumentType::create(['code' => '37', 'name' => 'Documentos que emitan los concesionarios del servicio de revisiones técnicas vehiculares, por la prestación de dicho servicio']);
        DocumentType::create(['code' => '50', 'name' => 'Declaración Única de Aduanas - Importación definitiv']);
        DocumentType::create(['code' => '52', 'name' => 'Despacho Simplificado - Importación Simplificada']);
        DocumentType::create(['code' => '53', 'name' => 'Declaración de Mensajería o Courier']);
        DocumentType::create(['code' => '54', 'name' => 'Liquidación de Cobranza']);
        DocumentType::create(['code' => '87', 'name' => 'Nota de Crédito Especial']);
        DocumentType::create(['code' => '88', 'name' => 'Nota de Débito Especial']);
        DocumentType::create(['code' => '91', 'name' => 'Comprobante de No Domiciliado']);
        DocumentType::create(['code' => '96', 'name' => 'Exceso de crédito fiscal por retiro de bienes']);
        DocumentType::create(['code' => '97', 'name' => 'Nota de Crédito - No Domiciliado']);
        DocumentType::create(['code' => '98', 'name' => 'Nota de Débito - No Domiciliado']);
        //DocumentType::create(['code' => '99', 'name' => 'Otros -Consolidado de Boletas de Venta']);

    }
}
