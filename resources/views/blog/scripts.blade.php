@push('scripts')
    <script src="{{ asset('js/plugins/simplemde/simplemde.min.js') }}"></script>
    <script src="{{ asset('js/plugins/moment/moment.min.js') }}"></script>
    <script src="{{ asset('js/plugins/tempusdominus-bootstrap-4/tempusdominus-bootstrap-4.min.js') }}"></script>
    <script src="{{ asset('js/plugins/tagEditor/jquery.caret.min.js') }}"></script>
    <script src="{{ asset('js/plugins/tagEditor/jquery.tag-editor.min.js') }}"></script>
    <script src="{{ asset('js/plugins/jasnyBootstrap/jasny-bootstrap.min.js') }}"></script>

    <script type="text/javascript">
        var options = {};

        @if ($post->exists)
            options = {
                initialTags: {!! $post->tags_list !!}
            };
        @endif

        $('input[name=post_tags]').tagEditor(options);

        $('#title').on('blur', function() {
            var theTitle = this.value.toLowerCase().trim(),
                slugInput = $('#slug'),
                theSlug = theTitle.replace(/&/g, '-and-')
                    .replace(/[^a-z0-9-]+/g, '-')
                    .replace(/\-\-+/g, '-')
                    .replace(/^-+|-+$/g, '');

            slugInput.val(theSlug);
        });

        var simplemde1 = new SimpleMDE({ element: $("#excerpt")[0] });
        var simplemde2 = new SimpleMDE({ element: $("#body")[0] });

        $('#datetimepicker1').datetimepicker({
            format: 'YYYY-MM-DD HH:mm:ss',
            showClear: true
        });

        $('#draft-btn').click(function(e) {
            e.preventDefault();
            $('#published_at').val("");
            $('#post-form').submit();
        });

    </script>
@endpush