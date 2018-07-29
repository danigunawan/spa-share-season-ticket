@component('mail::message')
# {{$first_line}}

## {{$second_line}}

@component('mail::table')
| Participant Detail | |
|--------------------|-|
| **Name**  | {{$participant_name}} |
| **Email** | {{$participant_email}} |
@endcomponent

@component('mail::button', ['url' => $confirm_url, 'color' => 'blue'])
    Confirm
@endcomponent

<hr/>
@component('mail::table')
| Draft Detail | |
|-------------|-|
| **Name**  | [{{ $team_name }}]({{ $team_url }}) |
| **Participants**  | {{$num_participants}} |
@endcomponent

<!-- Subcopy -->
@if (isset($confirm_url))
@component('mail::subcopy')
    If you have trouble clicking "Confirm" button , copy and paste this url on your browser[{{ $confirm_url }}]({{ $confirm_url }})
@endcomponent
@endif
@endcomponent
