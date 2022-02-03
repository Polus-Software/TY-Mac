<!-- timezone -->
@php
use App\Models\Timezone;

$date = new DateTime("now");
$timezones = Timezone::Orderby('offset')->get();
@endphp
@foreach($timezones as $timezone) 
    <option value="{{$timezone->name}}">({{ $timezone->diff_from_gtm }}) {{$timezone->name}}</option>
@endforeach



