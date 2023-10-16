@extends('layouts.app')

@section('content')
<main class="py-4 mb-5">
    <div class="d-flex justify-content-center">
        <div class="container w-50">
            @if (!empty($card))
            <h3>登録済みのクレジットカード</h3>

            <hr>
            <h4>{{ $card["brand"] }}</h4>
            <p>有効期限: {{ $card["exp_year"] }}/{{ $card["exp_month"] }}</p>
            <p>カード番号: ************{{ $card["last4"] }}</p>
            @endif

            <form action="{{ route('mypage.token') }}" method="post">
                @csrf
                <payjp-button :card-exists="@json(!empty($card))" api-key="{{ ENV('PAYJP_PUBLIC_KEY') }}"></payjp-button>
            </form>
        </div>
    </div>
</main>
@endsection