<nav class="navbar navbar-expand-md navbar-light shadow-sm header-container">
    <div class="container">
        <a class="navbar-brand" href="{{ url('/') }}">
            <img src="{{asset('img/logo.jpg')}}">
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ms-auto mr-5 mt-2">
                <!-- Authentication Links -->
                @guest
                <li class="nav-item mr-5">
                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                </li>
                <li class="nav-item mr-5">
                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                </li>

                @else
                <li class="nav-item me-3">
                    <a class="nav-link" href="{{ route('reviews.timeline') }}">
                        <i class="fa-solid fa-book me-1"></i><label>タイムライン</label>
                    </a>
                </li>
                <hr>
                <li class="nav-item me-3">
                    <a class="nav-link" href="{{ route('mypage.favorite') }}">
                        <i class="fas fa-bookmark me-1"></i><label>お気に入り</label>
                    </a>
                </li>
                <hr>
                <li class="nav-item me-3">
                    <a class="nav-link" href="{{ route('mypage') }}">
                        <i class="fas fa-user me-1"></i><label>マイページ</label>
                    </a>
                </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>