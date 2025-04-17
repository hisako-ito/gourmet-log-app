<p>{{ $reservation->user->name }} 様</p>

<p>いつもご利用ありがとうございます。</p>

<p>以下のご予約内容が変更されましたのでご確認ください。</p>

<hr>

<h3>■ 変更後のご予約内容</h3>
<ul>
    <li><strong>店舗名：</strong>{{ $reservation->shop->name }}</li>
    <li><strong>日付：</strong>{{ \Carbon\Carbon::parse($reservation->date)->format('Y年m月d日') }}</li>
    <li><strong>時間：</strong>{{ \Carbon\Carbon::parse($reservation->time)->format('H:i') }}</li>
    <li><strong>コース：</strong>{{ $reservation->course->name }}（{{ $reservation->course->price }}円）</li>
    <li><strong>人数：</strong>{{ $reservation->number }} 名様</li>
</ul>

<hr>

<p>変更内容にお間違いがある場合は、再度マイページよりご確認ください。</p>

<p>今後ともよろしくお願いいたします。</p>