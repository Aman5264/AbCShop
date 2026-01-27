<x-guest-layout>
    <div class="mb-4">
        <h2 class="text-3xl font-bold text-gray-900 tracking-tight">Create account</h2>
        <p class="text-gray-500 mt-2 text-sm">Join us and start shopping for premium products today.</p>
    </div>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div class="space-y-1">
            <x-input-label for="name" :value="__('Full Name')" class="text-xs font-bold uppercase text-gray-500 tracking-wider" />
            <x-text-input id="name" class="block w-full border-gray-200 focus:border-indigo-500 focus:ring-indigo-500 rounded-xl shadow-sm py-2.5 px-4" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" placeholder="John Doe" />
            <x-input-error :messages="$errors->get('name')" class="mt-1" />
        </div>

        <!-- Email Address -->
        <div class="mt-4 space-y-1">
            <x-input-label for="email" :value="__('Email Address')" class="text-xs font-bold uppercase text-gray-500 tracking-wider" />
            <x-text-input id="email" class="block w-full border-gray-200 focus:border-indigo-500 focus:ring-indigo-500 rounded-xl shadow-sm py-2.5 px-4" type="email" name="email" :value="old('email')" required autocomplete="username" placeholder="name@company.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-1" />
        </div>

        <!-- Password -->
        <div class="mt-4 space-y-1">
            <x-input-label for="password" :value="__('Password')" class="text-xs font-bold uppercase text-gray-500 tracking-wider" />
            <x-text-input id="password" class="block w-full border-gray-200 focus:border-indigo-500 focus:ring-indigo-500 rounded-xl shadow-sm py-2.5 px-4"
                            type="password"
                            name="password"
                            required autocomplete="new-password"
                            placeholder="Min. 8 characters" />
            <x-input-error :messages="$errors->get('password')" class="mt-1" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4 space-y-1">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" class="text-xs font-bold uppercase text-gray-500 tracking-wider" />
            <x-text-input id="password_confirmation" class="block w-full border-gray-200 focus:border-indigo-500 focus:ring-indigo-500 rounded-xl shadow-sm py-2.5 px-4"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password"
                            placeholder="Repeat password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1" />
        </div>

        <div class="mt-8">
            <button type="submit" class="w-full inline-flex items-center justify-center px-6 py-3 bg-gray-900 border border-transparent rounded-xl font-bold text-sm text-white uppercase tracking-widest hover:bg-gray-800 focus:bg-gray-800 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 shadow-xl shadow-gray-200">
                {{ __('Create Account') }}
            </button>
        </div>

        <div class="mt-10 text-center text-sm text-gray-500">
            {{ __("Already have an account?") }}
            <a href="{{ route('login') }}" class="font-bold text-indigo-600 hover:text-indigo-500 transition-colors">
                {{ __('Sign in instead') }}
            </a>
        </div>
    </form>
</x-guest-layout>

