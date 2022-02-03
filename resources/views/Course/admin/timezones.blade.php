<!-- timezone -->
@php
use App\Models\CustomTimezone;

$date = new DateTime("now");
$timezones = CustomTimezone::Orderby('offset')->get();
@endphp
@foreach($timezones as $timezone) 
    <option value="{{$timezone->name}}">({{ $timezone->diff_from_gtm }}) {{$timezone->name}}</option>
@endforeach



