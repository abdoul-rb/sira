<nav class="fixed lg:hidden w-full bottom-0 left-0 bg-white border-t border-gray-100 z-40">
    <div class="grid h-full max-w-lg grid-cols-4 mx-auto">
        <a class="inline-flex flex-col items-center justify-center p-2 rounded-xl {{ request()->routeIs('dashboard.products.*') ? 'text-black' : 'text-gray-400' }}"
            href="{{ route('dashboard.products.index') }}">
            <div
                class="p-2.5 rounded-lg transition-all duration-300 {{ request()->routeIs('dashboard.products.*') ? 'bg-black text-white' : 'text-gray-400' }}">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="w-4 h-4">
                    <path d="m2 7 4.41-4.41A2 2 0 0 1 7.83 2h8.34a2 2 0 0 1 1.42.59L22 7"></path>
                    <path d="M4 12v8a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-8"></path>
                    <path d="M15 22v-4a2 2 0 0 0-2-2h-2a2 2 0 0 0-2 2v4"></path>
                    <path d="M2 7h20"></path>
                    <path
                        d="M22 7v3a2 2 0 0 1-2 2a2.7 2.7 0 0 1-1.59-.63.7.7 0 0 0-.82 0A2.7 2.7 0 0 1 16 12a2.7 2.7 0 0 1-1.59-.63.7.7 0 0 0-.82 0A2.7 2.7 0 0 1 12 12a2.7 2.7 0 0 1-1.59-.63.7.7 0 0 0-.82 0A2.7 2.7 0 0 1 8 12a2.7 2.7 0 0 1-1.59-.63.7.7 0 0 0-.82 0A2.7 2.7 0 0 1 4 12a2 2 0 0 1-2-2V7">
                    </path>
                </svg>
            </div>
            <span
                class="text-xs tracking-wide {{ request()->routeIs('dashboard.products.*') ? 'mt-1 text-black' : 'text-gray-400' }}">
                Produits
            </span>
        </a>

        <a class="inline-flex flex-col items-center justify-center p-2 rounded-xl {{ request()->routeIs('dashboard.marketings.*') ? 'text-black' : 'text-gray-400' }}"
            href="#">
            <div
                class="p-2.5 rounded-lg transition-all duration-300 {{ request()->routeIs('dashboard.marketings.*') ? 'bg-black text-white' : 'text-gray-400' }}">
                <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                    stroke-width="1.5" stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M10.34 15.84c-.688-.06-1.386-.09-2.09-.09H7.5a4.5 4.5 0 1 1 0-9h.75c.704 0 1.402-.03 2.09-.09m0 9.18c.253.962.584 1.892.985 2.783.247.55.06 1.21-.463 1.511l-.657.38c-.551.318-1.26.117-1.527-.461a20.845 20.845 0 0 1-1.44-4.282m3.102.069a18.03 18.03 0 0 1-.59-4.59c0-1.586.205-3.124.59-4.59m0 9.18a23.848 23.848 0 0 1 8.835 2.535M10.34 6.66a23.847 23.847 0 0 0 8.835-2.535m0 0A23.74 23.74 0 0 0 18.795 3m.38 1.125a23.91 23.91 0 0 1 1.014 5.395m-1.014 8.855c-.118.38-.245.754-.38 1.125m.38-1.125a23.91 23.91 0 0 0 1.014-5.395m0-3.46c.495.413.811 1.035.811 1.73 0 .695-.316 1.317-.811 1.73m0-3.46a24.347 24.347 0 0 1 0 3.46" />
                </svg>
            </div>
            <span
                class="text-xs tracking-wide {{ request()->routeIs('dashboard.marketings.*') ? 'mt-1 text-black' : 'text-gray-400' }}">
                Marketing
            </span>
        </a>

        <a class="inline-flex flex-col items-center justify-center p-2 rounded-xl {{ request()->routeIs('dashboard.orders.*') ? 'text-black' : 'text-gray-400' }}"
            href="{{ route('dashboard.orders.index') }}">
            <div
                class="p-2.5 rounded-lg transition-all duration-300 {{ request()->routeIs('dashboard.orders.*') ? 'bg-black text-white' : 'text-gray-400' }}">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="w-4 h-4">
                    <path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4Z"></path>
                    <path d="M3 6h18"></path>
                    <path d="M16 10a4 4 0 0 1-8 0"></path>
                </svg>
            </div>
            <span
                class="text-xs tracking-wide {{ request()->routeIs('dashboard.orders.*') ? 'mt-1 text-black' : 'text-gray-400' }}">
                {{ __('Ventes') }}
            </span>
        </a>

        <a class="inline-flex flex-col items-center justify-center p-2 rounded-xl {{ request()->routeIs('dashboard.customers.*') ? 'text-black' : 'text-gray-400' }}"
            href="{{ route('dashboard.customers.index') }}">
            <div
                class="p-2.5 rounded-lg transition-all duration-300 {{ request()->routeIs('dashboard.customers.*') ? 'bg-black text-white' : 'text-gray-400' }}">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="w-4 h-4">
                    <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path>
                    <circle cx="9" cy="7" r="4"></circle>
                    <path d="M22 21v-2a4 4 0 0 0-3-3.87"></path>
                    <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                </svg>
            </div>
            <span
                class="text-xs tracking-wide {{ request()->routeIs('dashboard.customers.*') ? 'mt-1 text-black' : 'text-gray-400' }}">
                Clients
            </span>
        </a>

        {{-- <a class="inline-flex flex-col items-center justify-center p-2 rounded-xl {{ request()->routeIs('dashboard.agents.*') ? 'text-black' : 'text-gray-400' }}"
            href="{{ route('dashboard.agents.index') }}">
            <div
                class="p-2.5 rounded-lg transition-all duration-300 {{ request()->routeIs('dashboard.agents.*') ? 'bg-black text-white' : 'text-gray-400' }}">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                    stroke-linejoin="round" class="w-4 h-4">
                    <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path>
                    <circle cx="9" cy="7" r="4"></circle>
                    <path d="M22 21v-2a4 4 0 0 0-3-3.87"></path>
                    <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                </svg>
            </div>
            <span
                class="text-xs tracking-wide {{ request()->routeIs('dashboard.agents.*') ? 'mt-1 text-black' : 'text-gray-400' }}">
                {{ __('Agents') }}
            </span>
        </a> --}}
    </div>
</nav>
