@extends('layouts.app')

@section('content')
<main>
    <section class="vh-lg-200 mt-5 mt-lg-0 bg-soft d-flex align-items-center">
        <div class="container">
            <div class="row justify-content-center form-bg-image" data-background="{{ asset('admin/assets/img/illustrations/signin.svg') }}">
                <div class="col-12 d-flex align-items-center justify-content-center">
                    <div class="bg-white shadow border-0 rounded border-light p-4 p-lg-5 w-100 fmxw-500">
                        <div class="text-center text-md-center mb-4 mt-md-0">
                            <h1 class="mb-0 h3">Create Asesor Account</h1>
                        </div>
                        @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div><br />
                        @endif
                        <form action="{{ route('register.store.asesor') }}" class="mt-4" method="POST">
                            @csrf
                            <div class="form-group mb-4">
                                <x-forms.label :label="__('Name')"/>
                                <div class="input-group">
                                    <span class="input-group-text" id="basic-addon1">
                                        <x-icons.mail/>
                                    </span>
                                    <x-forms.input-group name="name" placeholder="Name" required autofocus/>
                                </div>
                            </div>
                            <div class="form-group mb-4">
                                <x-forms.label :label="__('Username')"/>
                                <div class="input-group">
                                    <span class="input-group-text" id="basic-addon1">
                                        <x-icons.mail/>
                                    </span>
                                    <x-forms.input-group name="username" placeholder="Username" required/>
                                </div>
                            </div>
                            <div class="form-group mb-4">
                                <x-forms.label :label="__('Intansi Asal')"/>
                                <div class="input-group">
                                    <span class="input-group-text" id="basic-addon1">
                                        <x-icons.mail/>
                                    </span>
                                    <x-forms.input-group name="institution_name" placeholder="Instansi Asal" required/>
                                </div>
                            </div>
                            <div class="form-group mb-4">
                                <x-forms.label :label="__('Provinsi Asal')"/>
                                <div class="input-group">
                                    <span class="input-group-text" id="basic-addon1">
                                        <x-icons.mail/>
                                    </span>
                                    <x-forms.select-public-province name="province_id" :regionId="''" :placeholder="__('Provinsi')" :fill="''" required/>
                                </div>
                            </div>
                            <div class="form-group mb-4">
                                <x-forms.label :label="__('E-mail')"/>
                                <div class="input-group">
                                    <span class="input-group-text" id="basic-addon1">
                                        <x-icons.mail/>
                                    </span>
                                    <x-forms.input-group name="email" type="email" placeholder="Email" required/>
                                </div>
                            </div>
                            <div class="form-group mb-4">
                                <x-forms.label :label="__('No HP')"/>
                                <div class="input-group">
                                    <span class="input-group-text" id="basic-addon1">
                                        <x-icons.mail/>
                                    </span>
                                    <x-forms.input-group type="number" name="phone_number" placeholder="08123456789" required/>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="form-group mb-4">
                                    <x-forms.label :label="__('Password')"/>
                                    <div class="input-group">
                                        <span class="input-group-text" id="basic-addon2">
                                            <x-icons.lock/>
                                        </span>
                                        <x-forms.input-group name="password" type="password" placeholder="Password" required/>
                                    </div>
                                </div>
                                <div class="form-group mb-4">
                                    <x-forms.label :label="__('Password Confirmation')"/>
                                    <div class="input-group">
                                        <span class="input-group-text" id="basic-addon2">
                                            <x-icons.lock/>
                                        </span>
                                        <x-forms.input-group name="password_confirmation" type="password" placeholder="Password" required/>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group mb-4 mt-4">
                                <div class="captcha">
                                    <span>{!! captcha_img('inverse') !!}</span>
                                    <button type="button" class="btn btn-danger" class="reload" id="reload">
                                        &#x21bb;
                                    </button>
                                </div>
                            </div>
                            <div class="form-group mb-4">
                                <div class="input-group">
                                    <span class="input-group-text" id="basic-addon2">
                                        <x-icons.pencil/>
                                    </span>
                                    <x-forms.input-group name="captcha" placeholder="Captcha..." value="" required/>
                                </div>
                            </div>
                            <div class="d-grid">
                                <x-buttons.save :title="__('Sign Up')"/>
                            </div>
                        </form>
                        <div class="d-flex justify-content-center align-items-center mt-4">
                            <span class="fw-normal">
                                Already have an account?
                                <a href="{{ route('login') }}" class="fw-bold">Login here</a>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
@endsection

@push('js')
    <script>
        $('#reload').click(function () {
            $.ajax({
                type: 'GET',
                url: "{{ route('register.reload_captcha') }}",
                success: function (data) {
                    $(".captcha span").html(data.captcha);
                }
            })
        })
    </script>
@endpush
