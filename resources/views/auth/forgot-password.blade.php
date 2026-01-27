<x-guest-layout>
    <div class="mb-6">
        <h2 class="text-3xl font-bold text-gray-900 tracking-tight">Reset Password</h2>
        <p class="text-gray-500 mt-2 text-sm leading-relaxed">
            Forgot your password? No problem. Enter your email and we'll send you a link to choose a new one.
        </p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <!-- Email Address -->
        <div class="space-y-1">
            <x-input-label for="email" :value="__('Email Address')" class="text-xs font-bold uppercase text-gray-500 tracking-wider" />
            <x-text-input id="email" class="block w-full border-gray-200 focus:border-indigo-500 focus:ring-indigo-500 rounded-xl shadow-sm py-2.5 px-4" type="email" name="email" :value="old('email')" required autofocus placeholder="name@company.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-1" />
        </div>

        <div class="mt-8">
            <button type="submit" class="w-full inline-flex items-center justify-center px-6 py-3 bg-gray-900 border border-transparent rounded-xl font-bold text-sm text-white uppercase tracking-widest hover:bg-gray-800 focus:bg-gray-800 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 shadow-xl shadow-gray-200">
                {{ __('Email Reset Link') }}
            </button>
        </div>

        <div class="mt-10 text-center text-sm text-gray-500">
            <a href="{{ route('login') }}" class="font-bold text-indigo-600 hover:text-indigo-500 transition-colors">
                &larr; Back to login
            </a>
        </div>
    </form>
</x-guest-layout>

