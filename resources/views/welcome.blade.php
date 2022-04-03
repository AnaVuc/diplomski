@extends('layouts.app')

@section('content')
    <div class='login-container flex w-full'>
        <div class='w-6/12 relative'>
            <h3 class="text-6xl font-bold text-primaryGreen text-center mt-32">Rating <span class="text-black font-normal">solution</span></h3>
            <div class="w-full absolute bottom-0 mb-4">
                <img src="{{asset('icon.png')}}" class="w-104 mx-auto">
            </div>
        </div>
        <div class='max-w-md h-auto ml-4 shadow-box rounded px-8 pt-6 pb-8 mb-4 rounded-medium rounded-medium mt-24 bg-transparent' style="backdrop-filter: blur(6px);">
            <form method="POST" action="{{ route('login') }}">
                @csrf
            <h5 class="text-4xl text-center font-bold text-primaryGreen mb-12">Log in</h5>
            <div class="input-group w-8/12 mx-auto mb-6">
                <label class="block text-gray-700 text-sm font-semibold mb-2" for="email">Email:</label>
                <input class="bg-gray-300 shadow appearance-none border rounded-medium w-full py-4 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('email') border-red-700  @enderror" type="text" id="email" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                
            </div>
            <div class="input-group w-8/12 mx-auto mb-8">
                <label class="block text-gray-700 text-sm font-semibold mb-2" for="password">Password:</label>
                <input class="bg-gray-300 shadow appearance-none border rounded-medium w-full py-4 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('email') border-red-700  @enderror" type="password" id="password" name="password" required autocomplete="current-password">
                @error('email')
                    <span class="invalid-feedback pl-2 text-red-700 text-sm" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="input-group mx-auto mb-8" style="width: fit-content;">
                <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                <label class="text-gray-800" for="remember">Remember Me</label>
            </div>
            
            <button type="submit" class="shadow bg-primaryGreen block mx-auto hover:bg-blue-500 focus:shadow-outline focus:outline-none text-white font-bold py-4 px-10 rounded-medium" id="login" >Log in</button>
            <img class='w-6/12 block mx-auto mt-8' src="{{asset('ibislogo.png')}}">
            </form>
        </div>
    </div>
    

@endsection