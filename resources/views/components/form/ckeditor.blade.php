@props(["name","label"=>null,'placeholder'=>null,'rows'=>5,'upload_url'=>'','blocks'=>'Paragraph=p;Heading 4=h4;Heading 5=h5;Heading 6=h6;Address=address;Pre=pre','plugins'=>'code table lists image fullscreen autoresize','toolbar'=>'blocks | bold italic | alignleft aligncenter alignright | image | indent outdent | bullist numlist | code | table | fullscreen'])
<div wire:ignore class="w-full relative">
    <x-lf.form.field :name="$name">
    <textarea wire:model="{{$name}}"
              id="{{$name}}"
              placeholder="{{$placeholder}}"
              {{$attributes}}
              rows="{{$rows}}"
              x-data
              x-ref="{{$name}}"
              x-init="
              ClassicEditor.create( document.querySelector( '#{{$name}}' ), {
                    extraPlugins: [ MyCustomUploadAdapterPlugin ]
                })
                .then(editor => {
                    editor.model.document.on('change:data', () => {
                        @this.set('{{$name}}', editor.getData());
                    });
                    const wordCountPlugin = editor.plugins.get( 'WordCount' );
                    const wordCountWrapper = document.getElementById( 'word-count' );

                    wordCountWrapper.appendChild( wordCountPlugin.wordCountContainer );
                })
        .catch( error => {
            console.error( error );
        } );"
    ></textarea>
    <x-slot:label>
        {{$label}}
        ( <div id="word-count"></div> )
    </x-slot:label>
    </x-lf.form.field>
</div>
