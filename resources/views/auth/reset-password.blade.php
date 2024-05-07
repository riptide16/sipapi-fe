@extends('layouts.app')

@section('content')
<main>
    <!-- Section -->
    <section class="vh-lg-100 mt-4 mt-lg-0 bg-soft d-flex align-items-center">
        <div class="container">
            <div class="row justify-content-center form-bg-image">
                <p class="text-center"><a href="{{ route('login') }}" class="d-flex align-items-center justify-content-center"><svg class="icon icon-xs me-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M7.707 14.707a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l2.293 2.293a1 1 0 010 1.414z" clip-rule="evenodd"></path></svg> Back to log in</a></p>
                <div class="col-12 d-flex align-items-center justify-content-center">
                    <div class="signin-inner my-3 my-lg-0 bg-white shadow border-0 rounded p-4 p-lg-5 w-100 fmxw-500">
                        <h1 class="h3">Reset Password?</h1>
                        <form action="{{ route('reset_password.update', ['token' => $token]) }}" method="POST">
                            @csrf
                            <!-- Form -->
                            <div class="mb-4">
                                <x-forms.input-group type="hidden" name="email" value="{{ $email }}" required/>
                                <x-forms.label :label="__('Password')"/>
                                <div class="input-group">
                                    <x-forms.input-group type="password" name="password" placeholder="Password" required autofocus/>
                                </div>  
                            </div>
                            <div class="mb-4">
                                <x-forms.label :label="__('Password Confirmation')"/>
                                <div class="input-group">
                                    <x-forms.input-group type="password" name="password_confirmation" placeholder="Password" required/>
                                </div>
                            </div>
                            <div class="d-grid">
                                <x-buttons.save :title="__('Send')"/>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
@endsection