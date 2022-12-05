@props(["name","label"=>null,'placeholder'=>null,'rows'=>5,'upload_url'=>'','blocks'=>'Paragraph=p;Heading 4=h4;Heading 5=h5;Heading 6=h6;Address=address;Pre=pre','plugins'=>'code table lists image fullscreen autoresize','toolbar'=>'blocks | bold italic | alignleft aligncenter alignright | image | indent outdent | bullist numlist | code | table | fullscreen'])
<div wire:ignore class="w-full relative">
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
                         block_formats: '{{$blocks}}',
                         image_title: true,
                         promotion: false,
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
