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
<div class="flex justify-center ">
    <div class="m-20 h-2/3 w-1/2 bg-white rounded-md flex">
        {{-- <div class="text-4xl font-medium px-10 py-3">Login</div> --}}
        <div class=" w-1/2 border-r-4 border-blue-300 bg-blue-300">
            <div class="flex justify-center h-full items-center text-9xl ">
                <div class="text-blue-700">
                    <i class="fas fa-film "></i>

                </div>
            </div>
        </div>
        <div class="">
            <div class="flex justify-center p-16">
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="">
                        <label for="email" class="font-medium">{{ __('Username') }}</label>
                        <div class="">
                            <input id="username" type="text" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ old('username') }}" required autocomplete="username" autofocus>

                            @error('username')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="pt-3">
                        <label for="password" class="font-medium">{{ __('Password') }}</label>

                        <div class="">
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="pt-3">
                        <div class="">
                            <div class="">
                                <input class="" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                <label class="" for="remember">
                                    {{ __('Remember username') }}
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="pt-4 block">
                        <div class="block">
                            <button type="submit" class="btn btn-info btn-md">
                                {{ __('Submit') }}
                            </button>

                            @if (Route::has('password.request'))
                                <a class="text-blue-500 font-semibold text-base" href="{{ route('password.request') }}">
                                    {{ __('Forgot password?') }}
                                </a>
                            @endif
                        </div>
                    </div>
                </form>

            </div>

        </div>

    </div>

    </div>

</div>
@endsection
