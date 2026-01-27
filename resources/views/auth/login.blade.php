<x-guest-layout>
    <div class="text-center mb-4">
        <h2 class="text-3xl font-extrabold text-[#111827] tracking-tight">Welcome back</h2>
        <p class="text-gray-400 mt-1 text-sm font-medium">Please enter your details to sign in</p>
    </div>

    <div class="mb-3">
        <!-- Google Login Button -->
        <a href="{{ route('social.login', 'google') }}" class="flex items-center justify-center w-full px-4 py-2 bg-white border border-gray-100 rounded-xl font-bold text-sm text-[#111827] shadow-sm hover:shadow-md hover:border-gray-200 transition-all duration-300 group">
            <img src="https://www.svgrepo.com/show/475656/google-color.svg" class="w-5 h-5 mr-3 group-hover:scale-110 transition-transform" alt="Google">
            Login with Google
        </a>
    </div>

    <div class="relative flex py-1.5 items-center">
        <div class="flex-grow border-t border-gray-100"></div>
        <span class="flex-shrink-0 mx-4 text-gray-400 text-[10px] font-bold uppercase tracking-[0.2em]">Or</span>
        <div class="flex-grow border-t border-gray-100"></div>
    </div>

    <form method="POST" action="{{ route('login') }}" class="space-y-2.5">
        @csrf

        <!-- Email Address -->
        <div class="space-y-0.5">
            <x-input-label for="email" :value="__('Your Email Address')" class="text-xs font-bold uppercase text-gray-400 tracking-wider" />
            <x-text-input id="email" class="block w-full border-gray-200 focus:border-indigo-500 focus:ring-indigo-500 rounded-xl shadow-none py-2 px-4 placeholder-gray-300 transition-colors text-sm" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="Your Email Address" />
            <x-input-error :messages="$errors->get('email')" class="mt-1" />
        </div>

        <!-- Password -->
        <div class="space-y-0.5" x-data="{ show: false }">
            <x-input-label for="password" :value="__('Password')" class="text-xs font-bold uppercase text-gray-400 tracking-wider" />
            <div class="relative flex items-center">
                <input id="password" 
                       x-bind:type="show ? 'text' : 'password'"
                       class="block w-full border-gray-200 focus:border-indigo-500 focus:ring-indigo-500 rounded-xl shadow-none h-10 px-4 placeholder-gray-300 transition-colors pr-10 text-sm"
                       name="password"
                       required autocomplete="current-password"
                       placeholder="**********" />
                <button type="button" @click="show = !show" class="absolute right-2.5 flex items-center justify-center w-8 h-8 text-gray-400 hover:text-gray-600 focus:outline-none transition-colors">
                    <svg x-show="!show" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.644C3.67 8.5 7.652 4.5 12 4.5c4.348 0 8.33 4 9.964 7.178.07.12.07.274 0 .394C20.33 15.5 16.348 19.5 12 19.5c-4.348 0-8.33-4-9.964-7.178Z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                    </svg>
                    <svg x-show="show" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5" style="display: none;">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 0 0 1.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.451 10.451 0 0 1 12 4.5c4.756 0 8.773 3.162 10.065 7.498a10.522 10.522 0 0 1-4.293 5.774M6.228 6.228 3 3m3.228 3.228 3.65 3.65m7.894 7.894L21 21m-3.228-3.228-3.65-3.65m0 0a3 3 0 1 0-4.243-4.243m4.242 4.242L9.88 9.88" />
                    </svg>
                </button>
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-1" />
        </div>

        <!-- Remember Me & Forgot Password -->
        <div class="flex items-center justify-between pt-0.5">
            <label for="remember_me" class="inline-flex items-center cursor-pointer group">
                <input id="remember_me" type="checkbox" class="w-4 h-4 rounded-md border-gray-200 text-indigo-600 shadow-none focus:ring-transparent cursor-pointer transition-all" name="remember">
                <span class="ms-2 text-[12px] font-semibold text-gray-500 group-hover:text-gray-900 transition-colors">{{ __('Remember me') }}</span>
            </label>

            @if (Route::has('password.request'))
                <a class="text-[12px] font-bold text-gray-700 hover:text-indigo-600 transition-colors" href="{{ route('password.request') }}">
                    {{ __('Forgot password?') }}
                </a>
            @endif
        </div>

        <div class="pt-1.5">
            <button type="submit" class="w-full inline-flex items-center justify-center px-6 py-3 bg-[#2D2D2D] border border-transparent rounded-xl font-bold text-base text-white hover:bg-black focus:outline-none transition-all duration-200 transform hover:-translate-y-0.5 active:translate-y-0 shadow-lg shadow-gray-200">
                {{ __('Sign in') }}
            </button>
        </div>

        <div class="mt-3.5 text-center text-sm font-medium text-gray-500">
            {{ __("Don't have an account?") }}
            <a href="{{ route('register') }}" class="font-bold text-gray-900 hover:text-indigo-600 transition-colors ml-1">
                {{ __('Sign up') }}
            </a>
        </div>
    </form>
</x-guest-layout>

