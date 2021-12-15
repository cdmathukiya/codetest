<table class="table table-striped">
    <tr>
        <th>Affiliate Id</th>
        <th>Name</th>
        <th>Distance (In KM)</th>
    </tr>
    @if(count($affiliates))
        @foreach($affiliates as $affiliate)
        <tr>
            <td>{{$affiliate->affiliate_id ?? ''}}</td>
            <td>{{$affiliate->name ?? ''}}</td>
            <td>{{$affiliate->distance ?? ''}}</td>
        </tr>
        @endforeach
    @else
        <tr>
            <td colspan="3">No affiliates found near you</td>
        </tr>
    @endif
</table>