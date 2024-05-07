@extends('layouts.public')

@section('content')
<section class="text-gray-600 body-font py-10 container mx-auto">
    <div class="margin-100 mx-auto bg-white flex-row relative">
        <div class="m-6 md:mx-0 bg-white text-blue-900 rounded-t">
            <h5 class="text-gray-700 text-2xl capitalize">Penelusuran Akreditasi Perpustakaan</h5>
        </div>
        <div class="mx-auto px-5 lg:px-0 grid grid-cols-1 md:grid-cols-2 justify-center gap-5 py-5">
            <form action="#hasil" method="GET">
                <div class="grid grid-cols-1 lg:grid-cols-2 justify-center gap-5 py-1">
                    <label for="province" class="md:mx-0 text-left">Provinsi</label>
                    <select id="province" class="md:ml-0" name="province">
                        <option value="">Pilih</option>
                        @foreach ($provinces as $province)
                            <option value="{{ $province['id'] }}" {{ isset($get['province']) && $get['province'] == $province['id'] ? 'selected' : '' }}>{{ $province['name'] }}</option>
                        @endforeach
                    </select>
                    <label for="city" class="md:mx-0 text-left">Kabupaten/Kota</label>
                    <select id="city" class="md:ml-0" name="city" disabled>
                        <option value="">Pilih</option>
                    </select>
                    <label for="category" class="md:mx-0 text-left">Jenis Perpustakaan</label>
                    <select id="category" class="md:ml-0" name="category">
                        <option value="">Pilih</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category }}" {{ isset($get['category']) && $get['category'] == $category ? 'selected' : '' }}>{{ $category }}</option>
                        @endforeach
                    </select>
                    <label for="predicate" class="md:mx-0 text-left">Predikat</label>
                    <select id="predicate" class="md:ml-0" name="predicate">
                        <option value="">Pilih</option>
                        @foreach ($predicates as $predicate)
                            <option value="{{ $predicate }} {{ isset($get['predicate']) && $get['predicate'] == $predicate ? 'selected' : '' }}">{{ $predicate }}</option>
                        @endforeach
                    </select>
                    <label for="name" class="md:mx-0 text-left">Nama Perpustakaan</label>
                    <input type="text" class="md:ml-0 border border-gray-400 px-2" name="name" />
                    <label for="captcha" class="md:mx-0 text-left">Captcha</label>
                    <div class="grid grid-rows-1">
                        <input type="text" class="md:ml-0 border border-gray-400 px-2" name="captcha" />
                        @error('captcha')
                            <small class="text-red-500">{{ $message }}</small>
                        @enderror
                    </div>
                    <div></div>
                    <div class="captcha inline">
                        <input type="hidden" name="do" value="1" />
                        <span>{!! captcha_img('inverse') !!}</span>
                        <button type="button" class="bg-red-500 text-white text-2xl my-2 px-2 rounded-xl" class="reload" id="reload">
                            &#x21bb;
                        </button>
                    </div>
                </div>
                <div class="my-6 flex justify-center">
                    <button class="w-full md:w-64 font-semibold text-white bg-green-500 rounded-lg p-3" type="submit">Cari Perpustakaan</button>
                </div>
            </form>
        </div>

        @isset ($libraries['data'])
            <div class="m-6 md:mx-0 bg-white text-blue-900 rounded-t">
                <h5 id="hasil" class="text-gray-700 text-lg capitalize">Hasil Penelusuran</h5>
            </div>
            <div class="overflow-auto lg:overflow-visible">
                <table class="pb-16 border-collapse border border-gray w-full">
                    <thead>
                        <th class="border border-green bg-green-500 text-white py-2">No.</th>
                        <th class="border border-green bg-green-500 text-white py-2">Nama Perpustakaan</th>
                        <th class="border border-green bg-green-500 text-white py-2">Jenis Perpustakaan</th>
                        <th class="border border-green bg-green-500 text-white py-2">Tahun Akreditasi Terakhir</th>
                        <th class="border border-green bg-green-500 text-white py-2">Predikat</th>
                        <th class="border border-green bg-green-500 text-white py-2">Alamat</th>
                    </thead>
                    <tbody>
                        @foreach ($libraries['data'] as $library)
                            <tr>
                                <td class="border border-gray text-center py-2">{{ $loop->iteration }}</td>
                                <td class="border border-gray text-center py-2">{{ $library['library_name'] }}</td>
                                <td class="border border-gray text-center py-2">{{ $library['category'] }}</td>
                                <td class="border border-gray text-center py-2">{{ $library['tahun'] }}</td>
                                <td class="border border-gray text-center py-2">{{ $library['predicate'] }}</td>
                                <td class="border border-gray text-center py-2">{{ $library['address'] }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="p-10 grid grid-cols-1 gap-5">
                <div class="flex justify-center space-x-4">
                    @isset ($libraries['prev_page_url'])
                        <a href="{{ route('layanan.akreditasi.browse', array_merge(request()->all(), ['page' => $libraries['current_page'] - 1])) }}" class="px-4 py-2 font-bold text-gray-500 bg-gray-300 rounded-md hover:bg-blue-400 hover:text-white">
                            Sebelumnya
                        </a>
                    @endisset
                    @isset ($libraries['next_page_url'])
                        <a href="{{ route('layanan.akreditasi.browse', array_merge(request()->all(), ['page' => $libraries['current_page'] + 1])) }}" class="px-4 py-2 font-bold text-gray-500 bg-gray-300 rounded-md hover:bg-blue-400 hover:text-white">
                            Berikutnya
                        </a>
                    @endisset
                </div>
            </div>
        @endisset
    </div>
</section>
@endsection

@push('script')
    <script>
        $('#reload').on('click', function () {
            $.ajax({
                type: 'GET',
                url: "{{ route('register.reload_captcha') }}",
                success: function (data) {
                    $(".captcha span").html(data.captcha);
                }
            })
        })
        $("select").select2();

        $("#province").on('change', function () {
            let provinceId = $(this).val();

            let query = new URLSearchParams({
                province_id: provinceId,
            });
            jQuery.ajax({
                method: 'GET',
                dataType: 'json',
                url: '/json/cities' + '?' + query.toString(),
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
            }).done((result) => {
                let target = '#city';
                $(target).empty();
                $(target).append('<option value="">Pilih</option>');
                $.each(result.data, function (key, value) {
                    $(target).append('<option value="'+ value.id + '">'+ value.type + ' ' + value.name + '</option>')
                });
                $(target).prop('disabled', false);
            }).fail((error) => {
            })
        });
    </script>
@endpush
