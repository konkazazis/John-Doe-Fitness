<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta name="viewport" content="width=device-width,minimum-scale=1" />
    <title>@yield("title", "John Doe - Fitness Instructor")</title>
    <meta
        name="description"
        content="@yield("meta_description", "One-to-one strength coaching and personalised nutrition plans for real, sustainable results.")"
    />
    <link rel="canonical" href="@yield("canonical", url()->current())" />

    {{-- Open Graph --}}
    <meta property="og:type" content="@yield("og_type", "website")" />
    <meta
        property="og:url"
        content="@yield("canonical", url()->current())"
    />
    <meta property="og:title" content="@yield("og_title", "John Doe")" />
    <meta
        property="og:description"
        content="@yield("meta_description", "One-to-one strength coaching and personalised nutrition plans for real, sustainable results.")"
    />
    <meta property="og:site_name" content="John Doe" />
    <meta
        property="og:image"
        content="@yield("og_image", asset("images/home-bg.jpg"))"
    />
    <meta property="og:image:width" content="1200" />
    <meta property="og:image:height" content="630" />

    {{-- Twitter Card --}}
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:creator" content="@JohnDoe" />
    <meta name="twitter:title" content="@yield("og_title", "John Doe")" />
    <meta
        name="twitter:description"
        content="@yield("meta_description", "One-to-one strength coaching and personalised nutrition plans for real, sustainable results.")"
    />
    <meta
        name="twitter:image"
        content="@yield("og_image", asset("images/home-bg.jpg"))"
    />

    @if (config("services.google.site_verification"))
        <meta
            name="google-site-verification"
            content="{{ config("services.google.site_verification") }}"
        />
    @endif

    <link rel="icon" href="{{ asset("favicon.svg") }}" type="image/svg+xml" />
    <link rel="manifest" href="{{ asset("site.webmanifest") }}" />

    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />

    @stack("head")
    @stack("schema")
    @vite(["resources/css/app.css", "resources/js/app.js"])
</head>

<body>
    <div class="flex min-h-screen flex-col">
        <header
            class="sticky top-0 z-50 border-b-2 border-ink bg-cream px-4 md:px-0"
        >
            <div
                class="mx-auto flex h-20 max-w-7xl items-center justify-between"
            >
                <a
                    href="{{ route("home") }}"
                    class="flex items-center gap-2.5"
                >
                    <span
                        class="flex h-9 w-9 items-center justify-center rounded-full bg-brand text-base font-black text-white"
                    >
                        J
                    </span>
                    <span class="font-display text-lg tracking-tight text-ink uppercase">
                        John&nbsp;Doe
                    </span>
                </a>

                <nav
                    class="hidden items-center gap-8 text-sm font-bold text-ink sm:flex"
                >
                    <a
                        href="{{ route("home") }}#about"
                        class="transition-colors hover:text-brand"
                    >
                        About
                    </a>
                    <a
                        href="{{ route("blog") }}"
                        class="transition-colors {{ request()->routeIs("blog") || request()->routeIs("posts.show") ? "text-brand" : "hover:text-brand" }}"
                    >
                        Blog
                    </a>
                    <a
                        href="{{ route("home") }}#contact"
                        class="transition-colors hover:text-brand"
                    >
                        Contact
                    </a>
                </nav>
                @guest
                    <a
                        href="{{ route("login") }}"
                        class="hidden rounded-full bg-ink px-5 py-2.5 text-sm font-bold text-white transition-colors hover:bg-ink/80 sm:inline-block"
                    >
                        Login/Register
                    </a>
                @endguest
                @auth
                <div
                    class="group relative inline-block justify-self-end text-left"
                        id="dropdown-container"
                    >
                            @if (auth()->user()->role('admin') || auth()->user()->role('user'))
                                <button
                                    type="button"
                                    id="dropdown-button"
                                    class="hidden sm:inline-flex items-center gap-1 rounded-full px-1.5 py-1.5 text-sm font-medium text-stone-600 hover:bg-stone-100 transition-colors focus:outline-none"
                                >
                                    <span
                                        class="flex items-center justify-center w-9 h-9 rounded-full bg-stone-100 text-stone-500 text-lg"
                                    >
                                        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                                        </svg>
                                    </span>
                                    <svg
                                        class="mr-1 h-4 w-4 text-stone-400 transition-transform duration-200"
                                        id="dropdown-arrow"
                                        xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 20 20"
                                        fill="currentColor"
                                    >
                                        <path
                                            fill-rule="evenodd"
                                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                            clip-rule="evenodd"
                                        />
                                    </svg>
                                </button>
                                <div
                                    id="dropdown-menu"
                                    class="origin-top-right absolute right-0 mt-2 w-52 rounded-lg shadow-lg bg-white ring-1 ring-stone-200 focus:outline-none hidden overflow-hidden"
                                >
                                    <div class="py-1">
                                        @if (auth()->user()->role('admin'))
                                            <a
                                                href="{{ route("admin.dashboard") }}"
                                                class="flex items-center gap-2.5 px-4 py-2.5 text-sm text-stone-700 hover:bg-stone-50 hover:text-stone-900 transition-colors"
                                            >
                                                <svg class="h-4 w-4 text-stone-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 13.5l10.5-11.25L12 10.5h8.25L9.75 21.75 12 13.5H3.75z" />
                                                </svg>
                                                Admin Panel
                                            </a>
                                        @elseif (auth()->user()->role('user'))
                                            <a
                                                href="{{ route("user.dashboard") }}"
                                                class="flex items-center gap-2.5 px-4 py-2.5 text-sm text-stone-700 hover:bg-stone-50 hover:text-stone-900 transition-colors"
                                            >
                                                <svg class="h-4 w-4 text-stone-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 13.5l10.5-11.25L12 10.5h8.25L9.75 21.75 12 13.5H3.75z" />
                                                </svg>
                                                My Dashboard
                                            </a>
                                        @endif

                                        <form
                                            method="POST"
                                            action="{{ route("logout") }}"
                                        >
                                            @csrf
                                            <button
                                                type="submit"
                                                class="flex items-center gap-2.5 w-full text-left px-4 py-2.5 text-sm text-stone-700 hover:bg-stone-50 hover:text-stone-900 border-t border-stone-100 transition-colors"
                                            >
                                                <svg class="h-4 w-4 text-stone-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75" />
                                                </svg>
                                                Logout
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @endif
                </div>
                @endauth

                        <button
                            id="burger-btn"
                            class="sm:hidden flex flex-col justify-center items-center gap-1.5 w-8 h-8 text-stone-700 hover:text-stone-900 transition-colors"
                            aria-label="Toggle menu"
                            aria-expanded="false"
                        >
                            <span
                                class="burger-line block w-6 h-0.5 bg-current transition-all duration-300"
                            ></span>
                            <span
                                class="burger-line block w-6 h-0.5 bg-current transition-all duration-300"
                            ></span>
                            <span
                                class="burger-line block w-6 h-0.5 bg-current transition-all duration-300"
                            ></span>
                        </button>
            </div>

            <nav
                id="mobile-nav"
                class="hidden flex-col gap-0 border-t-2 border-ink bg-cream px-6 pb-4 text-sm font-bold tracking-wide text-ink uppercase sm:hidden"
            >
                <a
                    href="{{ route("home") }}#about"
                    class="py-3 border-b border-ink/10 text-ink transition-colors hover:text-brand"
                >
                    About
                </a>
                @auth
                    @if (auth()->user()->role('admin'))
                        <a
                            href="{{ route("admin.dashboard") }}"
                            class="py-3 border-b border-ink/10 transition-colors {{ request()->routeIs("admin.*") ? "text-brand" : "hover:text-brand" }}"
                        >
                            Admin
                        </a>
                    @elseif (auth()->user()->role('user'))
                        <a
                            href="{{ route("user.dashboard") }}"
                            class="py-3 border-b border-ink/10 transition-colors {{ request()->routeIs("user.*") ? "text-brand" : "hover:text-brand" }}"
                        >
                            My Dashboard
                        </a>
                    @endif
                @endauth

                <a
                    href="{{ route("blog") }}"
                    class="py-3 border-b border-ink/10 transition-colors {{ request()->routeIs("blog") || request()->routeIs("posts.show") ? "text-brand" : "hover:text-brand" }}"
                >
                    Blog
                </a>
                <a
                    href="{{ route("home") }}#contact"
                    class="border-b border-ink/10 py-3 transition-colors hover:text-brand"
                >
                    Contact
                </a>
                <a
                    href="{{ route("privacy") }}"
                    class="border-b border-ink/10 py-3 transition-colors hover:text-brand"
                >
                    Privacy
                </a>
                @guest
                    <a
                        href="{{ route("login") }}"
                        class="py-3 text-ink transition-colors hover:text-brand"
                    >
                        Login/Register
                    </a>
                @endguest
                @auth
                    <form method="POST" action="{{ route("logout") }}">
                        @csrf
                        <button
                            type="submit"
                            class="w-full py-3 text-left text-ink transition-colors hover:text-brand"
                        >
                            Logout
                        </button>
                    </form>
                @endauth
            </nav>
        </header>

        <div class="w-full flex-1">
            @yield("content")
        </div>
        @stack("scripts")
        <script>
            const burgerBtn = document.getElementById('burger-btn');
            const mobileNav = document.getElementById('mobile-nav');
            const lines = burgerBtn.querySelectorAll('.burger-line');

            burgerBtn.addEventListener('click', () => {
                const open = mobileNav.classList.toggle('hidden');
                mobileNav.classList.toggle('flex', !open);
                burgerBtn.setAttribute('aria-expanded', String(!open));
                lines[0].style.transform = open
                ? ''
                : 'translateY(8px) rotate(45deg)';
                lines[1].style.opacity = open ? '' : '0';
                lines[2].style.transform = open
                ? ''
                : 'translateY(-8px) rotate(-45deg)';
            });

            mobileNav.querySelectorAll('a').forEach((a) => {
                a.addEventListener('click', () => {
                    mobileNav.classList.add('hidden');
                    mobileNav.classList.remove('flex');
                    burgerBtn.setAttribute('aria-expanded', 'false');
                    lines[0].style.transform = '';
                    lines[1].style.opacity = '';
                    lines[2].style.transform = '';
                });
            });
        </script>

        <script>
                const button = document.getElementById('dropdown-button');
                const menu = document.getElementById('dropdown-menu');
                const arrow = document.getElementById('dropdown-arrow');
                const container = document.getElementById(
                    'dropdown-container'
                );

                if (button && menu && arrow) {
                    button.addEventListener('click', (e) => {
                        e.stopPropagation(); // Prevent click from bubbling to document
                        const isHidden = menu.classList.contains('hidden');

                        if (isHidden) {
                            menu.classList.remove('hidden');
                            arrow.classList.add('rotate-180');
                        } else {
                            menu.classList.add('hidden');
                            arrow.classList.remove('rotate-180');
                        }
                    });

                    // Close when clicking outside
                    document.addEventListener('click', (e) => {
                        if (!container.contains(e.target)) {
                            menu.classList.add('hidden');
                            arrow.classList.remove('rotate-180');
                        }
                    });
                }
            </script>
    </div>
</body>
</html>
