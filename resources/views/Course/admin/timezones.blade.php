<!-- timezone -->
@php
use App\Models\CustomTimezone;

$date = new DateTime("now");
$timezones = CustomTimezone::Orderby('offset')->get();
@endphp
@foreach($timezones as $timezone) 
    @if($timezone->id == 133 || $timezone->id == 152 || $timezone->id == 193 || $timezone->id == 88 || $timezone->id == 164 || $timezone->id == 251 || $timezone->id == 243)
    <option value="{{$timezone->name}}">({{ $timezone->diff_from_gtm }}) {{$timezone->name}}</option>
    @endif
@endforeach
<option value="" disabled>----------------------</option>
@foreach($timezones as $timezone) 
@if($timezone->id != 133 || $timezone->id != 152 || $timezone->id != 193 || $timezone->id != 88 || $timezone->id != 164 || $timezone->id != 251 || $timezone->id != 243)
    <option value="{{$timezone->name}}">({{ $timezone->diff_from_gtm }}) {{$timezone->name}}</option>
@endif
@endforeach



