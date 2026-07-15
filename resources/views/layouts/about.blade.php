@extends('layouts.master')

@section('title', 'About · kostas')
@section('meta_description', 'Hi, I\'m Kostas — a developer who loves building things for the web. Learn more about me and this blog.')
@section('og_title', 'About · kostas')
@section('canonical', route('about'))

@push('schema')
    <script type="application/ld+json">
        @php
            $ldContext = '@context';
            $ldType = '@type';
        @endphp
        {!! json_encode([
            $ldContext => 'https://schema.org',
            $ldType => 'Person',
            'name' => 'Konstantinos Kazazis',
            'url' => route('about'),
            'jobTitle' => 'Full-Stack Web Developer',
            'email' => 'kostas@kazazis.dev',
            'sameAs' => [
                'https://github.com/konkazazis',
                'https://www.linkedin.com/in/konstantinos-kazazis-32a470228/',
            ],
        ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) !!}
    </script>
@endpush

@section('content')
    <section class="bg-stone-50 px-6 py-24 sm:px-8">
        <div class="mx-auto max-w-4xl">
            <div class="mb-16">
                <span class="section-label">About</span>
                <h1 class="section-heading">A developer for the modern web.</h1>
                <p class="max-w-2xl text-lg leading-relaxed text-stone-600">
                    I build thoughtful websites, tools and content experiences for digital-first brands.
                </p>
            </div>

            <div class="grid gap-12 lg:grid-cols-[1fr_0.95fr]">
                <div class="space-y-8 text-stone-600">
                    <p>
                        Hi! I’m <strong class="text-stone-900">kostas</strong>, a developer enjoying the web and recently an
                        expat learning how Germany works.
                    </p>
                    <p>
                        I spend my time coding and researching things that spark my interest. I love building software that
                        feels polished, fast, and dependable.
                    </p>
                </div>

                <aside class="panel-card">
                    <h2 class="mb-5 text-2xl font-semibold text-stone-900">Quick facts</h2>
                    <dl class="grid gap-4 text-sm text-stone-600">
                        <div>
                            <dt class="font-semibold text-stone-900">Location</dt>
                            <dd>Düsseldorf, Germany</dd>
                        </div>
                        <div>
                            <dt class="font-semibold text-stone-900">Skills</dt>
                            <dd>Laravel, Tailwind, Vite, PHP, modern web tooling</dd>
                        </div>
                        <div>
                            <dt class="font-semibold text-stone-900">Approach</dt>
                            <dd>Minimal design, strong typography, practical results.</dd>
                        </div>
                    </dl>
                </aside>
            </div>

            <div class="mt-16 space-y-8">
                <div class="panel-card">
                    <h2 class="mb-5 text-2xl font-semibold text-stone-900">This Blog</h2>
                    <p class="leading-relaxed text-stone-600">
                        This blog is my space to share thoughts on web development, software engineering, and the things I
                        learn along the way. Sometimes I also write about everyday life.
                    </p>
                </div>

                <div class="panel-card">
                    <h2 class="mb-5 text-2xl font-semibold text-stone-900">Get in touch</h2>
                    <p class="leading-relaxed text-stone-600">
                        If you enjoy my writing or want to share ideas, drop a line by email or connect on GitHub and
                        LinkedIn.
                    </p>
                    <div class="mt-6 space-y-3 text-sm text-stone-600">
                        <p>Email: <a href="mailto:kostas@kazazis.dev"
                            class="hover:text-brand text-stone-900">kostas@kazazis.dev</a></p>
                            <p>GitHub: <a href="https://github.com/konkazazis" target="_blank" rel="noopener noreferrer"
                                class="hover:text-brand text-stone-900">github.com/konkazazis</a></p>
                                <p>LinkedIn: <a href="https://www.linkedin.com/in/konstantinos-kazazis-32a470228/" target="_blank"
                                    rel="noopener noreferrer"
                                    class="hover:text-brand text-stone-900">linkedin.com/in/konstantinos-kazazis-32a470228/</a>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
@endsection