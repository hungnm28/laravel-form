@props(["name","label"=>null,'placeholder'=>null,'rows'=>5,'upload_url'=>'','plugins'=>'code table lists image fullscreen','toolbar'=>'blocks | bold italic | alignleft aligncenter alignright | image | indent outdent | bullist numlist | code | table | fullscreen'])
<div wire:ignore>
    <x-lf.form.field :name="$name" :label="$label">
    <textarea wire:model.debounce.9999999ms="{{$name}}"
              id="{{$name}}"
              placeholder="{{$placeholder}}"
              {{$attributes}}
              rows="{{$rows}}"
              x-data
              x-ref="{{$name}}"
              x-init="
                    tinymce.init({
                         selector: '#{{$name}}',
                         plugins: '{{$plugins}}',
                         toolbar: '{{$toolbar}}',
                         image_title: true,
                         {{$upload_url?"images_upload_url:'".$upload_url."',":''}}
                          setup: function (editor) {
                             editor.on('init change', function () {
                                       editor.save();
                               });
                                editor.on('change', function (e) {
                                         @this.set('{{$name}}', editor.getContent());
                                 });
                            },
                         });"
    ></textarea>
    </x-lf.form.field>
</div>
