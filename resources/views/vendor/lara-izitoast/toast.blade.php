@php
    foreach (optional(session()->get('errors'))->keys() ?? [] as $key => $message) {
        // notify($message, null, 'error');
    }
    
@endphp

<script>
    'use strict';
    @foreach (session('toasts', collect())->toArray() as $toast)

        var options = {
            title: '{{ $toast['title'] }}',
            message: <?= is_array($toast['message']) ? "''" : "'$toast[message]'" ?>,
            messageColor: '{{ $toast['messageColor'] }}',
            messageSize: '{{ $toast['messageSize'] }}',
            titleLineHeight: '{{ $toast['titleLineHeight'] }}',
            messageLineHeight: '{{ $toast['messageLineHeight'] }}',
            position: '{{ $toast['position'] }}',
            titleSize: '{{ $toast['titleSize'] }}',
            titleColor: '{{ $toast['titleColor'] }}',
            closeOnClick: '{{ $toast['closeOnClick'] }}',

        };

        var type = '{{ $toast['type'] }}';

        @php
            echo "var myOptions;\n";
            if (is_array($toast['message'])) {
                foreach ($toast['message'] as $item) {
                    echo "            myOptions = {...options, message: '$item[0]'};\n";
                    echo "            show('$item[2]', myOptions);\n";
                }
            } else {
                echo 'show(type, options);';
            }
        @endphp
    @endforeach
    function show(type, options) {
        if (type === 'info') {
            iziToast.info(options);
        } else if (type === 'success') {
            iziToast.success(options);
        } else if (type === 'warning') {
            iziToast.warning(options);
        } else if (type === 'error') {
            iziToast.error(options);
        } else {
            iziToast.show(options);
        }

    }
</script>
{{ session()->forget('toasts') }}
