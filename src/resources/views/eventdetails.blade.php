<div class="card">
    <div class="card-header">
        <h3>Event: Dackeltag 23.03.2022</h3>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-4">
                <dl>
                    <dt>Total Mined ISK</dt>
                    <dd>{{ number_format($total_mined_isk) }} ISK</dd>
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
                    <tr id="mod_{{ $mining_id }}">
                        <td>{{ $mining->character_name }}</td>
                        <td>{{ number_format($mining->refined_price) }}</td>
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
        <form action="{{ route('corpminingtax.addmining') }}" method="post" id="mining" name="mining">
            {{ csrf_field() }}
            <div class="form-group">
                <label for="character">Character</label>
                <select class="groupSearch form-control" id="character" name="character">
                    <option></option>
                    @foreach($characters as $character)
                        <option value="{{ $character->id }}">{{ $character->name }}</option>
                    @endforeach
                </select>
                <label for="ore">Mined Ore</label>
                <textarea class="form-control" id="ore" name="ore" rows="3"></textarea>
                <input type="hidden" id="event_id" name="event_id" value="{{ $event_id }}">
                <button type="submit" class="btn btn-primary" id="e_{{ $event_id }}">Save</button>
            </div>
        </form>
    </div>
</div>
