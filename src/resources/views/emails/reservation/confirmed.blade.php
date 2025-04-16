@component('mail::message')
# 予約が完了しました！

以下のQRコードを店舗で提示してください。

<img src="{{ $qrImage }}" alt="QRコード">

- 店舗名: {{ $reservation->shop->name }}
- 予約日時: {{ $reservation->date }} {{ $reservation->time }}
- 人数: {{ $reservation->number }}名

@endcomponent