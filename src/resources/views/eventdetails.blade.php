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
                            <button class="btn btn-danger remove" id="r_{{ $mining->id }}">Delete</button>
                        </td>
                    </tr>
                @endforeach
            @endisset
            </tbody>
        </table>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h4>Add Character Mining</h4>
    </div>
    <div class="card-body">
        <form>
            <div class="form-group">
                <label for="character">Character</label>
                <select class="groupSearch form-control" data-control="select2" data-dropdown-parent="#modal_detail" id="character" name="character">
                    <option></option>
                </select>
                <label for="ore">Mined Ore</label>
                <textarea class="form-control" id="ore" rows="3"></textarea>
                <button class="btn btn-light" id="save_data">Save</button>
            </div>
        </form>
    </div>
</div>
