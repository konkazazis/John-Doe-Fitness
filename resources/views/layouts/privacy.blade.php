@extends('layouts.master')

@php $lang = request('lang') === 'en' ? 'en' : 'de'; @endphp

@section('title', 'Datenschutz · kostas')
@section('meta_description', 'Datenschutzerklärung für kostas.dev gemäß DSGVO.')
@section('canonical', route('privacy', $lang === 'en' ? ['lang' => 'en'] : []))

@push('head')
    <link rel="alternate" hreflang="de" href="{{ route('privacy') }}">
    <link rel="alternate" hreflang="en" href="{{ route('privacy', ['lang' => 'en']) }}">
    <link rel="alternate" hreflang="x-default" href="{{ route('privacy') }}">
@endpush

@section('content')
    <div class="mx-6 my-8 max-w-2xl lg:mx-auto">

        <div class="mb-10 flex items-end justify-between gap-4 border-b border-stone-200 pb-6">
            <div>
                <h1 class="mb-2 text-3xl font-bold tracking-tight uppercase">
                    Daten<strong class="text-brand">schutz</strong>
                </h1>
                <p class="text-sm text-stone-400">
                    {{ $lang === 'en' ? 'Privacy Policy — in accordance with GDPR' : 'Datenschutzerklärung gemäß DSGVO' }}
                </p>
            </div>
            <div class="flex shrink-0 gap-1">
                <a href="{{ route('privacy') }}"
                    class="rounded px-3 py-1 text-xs font-medium tracking-wide transition-colors {{ $lang === 'de' ? 'bg-stone-800 text-white' : 'text-stone-500 border border-stone-200 hover:border-stone-400 hover:text-stone-700' }}">
                    DE
                </a>
                <a href="{{ route('privacy', ['lang' => 'en']) }}"
                    class="rounded px-3 py-1 text-xs font-medium tracking-wide transition-colors {{ $lang === 'en' ? 'bg-stone-800 text-white' : 'text-stone-500 border border-stone-200 hover:border-stone-400 hover:text-stone-700' }}">
                    EN
                </a>
            </div>
        </div>

        <div class="prose prose-stone max-w-none space-y-8 leading-relaxed text-stone-700">

            @if($lang === 'de')

                <section>
                    <h2 class="mb-2 text-lg font-bold text-stone-800">1. Verantwortlicher</h2>
                    <p>
                        Konstantinos Kazazis<br>
                        Oberratherstrassse 24<br>
                        40472, Düsseldorf<br>
                        Deutschland<br>
                        E-Mail:
                        <a href="mailto:kazaziskonstantinos@gmail.com" class="text-brand hover:underline">
                            kostas@kazazis.dev
                        </a>
                    </p>
                </section>

                <section>
                    <h2 class="mb-2 text-lg font-bold text-stone-800">2. Cookies & Session</h2>
                    <p>
                        Diese Website setzt technisch notwendige Cookies ein, um den Betrieb der Website
                        zu gewährleisten (z. B. Session-Cookie für CSRF-Schutz). Diese Cookies enthalten
                        keine personenbezogenen Daten und werden nach dem Schließen des Browsers gelöscht.
                        Tracking- oder Werbe-Cookies werden nicht eingesetzt.
                    </p>
                    <p class="mt-2">
                        Rechtsgrundlage: Art. 6 Abs. 1 lit. f DSGVO (technische Notwendigkeit).
                    </p>
                </section>

                <section>
                    <h2 class="mb-2 text-lg font-bold text-stone-800">3. Google Fonts</h2>
                    <p>
                        Diese Website verwendet Google Fonts (Anbieter: Google LLC, 1600 Amphitheatre Parkway,
                        Mountain View, CA 94043, USA). Beim Laden der Seite wird eine Verbindung zu den Servern
                        von Google hergestellt, wodurch Ihre IP-Adresse an Google übermittelt wird.
                    </p>
                    <p class="mt-2">
                        Rechtsgrundlage: Art. 6 Abs. 1 lit. f DSGVO. Weitere Informationen finden Sie in der
                        <a href="https://policies.google.com/privacy" target="_blank" rel="noopener noreferrer"
                            class="text-brand hover:underline">Datenschutzerklärung von Google</a>.
                            </p>
                    </section>

            @else

                    <section>
                        <h2 class="mb-2 text-lg font-bold text-stone-800">1. Data Controller</h2>
                        <p>
                            Konstantinos Kazazis<br>
                            Oberratherstrassse 24<br>
                            40472, Düsseldorf<br>
                            Germany<br>
                            Email:
                            <a href="mailto:kazaziskonstantinos@gmail.com" class="text-brand hover:underline">
                                kostas@kazazis.dev
                            </a>
                        </p>
                    </section>

                    <section>
                        <h2 class="mb-2 text-lg font-bold text-stone-800">2. Cookies & Session</h2>
                        <p>
                            This website uses technically necessary cookies to ensure its operation
                            (e.g. a session cookie for CSRF protection). These cookies contain no personal
                            data and are deleted when the browser is closed. No tracking or advertising
                            cookies are used.
                        </p>
                        <p class="mt-2">
                            Legal basis: Art. 6(1)(f) GDPR (legitimate interest in secure website operation).
                        </p>
                    </section>

                    <section>
                        <h2 class="mb-2 text-lg font-bold text-stone-800">3. Google Fonts</h2>
                        <p>
                            This website uses Google Fonts (provider: Google LLC, 1600 Amphitheatre Parkway,
                            Mountain View, CA 94043, USA). When the page loads, a connection is established
                            to Google's servers, which transmits your IP address to Google.
                        </p>
                        <p class="mt-2">
                            Legal basis: Art. 6(1)(f) GDPR. For more information, see
                            <a href="https://policies.google.com/privacy" target="_blank" rel="noopener noreferrer"
                                class="text-brand hover:underline">Google's Privacy Policy</a>.
                                </p>
                        </section>

            @endif

        </div>

    </div>
@endsection