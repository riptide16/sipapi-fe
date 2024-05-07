@push('js')
    <script>
        $(document).ready(function(){
            toggleParentSelect($('input[name=menu_type]:checked').val());

            $('input[name=menu_type]').change(function () {
                toggleParentSelect($(this).val());
            });
        });

        function toggleParentSelect(value) {
            if (value == 'submenu') {
                $('.parent_select').show();
                $('#parent_id').prop('required', true);
            } else {
                $('.parent_select').hide();
                $('#parent_id').prop('required', false);
            }
        }
    </script>
@endpush
