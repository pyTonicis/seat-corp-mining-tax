<table class="table table-sm no-border">
       <tbody>
       <tr>
           <td><b>Contract to</b></td>
           <td>{{ $detail->character_name }}</td>
       </tr>
       <tr>
           <td><b>Contract Title</b></td>
           <td>{{ $detail->contractTitle }}</td>
       </tr>
       <tr>
           <td><b>Contract Type</b></td>
           <td>ItemExchange</td>
       </tr>
       <tr>
           <td><b>Tax</b></td>
           <td>{{ number_format($detail->tax) }}</td>
       </tr>
       </tbody>
</table>
