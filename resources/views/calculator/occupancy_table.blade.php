<div class="box box-primary">
    <div class="box box-body">
        <table class="table table-responsive" id="ports-table">
            <thead>
                <th></th>
                <th>Limit</th>
                <th>Current occupancy</th>
                <th>Remaining</th>
            </thead>
            <tbody>
                <tr>
                    <th>Size</th>
                    <td>
                        @if($selectedShip)
                            {{$selectedShip->max_hold_capacity}}
                        @endif</td>
                    <td>
                        {{$occupied_size}}
                    </td>
                    <td>
                        @if($selectedShip)
                            {{$selectedShip->max_hold_capacity-$occupied_size}}
                        @endif
                    </td>
                </tr>
                <tr>
                    <th>Draft</th>
                    <td>
                        @if($selectedShip)
                            {{$selectedShip->max_laden_draft}}
                        @endif
                    </td>
                    <td>
                            {{$selectedShip->ballast_draft * $occupied_tonnage}}
                    </td>
                    <td>
                        @if($selectedShip)
                            {{$selectedShip->max_laden_draft-($selectedShip->ballast_draft * $occupied_tonnage)}}
                        @endif
                    </td>
                </tr>
                <tr>
                    <th>Tonage</th>
                    <td>
                        @if($selectedShip)
                            {{$selectedShip->dwcc}}
                        @endif
                    </td>
                    <td>
                        {{$selectedShip->dwcc-($selectedShip->ballast_draft * $occupied_tonnage)}}
                    </td>
                    <td>
                        @if($selectedShip)
                            {{$selectedShip->dwcc-$occupied_tonnage}}
                        @endif
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>