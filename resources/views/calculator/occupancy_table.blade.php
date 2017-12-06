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
                    <td>{{$ship->max_holds_capacity}}</td>
                    <td>0</td>
                    <td>{{$ship->max_holds_capacity - 0}}</td>
                </tr>
                <tr>
                    <th>Draft</th>
                    <td>{{$ship->max_laden_draft}}</td>
                    <td>0</td>
                    <td>{{$ship->max_laden_draft - 0}}</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>