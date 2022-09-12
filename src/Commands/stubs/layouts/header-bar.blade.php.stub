<header>
    <label for="lf-control" class="h-btn h-menu">{!! lfIcon("menu") !!}</label>
    <div class="header-bar"></div>
     <x-lf.btn.dropdown class="h-user" icon="person">
        <div class="user">
            <span class="icon">{!! lfIcon('person',56) !!}</span>
            <span class="name">{{Auth::user()->name}}</span>
        </div>
        <div class="action">
            <a class="btn">Setting</a>
            <form method="post" action="{{route('logout')}}">
                @csrf
                <button class="btn">Logout</button>
            </form>
        </div>
    </x-lf.btn.dropdown>
</header>
