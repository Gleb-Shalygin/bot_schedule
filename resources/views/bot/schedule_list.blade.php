<b>Расписание {{ $group_name }}</b>
{{ $week_day }} {{ $date }}

@foreach($pairs as $pair)
<b>{{ $pair['pair'] }} пара:</b> {{ $pair['predmet'] }}
Препод: {{ $pair['teacher_name'] }}
Кабинет: {{ $pair['office'] }}

@endforeach

<b>Объявление:</b>

{{ $message }}
