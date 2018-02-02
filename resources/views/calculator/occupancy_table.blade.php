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
                    <td>{{$selectedShip->max_laden_draft}}</td>
                    <td>0</td>
                    <td></td>
                </tr>
                <tr>
                    <th>Draft</th>
                    <td>{{$selectedShip->max_laden_draft}}</td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <th>Tonage</th>
                    <td>{{$selectedShip->dwcc}}</td>
                    <td>0</td>
                    <td></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>