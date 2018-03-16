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
                        @else
                            {{0}}
                        @endif
                    </td>
                    <td>
                        @if($selectedShip && $occupied_size)
                            {{$occupied_size}}
                         @else
                            {{0}}
                        @endif
                    </td>
                    <td>
                        @if($selectedShip && $occupied_size)
                            {{$selectedShip->max_holds_capacity - $occupied_size}}
                        @elseif($selectedShip)
                            {{$selectedShip->max_holds_capacity}}
                        @else
                            {{0}}
                        @endif
                    </td>
                </tr>
                <tr>
                    <th>Draft</th>
                    <td>
                        @if($allowedDraft)
                            {{$allowedDraft}}
                        @else
                            {{0}}
                        @endif
                    </td>
                    <td>
                         @if($occupied_draft)
                            {{$occupied_draft}}
                        @else
                            {{0}}
                        @endif
                    </td>
                    <td>
                        @if($allowedDraft && $occupied_draft)
                            {{$remainingDraft}}
                        @elseif($allowedDraft)
                            {{$allowedDraft}}
                        @else
                            {{0}}
                        @endif
                    </td>
                </tr>
                <tr>
                    <th>Tonage</th>
                    <td>
                        @if($selectedShip)
                            {{$selectedShip->dwcc}}
                        @else
                            {{0}}
                        @endif
                    </td>
                    <td>
                        @if($selectedShip && $occupied_tonage)
                            {{$occupied_tonage}}
                        @else
                            {{0}}
                        @endif
                    </td>
                    <td>
                        @if($selectedShip && $occupied_tonage)
                            {{$selectedShip->dwcc-$occupied_tonage}}
                        @elseif($selectedShip)
                            {{$selectedShip->dwcc}}
                        @else 
                            {{0}}
                        @endif
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>