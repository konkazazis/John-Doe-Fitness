@extends('layouts.master')

@php $lang = request('lang') === 'en' ? 'en' : 'de'; @endphp

@section('title', 'Impressum · kostas')
@section('meta_description', 'Legal notice (Impressum) for kostas.dev — required by German law (§5 TMG).')
@section('canonical', route('impressum', $lang === 'en' ? ['lang' => 'en'] : []))

@push('head')
    <link rel="alternate" hreflang="de" href="{{ route('impressum') }}">
    <link rel="alternate" hreflang="en" href="{{ route('impressum', ['lang' => 'en']) }}">
    <link rel="alternate" hreflang="x-default" href="{{ route('impressum') }}">
@endpush

@section('content')
    <div class="max-w-2xl my-8 mx-6 lg:mx-auto">

        <div class="mt-8 mb-10 pb-6 border-b border-stone-200 flex items-end justify-between gap-4">
            <div>
                <h1 class="text-3xl font-bold tracking-tight uppercase mb-2">
                    Im<strong class="text-brand">pressum</strong>
                </h1>
                <p class="text-stone-400 text-sm">
                    {{ $lang === 'en' ? 'Legal Notice — required by German law (§5 TMG)' : 'Angaben gemäß § 5 TMG' }}
                </p>
            </div>
            <div class="flex gap-1 shrink-0">
                <a href="{{ route('impressum') }}"
                    class="px-3 py-1 rounded text-xs font-medium tracking-wide transition-colors
                                  {{ $lang === 'de' ? 'bg-stone-800 text-white' : 'text-stone-500 border border-stone-200 hover:border-stone-400 hover:text-stone-700' }}">
                    DE
                </a>
                <a href="{{ route('impressum', ['lang' => 'en']) }}"
                    class="px-3 py-1 rounded text-xs font-medium tracking-wide transition-colors
                                  {{ $lang === 'en' ? 'bg-stone-800 text-white' : 'text-stone-500 border border-stone-200 hover:border-stone-400 hover:text-stone-700' }}">
                    EN
                </a>
            </div>
        </div>

        <div class="prose prose-stone max-w-none text-stone-700 leading-relaxed space-y-8">

            @if($lang === 'de')

                <section>
                    <h2 class="text-lg font-bold text-stone-800 mb-2">Verantwortlich</h2>
                    <p>
                        Konstantinos Kazazis<br>
                        Oberratherstrassse 24<br>
                        40472, Düsseldorf<br>
                        Deutschland
                    </p>
                </section>

                <section>
                    <h2 class="text-lg font-bold text-stone-800 mb-2">Kontakt</h2>
                    <p>
                        E-Mail:
                        <a href="mailto:kazaziskonstantinos@gmail.com" class="text-brand hover:underline">
                            kostas@kazazis.dev
                        </a>
                    </p>
                </section>

                <section>
                    <h2 class="text-lg font-bold text-stone-800 mb-2">Umsatzsteuer-ID</h2>
                    <p>DE460984115</p>
                </section>

                <section>
                    <h2 class="text-lg font-bold text-stone-800 mb-2">Haftung für Inhalte</h2>
                    <p>
                        Die Inhalte dieser Website wurden mit größter Sorgfalt erstellt. Für die Richtigkeit,
                        Vollständigkeit und Aktualität der Inhalte kann jedoch keine Gewähr übernommen werden.
                        Als Diensteanbieter bin ich gemäß § 7 Abs. 1 TMG für eigene Inhalte auf diesen Seiten
                        nach den allgemeinen Gesetzen verantwortlich.
                    </p>
                </section>

                <section>
                    <h2 class="text-lg font-bold text-stone-800 mb-2">Haftung für Links</h2>
                    <p>
                        Diese Website enthält Links zu externen Websites Dritter, auf deren Inhalte kein
                        Einfluss besteht. Für die Inhalte der verlinkten Seiten ist stets der jeweilige
                        Anbieter oder Betreiber der Seiten verantwortlich. Zum Zeitpunkt der Verlinkung
                        wurden die verlinkten Seiten auf mögliche Rechtsverstöße überprüft. Rechtswidrige
                        Inhalte waren zum Zeitpunkt der Verlinkung nicht erkennbar.
                    </p>
                </section>

                <section>
                    <h2 class="text-lg font-bold text-stone-800 mb-2">Urheberrecht</h2>
                    <p>
                        Die durch den Seitenbetreiber erstellten Inhalte und Werke auf diesen Seiten
                        unterliegen dem deutschen Urheberrecht. Die Vervielfältigung, Bearbeitung,
                        Verbreitung und jede Art der Verwertung außerhalb der Grenzen des Urheberrechtes
                        bedürfen der schriftlichen Zustimmung des jeweiligen Autors bzw. Erstellers.
                    </p>
                </section>

            @else

                <section>
                    <h2 class="text-lg font-bold text-stone-800 mb-2">Responsible Party</h2>
                    <p>
                        Konstantinos Kazazis<br>
                        Oberratherstrassse 24<br>
                        40472, Düsseldorf<br>
                        Germany
                    </p>
                </section>

                <section>
                    <h2 class="text-lg font-bold text-stone-800 mb-2">Contact</h2>
                    <p>
                        Email:
                        <a href="mailto:kazaziskonstantinos@gmail.com" class="text-brand hover:underline">
                            kostas@kazazis.dev
                        </a>
                    </p>
                </section>

                <section>
                    <h2 class="text-lg font-bold text-stone-800 mb-2">VAT Number</h2>
                    <p>DE460984115</p>
                </section>

                <section>
                    <h2 class="text-lg font-bold text-stone-800 mb-2">Liability for Content</h2>
                    <p>
                        The contents of this website have been compiled with the utmost care. However,
                        no guarantee can be given for the accuracy, completeness, or timeliness of the
                        content. As a service provider, I am responsible for my own content on these pages
                        in accordance with general law.
                    </p>
                </section>

                <section>
                    <h2 class="text-lg font-bold text-stone-800 mb-2">Liability for Links</h2>
                    <p>
                        This website contains links to external third-party websites over whose content
                        I have no control. The respective provider or operator of those pages is always
                        responsible for their content. All linked pages were checked for possible legal
                        violations at the time of linking. No illegal content was apparent at that time.
                    </p>
                </section>

                <section>
                    <h2 class="text-lg font-bold text-stone-800 mb-2">Copyright</h2>
                    <p>
                        The content and works created by the site operator on these pages are subject to
                        German copyright law. Reproduction, editing, distribution, and any kind of use
                        beyond the limits of copyright law require the written consent of the respective
                        author or creator.
                    </p>
                </section>

            @endif

        </div>

    </div>
@endsection