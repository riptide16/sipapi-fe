@push('js')
<script>
    let url = "{{ route('admin.kategori_instrumen.filter') }}";
    $(document).ready(function () {
        $('#category').change(function () {
            let category = $(this).val();
            disableSelect('.main_id');
            disableSelect('.sub_1_id');
            let components = filterComponents({
                category: category,
                type: 'main',
            }, '.main_id');
        });
        $('.main_id').change(function () {
            let category = $('#category').val();
            disableSelect('.sub_1_id');
            let components = filterComponents({
                category: category,
                type: 'sub_1',
                parent_id: $(this).val(),
            }, '.sub_1_id');
        });
    });

    function disableSelect(select) {
        $(select + ' option').remove();
        $(select).prop('disabled', true);
    }

    function filterComponents(params, target) {
        const query = new URLSearchParams(params);
        jQuery.ajax({
            method: 'GET',
            dataType: 'json',
            url: url + '?' + query.toString(),
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
        }).done((result) => {
            $(target).empty();
            if (target != '.sub_id') {
                $('.sub_id').val(null).trigger('change');
            }
            $(target).append('<option value="">-- Please Select --</option>');
            $.each(result, function (key, value) {
                $(target).append('<option value="'+ value.id + '">'+ value.name + '</option>')
            });
            $(target).prop('disabled', false);
        }).fail((error) => {
            $('#'+target).append('<option value="999999">error</option>')
        })
    }
</script>
@endpush
