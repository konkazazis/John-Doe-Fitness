@extends('layouts.master')

@section('title', 'Portfolio')

@section('content')

    <x-portfolio.hero />

    <x-portfolio.services />

    <x-portfolio.pricing />

    <x-portfolio.testimonials />

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
