@extends(config('laravel-h5p.layout'))

@section('h5p')
    <div class="container-fluid">

        <div class="row">

            <div class="col-md-12">
                <div class="h5p-content-wrap">
                    {!! $embed_code !!}
                </div>

                <br />
                <p class='text-center'>

                    <a href="{{ url()->previous() }}" class="btn btn-default"><i class="fa fa-reply"></i>
                        {{ trans('laravel-h5p.content.cancel') }}</a>

                </p>
            </div>

        </div>

    </div>
@endsection

@push('h5p-header-script')
    {{--    core styles       --}}
    @foreach ($settings['core']['styles'] as $style)
        {{ Html::style($style) }}
    @endforeach

    @foreach ($settings['loadedCss'] as $style)
        {{ Html::style($style) }}
    @endforeach
@endpush

@push('h5p-footer-script')
<script type="text/javascript">
    H5PIntegration = {!! json_encode($settings) !!};

    if (H5PIntegration.contents) {
        // Extract the keys (like 'cid-2', 'cid-17', etc.)
        var keys = Object.keys(H5PIntegration.contents);

        keys.forEach(function(key) {
            if (H5PIntegration.contents[key].scripts) {
                // Remove undesired scripts
                H5PIntegration.contents[key].scripts = H5PIntegration.contents[key].scripts.filter(function(script) {
                    return !(
                        script.includes('html5.js') ||
                        script.includes('youtube.js') ||
                        script.includes('vimeo.js') ||
                        script.includes('multichoice.js') ||
                        script.includes("scripts/video.js?ver=1.6.10") ||
                        script.includes("panopto.js")
                    );
                });

                // Array of custom scripts
                var customScripts = [
                    "{{ asset('js/custom-h5p-html5.js') }}",
                    "{{ asset('js/custom-h5p-multichoice.js') }}",
                    "{{ asset('js/custom-h5p-youtube.js') }}",
                    "{{ asset('js/custom-h5p-video.js') }}",
                    "{{ asset('js/custom-h5p-vimeo.js') }}",
                    "{{ asset('js/custom-h5p-panopto.js') }}"
                ];
                
                // Add custom scripts
                customScripts.forEach(function(script) {
                    H5PIntegration.contents[key].scripts.push(script);
                });
                
                // Output for debugging
                console.log(H5PIntegration.contents[key].scripts);
            }
        });
    } else {
        console.warn('H5PIntegration.contents is not defined!');
    }
</script>



   @foreach ($settings['core']['scripts'] as $script)
    {{ Html::script($script) }}
    <script>
        console.log('Core : {{ $script }}');
    </script>
    
    @endforeach

    @foreach ($settings['loadedJs'] as $script)
        {{ Html::script($script) }}
        <script>
            console.log('LoadedJS: {{ $script }}');
        </script>
    @endforeach

    {{-- <script defer></script> --}}
@endpush