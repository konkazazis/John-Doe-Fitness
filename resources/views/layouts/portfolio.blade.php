@extends('layouts.master')

@section('title', 'John Doe · Personal Trainer & Nutrition Coach')
@section('meta_description', 'One-to-one strength coaching and personalised nutrition plans, built around your body, your schedule and your goals — not a generic template.')
@section('og_title', 'John Doe · Personal Trainer & Nutrition Coach')

@push('schema')
    <script type="application/ld+json">
        @php
            $ldContext = '@context';
            $ldType = '@type';
        @endphp
        {!! json_encode([
            $ldContext => 'https://schema.org',
            $ldType => 'ProfessionalService',
            'name' => 'John Doe Coaching',
            'description' => 'One-to-one strength coaching and personalised nutrition plans.',
            'url' => route('home'),
            'image' => asset('images/home-bg.jpg'),
            'priceRange' => '$$',
            'founder' => [
                $ldType => 'Person',
                'name' => 'John Doe',
                'jobTitle' => 'Personal Trainer & Nutrition Coach',
            ],
            'sameAs' => [
                'https://www.youtube.com/@NtinosLiftzz',
            ],
        ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) !!}
    </script>
@endpush

@section('content')

    <x-portfolio.hero />

    <x-portfolio.services />

    <x-portfolio.plans :plans="$plans" />

    <x-portfolio.testimonials :testimonials="$testimonials" />

    <x-portfolio.projects :projects="$projects" />

    <x-portfolio.blog-posts :posts="$posts" />

    <x-portfolio.technologies />

    <x-portfolio.about />

    <x-portfolio.contact />

    <script>
        document.querySelectorAll('a.smoothScroll').forEach(link => {
            link.addEventListener('click', function (e) {
                const href = this.getAttribute('href');
                if (href.startsWith('#')) {
                    e.preventDefault();
                    const element = document.querySelector(href);
                    if (element) {
                        element.scrollIntoView({ behavior: 'smooth', block: 'start' });
                    }
                }
            });
        });

        const mobileMenuBtn = document.getElementById('mobile-menu-btn');
        const navMenu = document.getElementById('nav-menu');

        if (mobileMenuBtn) {
            mobileMenuBtn.addEventListener('click', function () {
                navMenu.classList.toggle('hidden');
                navMenu.classList.toggle('flex');
                navMenu.classList.toggle('flex-col');
                navMenu.classList.toggle('absolute');
                navMenu.classList.toggle('top-16');
                navMenu.classList.toggle('left-0');
                navMenu.classList.toggle('right-0');
                navMenu.classList.toggle('bg-white');
                navMenu.classList.toggle('border-b');
            });
        }
    </script>
@endsection
