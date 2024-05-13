@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center py-4">
    <div class="d-block mb-4 mb-md-0">
        <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
            <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent">
                <li class="breadcrumb-item">
                    <a href="{{ route('admin.dashboard') }}">
                        <x-icons.home/>
                    </a>
                </li>
                <li class="breadcrumb-item" aria-current="page">
                    <a href="{{ route('admin.akreditasi.index') }}" class="text-info">
                        All Acreditation
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Input Data Pengajuan Akreditasi</li>
            </ol>
        </nav>
        <h2 class="h4">Input Data Pengajuan Akreditasi</h2>
    </div>
</div>
<div class="card border-0 shadow mb-4">
    <div class="card-body">
        <form action="{{ route('admin.akreditasi.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @php
                $aspectNo = 1;
            @endphp
            <input type="hidden" name="action_type" value="{{ $fetchData['data'][0]['action_type'] }}">
            <input type="hidden" name="type" value="{{ $type }}">
            @if(!empty($fetchData['links']['next']))
                <input type="hidden" name="next" value="{{ $fetchData['meta']['to'] + 1 }}">
            @endif
            @if($fetchData['data'][0]['action_type'] == "choice")
                <div class="form-group row mb-2">
                    @if (count($fetchData['data'][0]['aspects']) > 0)
                        <h2 class="question-title">{{ $fetchData['meta']['current_page'] }}. {{ $fetchData['data'][0]['name'] }}</h2>
                        <input type="hidden" value="{{ $fetchData['data'][0]['id'] }}" name="component_id[]">
                        @foreach($fetchData['data'][0]['aspects'] as $key => $item)
                            <div>
                                <div class="aspect-box">
                                    <input type="hidden" value="{{ $item['id'] }}" name="aspect_id[]">
                                    <div class="form-group row">
                                        <p class="fw-bold">{{ $aspectNo++ }}. {{ $item['aspect'] }}</p>
                                    </div>
                                    <div class="aspect-opts">
                                        <small>Pilih salah satu</small>
                                        @if ($item['type'] == 'multi_aspect')
                                            @foreach ($item['children'] as $multiChildAspect)
                                                <p class="fw-bold">{{ $multiChildAspect['aspect'] }}</p>
                                                @foreach(array_slice($multiChildAspect['points'], 0, 5) as $key2 => $item2)
                                                <div class="border-success d-flex py-2 px-0">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="statement[{{ $item['id'] }}]" id="exampleRadios{{ $item['aspect'] . $item2['id'] }}" value="{{ $item2['id'] }}" {{ !empty($item['answers']) && $item['answers'][0]['instrument_aspect_point_id'] == $item2['id'] ? 'checked' : ''}}>
                                                        <label class="form-check-label" for="exampleRadios{{ $item['aspect'] . $item2['id'] }}">
                                                        {{ range('a', 'e')[$loop->index].'. '.$item2['statement'] }}
                                                        </label>
                                                    </div>
                                                </div>
                                                @endforeach
                                            @endforeach
                                        @else
                                            @foreach(array_slice($item['points'], 0, 5) as $key2 => $item2)
                                            <div class="border-success d-flex py-2 px-0">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="statement[{{ $item['id'] }}]" id="exampleRadios{{ $key }}" value="{{ $item2['id'] }}" {{ !empty($item['answers']) && $item['answers'][0]['instrument_aspect_point_id'] == $item2['id'] ? 'checked' : ''}}>
                                                    <label class="form-check-label" for="exampleRadios{{ $key }}">
                                                    {{ range('a', 'e')[$loop->index].'. '.$item2['statement'] }}
                                                    </label>
                                                </div>
                                            </div>
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif
                    @if(isset($fetchData['data'][0]['children']) && count($fetchData['data'][0]['children']) > 0)
                        @php
                            $is = 0;
                        @endphp
                        @foreach($fetchData['data'][0]['children'] as $key => $item)
                            @foreach($item['aspects'] as $key2 => $item2)
                                <h2 class="question-title">{{ $fetchData['meta']['current_page'] }}. {{ $fetchData['data'][0]['name'] }} &gt; {{ $fetchData['meta']['current_page'] }}.{{ $key + 1 }}. {{ $item['name'] }}</h2>
                                <div>
                                    <div class="aspect-box">
                                        <div class="form-group row">
                                            <input type="hidden" value="{{ $item['id'] }}" name="component_id[]">
                                            <input type="hidden" value="{{ $item2['id'] }}" name="aspect_id[]">
                                            <p class="fw-bold">{{ $aspectNo++ }}. {{ $item2['aspect'] }}</p>
                                        </div>
                                        <div class="aspect-opts">
                                            <small>Pilih salah satu</small>
                                            @if ($item2['type'] == 'multi_aspect')
                                                @foreach ($item2['children'] as $multiChildAspect)
                                                    <p class="fw-bold">{{ $multiChildAspect['aspect'] }}</p>
                                                    @foreach(array_slice($multiChildAspect['points'], 0, 5) as $key3 => $item3)
                                                    <div class="border-success d-flex py-2 px-0">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="statement[{{ $item2['id'] }}]" id="exampleRadios{{ $item2['aspect'] . $item3['id'] }}" value="{{ $item3['id'] }}" {{ !empty($item2['answers']) && $item2['answers'][0]['instrument_aspect_point_id'] == $item3['id'] ? 'checked' : ''}}>
                                                            <label class="form-check-label" for="exampleRadios{{ $item2['aspect'] . $item3['id'] }}">
                                                            {{ range('a', 'e')[$loop->index].'. '.$item3['statement'] }}
                                                            </label>
                                                        </div>
                                                    </div>
                                                    @endforeach
                                                @endforeach
                                            @else
                                                @foreach(array_slice($item2['points'], 0, 5) as $key3 => $item3)
                                                <div class="border-success d-flex py-2 px-0">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="statement[{{ $item2['id'] }}]" id="exampleRadios{{ $item2['aspect'] . $key3 }}" value="{{ $item3['id'] }}" {{ !empty($item2['answers']) && $item2['answers'][0]['instrument_aspect_point_id'] == $item3['id'] ? 'checked' : ''}}>
                                                        <label class="form-check-label" for="exampleRadios{{ $item2['aspect'] . $key3 }}">
                                                            {{ range('a', 'e')[$loop->index].'. '.$item3['statement'] }}
                                                        </label>
                                                    </div>
                                                </div>
                                                @endforeach
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                            @if (count($item['children']) > 0)
                                @php
                                    $index = 0;
                                @endphp
                                @foreach($item['children'] as $key2 => $item2)
                                    <h2 class="question-title">{{ $fetchData['meta']['current_page'] }}. {{ $fetchData['data'][0]['name'] }} &gt; {{ $fetchData['meta']['current_page'] }}.{{ $key + 1 }}. {{ $item['name'] }} &gt; {{ $fetchData['meta']['current_page'] }}.{{ $key + 1 }}.{{ $key2 + 1 }}. {{ $item2['name'] }}</h2>
                                    <div class="clear"></div>

                                    @foreach ($item2['aspects'] as $key3 => $item3)
                                        <div>
                                            <div class="aspect-box">
                                                <div class="form-group row">
                                                    <p><input type="hidden" value="{{ $item2['id'] }}" name="component_id[]">
                                                    <input type="hidden" value="{{ $item3['id'] }}" name="aspect_id[]"></p>
                                                    <p class="fw-bold">{{ $aspectNo++ }}. {{ $item3['aspect'] }}</p>
                                                </div>
                                                <div class="aspect-opts">
                                                    <small>Pilih salah satu</small>
                                                    @if ($item3['type'] == 'multi_aspect')
                                                        @foreach ($item3['children'] as $multiChildAspect)
                                                            <p class="fw-bold">{{ $multiChildAspect['aspect'] }}</p>
                                                            @foreach(array_slice($multiChildAspect['points'], 0, 5) as $key4 => $item4)
                                                            <div class="border-success d-flex py-2 px-0">
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="statement[{{ $item3['id'] }}]" id="exampleRadios{{ $item3['aspect'] . $item4['id'] }}" value="{{ $item4['id'] }}" {{ !empty($item3['answers']) && $item3['answers'][0]['instrument_aspect_point_id'] == $item4['id'] ? 'checked' : ''}}>
                                                                    <label class="form-check-label" for="exampleRadios{{ $item3['aspect'] . $item4['id'] }}">
                                                                    {{ range('a', 'e')[$loop->index].'. '.$item4['statement'] }}
                                                                    </label>
                                                                </div>
                                                            </div>
                                                            @endforeach
                                                        @endforeach
                                                    @else
                                                        @foreach (array_slice($item3['points'], 0, 5) as $key4 => $item4)
                                                        <label>
                                                            <div class="border-success d-flex py-2 px-0">
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="statement[{{ $item3['id'] }}]" id="exampleRadios{{ $item3['aspect'] . $key4 }}" value="{{ $item4['id'] }}" {{ isset($item3['answers']) && count($item3['answers']) > 0 && $item3['answers'][0]['instrument_aspect_point_id'] == $item4['id'] ? 'checked' : ''}}>
                                                                    <label class="form-check-label" for="exampleRadios{{ $item3['aspect'] . $key4 }}">
                                                                    {{ range('a', 'e')[$loop->index].'. '.$item4['statement'] }}
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </label>
                                                        @endforeach
                                                    @endif
                                                    @php
                                                        $index++;
                                                    @endphp
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @endforeach
                            @endif
                            @php
                                $is += 1;
                            @endphp
                        @endforeach
                    @endif
                </div>
            @elseif($fetchData['data'][0]['action_type'] == "proof")
                <div class="form-group row mb-2">
                    <input type="hidden" value="{{ $fetchData['data'][0]['id'] }}" name="component_id">
                    <h4>{{ $fetchData['meta']['current_page'] }}. Bukti Fisik {{ $fetchData['data'][0]['name'] }}</h4>
                    <x-forms.input type="file" name="file_upload" accept=".zip,.rar,.pdf" required />
                    @if (!empty($fetchData['data'][0]['answers']))
                        <a class="btn btn-info col-2 mt-3" href="{{ $fetchData['data'][0]['answers'][0]['file'] }}">Download File</a>
                    @endif
                    <span class="mt-2"><b>Note:</b></span>
                    <small>Silahkan kompilasi seluruh bukti fisik menjadi satu file pdf dengan ukuran maksimal 10MB</small>
                    <small>Jenis file : .zip,.rar,.pdf</small>
                </div>
	        @elseif($fetchData['data'][0]['action_type'] == "gdrive")
                <div class="form-group row mb-2">
                    <input type="hidden" value="{{ $fetchData['data'][0]['id'] }}" name="component_id">
                    <h4>Link Google Drive Bukti Fisik</h4>
                    <x-forms.input type="text" name="url" required />
                    <span class="mt-2"><b>Note:</b></span>
                    <small>Silahkan unggah seluruh file bukti fisik ke dalam folder google drive.</small>
                </div>
            @elseif($fetchData['data'][0]['action_type'] == "video")
                <div class="form-group row mb-2">
                    <input type="hidden" value="{{ $fetchData['data'][0]['id'] }}" name="component_id">
                    <h4>Link YouTube Video Profil Perpustakaan</h4>
                    <x-forms.input type="text" name="url" required />
		    <span class="mt-2"><b>Note:</b></span>
	            <small>Silahkan unggah video perpustakaan ke Channel Youtube terlebih dahulu. Setelah itu, salin link video dan masukkan pada isian yang tersedia di atas.</small>
                </div>
            @endif
            <div class="form-group row text-center">
                <div class="col-md-12">
                    @if(!empty($fetchData['links']['prev']))
                    <x-buttons.prev :href="route('admin.akreditasi.create', ['page' => $fetchData['meta']['from'] - 1, 'type' => $type])"/>
                    @endif

                    @if(empty($fetchData['links']['next']))
                        <button type="submit" class="btn-finalize btn btn-primary">{{ __('Submit') }}</button>
                    @else
                        <x-buttons.save :title="__('Next')"/>
                    @endif
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@push('js')
    <script>
        $(document).ready(function () {
            $('.btn-finalize').click(function (e) {
                e.preventDefault();
                Swal.fire({
                    title : "",
                    text : "{{ __('Apakah Anda yakin akan submit akreditasi ini?') }}",
                    icon : "info",
                    showCancelButton: true,
                    confirmButtonText: "Submit",
                    cancelButtonText: "Batal",
                }).then((event) => {
                    if (event.isConfirmed) {
                        $('form').submit();
                    } else if (event.dismiss === Swal.DismissReason.cancel) {
                        Swal.fire('Cancelled', 'Submit Cancelled', 'warning');
                    }
                })
            })
        })

        @if (!empty($fetchData['data']) && $fetchData['data'][0]['action_type'] == "proof" && !empty($fetchData['data'][0]['answers']))
            $('input[name=file_upload]').removeAttr('required');
        @endif
    </script>
@endpush
