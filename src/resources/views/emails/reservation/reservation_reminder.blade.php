<p>{{ $reservation->user->name }}様</p>
<p>本日 {{ $reservation->shop->name }} にてご予約いただいております。</p>
<ul>
    <li>日付：{{ $dateFormatted }}</li>
    <li>時間：{{ $timeFormatted }}</li>
    <li>人数：{{ $reservation->number }}人</li>
</ul>
<p>お気をつけてお越しくださいませ。</p>