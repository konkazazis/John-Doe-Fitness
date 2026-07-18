@extends('layouts.master')
@section('title', 'Success!')

@section('content')
    <div class="flex min-h-[60vh] items-center justify-center px-4">
        <div class="max-w-md text-center">
            <div class="mb-4 text-5xl">🎉</div>
            <h1 class="text-2xl font-bold text-zinc-800 dark:text-zinc-100">
                Subscription successful!
            </h1>
            <p class="mt-2 text-zinc-500 dark:text-zinc-400">
                Thanks for subscribing. Your plan is now active.
            </p>
            <a href="{{ route('home') }}"
                class="mt-6 inline-block rounded-lg bg-zinc-900 px-5 py-2 text-sm font-semibold text-white hover:bg-zinc-700 dark:bg-zinc-100 dark:text-zinc-900">
                Back to home
            </a>
        </div>
    </div>
@endsection