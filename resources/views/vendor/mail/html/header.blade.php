<tr>
<td class="header">
<a href="{{ $url }}" style="display: inline-block;">
@if(file_exists(asset('vendor/lms/img/logo.jpg')))
<img src="{{ asset('vendor/lms/img/logo.jpg')}}" class="logo" alt="lms Logo">
@else
{{ config('app.name')}}
@endif 
</a>
</td>
</tr>
