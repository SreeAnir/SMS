<div class="form-floating fv-row {{$attributes->get('direction')}}">
    <textarea class="form-control editors" placeholder="{{$label}}" data-component-init="initTinyMCE"
              id="{{$getId()}}" {{$attributes->except(['id','name','label','value'])}}
              name="{{$getName()}}" data-max-length="{{$maxlength}}">{!! $attributes->get('value') !!}</textarea>
    <label class="fs-6 fw-bold form-label mb-2"
           for="{{$getId()}}">{{$label}}</label>
</div>
@once
    @push('styles')
        <style>
            .tox-tinymce {
                height: 300px !important;
            }
        </style>
    @endpush
    @push('scripts')
        <script src="{{asset('assets/plugins/custom/tinymce/tinymce.bundle.js')}}"></script>
        <script>
            BladeComponents.initTinyMCE = function (element) {
                let editor_config = {
                    branding: false,
                    menubar: false,
                    height: 300,
                    plugins: ['directionality paste nonbreaking pagebreak hr anchor autolink lists link wordcount'],
                    toolbar1: 'undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link |print preview media | forecolor backcolor',
                    tinycomments_mode: 'embedded',
                    tinycomments_author: '',
                    iconfonts_selector: '.fa, .fab, .fal, .far, .fas, .glyphicon',
                    image_advtab: true,
                    relative_urls: false,
                    media_poster: false,
                    remove_script_host: false,
                    image_title: true,
                    automatic_uploads: false,
                    setup: editor => {
                        editor.on('init', function (e) {
                            let element = $(editor.targetElm);
                            editor.setContent(element.val());
                        });
                        let max = $('#' + editor.id).data('max-length');
                        editor.on('keyup', e => {
                            let numChars = tinymce.activeEditor.plugins.wordcount.body.getCharacterCount();
                            if (numChars > max) {
                                swalError("Maximum " + max + " characters allowed.", 'Info');
                            }
                        });
                        editor.on('change', e => {
                            let element = $(editor.targetElm);
                            element.val(editor.getContent());
                            FormValidationHelper.getInstanceFromElement(element).safelyReValidateField(element.attr('description'));
                        });
                    },
                };
                let direction = element.attr('direction') ?? 'ltr';
                let config = $.extend(editor_config, {target: element[0], directionality: direction});
                tinymce.init(config);
            }

            $(document).ready(function () {
                $("textarea.editors").each((i, el) => {
                    if ($(el).closest('.repeater-component-container').length <= 0) {
                        BladeComponents.initTinyMCE($(el));
                    }
                })
            });
        </script>
    @endpush
@endonce
