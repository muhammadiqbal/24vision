@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Fee Price
        </h1>
    </section>
    <div class="content">
        <div class="box box-primary">
            <div class="box-body">
                <div class="row" style="padding-left: 20px">
                    @include('fee_prices.show_fields')
                    <a href="{!! route('feePrices.index') !!}" class="btn btn-default">Back</a>
                </div>
            </div>
        </div>
    </div>
@endsection
