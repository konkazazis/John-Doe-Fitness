<!DOCTYPE html>
<html lang="{{ str_replace("_", "-", app()->getLocale()) }}">
<head>
    @include("partials.head")
    <link
        href="https://cdn.quilljs.com/1.3.7/quill.snow.css"
        rel="stylesheet"
    />
    <script src="https://cdn.quilljs.com/1.3.7/quill.min.js"></script>
    <style>
        .ql-toolbar.ql-snow {
            border-left: none;
            border-right: none;
            border-top: none;
            background: #fff;
            position: sticky;
            top: 0;
            z-index: 1;
        }
        .ql-container.ql-snow {
            border: none;
            font-size: 1.0625rem;
            height: auto !important;
            min-height: 480px;
        }
        .ql-editor {
            height: auto !important;
            min-height: 480px;
            padding: 1.5rem 2rem;
            line-height: 1.8;
        }
        .ql-editor.ql-blank::before {
            font-style: normal;
            color: #d4d4d4;
        }
    </style>
</head>

<body
    class="min-h-screen bg-zinc-50 text-zinc-800 dark:bg-zinc-950 dark:text-zinc-100"
>
    <flux:sidebar
        sticky
        collapsible="mobile"
        class="border-e border-zinc-200 bg-white shadow-sm dark:border-zinc-800 dark:bg-zinc-900"
    >
        <flux:sidebar.header class="py-4">
            <a
                href="{{ route("home") }}"
                class="flex items-center gap-2 px-1"
                wire:navigate
                target="_blank"
            >
                <div
                    class="flex h-8 w-8 shrink-0 items-center justify-center rounded-md bg-zinc-900"
                >
                    <svg
                        class="h-4 w-4 text-white"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="1.5"
                            d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"
                        />
                    </svg>
                </div>
                <span
                    class="text-base font-bold tracking-tight text-zinc-800 dark:text-zinc-100"
                >
                    User Dashboard
                </span>
            </a>
            <flux:sidebar.collapse class="lg:hidden" />
        </flux:sidebar.header>

        <flux:sidebar.nav>
            <flux:sidebar.group heading="Main" class="grid">
                <flux:sidebar.item
                    icon="chart-bar"
                    :href="route('user.dashboard')"
                    :current="request()->routeIs('user.dashboard')"
                    wire:navigate
                >
                    Overview
                </flux:sidebar.item>
            </flux:sidebar.group>

             <flux:sidebar.group heading="Progress" class="grid">
                <flux:sidebar.item
                    icon="chart-bar"
                    :href="route('user.my-subscription')"
                    :current="request()->routeIs('user.my-subscription')"
                    wire:navigate
                >
                    My Subscription
                </flux:sidebar.item>

                <flux:sidebar.item
                    icon="chart-bar"
                    :href="route('user.my-nutrition')"
                    :current="request()->routeIs('user.my-nutrition')"
                    wire:navigate
                >
                    My Nutrition
                </flux:sidebar.item>

                <flux:sidebar.item
                    icon="chart-bar"
                    :href="route('user.my-exercise')"
                    :current="request()->routeIs('user.my-exercise')"
                    wire:navigate
                >
                    My Exercise
                </flux:sidebar.item>
            </flux:sidebar.group>

            <flux:sidebar.group heading="Content" class="grid">
                <flux:sidebar.item
                    icon="inbox"
                    :href="route('user.messages')"
                    :current="request()->routeIs('user.messages.*')"
                    wire:navigate
                >
                    Messages
                </flux:sidebar.item>
            </flux:sidebar.group>

        </flux:sidebar.nav>

        <flux:spacer />

        <flux:sidebar.nav>
            <flux:sidebar.item
                icon="arrow-top-right-on-square"
                href="{{ route('home') }}"
                target="_blank"
            >
                View site
            </flux:sidebar.item>
            <flux:sidebar.item
                icon="cog-6-tooth"
                :href="route('user.settings.profile')"
                :current="request()->routeIs('user.settings.*')"
                wire:navigate
            >
                Settings
            </flux:sidebar.item>
        </flux:sidebar.nav>

        <x-desktop-user-menu class="hidden lg:block" />
    </flux:sidebar>

    {{-- Mobile Header --}}
    <flux:header
        class="border-b border-zinc-200 bg-white lg:hidden dark:border-zinc-800 dark:bg-zinc-900"
    >
        <flux:sidebar.toggle class="lg:hidden" icon="bars-2" inset="left" />

        <a
            href="{{ route("user.dashboard") }}"
            wire:navigate
            class="mx-auto flex items-center gap-2"
        >
            <span
                class="text-sm font-bold text-zinc-800 dark:text-zinc-100"
            >
                Portfolio CMS
            </span>
        </a>

        <flux:spacer />

        <flux:dropdown position="top" align="end">
            <flux:profile
                :initials="auth()->user()->initials()"
                icon-trailing="chevron-down"
            />
            <flux:menu>
                <flux:menu.radio.group>
                    <div class="p-0 text-sm font-normal">
                        <div
                            class="flex items-center gap-2 px-1 py-1.5 text-start text-sm"
                        >
                            <flux:avatar
                                :initials="auth()->user()->initials()"
                            />
                            <div
                                class="grid flex-1 text-start text-sm leading-tight"
                            >
                                <flux:heading class="truncate">
                                    {{ auth()->user()->username }}
                                </flux:heading>
                                <flux:text class="truncate">
                                    {{ auth()->user()->email }}
                                </flux:text>
                            </div>
                        </div>
                    </div>
                </flux:menu.radio.group>
                <flux:menu.separator />
                <form
                    method="POST"
                    action="{{ route("logout") }}"
                    class="w-full"
                >
                    @csrf
                    <flux:menu.item
                        as="button"
                        type="submit"
                        icon="arrow-right-start-on-rectangle"
                        class="w-full cursor-pointer"
                    >
                        Log out
                    </flux:menu.item>
                </form>
            </flux:menu>
        </flux:dropdown>
    </flux:header>

    {{ $slot }}

    @persist("toast")
        <flux:toast.group>
            <flux:toast />
        </flux:toast.group>
    @endpersist

    @fluxScripts
</body>
</html>
