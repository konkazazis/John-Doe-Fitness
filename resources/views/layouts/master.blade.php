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
    <div class="flex min-h-screen flex-col">
        <header
            class="sticky top-0 z-50 border-b border-stone-200 bg-white/95 px-4 backdrop-blur-sm md:px-0"
        >
            <div
                class="mx-auto flex h-20 max-w-7xl items-center justify-between"
            >
                <a
                    href="{{ route("home") }}"
                    class="text-base font-semibold tracking-[0.35em] text-stone-900 uppercase"
                >
                    Dinos
                </a>

                <nav
                    class="hidden gap-8 text-sm font-medium tracking-[0.35em] text-stone-600 uppercase sm:flex"
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
                    @if (!Auth::user()) 
                        <a
                            href="{{ route("login") }}"
                            class="transition-colors hover:text-stone-900"
                        >
                            Login/Register
                        </a>
                    @endauth
                </nav>
                @auth
                    <div
                        class="group relative inline-block text-left"
                        id="dropdown-container"
                    >
                        <button
                            type="button"
                            id="dropdown-button"
                            class="hidden w-full justify-center bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-100 focus:outline-none md:inline-flex"
                        >
                            <img
                                src="https://s3.eu-north-1.amazonaws.com/kazazis.dev/profile-pic.png"
                                alt="Kostas"
                                class="h-10 w-10 rounded-full bg-stone-100 object-cover"
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
                            class="ring-opacity-5 absolute right-0 mt-2 hidden w-56 origin-top-right rounded-md bg-white shadow-lg ring-1 ring-black focus:outline-none"
                        >
                            <div class="py-1">
                                @auth
                                    @if (auth()->user()->role('admin'))
                                        <a
                                            href="{{ route("admin.dashboard") }}"
                                            class="block px-4 py-2 text-sm text-gray-700 transition-colors hover:bg-gray-100 hover:text-gray-900"
                                        >
                                            Admin
                                        </a>
                                    @elseif (auth()->user()->role('user'))
                                        <a
                                            href="{{ route("user.dashboard") }}"
                                            class="block px-4 py-2 text-sm text-gray-700 transition-colors hover:bg-gray-100 hover:text-gray-900"
                                        >
                                            My Dashboard
                                        </a>
                                    @endif
                                @endauth
                                <form
                                    method="POST"
                                    action="{{ route("logout") }}"
                                >
                                    @csrf
                                    <button
                                        type="submit"
                                        class="block w-full px-4 py-2 text-left text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900"
                                    >
                                        Logout
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endauth

                <button
                    id="burger-btn"
                    class="flex h-8 w-8 flex-col items-center justify-center gap-1.5 text-stone-700 transition-colors hover:text-stone-900 sm:hidden"
                    aria-label="Toggle menu"
                    aria-expanded="false"
                >
                    <span
                        class="burger-line block h-0.5 w-6 bg-current transition-all duration-300"
                    ></span>
                    <span
                        class="burger-line block h-0.5 w-6 bg-current transition-all duration-300"
                    ></span>
                    <span
                        class="burger-line block h-0.5 w-6 bg-current transition-all duration-300"
                    ></span>
                </button>
            </div>

            <nav
                id="mobile-nav"
                class="hidden flex-col gap-0 border-t border-stone-200 bg-white px-6 pb-4 text-sm font-semibold tracking-wide text-stone-700 uppercase sm:hidden"
            >
                <a
                    href="{{ route("about") }}"
                    class="py-3 border-b border-stone-100 transition-colors {{ request()->routeIs("about") ? "text-stone-900" : "hover:text-stone-900" }}"
                >
                    About
                </a>
                @auth
                    @if (auth()->user()->role('admin'))
                        <a
                            href="{{ route("admin.dashboard") }}"
                            class="py-3 border-b border-stone-100 transition-colors {{ request()->routeIs("admin.*") ? "text-stone-900" : "hover:text-stone-900" }}"
                        >
                            Admin
                        </a>
                    @elseif (auth()->user()->role('user'))
                        <a
                            href="{{ route("user.dashboard") }}"
                            class="py-3 border-b border-stone-100 transition-colors {{ request()->routeIs("user.*") ? "text-stone-900" : "hover:text-stone-900" }}"
                        >
                            My Dashboard
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
                    class="border-b border-stone-100 py-3 transition-colors hover:text-stone-900"
                >
                    Contact
                </a>
                <a
                    href="{{ route("impressum") }}"
                    class="border-b border-stone-100 py-3 transition-colors hover:text-stone-900"
                >
                    Impressum
                </a>
                <a
                    href="{{ route("privacy") }}"
                    class="border-b border-stone-100 py-3 transition-colors hover:text-stone-900"
                >
                    Privacy
                </a>
                @auth
                    <form method="POST" action="{{ route("logout") }}">
                        @csrf
                        <button
                            type="submit"
                            class="w-full py-3 text-left text-stone-700 transition-colors hover:text-stone-900"
                        >
                            Logout
                        </button>
                    </form>
                @endauth
            </nav>
        </header>

        <div class="mx-auto w-full max-w-7xl flex-1">
            <div class="mx-auto w-full max-w-350 flex-1">
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
