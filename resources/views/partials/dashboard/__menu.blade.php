<nav class="flex flex-1 flex-col">
    <ul role="list" class="flex flex-1 flex-col gap-y-10">
        <li>
            <ul role="list" class="-mx-2 space-y-2">
                <li>
                    <a href="{{ route('dashboard.index', ['tenant' => request()->route('tenant')]) }}"
                        class="group flex gap-x-2 rounded-md p-2 text-sm leading-6 hover:bg-gray-100 {{ request()->routeIs('dashboard.index') ? 'bg-sky-100 text-sky-500 font-semibold' : 'text-slate-900 font-medium' }}">
                        <svg class="h-6 w-6 shrink-0" fill="none" stroke-width="1.5" stroke="currentColor"
                            viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M3.75 6A2.25 2.25 0 0 1 6 3.75h2.25A2.25 2.25 0 0 1 10.5 6v2.25a2.25 2.25 0 0 1-2.25 2.25H6a2.25 2.25 0 0 1-2.25-2.25V6ZM3.75 15.75A2.25 2.25 0 0 1 6 13.5h2.25a2.25 2.25 0 0 1 2.25 2.25V18a2.25 2.25 0 0 1-2.25 2.25H6A2.25 2.25 0 0 1 3.75 18v-2.25ZM13.5 6a2.25 2.25 0 0 1 2.25-2.25H18A2.25 2.25 0 0 1 20.25 6v2.25A2.25 2.25 0 0 1 18 10.5h-2.25a2.25 2.25 0 0 1-2.25-2.25V6ZM13.5 15.75a2.25 2.25 0 0 1 2.25-2.25H18a2.25 2.25 0 0 1 2.25 2.25V18A2.25 2.25 0 0 1 18 20.25h-2.25A2.25 2.25 0 0 1 13.5 18v-2.25Z">
                            </path>
                        </svg>

                        {{ __('Tableau de bord') }}
                    </a>
                </li>

                <li>
                    <a href="{{ route('dashboard.employees.index') }}"
                        class="group flex gap-x-2 rounded-md p-2 text-sm leading-6 hover:bg-gray-100 {{ request()->routeIs('dashboard.employees.*') ? 'bg-sky-100 text-sky-500 font-semibold' : 'text-slate-900 font-medium' }}">
                        <svg class="h-6 w-6 shrink-0" data-slot="icon" fill="none" stroke-width="1.5"
                            stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"
                            aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z">
                            </path>
                        </svg>

                        {{ __('Employés') }}
                    </a>
                </li>

                <li>
                    <a href="{{ route('dashboard.customers.index') }}"
                        class="group flex gap-x-2 rounded-md p-2 text-sm leading-6 hover:bg-gray-100 {{ request()->routeIs('dashboard.customers.*') ? 'bg-sky-100 text-sky-500 font-semibold' : 'text-slate-900 font-medium' }}">
                        <svg class="h-6 w-6 shrink-0" data-slot="icon" fill="none" stroke-width="1.5"
                            stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"
                            aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a5.971 5.971 0 0 0-.941-3.197m0 0A5.995 5.995 0 0 0 12 12.75a5.995 5.995 0 0 0-5.058 2.772m0 0a3 3 0 0 0-4.681 2.72 8.986 8.986 0 0 0 3.74.477m.94-3.197a5.971 5.971 0 0 0-.94 3.197M15 6.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 3a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Zm-13.5 0a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z">
                            </path>
                        </svg>

                        {{ __('Clients') }}
                    </a>
                </li>

                <li>
                    <a href="{{ route('dashboard.customers.index') }}"
                        class="group flex gap-x-2 rounded-md p-2 text-sm leading-6 hover:bg-gray-100 {{ request()->routeIs('dashboard.customers.*') ? 'bg-sky-100 text-sky-500 font-semibold' : 'text-slate-900 font-medium' }}">
                        <svg class="h-6 w-6 shrink-0" data-slot="icon" fill="none" stroke-width="1.5"
                            stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"
                            aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a5.971 5.971 0 0 0-.941-3.197m0 0A5.995 5.995 0 0 0 12 12.75a5.995 5.995 0 0 0-5.058 2.772m0 0a3 3 0 0 0-4.681 2.72 8.986 8.986 0 0 0 3.74.477m.94-3.197a5.971 5.971 0 0 0-.94 3.197M15 6.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 3a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Zm-13.5 0a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z">
                            </path>
                        </svg>

                        {{ __('Agents') }}
                    </a>
                </li>
            </ul>
        </li>

        <li>
            <div class="text-xs text-slate-600 font-medium uppercase">
                {{ __('Boutique') }}
            </div>

            <ul role="list" class="-mx-2 mt-2 space-y-2">
                <li>
                    <a href="{{ route('dashboard.orders.index') }}"
                        class="group flex gap-x-2 rounded-md p-2 text-sm leading-6 hover:bg-gray-100 {{ request()->routeIs('dashboard.orders.*') ? 'bg-sky-100 text-sky-500 font-semibold' : 'text-slate-900 font-medium' }}">
                        <svg class="h-6 w-6 shrink-0" fill="none" stroke-width="1.5" stroke="currentColor"
                            viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M2.25 18.75a60.07 60.07 0 0 1 15.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 0 1 3 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 0 0-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 0 1-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 0 0 3 15h-.75M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm3 0h.008v.008H18V10.5Zm-12 0h.008v.008H6V10.5Z">
                            </path>
                        </svg>

                        {{ __('Commandes') }}
                    </a>
                </li>

                <li>
                    <a href="{{ route('dashboard.products.index') }}"
                        class="group flex gap-x-2 rounded-md p-2 text-sm leading-6 hover:bg-gray-100 {{ request()->routeIs('dashboard.products.*') ? 'bg-sky-100 text-sky-500 font-semibold' : 'text-slate-900 font-medium' }}">
                        <svg class="h-6 w-6 shrink-0" data-slot="icon" fill="none" stroke-width="1.5"
                            stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"
                            aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 0 0-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 0 0-16.536-1.84M7.5 14.25 5.106 5.272M6 20.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Zm12.75 0a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z">
                            </path>
                        </svg>

                        {{ __('Produits') }}
                    </a>
                </li>
            </ul>
        </li>

        <li class="-mx-6 mt-auto">
            <a href="#"
                class="flex items-center gap-x-4 px-6 py-3 text-sm leading-6 hover:text-sky-500 hover:bg-sky-200 {{ request()->routeIs('dashboard.profile') ? 'bg-sky-100 text-sky-500 font-semibold' : 'text-slate-900 font-medium' }}">
                <img class="h-8 w-8 rounded-full object-cover bg-gray-800"
                    src="https://images.unsplash.com/photo-1503300961747-204cbbdaeb51?w=900&auto=format&fit=crop&q=60&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8OHx8YmxhY2slMjBib3l8ZW58MHx8MHx8fDA%3D"
                    alt="Abdoul Rahim">
                <span class="sr-only">{{ __('Votre profile') }}</span>
                <span aria-hidden="true">
                    Abdoul Rahim
                </span>
            </a>
        </li>
    </ul>
</nav>
