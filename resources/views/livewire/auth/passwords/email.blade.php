@section('title', __('Mot de passe oublié'))

<div class="flex min-h-screen items-center justify-center bg-gray-50 px-4 py-12 sm:px-6 lg:px-8">
    <div class="w-full max-w-md">
        <!-- Card -->
        <div class="bg-white rounded-xl border border-gray-100 px-8 py-10">
            <!-- Logo -->
            <div class="flex mb-8">
                <a href="{{ route('home') }}">
                    <x-logo class="h-16 w-auto" />
                </a>
            </div>

            <!-- Title -->
            <h2 class="text-2xl font-bold text-gray-900 mb-3">
                {{ __('Mot de passe oublié ?') }}
            </h2>

            <p class="text-sm text-gray-500 mb-8">
                {{ __('Entrez votre adresse email et nous vous enverrons un lien pour réinitialiser votre mot de passe.') }}
            </p>

            @if ($emailSentMessage)
                <!-- Success Message -->
                <div class="rounded-lg bg-green-50 p-4 mb-6">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-green-800">
                                {{ $emailSentMessage }}
                            </p>
                        </div>
                    </div>
                </div>

                <a href="{{ route('auth.login') }}"
                    class="flex w-full justify-center rounded-lg bg-gray-900 px-4 py-3 text-sm font-medium text-white hover:bg-gray-800 transition">
                    {{ __('Retour à la connexion') }}
                </a>
            @else
                <form wire:submit.prevent="sendResetPasswordLink" class="space-y-6">
                    <x-form.input type="email" name="email" :label="__('Adresse email')" :wire="true" />

                    <button type="submit"
                        class="flex w-full justify-center rounded-lg bg-gray-900 px-4 py-3 text-sm font-medium text-white hover:bg-gray-800 transition cursor-pointer"
                        wire:loading.attr="disabled" wire:target="sendResetPasswordLink">
                        <span wire:loading wire:target="sendResetPasswordLink">
                            <svg class="animate-spin h-5 w-5 inline mr-2" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4">
                                </circle>
                                <path class="opacity-75" fill="currentColor"
                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                </path>
                            </svg>
                        </span>
                        {{ __('Envoyer le lien de réinitialisation') }}
                    </button>
                </form>

                <p class="mt-6 text-center text-sm text-gray-500">
                    {{ __('Vous vous souvenez de votre mot de passe ?') }}
                    <a href="{{ route('auth.login') }}" class="font-medium text-sky-600 hover:text-sky-500">
                        {{ __('Se connecter') }}
                    </a>
                </p>
            @endif
        </div>
    </div>
</div>