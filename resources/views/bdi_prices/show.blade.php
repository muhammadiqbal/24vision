@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Bdi Price
        </h1>
    </section>
    <div class="content">
        <div class="box box-primary">
            <div class="box-body">
                <div class="row" style="padding-left: 20px">
                    @include('bdi_prices.show_fields')
                    <a href="{!! route('bdiPrices.index') !!}" class="btn btn-default">Back</a>
                </div>
            </div>
        </div>
    </div>
@endsection
