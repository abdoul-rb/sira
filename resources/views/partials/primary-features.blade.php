<section id="features" aria-label="Features for running your books"
    class="relative overflow-hidden bg-blue-600 pt-20 pb-28 sm:py-32">

    <img alt="" loading="lazy"
        class="absolute top-1/2 left-1/2 max-w-none translate-x-[-44%] translate-y-[-42%]"
        src="https://salient.tailwindui.com/_next/static/media/background-features.5f7a9ac9.jpg">

    <div class="relative mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

        <div class="max-w-2xl md:mx-auto md:text-center xl:max-w-none">
            <h2 class="font-display text-3xl tracking-tight text-white sm:text-4xl md:text-5xl">
                Tout ce qu'il vous faut pour gérer votre business.
            </h2>
            <p class="mt-6 text-lg tracking-tight text-blue-100 max-w-5xl mx-auto">
                Gérez votre boutique sans stress, sans calculs compliqués et sans risque d'erreurs.
            </p>
        </div>

        <div class="mt-16 grid grid-cols-1 gap-y-10 lg:grid-cols-12 lg:gap-x-8">

            <div class="lg:col-span-5">
                <div class="space-y-2" role="tablist">

                    <!-- Analytics -->
                    <div class="group tab-group tab-active rounded-xl p-6 bg-white/10 ring-1 ring-white/10">
                        <button class="tab-button font-display text-lg text-white"
                            data-tab="analytics" aria-selected="true">
                            Analytics
                        </button>
                        <p class="mt-2 text-sm text-white">
                            Tableau de bord clair avec vos produits les plus rentables.
                        </p>
                    </div>

                    <!-- Stock -->
                    <div class="group tab-group rounded-xl p-6 hover:bg-white/10">
                        <button class="tab-button font-display text-lg text-white"
                            data-tab="stock" aria-selected="false">
                            Stock
                        </button>
                        <p class="mt-2 text-sm text-blue-100 group-hover:text-white">
                            Suivi en temps réel pour éviter les ruptures.
                        </p>
                    </div>

                    <!-- Ventes -->
                    <div class="group tab-group rounded-xl p-6 hover:bg-white/10">
                        <button class="tab-button font-display text-lg text-white"
                            data-tab="ventes" aria-selected="false">
                            Ventes
                        </button>
                        <p class="mt-2 text-sm text-blue-100 group-hover:text-white">
                            Enregistrez vos ventes et votre chiffre d'affaires.
                        </p>
                    </div>

                    <!-- Contacts -->
                    <div class="group tab-group rounded-xl p-6 hover:bg-white/10">
                        <button class="tab-button font-display text-lg text-white"
                            data-tab="contacts" aria-selected="false">
                            Contacts
                        </button>
                        <p class="mt-2 text-sm text-blue-100 group-hover:text-white">
                            Clients et fournisseurs centralisés.
                        </p>
                    </div>

                </div>
            </div>

          
            <div class="lg:col-span-7">

                <!-- Analytics (visible par défaut) -->
                <div class="tab-panel" data-panel="analytics">
                    <img
                        src="{{ asset('imgs/analytics.webp') }}"
                        alt="Analytics"
                        class="w-full rounded-xl shadow-xl">
                </div>

                <!-- Stock -->
                <div class="tab-panel hidden" data-panel="stock">
                    <img
                        src="{{ asset('imgs/stock.webp') }}"
                        alt="Stock"
                        class="w-full rounded-xl shadow-xl">
                </div>

                <!-- Ventes -->
                <div class="tab-panel hidden" data-panel="ventes">
                    <img
                        src="{{ asset('imgs/ventes.webp') }}"
                        alt="Ventes"
                        class="w-full rounded-xl shadow-xl">
                </div>

                <!-- Contacts -->
                <div class="tab-panel hidden" data-panel="contacts">
                    <img
                        src="{{ asset('imgs/contacts.webp') }}"
                        alt="Contacts"
                        class="w-full rounded-xl shadow-xl">
                </div>

            </div>

</section>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const buttons = document.querySelectorAll('.tab-button');
    const panels = document.querySelectorAll('.tab-panel');
    const groups = document.querySelectorAll('.tab-group');

    buttons.forEach(btn => {
        btn.addEventListener('click', () => {
            const target = btn.dataset.tab;

            buttons.forEach(b => b.setAttribute('aria-selected', 'false'));
            panels.forEach(p => p.classList.add('hidden'));
            groups.forEach(g => g.classList.remove('tab-active'));

            btn.setAttribute('aria-selected', 'true');
            btn.closest('.tab-group').classList.add('tab-active');
            document.querySelector(`[data-panel="${target}"]`).classList.remove('hidden');
        });
    });
});
</script>

<style>
.tab-active {
    background-color: rgba(255,255,255,0.18);
}
</style>

