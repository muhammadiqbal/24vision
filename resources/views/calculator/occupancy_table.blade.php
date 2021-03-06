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
                        @if(isset($selectedShip))
                            {{$selectedShip->max_holds_capacity}}
                        @else
                            {{0}}
                        @endif
                  </td>
                    <td>
                        @if(isset($occupied_size))
                            {{$occupied_size}}
                         @else
                            {{0}}
                        @endif
                    </td>
                    <td>
                        @if(isset($selectedShip) && isset($occupied_size))
                            {{$selectedShip->max_holds_capacity - $occupied_size}}
                        @elseif(isset($selectedShip))
                            {{$selectedShip->max_holds_capacity}}
                        @else
                            {{0}}
                        @endif
                    </td>
                </tr>
                <tr>
                    <th>Draft</th>
                    <td>
                        @if(isset($allowedDraft))
                            {{$allowedDraft}}
                        @else
                            {{0}}
                        @endif
                    </td>
                    <td>
                         @if(isset($occupied_draft))
                            {{$occupied_draft}}
                        @else
                            {{0}}
                        @endif
                    </td>
                    <td>
                        @if(isset($remainingDraft))
                            {{$remainingDraft}}
                        @elseif(isset($allowedDraft))
                            {{$allowedDraft}}
                        @else
                            {{0}}
                        @endif
                    </td>
                </tr>
                <tr>
                    <th>Tonage</th>
                    <td>
                        @if(isset($selectedShip))
                            {{$selectedShip->dwcc}}
                        @else
                            {{0}}
                        @endif
                    </td>
                    <td>
                        @if(isset($$occupied_tonage))
                            {{$occupied_tonage}}
                        @else
                            {{0}}
                        @endif
                    </td>
                    <td>
                        @if(isset($selectedShip) && isset($occupied_tonage))
                            {{$selectedShip->dwcc-$occupied_tonage}}
                        @elseif(isset($selectedShip))
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