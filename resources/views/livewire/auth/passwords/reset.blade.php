@section('title', $isInvitation ? __('Définir votre mot de passe') : __('Réinitialiser le mot de passe'))

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
                {{ $isInvitation ? __('Définir votre mot de passe') : __('Réinitialiser le mot de passe') }}
            </h2>

            <p class="text-sm text-gray-500 mb-8">
                @if ($isInvitation)
                    {{ __('Bienvenue ! Définissez votre mot de passe pour accéder à votre compte.') }}
                @else
                    {{ __('Entrez votre nouveau mot de passe ci-dessous.') }}
                @endif
            </p>

            <form wire:submit.prevent="resetPassword" class="space-y-6">
                <input wire:model="token" type="hidden">

                <x-form.input type="email" name="email" :label="__('Adresse email')" :wire="true" />

                <x-form.input-password name="password" :label="__('Nouveau mot de passe')" :wire="true" />

                <x-form.input-password name="password_confirmation" :label="__('Confirmer le mot de passe')"
                    :wire="true" />

                <button type="submit"
                    class="flex w-full justify-center rounded-lg bg-gray-900 px-4 py-3 text-sm font-medium text-white hover:bg-gray-800 transition cursor-pointer"
                    wire:loading.attr="disabled" wire:target="resetPassword">
                    <span wire:loading wire:target="resetPassword">
                        <svg class="animate-spin h-5 w-5 inline mr-2" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4">
                            </circle>
                            <path class="opacity-75" fill="currentColor"
                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                            </path>
                        </svg>
                    </span>
                    {{ $isInvitation ? __('Définir mon mot de passe') : __('Réinitialiser le mot de passe') }}
                </button>
            </form>
        </div>
    </div>
</div>