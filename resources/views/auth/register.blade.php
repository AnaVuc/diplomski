@extends('layouts.app')

@section('content')
    <div class="flex justify-start text-white text-3xl">
        <a href="/">
            <div class="flex p-4">
                <i class="fas fa-arrow-left pt-1"></i>
                <span class="pl-2 pb-2">Back</span>
            </div>

        </a>
    </div>
    <div class="flex py-10 ">
        {{-- <div class=""> --}}
            <div class="mx-auto px-10 bg-white rounded-md w-3/6">
                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf
                        <div class="flex justify-center text-2xl pb-3">
                            <label for="username"
                                class="font-medium">{{ __('Create an Account') }}</label>
                        </div>
                        <div class="flex justify-evenly">

                            <div class="w-5/12">
                                <label for="username"
                                    class="font-medium pr-4">{{ __('Username') }}</label>

                                <div class="">
                                    <input id="username" type="text"
                                        class="form-control @error('username') is-invalid @enderror" name="username"
                                        value="{{ old('username') }}" required autocomplete="username">

                                    @error('username')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="w-5/12">
                                <label for="email"
                                    class="font-medium pr-4">{{ __('E-Mail address') }}</label>

                                <div class="">
                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                                        name="email" value="{{ old('email') }}" required autocomplete="email">

                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div  class="flex justify-evenly">

                            <div class="pt-3 w-5/12">
                                <label for="firstName"
                                    class="font-medium pr-4">{{ __('First name') }}</label>

                                <div class="">
                                    <input id="firstName" type="firstName" class="form-control @error('firstName') is-invalid @enderror"
                                        name="firstName" value="{{ old('firstName') }}" required autocomplete="firstName">

                                    @error('firstName')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class=" pt-3 w-5/12">
                                <label for="lastName"
                                    class="font-medium pr-4">{{ __('Last name') }}</label>

                                <div class="">
                                    <input id="lastName" type="lastName" class="form-control @error('lastName') is-invalid @enderror"
                                        name="lastName" value="{{ old('lastName') }}" required autocomplete="lastName">

                                    @error('lastName')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>


                        <div  class="flex justify-evenly">
                            <div class=" pt-3 w-5/12">
                                <label for="password"
                                    class="font-medium pr-4">{{ __('Password') }}</label>

                                <div class="">
                                    <input id="password" type="password"
                                        class="form-control @error('password') is-invalid @enderror" name="password" required
                                        autocomplete="new-password">

                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class=" pt-3 w-5/12">
                                <label for="password-confirm"
                                    class="font-medium pr-4">{{ __('Confirm password') }}</label>

                                <div class="">
                                    <input id="password-confirm" type="password" class="form-control"
                                        name="password_confirmation" required autocomplete="new-password">
                                </div>
                            </div>
                        </div>


                        <div class="flex justify-center">
                            <div class="pt-3">
                                <button type="submit" class="btn btn-wide bg-blue-600">
                                    {{ __('Register') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        {{-- </div> --}}
    </div>
@endsection
