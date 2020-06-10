<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">

        <link href="{{ asset('css/budgetPdf.css') }}" rel="stylesheet">
        <title>Guía de remisión {{ $senderGuide->serie }} - {{ $senderGuide->code }}</title>
    </head>

    <body>
        <div class="img-center">
            <img src="{{ asset('./img/store.png') }}" alt="logo" width="150">
        </div>
        <div class="mx-auto">
            <div>
                <label>{{ $user->description }}</label>
            </div>
            <div>
                <label>{{ $user->adress }}</label>
            </div>

            <div>
                <label>{{ $user->phone1 }} |
                    {{ $user->web }}</label>
            </div>
            <div>
                <label> {{ $user->public_email }}
                </label>
            </div>
        </div>

        <div class="mt-4">
            <div class="">
                <label> <strong>Señores:</strong> {{ $senderGuide->client_name }}</label>
            </div>

            <div class="mt-1">
                <label>{{ $senderGuide->note }}</label>
            </div>
        </div>

        <h4> Guía de remisión {{ $senderGuide->serie }}-{{ $senderGuide->code }}</h4>


        <div class="mt-4">
            <table>

                <tr class="thead">
                    <td>Articulo</td>
                    <td>Medida</td>
                    <td>Referencia</td>
                    <td>Cantidad</td>
                    <td>Precio</td>
                    <td>Desc.%</td>
                    <td>Total</td>
                    <td></td>
                </tr>


                @foreach ($items as $item)
                <tr>

                    <td>{{ $item->name }}</td>
                    <td>{{ $item->measure }}</td>
                    <td>{{ $item->reference }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>{{ $item->price }}</td>
                    <td>{{ $item->discount }}</td>
                    <td>{{ $item->total }}</td>
                    <td></td>
                </tr>
                @endforeach

            </table>
        </div>

        <div class="mt-4">

            <div class="">
                {{-- <label> <strong>Forma de pago: </strong>{{ $senderGuide->condition }}
                días</label>

                <label for="sub_total" class="ml-30"> <strong> Sub total: </strong> </label>
                <label class="ml-5">{{ $sub_total }}</label> --}}
            </div>
            <div class="">
                <label> <strong>Fecha de entrega: </strong>{{ $today }}</label>

                {{-- <label for="IGV" class="ml-26"> <strong> Tax: </strong></label>
                <label class="ml-10">{{ $tax }}</label>
                --}}
            </div>
            <div class="">
                <label> <strong></strong></label>

                {{-- <label for="Total" class="ml-45"> <strong> Total: </strong></label>
                <label class="ml-3">{{ $total }}</label>
                --}}
            </div>
            @if ($accounts)

            <div class="mt-4">
                <label> <strong>Cuentas Bancarias: </strong> </label>
                {{ $senderGuide->bank_account }}

            </div>
            @endif
        </div>

    </body>

</html>
