<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <meta name="viewport" content="width=device-width,minimum-scale=1" />
        <title>@yield("title", "kostas — Full-Stack Web Developer")</title>
        <meta
            name="description"
            content="@yield("meta_description", "A developer who loves building things for the web. Thoughts on code, design, and everything in between.")"
        />
        <link rel="canonical" href="@yield("canonical", url()->current())" />

        {{-- Open Graph --}}
        <meta property="og:type" content="@yield("og_type", "website")" />
        <meta
            property="og:url"
            content="@yield("canonical", url()->current())"
        />
        <meta property="og:title" content="@yield("og_title", "kostas")" />
        <meta
            property="og:description"
            content="@yield("meta_description", "A developer who loves building things for the web. Thoughts on code, design, and everything in between.")"
        />
        <meta property="og:site_name" content="kostas" />
        <meta
            property="og:image"
            content="@yield("og_image", asset("images/home-bg.jpg"))"
        />
        <meta property="og:image:width" content="1200" />
        <meta property="og:image:height" content="630" />

        {{-- Twitter Card --}}
        <meta name="twitter:card" content="summary_large_image" />
        <meta name="twitter:creator" content="@konkazazis" />
        <meta name="twitter:title" content="@yield("og_title", "kostas")" />
        <meta
            name="twitter:description"
            content="@yield("meta_description", "A developer who loves building things for the web. Thoughts on code, design, and everything in between.")"
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

        <link rel="manifest" href="{{ asset("site.webmanifest") }}" />
        <link
            rel="stylesheet"
            href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
            crossorigin="anonymous"
        />

        @stack("head")
        @stack("schema")
        @vite(["resources/css/app.css", "resources/js/app.js"])
    </head>

    <body>
        <div class="min-h-screen flex flex-col">
            <header
                class="sticky top-0 z-50 px-4 md:px-0 bg-white/95 backdrop-blur-sm border-b border-stone-200"
            >
                <div
                    class="max-w-7xl mx-auto h-20 flex items-center justify-between"
                >
                    <a
                        href="{{ route("home") }}"
                        class="text-base font-semibold uppercase tracking-[0.35em] text-stone-900"
                    >
                        Dinos
                    </a>

                    <nav
                        class="hidden sm:flex gap-8 text-sm uppercase tracking-[0.35em] font-medium text-stone-600"
                    >
                        <a
                            href="{{ route("about") }}"
                            class="transition-colors {{ request()->routeIs("about") ? "text-stone-900" : "hover:text-stone-900" }}"
                        >
                            About
                        </a>
                        <a
                            href="{{ route("blog") }}"
                            class="transition-colors {{ request()->routeIs("blog") || request()->routeIs("posts.show") ? "text-stone-900" : "hover:text-stone-900" }}"
                        >
                            Blog
                        </a>
                        <a
                            href="{{ route("home") }}#contact"
                            class="transition-colors hover:text-stone-900"
                        >
                            Contact
                        </a>
                    </nav>
                    @auth
                        @if (auth()->user()->is_admin)
                            <div
                                class="group relative inline-block text-left"
                                id="dropdown-container"
                            >
                                <button
                                    type="button"
                                    id="dropdown-button"
                                    class="hidden md:inline-flex justify-center w-full px-4 py-2 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-100"
                                >
                                    <img
                                        src="https://s3.eu-north-1.amazonaws.com/kazazis.dev/profile-pic.png"
                                        alt="Kostas"
                                        class="w-10 h-10 rounded-full object-cover bg-stone-100"
                                    />
                                    <svg
                                        class="-mr-1 ml-2 h-5 w-5 transition-transform duration-200"
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
                                    class="origin-top-right absolute right-0 mt-2 w-56 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 focus:outline-none hidden"
                                >
                                    <div class="py-1">
                                        <a
                                            href="{{ route("admin.dashboard") }}"
                                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900 transition-colors"
                                        >
                                            Admin
                                        </a>

                                        <form
                                            method="POST"
                                            action="{{ route("logout") }}"
                                        >
                                            @csrf
                                            <button
                                                type="submit"
                                                class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900"
                                            >
                                                Logout
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endif
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
                    class="sm:hidden hidden flex-col gap-0 text-sm uppercase tracking-wide font-semibold border-t border-stone-200 px-6 pb-4 text-stone-700 bg-white"
                >
                    <a
                        href="{{ route("about") }}"
                        class="py-3 border-b border-stone-100 transition-colors {{ request()->routeIs("about") ? "text-stone-900" : "hover:text-stone-900" }}"
                    >
                        About
                    </a>
                    @auth
                        @if (auth()->user()->is_admin)
                            <a
                                href="{{ route("admin.dashboard") }}"
                                class="py-3 border-b border-stone-100 transition-colors {{ request()->routeIs("admin.*") ? "text-stone-900" : "hover:text-stone-900" }}"
                            >
                                Admin
                            </a>
                        @endif
                    @endauth

                    <a
                        href="{{ route("blog") }}"
                        class="py-3 border-b border-stone-100 transition-colors {{ request()->routeIs("blog") || request()->routeIs("posts.show") ? "text-stone-900" : "hover:text-stone-900" }}"
                    >
                        Blog
                    </a>
                    <a
                        href="{{ route("home") }}#contact"
                        class="py-3 border-b border-stone-100 transition-colors hover:text-stone-900"
                    >
                        Contact
                    </a>
                    <a
                        href="{{ route("impressum") }}"
                        class="py-3 border-b border-stone-100 transition-colors hover:text-stone-900"
                    >
                        Impressum
                    </a>
                    <a
                        href="{{ route("privacy") }}"
                        class="py-3 border-b border-stone-100 transition-colors hover:text-stone-900"
                    >
                        Privacy
                    </a>
                    @auth
                        <form method="POST" action="{{ route("logout") }}">
                            @csrf
                            <button
                                type="submit"
                                class="w-full text-left py-3 text-stone-700 hover:text-stone-900 transition-colors"
                            >
                                Logout
                            </button>
                        </form>
                    @endauth
                </nav>
            </header>

            <div class="flex-1 w-full max-w-7xl mx-auto">
                <div class="flex-1 w-full max-w-350 mx-auto">
                    @yield("content")
                </div>
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
                    if (
                        !document
                            .getElementById('dropdown-container')
                            .contains(e.target)
                    ) {
                        menu.classList.add('hidden');
                        arrow.classList.remove('rotate-180');
                    }
                });
            </script>
        </div>
    </body>
</html>
