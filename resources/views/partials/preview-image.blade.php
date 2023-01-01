@php
    $module = preg_replace('/=/', '', base64_encode(__FILE__)) . \Illuminate\Support\Str::random(5);
@endphp

<style>
    @import url(https://fonts.googleapis.com/css?family=Open+Sans:700,300);

    .preview__frame-{{ $module }} {
        display: block;
        position: relative;
        width: 100%;
        height: 100%;
        border-radius: 2px;
        /* box-shadow: 4px 8px 16px 0 rgba(0, 0, 0, 0.1); */
        overflow: hidden;
        /* background: linear-gradient(to top right, darkmagenta 0%, hotpink 100%); */
        color: #333;
        font-family: "Open Sans", Helvetica, sans-serif;
    }

    .preview__center-{{ $module }} {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 100%;
        height: 100%;
        border-radius: 3px;
        box-shadow: 8px 10px 15px 0 rgba(0, 0, 0, 0.2);
        background: #fff;
        display: flex;
        align-items: center;
        justify-content: space-evenly;
        flex-direction: column;
    }

    .preview__title-{{ $module }} {
        width: 100%;
        height: 50px;
        border-bottom: 1px solid #999;
        text-align: center;
    }

    .preview-{{ $module }} h5 {
        font-size: 16px;
        font-weight: 300;
        color: #666;
    }

    .preview__dropzone-{{ $module }} {
        width: 100px;
        height: 80px;
        border: 1px dashed #999;
        border-radius: 3px;
        text-align: center;
    }

    .preview__uploadIcon-{{ $module }} {
        margin: 25px 2px 2px 2px;
    }

    .preview__uploadInput-{{ $module }} {
        position: absolute;
        /* background-color: red; */
        width: 100%;
        height: 100%;
        left: 50%;
        top: 50%;
        transform: translate(-50%, -50%);
        opacity: 0;
    }

    .preview__btn-{{ $module }} {
        display: block;
        width: 140px;
        height: 40px;
        background: darkmagenta;
        color: #fff;
        border-radius: 3px;
        border: 0;
        box-shadow: 0 3px 0 0 hotpink;
        transition: all 0.3s ease-in-out;
        font-size: 14px;
    }

    .preview__btn-{{ $module }}:hover {
        background: rebeccapurple;
        box-shadow: 0 3px 0 0 deeppink;
    }

    .preview__img-{{ $module }} {
        width: 100%;
        height: 100%;
        border-radius: 50%;
    }
</style>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.3/jquery.min.js"
    integrity="sha512-STof4xm1wgkfm7heWqFJVn58Hm3EtS31XFaagaa8VMReCXAkQnJZ+jEy8PCC/iT18dFy95WcExNHFTqLyp72eQ=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>


<script>
    function appendPreviewFrame(nodeElement, inputName = '') {

        $(nodeElement).append(`
            <label class="preview__frame-{{ $module }}">
                <div class="preview__center-{{ $module }}">
                    <div class="preview__title-{{ $module }}">
                        <h5>Drop file to upload</h5>
                    </div>

                    <div class="preview__dropzone-{{ $module }}">
                        <img src="http://100dayscss.com/codepen/upload.svg" class="preview__uploadIcon-{{ $module }}" />
                        <input type="file" class="preview__uploadInput-{{ $module }} img-{{ $module }}" accept="image/*" name="${inputName}">
                    </div>

                    {{-- <button type="button" class="preview__btn-{{ $module }}">Upload file</button> --}}

                </div>
                <img class="preview__img-{{ $module }}" style="z-index: 0" src="${$(nodeElement).attr('default') ?? ''}">
            </label>
        `);

        if ($(nodeElement).attr('default')) {
            show{{ $module }}($('.img-{{ $module }}'))
        }
    }

    function show{{ $module }}(that) {
        let arr = that[0].files.length == 0 ? ['test', ''] : ['src', URL.createObjectURL(that[0].files[0])]

        that
            .parents('.preview__center-{{ $module }}').css('opacity', '0')
            .parents('.preview__frame-{{ $module }}')
            .find('.preview__img-{{ $module }}').attr(...arr)
            .css({
                'objectFit': 'cover',
                'width': '100%',
                'height': '100%',
                'zIndex': '1',
                'margin': '0'
            });
    }

    $(() => {
        $('input[type=file].img-{{ $module }}').on('change', function() {
            show{{ $module }}($(this));
        });
    })
</script>
