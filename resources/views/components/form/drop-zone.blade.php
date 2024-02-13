<div class="fv-row">
    <!--begin::Dropzone-->
    <div class="dropzone" {{$attributes->merge(['id'=>$getId(),'name'=>$getName()])->except(['value'])}}>
        <input id="{{'validate_'.$getId()}}" type="hidden" name="{{'validate_'.$getName()}}">
        <!--begin::Message-->
        <div class="dz-message needsclick">
            <!--begin::Icon-->
            <i class="bi bi-file-earmark-arrow-up text-primary fs-3x"></i>
            <!--end::Icon-->

            <!--begin::Info-->
            <div class="ms-4">
                <h3 class="fs-5 fw-bolder text-gray-900 mb-1">
                    {{$attributes->get('label',__('Drop file here or click to upload.'))}}
                </h3>
                <span class="fs-7 fw-bold text-gray-400">
                    {{$attributes->get('info',__('Upload up to 1 file'))}}
                </span>
            </div>
            <!--end::Info-->
        </div>
    </div>
    <!--end::Dropzone-->
</div>

@once
    @push('styles')
        <!-- Style added from drop-zone component -->
        <style>
            .dz-image img {
                width: 100%;
                height: 100%;
            }
        </style>
    @endpush

    @push('scripts')
        <script>
            //Dropzone common script
            class DropZoneManger {
                dropzone = null;
                id = null;
                el = null;
                config = null;
                value = null;
                inputName = 'file';

                constructor(el, config, value) {
                    let manager = this;
                    this.el = el;
                    this.id = el.attr('id');
                    this.value = value;

                    this.config = {
                        url: '{{route('admin.media.store')}}',
                        paramName: "file",
                        maxFiles: 1,
                        maxFilesize: 10, // MB
                        addRemoveLinks: true,
                        acceptedFiles: 'image/*',
                        headers: {
                            'X-CSRF-TOKEN': "{{ csrf_token() }}"
                        },
                        init: function () { //We have to keep it this function syntax here for access to "this"
                            if (!manager.value) {
                                return;
                            }
                            let files = manager.value;

                            if (typeof files === "object") {
                                if (files.length > 0) {
                                    $("#validate_" + manager.id).val(files.length).change();
                                }
                                for (let i in files) {
                                    let file = files[i];
                                    file.accepted = true; //Only by having this property will the file count towards maxFiles count
                                    file.loaded = true; //This flag here is to identify the initially loaded files
                                    let imageUrl = null;
                                    if (file.type === 'pdf') {
                                        imageUrl = '{{asset('assets/media/pdf.png')}}';
                                    } else if (file.type === 'video') {
                                        imageUrl = '{{asset('assets/media/video.jpg')}}';
                                    } else {
                                        imageUrl = file.dataURL;
                                    }
                                    this.displayExistingFile(file, imageUrl);
                                    this.files.push(file);
                                    // console.log('Loaded file -> ', file);
                                }
                            }
                        },
                        accept: (file, done) => {
                            return done();
                        },
                        success: (file, response) => {
                            this.processSuccess(file, response);
                        },
                        error: (file, data) => {
                            // console.log('Dropzone error -> ', data);
                            file.previewElement.remove();
                            this.dropzone.removeFile(file);
                            this.showDropZoneError(data);
                        },
                        removedfile: file => {
                            this.processRemove(file);
                        }
                    };
                    this.config = {...this.config, ...config};
                    // console.log('Dropzone Config -> ', this.config);

                    //Input name
                    this.inputName = this.el.attr('name') ?? 'image';
                    if (this.config.maxFiles === null || this.config.maxFiles > 1) {
                        this.inputName += '[]'; //Add brackets at end for an array of files
                    }

                    this.init();
                }

                init() {
                    this.dropzone = new Dropzone("#" + this.id, this.config);
                }

                fixName(name) {
                    return name.replace('[]', '');
                }

                addFileInput(value, type) {
                    let html = '<input type="hidden" name="' + this.inputName + '" value="' + value + '" data-type="' + type + '">';
                    this.el.closest('form').append(html);
                    $("#validate_" + this.id).val(value).attr('data-type', type).change();
                }

                removeFileInput(file) {
                    let selector = 'input[name="' + this.inputName + '"][value="' + file.file_name + '"]';
                    this.el.parents('form').find(selector).remove();
                    $("#validate_" + this.id).val("").attr('data-type', "").change();
                }

                addRemovedFileInput(file) {
                    let html = '<input type="hidden" name="remove_file_' + this.inputName + '" value="' + file.id + '">';
                    this.el.closest('form').append(html);
                    $("#validate_" + this.id).val("").attr('data-type', "").change();
                }

                processSuccess(file, response) {
                    this.addFileInput(response.name, file.type);
                    file.processed = true;
                    file.file_name = response.name;
                    file.dataURL = response.url;
                    if (file.type.split('/')[0] === 'image') {
                        //Do nothing
                    } else if (file.type === 'application/pdf') {
                        this.dropzone.emit("thumbnail", file, '{{asset('uploads/pdf.png')}}');
                    } else {
                        this.dropzone.emit("thumbnail", file, '{{asset('assets/media/video.jpg')}}');
                        createVideoLengthInputFields(this, file);
                    }
                }

                processRemove(file) {
                    setTimeout(() => {
                        $(this.dropzone.element).addClass("dz-started");
                    }, 50); //Need a delay for it to work.
                    if (!file.processed && !file.loaded) {
                        setTimeout(() => {
                            if (this.dropzone.files.length <= 0) {
                                $(this.dropzone.element).removeClass("dz-started");
                            }
                        }, 50); //Need a delay for it to work.
                        return;
                    }
                    swal.fire({
                        title: '@lang("Are you sure want to delete?")',
                        html: '<p>@lang("Once deleted, you will lose the file!")</p>',
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonText: '@lang('Yes')',
                        allowOutsideClick: false,
                        cancelButtonText: '@lang('No')',
                        reverseButtons: true,
                        customClass: {
                            confirmButton: "btn btn-light",
                            cancelButton: "btn btn-primary",
                        },
                    }).then((result) => {
                        if (!result.isConfirmed) {
                            return;
                        }

                        //Loaded check should be first because there can have files that are accepted but not loaded from server
                        if (file.loaded) {
                            //If initially loaded file, then add input field to delete that file on form submit.
                            this.addRemovedFileInput(file);
                            file.previewElement.remove();
                        } else if (file.accepted) {
                            swal.fire({
                                title: 'Please wait...',
                                showConfirmButton: false,
                                willOpen: () => {
                                    swal.showLoading();
                                }
                            });
                            //Delete the temporary uploaded file
                            $.ajax({
                                headers: {
                                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                                },
                                type: 'DELETE',
                                url: "{{route('admin.media.destroy')}}",
                                data: {name: file.file_name},
                                success: response => {
                                    swal.close();
                                    if (response.status === 'success') {
                                        file.previewElement.remove();
                                        this.removeFileInput(file);
                                    } else {
                                        this.showDropZoneError(response.message);
                                    }
                                },
                                error: function (e) {
                                    console.log(e);
                                }
                            });
                        }

                        if (this.dropzone.files.length <= 0) {
                            $(this.dropzone.element).removeClass("dz-started");
                        }
                    });
                }

                showDropZoneError(message) {
                    let row = this.el.closest('.fv-row');
                    if (!row.find('.fv-plugins-message-container').length) {
                        let containerHtml = '<div class="fv-plugins-message-container invalid-feedback"></div>';
                        this.el.closest('.fv-row').append(containerHtml);
                    }
                    let html = '<div>' + message + '</div>';
                    row.find('.fv-plugins-message-container').append(html);
                    setTimeout(() => {
                        this.hideDropZoneError();
                    }, 5500);
                }

                hideDropZoneError() {
                    this.el.closest('.fv-row').find('.fv-plugins-message-container').html('');
                }
            }
        </script>
    @endpush
@endonce

@push('scripts')
    <script>
        $(() => {
            //Dropzone individual script for input with id {{$getId()}} */
            let config = JSON.parse('{!! html_entity_decode($attributes->get('config','{}')) !!}');
            let value = JSON.parse('{!! html_entity_decode($attributes->get('value')?:'{}') !!}');
            let elm = $('#{{$getId()}}');
            let manager = new DropZoneManger(elm, config, value);
            elm.data('dz-manager', manager);
        })
    </script>
    <script>
        async function createVideoLengthInputFields(form, file) {
            getVideoLength(file).then(length => {
                // console.log('length:', length);
                let elements = document.getElementsByClassName('video_length');
                while (elements.length > 0) {
                    elements[0].parentNode.removeChild(elements[0]);
                }

                if (length) {
                    let html;
                    html = '<input class="video_length" type="hidden" name="video_length[h]" value="' + length.h + '">';
                    form.el.closest('form').append(html);
                    html = '<input class="video_length" type="hidden" name="video_length[m]" value="' + length.m + '">';
                    form.el.closest('form').append(html);
                    html = '<input class="video_length" type="hidden" name="video_length[s]" value="' + length.s + '">';
                    form.el.closest('form').append(html);
                    html = '<input class="video_length" type="hidden" name="video_length[ts]" value="' + length.ts + '">';
                    form.el.closest('form').append(html);
                }
            });
        }

        async function getVideoLength(file) {
            const video = await loadVideo(file)
            var timenow = video.duration

            // console.log('video.duration', video.duration)

            if (parseInt(timenow) / 60 >= 1) {
                var h = Math.floor(timenow / 3600);
                timenow = timenow - h * 3600;
                var m = Math.floor(timenow / 60);
                var s = Math.floor(timenow % 60);
                return {
                    h: h.toString().padStart(2, '0'),
                    m: m.toString().padStart(2, '0'),
                    s: s.toString().padStart(2, '0'),
                    ts: Math.floor(timenow)
                }
            } else {
                var m = Math.floor(timenow / 60);
                var s = Math.floor(timenow % 60);
                return {
                    h: 00,
                    m: m.toString().padStart(2, '0'),
                    s: s.toString().padStart(2, '0'),
                    ts: Math.floor(timenow)
                }
            }
        }

        async function loadVideo(file) {
            return new Promise(function (resolve, reject) {
                try {
                    console.log(file);
                    var video = document.createElement('video');
                    video.preload = 'metadata';

                    video.onloadedmetadata = function () {
                        resolve(this);
                    };
                    video.onerror = function () {
                        reject("Invalid video. Please select a video file.");
                    };

                    video.src = window.URL.createObjectURL(file);
                } catch (e) {
                    reject(e);
                }
            });
        };
    </script>
@endpush
