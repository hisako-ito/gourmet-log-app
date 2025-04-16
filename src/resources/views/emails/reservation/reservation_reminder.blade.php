<p>{{ $reservation->user->name }}様</p>
<p>本日 {{ $reservation->shop->name }} にてご予約いただいております。</p>
<ul>
    <li>日付：{{ $reservation->date->format('Y年m月d日') }}</li>
    <li>時間：{{ $reservation->time->format('H:i') }}</li>
    <li>人数：{{ $reservation->number }}人</li>
</ul>
<p>お気をつけてお越しくださいませ。</p>