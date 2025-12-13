<section id="benefits" aria-label="Simplifiez les tâches du quotidien." class="pt-20 pb-14 sm:pt-28 sm:pb-20 lg:pb-28">
    <div class="-mx-4 grid max-w-2xl grid-cols-1 gap-y-10 lg:mx-auto lg:max-w-4xl lg:grid-cols-2 lg:gap-x-8">
        <div class="group bg-white rounded-xl px-8 py-12 shadow-sm border border-gray-50 hover:border-blue-400">
            <div class="flex items-center gap-3 mb-6">
                <div class="w-10 h-10 rounded-full bg-red-50 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="w-5 h-5 text-red-500">
                        <path d="M18 6 6 18"></path>
                        <path d="m6 6 12 12"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-slate-900">
                    Avant Sira
                </h3>
            </div>

            <ul class="space-y-5">
                @foreach (["Cahiers difficiles à suivre", "Données jamais à jour", "Ruptures de stock répétées", "Mauvaises décisions d'achat", "Aucune visibilité sur la marge réelle"] as $item)
                    <li class="flex items-center">
                        <div class="w-5 h-5 rounded-full bg-red-50 flex items-center justify-center flex-shrink-0">
                            <svg class="h-6 w-6 flex-none text-red-500" data-slot="icon" fill="none" stroke-width="1.5"
                                stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"
                                aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="m9.75 9.75 4.5 4.5m0-4.5-4.5 4.5M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"></path>
                            </svg>
                        </div>
                        <span class="ml-3">
                            {{ $item }}
                        </span>
                    </li>
                @endforeach
            </ul>
        </div>

        <div class="group bg-white rounded-xl px-8 py-12 shadow-sm border border-gray-50 hover:border-blue-400">
            <div class="flex items-center gap-3 mb-6">
                <div class="w-10 h-10 rounded-full bg-blue-50 flex items-center justify-center">
                    <svg class="w-5 h-5 text-blue-500" data-slot="icon" fill="none" stroke-width="1.5"
                        stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-slate-900">
                    Avec Sira
                </h3>
            </div>

            <ul class="space-y-5">
                @foreach (["Cahiers difficiles à suivre", "Données jamais à jour", "Ruptures de stock répétées", "Mauvaises décisions d'achat", "Aucune visibilité sur la marge réelle"] as $item)
                    <li class="flex items-center">
                        <svg aria-hidden="true" class="h-6 w-6 flex-none fill-current stroke-current text-blue-400">
                            <path
                                d="M9.307 12.248a.75.75 0 1 0-1.114 1.004l1.114-1.004ZM11 15.25l-.557.502a.75.75 0 0 0 1.15-.043L11 15.25Zm4.844-5.041a.75.75 0 0 0-1.188-.918l1.188.918Zm-7.651 3.043 2.25 2.5 1.114-1.004-2.25-2.5-1.114 1.004Zm3.4 2.457 4.25-5.5-1.187-.918-4.25 5.5 1.188.918Z"
                                stroke-width="0"></path>
                            <circle cx="12" cy="12" r="8.25" fill="none" stroke-width="1.5" stroke-linecap="round"
                                stroke-linejoin="round"></circle>
                        </svg>
                        <span class="ml-3">
                            {{ $item }}
                        </span>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</section>