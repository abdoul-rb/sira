<section id="faq" aria-labelledby="faq-title" class="relative overflow-hidden bg-slate-50 py-20 sm:py-32">
    <img alt="" loading="lazy" width="1558" height="946" decoding="async" data-nimg="1"
        class="absolute top-0 left-1/2 max-w-none translate-x-[-20%] -translate-y-1/4" style="color:transparent"
        src="https://salient.tailwindui.com/_next/static/media/background-faqs.55d2e36a.jpg">

    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 relative">
        <div class="mx-auto max-w-2xl lg:max-w-4xl">
            <h2 id="faq-title" class="font-display text-3xl tracking-tight text-slate-900 sm:text-4xl">
                Questions fréquentes
            </h2>
            <p class="mt-4 text-base tracking-tight text-gray-600">
                Tout ce que vous devez savoir avant de commencer
            </p>
        </div>

        <div class="mx-auto mt-16 max-w-2xl lg:max-w-4xl space-y-4">
            @foreach ($faqs as $faq)
                <x-ui.accordion :question="$faq['question']" :answer="$faq['answer']" />
            @endforeach
        </div>
    </div>
</section>