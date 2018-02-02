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
                            {{$selectedShip->max_holds_capacity}}
                        @endif
                    </td>
                    <td>
                        @if($selectedShip && $occupied_size)
                            {{$occupied_size}}
                        @endif
                    </td>
                    <td>
                        @if($selectedShip && $occupied_size)
                            {{$selectedShip->max_holds_capacity - $occupied_size}}
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
                         @if($selectedShip && $occupied_tonage)
                            {{$selectedShip->ballast_draft * $occupied_tonage}}
                        @endif
                    </td>
                    <td>
                        @if($selectedShip && $occupied_tonage)
                            {{$selectedShip->max_laden_draft-($selectedShip->ballast_draft * $occupied_tonage)}}
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
                        @if($selectedShip && $occupied_tonage)
                            {{$occupied_tonage}}
                        @endif
                    </td>
                    <td>
                        @if($selectedShip && $occupied_tonage)
                            {{$selectedShip->dwcc-$occupied_tonage}}
                        @endif
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>