<div class="card">
    <div class="card-header">
        <h3>Event: Dackeltag 23.03.2022</h3>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-4">
                <dl>
                    <dt>Total Mined ISK</dt>
                    <dd>12,060,312,050 ISK</dd>
                </dl>
            </div>
            <div class="col-4">
                <dl>
                    <dt>Active Members</dt>
                    <dd>7</dd>
                </dl>
            </div>
            <div class="col-4">
                <dl>
                    <dt>Event Duration</dt>
                    <dd>1 days</dd>
                </dl>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h3>Minings</h3>
    </div>
    <div class="card-body">
        <table class="table" id="thieves">
            <thead>
            <tr>
                <th>Character</th>
                <th>Mined ISK</th>
                <th>Mined ORE</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @isset($event_minings)
                @foreach($event_minings as $mining)
                    <tr>
                        <td>{{ $mining->character_name }}</td>
                        <td>{{ $mining->refined_price }}</td>
                        <td>{{ $mining->typeName }} x{{ $mining->quantity }}</td>
                        <td>
                            <button class="btn btn-warning details" id="d_{{ $mining->id }}">Edit</button>
                            <button class="btn btn-danger remove" id="r_{{ $mining->id }}">Delete</button>
                        </td>
                    </tr>
                @endforeach
            @endisset
            </tbody>
        </table>

    </div>
</div>