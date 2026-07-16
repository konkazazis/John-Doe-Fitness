@extends('layouts.master')
@section('title', 'Privacy')
@section('meta_description', 'Privacy policy page')

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
                    Privacy<strong class="text-brand">Policy</strong>
                </h1>
            </div>
        </div>

        <div class="prose prose-stone max-w-none space-y-8 leading-relaxed text-stone-700">

                    <section>
                        <h2 class="mb-2 text-lg font-bold text-stone-800">1. Data Controller</h2>
                        <p>
                            John Doe<br>
                            Street Name<br>
                            Post-code, City<br>
                            Country<br>
                            Email:
                            <a href="mailto:example@mail.com" class="text-brand hover:underline">
                                example@mail.com
                            </a>
                        </p>
                    </section>

                    <section>
                        <h2 class="mb-2 text-lg font-bold text-stone-800">2. Cookies & Session</h2>
                        <p>
                           Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor 
                           invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. 
                           At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, 
                           no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, 
                           consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. 
                           At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.
                        </p>
                    </section>

                    <section>
                        <h2 class="mb-2 text-lg font-bold text-stone-800">3. Other Info</h2>
                        <p>
                           Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor 
                           invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. 
                           At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, 
                           no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, 
                           consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. 
                           At vero eos et accusam et justo duo dolores et ea rebum. 
                        </p>
                    </section>

        </div>

    </div>
@endsection