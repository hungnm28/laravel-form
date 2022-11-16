@props(["name","open"=>'false',"class"=>""])

<div x-data="{ open: {{$open}} }"
     x-on:{{$name}}.window="open = !open"
     x-show="open"
     class="box-modal"
     aria-labelledby="modal-title"
     x-ref="dialog"
     aria-modal="true"
     style="display: none"
     @keydown.window.escape="open = false"
>

    <div x-show="open" class="box-opacity" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" ></div>

    <div class="modal-container">
        <div class="modal-backdrop">

            <div class="modal-panel {{$class}}" x-show="open" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"  @click.away="open = false">
                {{$slot}}
            </div>

        </div>
    </div>
</div>
