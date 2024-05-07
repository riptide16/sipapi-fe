<ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
    @foreach ($regions as $key => $region)
        <li class="nav-item" role="presentation">
            <button class="nav-link @if(!session()->has('section') && $default == $key) active @elseif(session()->has('section') && session()->get('section.0') == $key) active @endif" id="pills-{{ $key }}-tab" data-bs-toggle="tab" data-bs-target="#pills-{{ $key }}" type="button" role="tab" aria-controls="pills-{{ $key }}" aria-selected="true">{{ $region }}</button>
        </li>    
    @endforeach
</ul>
<div class="tab-content" id="pills-tabContent">
    @foreach ($regions as $key => $region )
        <div class="tab-pane fade @if(!session()->has('section') && $default == $key) show active @elseif(session()->has('section') && session()->get('section.0') == $key) show active @endif" id="pills-{{ $key }}" role="tabpanel" aria-labelledby="pills-{{ $key }}-tab">
            <div class="table-responsive">
                @include('admin.region.'. $key . '.table-' . $key, ['masterData' => $masterData[$key]])
            </div>
        </div>
    @endforeach
</div>