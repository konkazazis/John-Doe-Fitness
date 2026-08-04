@extends('layouts.master')
@section('title', 'Privacy Policy · John Doe')
@section('meta_description', 'How John Doe Coaching collects, uses and protects your personal data.')

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
                            [Your Business Name]<br>
                            [Street Address]<br>
                            [Post-code, City]<br>
                            [Country]<br>
                            Email:
                            <a href="mailto:example@mail.com" class="text-brand hover:underline">
                                example@mail.com
                            </a>
                        </p>
                    </section>

                    <section>
                        <h2 class="mb-2 text-lg font-bold text-stone-800">2. Cookies & Session</h2>
                        <p>
                           This site uses a session cookie to keep you signed in and to protect forms against
                           cross-site request forgery. We don't use the session cookie to track you across other
                           websites. If we add analytics or marketing cookies in the future, this section will be
                           updated and, where required, we'll ask for your consent first.
                        </p>
                    </section>

                    <section>
                        <h2 class="mb-2 text-lg font-bold text-stone-800">3. What We Collect</h2>
                        <p>
                           When you create an account, book a consultation, send a message or subscribe to a
                           coaching plan, we collect the information you provide directly — such as your name,
                           email address and, where applicable, the training and nutrition details you share with
                           your coach. Payments are processed by Stripe; we do not store your card details on our
                           servers. Uploaded files (such as progress photos) are stored with our hosting provider.
                        </p>
                    </section>

                    <section>
                        <h2 class="mb-2 text-lg font-bold text-stone-800">4. How We Use It</h2>
                        <p>
                           We use your information to provide coaching services, manage your subscription, respond
                           to your messages and meet our legal and accounting obligations. We do not sell your
                           personal data.
                        </p>
                    </section>

                    <section>
                        <h2 class="mb-2 text-lg font-bold text-stone-800">5. Your Rights</h2>
                        <p>
                           You can ask to access, correct or delete the personal data we hold about you at any
                           time by contacting us at the email address above.
                        </p>
                    </section>

        </div>

    </div>
@endsection