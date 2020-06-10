<div class="row">
    <div class="col-md-4">
        <a href="{{ route('sale.index') }}">
            <button @if (request()->route()->getName() == 'sale.index')
                class="btn btn-primary active"
                @else
                class="btn btn-secondary"
                @endif>Facturación</button>
        </a>
    </div>
    <div class="col-md-4">
        <a href="{{ route('client.index') }}">
            <button @if (request()->route()->getName() == 'client.index')
                class="btn btn-primary active"
                @else
                class="btn btn-secondary"
                @endif>Clientes</button>
        </a>
    </div>
    <div class="col-md-4">
        <a href="{{ route('good.index') }}">
            <button @if (request()->route()->getName() == 'good.index')
                class="btn btn-primary active"
                @else
                class="btn btn-secondary"
                @endif>Bienes y servicios</button>
        </a>
    </div>
</div>
<hr style="border: solid #87CEFA 1px;">
{{-- TOTALES --}}
<div class="mt-2">
    @if (request()->route()->getName() == 'sale.index')
    <h3><strong>Facturación</strong></h3>
    @elseif(request()->route()->getName() == 'good.index')
    <h3><strong>Bienes y servicios</strong></h3>
    @else
    <h3><strong>Clientes</strong></h3>
    @endif
</div>


@if (request()->route()->getName() != 'good.index')
<div class="row mt-3">
    @if (request()->route()->getName() == 'sale.index')
    <div class="form-group col-md-2">
        <label for="goal" class="">Meta</label>
        <input type="text" name="goal" id="goal" class="form-control-plaintext" value="S/00" readonly>

    </div>
    @endif

    <div class="form-group col-md-2">
        <label for="global_invoice_sum" class="">Total Facturación</label>
        <input type="text" name="global_invoice_sum" id="global_invoice_sum" class="form-control-plaintext" value="S/00"
            readonly>
    </div>
    <div class="form-group col-md-2">
        <label for="global_debt_sum" class="">Total por cobrar</label>
        <input type="text" name="global_debt_sum" id="global_debt_sum" class="form-control-plaintext" value="S/00"
            readonly>
    </div>
    <div class="form-group col-md-2">
        <label for="global_pay_sum" class="">Total pagado</label>
        <input type="text" name="global_pay_sum" id="global_pay_sum" class="form-control-plaintext" value="S/00"
            readonly>
    </div>
    <div class="form-group col-md-2">
        <label for="global_leftForInvoice_sum" class="">Total por facturar</label>
        <input type="text" name="global_leftForInvoice_sum" id="global_leftForInvoice_sum" class="form-control-plaintext"
            value="S/00" readonly>
    </div>
</div>
@endif
