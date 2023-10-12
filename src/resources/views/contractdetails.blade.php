@isset($details)
<table class="table table-sm no-border">
    <tbody>
        <tr>
            <td><b>Contract to</b></td>
            <td id="c_name">{{ $details->character_name }}</td>
            <td><button class="btn btn-sm copy-data" data-toggle="tooltip" data-export="c_name"><i class="fas fa-copy"></i></button></td>
        </tr>
        <tr>
            <td><b>Contract Title</b></td>
            <td id="c_title">{{ $details->contractTitle }}</td>
            <td><button class="btn btn-sm copy-data" data-toggle="tooltip" data-export="c_title"><i class="fas fa-copy"></i></button></td>
        </tr>
        <tr>
            <td><b>Contract Type</b></td>
            <td>ItemExchange</td><td></td>
        </tr>
        <tr>
            <td><b>Tax</b></td>
            <td id="c_tax">{{ number_format($details->tax) }}</td>
            <td><button class="btn btn-sm copy-data" data-toggle="tooltip" data-export="c_tax"><i class="fas fa-copy"></i></button></td>
        </tr>
    <tr>
        <td><div id="debx">NO FUNCTION</div></td>
    </tr>
    </tbody>
</table>
@endisset
