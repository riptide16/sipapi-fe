@push('js')
    <script>
        $('#telephone_number, #mobile_number').on('keypress', function(e){
	    return e.metaKey || // cmd/ctrl
            e.which <= 0 || // arrow keys
            e.which == 8 || // delete key
            /[0-9]/.test(String.fromCharCode(e.which)); // numbers
        })

        function addWorker() {
            let clone = $('.library_worker_name').first().clone();
            clone.val('');
            $('.library_worker_name').first().parent().append(clone);
        }

        function removeWorker() {
            if ($('.library_worker_name').length > 1) {
                $('.library_worker_name').last().remove();
            }
        }

        let statusVerify = $('#statusVerify').val();

        if (statusVerify == 'tidak_valid') {
            $(':input','#institutionForm')
                .not(':button, :submit, :reset, :hidden')
                .val('')
                .removeAttr('checked')
                .removeAttr('selected');
        }

        @if (isset($data['category']) && !in_array($data['category'], ['Provinsi', 'Kabupaten Kota']))
            $('#typology').hide();
        @endif
        $('#category').change(function() {
            jenisPerpus = $(this).val();
            if (jenisPerpus == 'Provinsi' || jenisPerpus == 'Kabupaten Kota') {
                $('#typology').show();
            } else {
                $('#typology').hide();
            }
        })

        function getLocation(url = false, target = 'region_id') {
            jQuery.ajax({
                type: 'GET',
                dataType : 'json',
                url: url,
                headers : {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
            }).done((result) => {
                $('#'+target).empty()
                $('#'+target).append('<option value="">-- Please Select --</option>')
                $.each(result.data, function (key, value) {
                    if(target == "city_id" && value.type == "Kabupaten"){
                        $('#'+target).append('<option value="'+ value.id + '">'+ "Kab. "+ value.name + '</option>')
                    }
                    else{
                        $('#'+target).append('<option value="'+ value.id + '">'+ value.name + '</option>')
                    }
                });
            }).fail(() => {
                $('#'+target).append('<option value="999999">error</option>')
            });
        }

        $(function () {
            let regionId = $('#region_id').val();
            $('#region_id').change(function () {
                regionId = $(this).val();
                url = "{{ route('admin.master_data.get_location') }}?region_id="+regionId;
                $('#province_id,#city_id,#subdistrict_id,#village_id').prop('disabled', true);

                getLocation(url, 'province_id');

                if (region_id != "") {
                    $('#province_id').prop('disabled', false);
                } else {
                    $('#province_id').prop('disabled', true);
                }
            })

            let provinceId;
            let cityId;
            $('#province_id').change(function () {
                provinceId = $(this).val();
                url = "{{ route('admin.master_data.get_location') }}?province_id="+provinceId;
                $('#city_id,#subdistrict_id,#village_id').prop('disabled', true);

                getLocation(url, 'city_id');

                if (provinceId != "") {
                    $('#city_id').prop('disabled', false);
                } else {
                    $('#city_id').prop('disabled', true);
                }
            })

            $('#city_id').change(function () {
                cityId = $(this).val();
                url = "{{ route('admin.master_data.get_location') }}?city_id="+cityId;
                $('#subdistrict_id,#village_id').prop('disabled', true);

                getLocation(url, 'subdistrict_id');

                if (city_id != "") {
                    $('#subdistrict_id').prop('disabled', false);
                } else {
                    $('#subdistrict_id').prop('disabled', true);
                }
            })

            $('#subdistrict_id').change(function () {
                subdistrictId = $(this).val();
                url = "{{ route('admin.master_data.get_location') }}?subdistrict_id="+subdistrictId;
                $('#village_id').prop('disabled', true);

                getLocation(url, 'village_id');

                if (city_id != "") {
                    $('#village_id').prop('disabled', false);
                } else {
                    $('#village_id').prop('disabled', true);
                }
            })
        })
    </script>
@endpush
