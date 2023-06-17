<div class="w-full">
    @if ($errors->any())
        <div id="box-errors" class="box-errors">
            <div class="label">{{ __('Whoops! Something went wrong.') }}</div>
            <ul class="content">
                @foreach ($errors->all() as $error)
                    <li class="item">{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
</div>
