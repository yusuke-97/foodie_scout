@extends('layouts.app')

@section('content')
<main class="py-4 mb-5" style="margin-top: 30px;">
    <div class="d-flex justify-content-center">
        <div class="container">
            @if (!empty($card))
            <h3 style="font-size: 24px; font-weight: bold;">登録済みのクレジットカード</h3>

            <hr>

            <h4>
                {{ $card["brand"] }}
                @switch($card["brand"])
                @case("Visa")
                <i class="fa-brands fa-cc-visa"></i>
                @break
                @case("MasterCard")
                <i class="fa-brands fa-cc-mastercard"></i>
                @break
                @case("JCB")
                <i class="fa-brands fa-cc-jcb"></i>
                @break
                @case("American Express")
                <i class="fa-brands fa-cc-amex"></i>
                @break
                @case("Discover")
                <i class="fa-brands fa-cc-discover"></i>
                @break
                @case("Diners Club")
                <i class="fa-brands fa-cc-diners-club"></i>
                @break
                @default
                @endswitch
            </h4>

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