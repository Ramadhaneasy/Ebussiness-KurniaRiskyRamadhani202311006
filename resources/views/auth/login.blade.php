<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center px-4 py-10
        bg-gradient-to-b from-sky-50 via-white to-sky-50
        dark:from-slate-950 dark:via-slate-900 dark:to-slate-950">

        <div class="w-full max-w-5xl grid grid-cols-1 lg:grid-cols-2 gap-6">

            {{-- Left panel --}}
            <div class="hidden lg:flex rounded-3xl overflow-hidden border border-sky-100 dark:border-slate-700
                bg-white/70 dark:bg-slate-900/60 backdrop-blur shadow-sm">
                <div class="p-10 w-full
                    bg-gradient-to-br from-sky-100/70 via-white to-white
                    dark:from-slate-800 dark:via-slate-900 dark:to-slate-900">

                    <div class="flex items-center gap-3">
                        <div class="p-3 rounded-2xl bg-sky-600 text-white shadow-sm">
                            <x-application-logo class="block h-8 w-auto fill-current text-white" />
                        </div>
                        <div class="leading-tight">
                            <div class="text-xl font-extrabold text-sky-900 dark:text-white">
                                {{ config('app.name', 'E-Commerce') }}
                            </div>
                            <div class="text-sm text-sky-700 dark:text-slate-300">
                                Buyer & Seller Marketplace
                            </div>
                        </div>
                    </div>

                    <h2 class="mt-10 text-3xl font-extrabold text-sky-900 dark:text-white leading-tight">
                        Welcome back 👋
                    </h2>
                    <p class="mt-3 text-sky-800/80 dark:text-slate-300">
                        Login untuk melanjutkan belanja (Buyer) atau mengelola produk & pesanan (Seller/Admin).
                    </p>

                    <div class="mt-8 grid grid-cols-2 gap-3">
                        <div class="rounded-2xl border border-sky-100 dark:border-slate-700 bg-white/70 dark:bg-slate-900/60 p-4">
                            <div class="text-sm font-semibold text-sky-900 dark:text-white">Buyer</div>
                            <div class="text-xs text-gray-600 dark:text-slate-300 mt-1">
                                Shop • Cart • Checkout • Order Tracking
                            </div>
                        </div>
                        <div class="rounded-2xl border border-sky-100 dark:border-slate-700 bg-white/70 dark:bg-slate-900/60 p-4">
                            <div class="text-sm font-semibold text-sky-900 dark:text-white">Seller/Admin</div>
                            <div class="text-xs text-gray-600 dark:text-slate-300 mt-1">
                                Dashboard • Manage Products • Reports
                            </div>
                        </div>
                    </div>

                    <div class="mt-10 text-xs text-gray-500 dark:text-slate-400">
                        Tip: UI otomatis mengikuti tema sistem (Light/Dark).
                    </div>
                </div>
            </div>

            {{-- Right: Form --}}
            <div class="rounded-3xl border border-sky-100 dark:border-slate-700 bg-white/80 dark:bg-slate-900/70 backdrop-blur shadow-sm">
                <div class="p-7 sm:p-10">

                    <div class="flex items-center justify-between">
                        <div>
                            <h1 class="text-2xl font-extrabold text-sky-900 dark:text-white">Login</h1>
                            <p class="text-sm text-sky-700 dark:text-slate-300 mt-1">
                                Masukkan email & password untuk masuk.
                            </p>
                        </div>

                        <div class="lg:hidden p-2 rounded-2xl bg-sky-50 dark:bg-slate-800 border border-sky-100 dark:border-slate-700">
                            <x-application-logo class="block h-8 w-auto fill-current text-sky-700 dark:text-white" />
                        </div>
                    </div>

                    <div class="mt-5">
                        <x-auth-session-status class="mb-4" :status="session('status')" />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <form method="POST" action="{{ route('login') }}" class="mt-2 space-y-4">
                        @csrf

                        <div>
                            <x-input-label for="email" :value="__('Email')" />
                            <x-text-input
                                id="email"
                                class="mt-1 block w-full rounded-2xl border border-sky-100 dark:border-slate-700
                                    bg-white/70 dark:bg-slate-900/60
                                    focus:border-sky-300 focus:ring-sky-300"
                                type="email"
                                name="email"
                                :value="old('email')"
                                required
                                autofocus
                                autocomplete="username"
                                placeholder="you@example.com"
                            />
                        </div>

                        <div>
                            <x-input-label for="password" :value="__('Password')" />
                            <x-text-input
                                id="password"
                                class="mt-1 block w-full rounded-2xl border border-sky-100 dark:border-slate-700
                                    bg-white/70 dark:bg-slate-900/60
                                    focus:border-sky-300 focus:ring-sky-300"
                                type="password"
                                name="password"
                                required
                                autocomplete="current-password"
                                placeholder="••••••••"
                            />
                        </div>

                        <div class="flex items-center justify-between gap-3">
                            <label for="remember_me" class="inline-flex items-center gap-2">
                                <input id="remember_me" type="checkbox"
                                    class="rounded border-sky-200 dark:border-slate-700 text-sky-600 shadow-sm focus:ring-sky-300"
                                    name="remember">
                                <span class="text-sm text-gray-700 dark:text-slate-300">{{ __('Remember me') }}</span>
                            </label>

                            @if (Route::has('password.request'))
                                <a class="text-sm font-semibold text-sky-700 hover:text-sky-900 dark:text-sky-300 dark:hover:text-white"
                                   href="{{ route('password.request') }}">
                                    {{ __('Forgot password?') }}
                                </a>
                            @endif
                        </div>

                        <div class="pt-2">
                            <button type="submit"
                                class="w-full inline-flex items-center justify-center gap-2 px-4 py-3 rounded-2xl
                                    bg-sky-600 hover:bg-sky-700 text-white font-semibold transition">
                                {{ __('Log in') }}
                            </button>
                        </div>

                        <div class="pt-2 text-center text-sm text-gray-700 dark:text-slate-300">
                            Belum punya akun?
                            <a href="{{ route('register') }}"
                               class="font-semibold text-sky-700 hover:text-sky-900 dark:text-sky-300 dark:hover:text-white">
                                Register
                            </a>
                        </div>
                    </form>

                </div>
            </div>

        </div>
    </div>
</x-guest-layout>
