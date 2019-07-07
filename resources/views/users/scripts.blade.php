@push('scripts')
    <script src="{{ asset('js/plugins/moment/moment.min.js') }}"></script>
    <script src="{{ asset('js/plugins/tempusdominus-bootstrap-4/tempusdominus-bootstrap-4.min.js') }}"></script>
    <script src="{{ asset('js/plugins/jasnyBootstrap/jasny-bootstrap.min.js') }}"></script>

    <script type="text/javascript">
        $('#name').on('blur', function() {
            var theTitle = this.value.toLowerCase().trim(),
                slugInput = $('#slug'),
                theSlug = theTitle.replace(/&/g, '-and-')
                    .replace(/[^a-z0-9-]+/g, '-')
                    .replace(/\-\-+/g, '-')
                    .replace(/^-+|-+$/g, '');

            slugInput.val(theSlug);
        });

        $('#datepickerBirthday').datetimepicker({
            viewMode: 'years',
            format: 'YYYY/MM/DD'
        });
    </script>
@endpush