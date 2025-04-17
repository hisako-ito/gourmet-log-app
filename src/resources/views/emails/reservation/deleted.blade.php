<p>{{ $reservation->user->name }}様</p>

<p>以下のご予約は削除されました：</p>
<ul>
    <li>店舗名：{{ $reservation->shop->name }}</li>
    <li>日時：{{ $reservation->date }} {{ $reservation->time }}</li>
    <li>人数：{{ $reservation->number }}人</li>
</ul>

<p>またのご利用をお待ちしております。</p>