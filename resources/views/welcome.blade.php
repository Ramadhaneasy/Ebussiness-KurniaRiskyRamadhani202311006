<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Sellify') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-slate-50">
    {{-- Background biru halus --}}
    <div class="absolute inset-0 -z-10">
        <div class="absolute inset-0 bg-gradient-to-br from-sky-50 via-white to-blue-50"></div>
        <div class="absolute -top-24 -left-24 h-72 w-72 rounded-full bg-sky-200/40 blur-3xl"></div>
        <div class="absolute top-32 -right-24 h-80 w-80 rounded-full bg-blue-200/40 blur-3xl"></div>
        <div class="absolute bottom-0 left-1/2 h-72 w-72 -translate-x-1/2 rounded-full bg-sky-100/70 blur-3xl"></div>
    </div>

    <div class="mx-auto max-w-6xl px-6 py-10">
        {{-- Top bar --}}
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="grid h-12 w-12 place-items-center rounded-2xl bg-sky-600 text-white shadow-sm">
                    {{-- Icon sederhana --}}
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                        <path d="M4 7.5 12 3l8 4.5v9L12 21l-8-4.5v-9Z" stroke="currentColor" stroke-width="2" />
                        <path d="M12 3v18" stroke="currentColor" stroke-width="2" opacity="0.7"/>
                        <path d="M4 7.5 12 12l8-4.5" stroke="currentColor" stroke-width="2" opacity="0.7"/>
                    </svg>
                </div>
                <div>
                    <div class="text-lg font-semibold text-slate-900">{{ config('app.name', 'Sellify') }}</div>
                    <div class="text-sm text-slate-600">Buyer & Seller Marketplace</div>
                </div>
            </div>

            <div class="flex items-center gap-2">
                @auth
                    <a href="{{ url('/dashboard') }}"
                       class="rounded-xl bg-sky-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-sky-700">
                        Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}"
                       class="rounded-xl border border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-slate-800 shadow-sm hover:bg-slate-50">
                        Log in
                    </a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}"
                           class="rounded-xl bg-sky-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-sky-700">
                            Register
                        </a>
                    @endif
                @endauth
            </div>
        </div>

        {{-- Main card --}}
        <div class="mt-8 grid gap-6 lg:grid-cols-2">
            {{-- Left: copy --}}
            <div class="rounded-3xl border border-slate-200 bg-white/80 p-8 shadow-sm backdrop-blur">
                <div class="inline-flex items-center gap-2 rounded-full bg-sky-50 px-3 py-1 text-xs font-semibold text-sky-700">
                    <span>🛍️</span>
                    <span>E-Business / Marketplace Starter</span>
                </div>

                <h1 class="mt-4 text-4xl font-extrabold tracking-tight text-slate-900 sm:text-5xl">
                    Jual produkmu lebih cepat
                    <span class="text-sky-700">&</span> rapi.
                </h1>

                <p class="mt-4 max-w-prose text-base leading-relaxed text-slate-600">
                    Kelola produk, pesanan, dan pengguna dengan tampilan clean & modern.
                    Cocok untuk tugas kuliah maupun project portofolio.
                </p>

                <div class="mt-6 flex flex-wrap gap-3">
                    <a href="{{ route('register') }}"
                       class="rounded-2xl bg-sky-600 px-5 py-3 text-sm font-semibold text-white shadow-sm hover:bg-sky-700">
                        Mulai Sekarang
                    </a>
                    <a href="#fitur"
                       class="rounded-2xl border border-slate-200 bg-white px-5 py-3 text-sm font-semibold text-slate-800 shadow-sm hover:bg-slate-50">
                        Lihat Fitur
                    </a>
                </div>

                <div id="fitur" class="mt-8 grid gap-3">
                    <div class="rounded-2xl border border-slate-200 bg-white p-4">
                        <div class="flex items-start gap-3">
                            <div class="mt-1 h-2 w-2 rounded-full bg-sky-600"></div>
                            <div>
                                <div class="font-semibold text-slate-900">Produk & Katalog</div>
                                <div class="text-sm text-slate-600">Kelola item, harga, stok, dan gambar produk.</div>
                            </div>
                        </div>
                    </div>

                    <div class="rounded-2xl border border-slate-200 bg-white p-4">
                        <div class="flex items-start gap-3">
                            <div class="mt-1 h-2 w-2 rounded-full bg-sky-600"></div>
                            <div>
                                <div class="font-semibold text-slate-900">Checkout sederhana</div>
                                <div class="text-sm text-slate-600">Alur pemesanan jelas dan mudah dipakai.</div>
                            </div>
                        </div>
                    </div>

                    <div class="rounded-2xl border border-slate-200 bg-white p-4">
                        <div class="flex items-start gap-3">
                            <div class="mt-1 h-2 w-2 rounded-full bg-sky-600"></div>
                            <div>
                                <div class="font-semibold text-slate-900">Admin / Dashboard</div>
                                <div class="text-sm text-slate-600">Pantau order & pengguna dari satu tempat.</div>
                            </div>
                        </div>
                    </div>
                </div>

                <p class="mt-6 text-xs text-slate-500">
                    Tip: Landing page bagus itu singkat — 1 headline, 1 deskripsi, 1 tombol utama, 3 fitur.
                </p>
            </div>

            {{-- Right: preview mock --}}
            <div class="rounded-3xl border border-slate-200 bg-white/80 p-8 shadow-sm backdrop-blur">
                <div class="flex items-center justify-between">
                    <div class="text-lg font-bold text-slate-900">Preview</div>
                    <div class="text-xs font-semibold text-slate-500">Update harian</div>
                </div>

                <div class="mt-5 rounded-2xl border border-slate-200 bg-white p-5">
                    <div class="flex items-center justify-between">
                        <div class="font-semibold text-slate-900">Produk Populer</div>
                        <div class="text-xs text-slate-500">Minggu ini</div>
                    </div>

                    <div class="mt-4 grid grid-cols-2 gap-4">
                        @for ($i = 1; $i <= 4; $i++)
                            <div class="rounded-2xl border border-slate-200 p-3">
                                <div class="h-20 w-full rounded-xl bg-slate-100"></div>
                                <div class="mt-3 text-sm font-semibold text-slate-900">Produk {{ $i }}</div>
                                <div class="text-xs text-slate-500">Rp {{ number_format(49000 + ($i*5000), 0, ',', '.') }}</div>
                            </div>
                        @endfor
                    </div>

                    <div class="mt-4 text-sm text-slate-600">
                        Kamu bisa ganti bagian ini jadi banner, slider, atau testimoni.
                    </div>
                </div>

                <div class="mt-5 rounded-2xl border border-slate-200 bg-white p-5">
                    <div class="text-sm font-semibold text-slate-900">Kenapa Sellify?</div>
                    <ul class="mt-3 space-y-2 text-sm text-slate-600">
                        <li class="flex gap-2"><span class="text-sky-700">✓</span> UI konsisten (biru clean)</li>
                        <li class="flex gap-2"><span class="text-sky-700">✓</span> Siap login/register</li>
                        <li class="flex gap-2"><span class="text-sky-700">✓</span> Enak di HP & laptop</li>
                    </ul>
                </div>
            </div>
        </div>

        <footer class="mt-10 text-center text-xs text-slate-500">
            © {{ date('Y') }} {{ config('app.name', 'Sellify') }} • Built with Laravel
        </footer>
    </div>
</body>
</html>
