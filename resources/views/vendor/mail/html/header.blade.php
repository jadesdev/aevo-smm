<tr>
<td class="header">
<a href="{{ route('index') }}" style="display: inline-block;">
@if (trim($slot) === 'Laravel')
<img src="{{ my_asset('logo') }}" class="logo" alt="{{get_setting('title')}}">
@else
{{ $slot }}
@endif
</a>
</td>
</tr>
