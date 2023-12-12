<div class="card">
    <div class="card-header">
        <h3>Event: {{ $event_data->event_name }}</h3>
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
                    <dd>{{ $total_members }}</dd>
                </dl>
            </div>
            <div class="col-4">
                <dl>
                    <dt>Event Duration</dt>
                    <dd>{{ $event_data->event_duration }} days</dd>
                </dl>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h3>Miningdata</h3>
    </div>
    <div class="card-body">
        <textarea id="raw_data" name="raw_data">
            @isset($event_minings)
                @foreach($event_minings as $mining)
                    {{ $mining->typeName }}&nbsp;{{ $mining->quantity }}&#13;&#10;
                @endforeach
            @endisset
        </textarea>
    </div>
</div>
