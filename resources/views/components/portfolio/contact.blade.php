<section id="contact" class="pt-24 pb-8 px-6 sm:px-8 bg-stone-900 text-white border-t border-stone-800">
    <div class="max-w-3xl mx-auto">
        <div class="reveal mb-8">
            <span class="eyebrow text-on-dark-mut">Contact</span>
            <h2 class="mt-[18px] text-[clamp(2.1rem,5vw,3.4rem)] tracking-[-0.03em] leading-[1.04] font-bold">
                Got something you want <span class="serif-it text-[oklch(0.78_0.1_45)]">built?</span>
            </h2>
            <p class="mt-[22px] text-on-dark-mut text-[1.1rem] max-w-[40ch]">
                Tell me a little about your project. I read every message and reply within a day or two.
            </p>

            <a href="mailto:hello@kazazis.dev" class="inline-flex items-center gap-3 mt-8 font-mono text-[1.05rem] border-b border-dark-line pb-1.5 transition-all hover:border-on-dark hover:gap-4">
                kostas@kazazis.dev <span class="arr">&rarr;</span>
            </a>

            <div class="flex gap-2.5 mt-[30px]">
                <a href="https://github.com/konkazazis" target="_blank" rel="noopener" aria-label="GitHub"
                   class="w-11 h-11 rounded-[11px] border border-dark-line grid place-items-center text-on-dark-mut hover:text-on-dark hover:border-on-dark hover:-translate-y-[3px] transition">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M12 .5A11.5 11.5 0 0 0 .5 12a11.5 11.5 0 0 0 7.86 10.92c.58.1.79-.25.79-.56v-2c-3.2.7-3.88-1.37-3.88-1.37-.53-1.34-1.3-1.7-1.3-1.7-1.06-.72.08-.71.08-.71 1.17.08 1.78 1.2 1.78 1.2 1.04 1.78 2.73 1.27 3.4.97.1-.76.41-1.27.74-1.56-2.55-.29-5.24-1.28-5.24-5.7 0-1.26.45-2.29 1.19-3.1-.12-.29-.52-1.46.11-3.05 0 0 .97-.31 3.18 1.18a11 11 0 0 1 5.8 0c2.2-1.5 3.17-1.18 3.17-1.18.63 1.59.23 2.76.11 3.05.74.81 1.19 1.84 1.19 3.1 0 4.43-2.7 5.4-5.26 5.69.42.36.8 1.08.8 2.18v3.23c0 .31.2.67.8.56A11.5 11.5 0 0 0 23.5 12 11.5 11.5 0 0 0 12 .5Z"/></svg>
                </a>
                <a href="https://www.linkedin.com/in/konstantinos-kazazis-32a470228/" target="_blank" rel="noopener" aria-label="LinkedIn"
                   class="w-11 h-11 rounded-[11px] border border-dark-line grid place-items-center text-on-dark-mut hover:text-on-dark hover:border-on-dark hover:-translate-y-[3px] transition">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M4.98 3.5a2.5 2.5 0 1 1 0 5 2.5 2.5 0 0 1 0-5ZM2.4 9.4h5.16V21H2.4V9.4Zm7.7 0h4.95v1.58h.07c.69-1.24 2.37-2.54 4.88-2.54 5.22 0 6.18 3.36 6.18 7.74V21h-5.15v-5.13c0-1.22-.02-2.8-1.7-2.8-1.71 0-1.97 1.32-1.97 2.7V21H10.1V9.4Z"/></svg>
                </a>
            </div>
        </div>

        <livewire:contact-form />

        <div class="lg:flex text-center lg:justify-between border-t border-stone-800 pt-8 text-stone-400 text-sm">
            <div class="mb-4 lg:mb-0">
                <p>Copyright © {{ date('Y') }} Kostas Kazazis</p>
            </div>
            <div class="flex justify-between lg:gap-4">
                <a href="https://github.com/konkazazis" target="_blank" rel="noopener noreferrer"
                    class="text-sm text-zinc-500 hover:text-brand transition-colors">
                    GitHub
                </a>
                <a href="https://www.linkedin.com/in/konstantinos-kazazis-32a470228/" target="_blank"
                    rel="noopener noreferrer" class="text-sm text-zinc-500 hover:text-brand transition-colors">
                    LinkedIn
                </a>
                <a href="{{ route('impressum') }}" class="text-sm text-zinc-500 hover:text-brand transition-colors">
                    Impressum
                </a>
                <a href="{{ route('privacy') }}" class="text-sm text-zinc-500 hover:text-brand transition-colors">
                    Privacy
                </a>
            </div>
        </div>
    </div>
</section>

