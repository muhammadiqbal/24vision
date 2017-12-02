<table class="table table-responsive" id="ships-table">
    <thead>
        <th>Name</th>
        <th>Imo</th>
        <th>Year Of Built</th>
       {{--  <th>Dwcc</th>
        <th>Max Holds Capacity</th>
        <th>Max Laden Draft</th>
        <th>Fuel Consumption At Sea</th>
        <th>Fuel Consumption In Port</th> --}}
        <th>Flag</th>
        <th>Ship Type</th>
        <th>Ship Specialization</th>
        <th>Gear Onboard</th>
        <th>Additional Information</th>
        <th colspan="3">Action</th>
    </thead>
    <tbody>
    @foreach($ships as $ship)
        <tr>
            <td>{!! $ship->name !!}</td>
            <td>{!! $ship->imo !!}</td>
            <td>{!! $ship->year_of_built !!}</td>
          {{--   <td>{!! $ship->dwcc !!}</td>
            <td>{!! $ship->max_holds_capacity !!}</td>
            <td>{!! $ship->max_laden_draft !!}</td>
            <td>{!! $ship->fuel_consumption_at_sea !!}</td>
            <td>{!! $ship->fuel_consumption_in_port !!}</td> --}}
            <td>{!! $ship->flag !!}</td>
            <td>{!! $ship->shipType->name!!}</td>
            <td>{!! $ship->shipSpecialization->name!!}</td>
            <td>{!! $ship->gear_onboard !!}</td>
            <td>{!! $ship->additional_information !!}</td>
            <td>
                {!! Form::open(['route' => ['ships.destroy', $ship->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('ships.show', [$ship->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                    <a href="{!! route('ships.edit', [$ship->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>