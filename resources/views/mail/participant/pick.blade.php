@component('mail::message')
# {{$first_line}}

## {{$second_line}}

@component('mail::table')
| Picks made thus far: | | |
|--------------|-|-|
@foreach($pickeds as $picked)
| **#{{$picked['iterator']}}** | {{$picked['participant_name']}} | {{$picked['schedule_name']}} {{$picked['schedule_time']}} |
@endforeach
@endcomponent

<hr/>
@component('mail::table')
| Available for you pick from: | |
|-----------|-|
@foreach($schedules as $schedule)
| [PICK]({{ $schedule['select_link'] }}) | {{$schedule['schedule_name']}} {{$schedule['schedule_time']}} |
@endforeach
@endcomponent

<!-- Subcopy -->
@if (isset($team_url))
@component('mail::subcopy')
You can view your team progress : [{{ $team_url }}]({{ $team_url }})
@endcomponent
@endif
@endcomponent
