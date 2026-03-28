<div x-data="{ open: true }" @keydown.escape.window="open = false">
    <!-- Overlay -->
    <div x-show="open" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
        class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-xs p-4"
        style="display: none;">

        <div x-show="open" x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-95"
            class="relative w-full max-w-md bg-white rounded-2xl shadow-2xl overflow-hidden" style="display: none;">

            <!-- Header -->
            <div class="px-8 pt-8 pb-4">
                <div class="flex items-center justify-between mb-6">
                    <div class="flex items-center gap-2">
                        <div class="h-8 w-8 rounded-lg bg-gray-900 flex items-center justify-center">
                            <svg class="h-4 w-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 10V3L4 14h7v7l9-11h-7z" />
                            </svg>
                        </div>
                        <span class="text-sm font-semibold text-gray-900">Sira</span>
                    </div>
                    <span class="text-xs font-medium text-gray-400">{{ $step }}/2</span>
                </div>

                <!-- Barre de progression -->
                <div class="w-full bg-gray-100 rounded-full h-1.5 mb-6">
                    <div class="bg-gray-900 h-1.5 rounded-full transition-all duration-500"
                        style="width: {{ $step === 1 ? '50' : '100' }}%"></div>
                </div>

                @if ($step === 1)
                    <h3 class="text-xl font-bold text-gray-900">
                        Créer votre compte
                    </h3>
                @elseif ($step === 2)
                    <h3 class="flex items-center gap-2 text-xl font-medium text-gray-900 border-b border-gray-200 pb-2">
                        <svg class="size-5 text-gray-500" data-slot="icon" fill="none" stroke-width="1.5"
                            stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M15.75 10.5V6a3.75 3.75 0 1 0-7.5 0v4.5m11.356-1.993 1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 0 1-1.12-1.243l1.264-12A1.125 1.125 0 0 1 5.513 7.5h12.974c.576 0 1.059.435 1.119 1.007ZM8.625 10.5a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm7.5 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z">
                            </path>
                        </svg>
                        Votre boutique
                    </h3>
                @endif
            </div>

            <!-- Body -->
            <div class="px-8 pb-8">
                <!-- ==================== STEP 1 ==================== -->
                @if ($step === 1)
                    <div class="space-y-4">
                        <!-- Nom complet -->
                        <x-form.input name="name" label="Nom complet" :wire="true" :required="true"
                            placeholder="ex : Aminata Koné" />

                        <x-phone-input name="phoneNumber" label="Numéro WhatsApp" :countryCode="$countryCode"
                            :required="true" />

                        <x-form.input-password class="col-span-full" name="password" label="Mot de passe" :wire="true"
                            :required="true" />

                        {{-- Note CGU (acceptation implicite) --}}
                        <p class="text-xs text-gray-400">
                            En créant un compte, vous acceptez les
                            <a href="{{ route('cgu') }}" target="_blank" class="underline hover:text-gray-600">CGU</a>
                            et la
                            <a href="{{ route('privacy-policy') }}" target="_blank"
                                class="underline hover:text-gray-600">politique de confidentialité</a>.
                        </p>
                    </div>
                @endif

                {{-- ==================== STEP 2 ==================== --}}
                @if ($step === 2)
                    <div class="space-y-4">
                        {{-- Nom de la boutique --}}
                        <x-form.input name="companyName" label="Nom de la boutique" :wire="true"
                            placeholder="ex : Boutique Aminata" />

                        {{-- Info pays --}}
                        @php
                            $countries = config('countries');
                            $selectedCountry = $countries[$countryCode] ?? null;
                        @endphp

                        @if ($selectedCountry)
                            <div
                                class="flex items-center gap-2 rounded-lg bg-gray-50 border border-gray-200 px-3 py-2 text-sm text-gray-600">
                                <span class="text-lg">{{ $selectedCountry['flag'] }}</span>
                                <span>
                                    Pays détecté : <strong class="text-gray-900">{{ $selectedCountry['name'] }}</strong>
                                </span>
                            </div>
                        @endif

                        {{-- Erreur globale --}}
                        @error('companyName'){{-- handled above --}}@enderror
                    </div>
                @endif

                <!-- Actions CTA -->
                @if($step === 1)
                    <button type="button" wire:click="nextStep" wire:loading.attr="disabled" wire:target="nextStep"
                        class="mt-2 w-full flex items-center justify-center gap-2 rounded-lg bg-gray-900 px-4 py-2.5 text-sm font-semibold text-white hover:bg-gray-800 transition disabled:opacity-60 cursor-pointer">
                        <span wire:loading wire:target="nextStep">
                            <svg class="animate-spin h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4">
                                </circle>
                                <path class="opacity-75" fill="currentColor"
                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                </path>
                            </svg>
                        </span>
                        <span wire:loading.remove wire:target="nextStep">Continuer</span>
                        <span wire:loading wire:target="nextStep">Vérification...</span>
                    </button>

                    <p class="text-center text-sm text-gray-500 pt-1">
                        Déjà un compte ?
                        <a href="{{ route('auth.login') }}" class="font-medium text-blue-600 hover:underline">
                            Connexion
                        </a>
                    </p>
                @endif

                @if($step > 1)
                    <div class="flex gap-2 pt-2 mt-2">
                        <button type="button" wire:click="prevStep"
                            class="flex-1 rounded-lg border border-gray-300 px-4 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-50 transition cursor-pointer">
                            ← Retour
                        </button>

                        <button type="button" wire:click="submit" wire:loading.attr="disabled" wire:target="submit"
                            class="flex-1 flex items-center justify-center gap-2 rounded-lg bg-gray-900 px-4 py-2.5 text-sm font-semibold text-white hover:bg-gray-800 transition disabled:opacity-60 cursor-pointer">
                            <span wire:loading wire:target="submit">
                                <svg class="animate-spin h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                        stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor"
                                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                    </path>
                                </svg>
                            </span>
                            <span wire:loading.remove wire:target="submit">Créer ma boutique</span>
                            <span wire:loading wire:target="submit">Création en cours...</span>
                        </button>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>