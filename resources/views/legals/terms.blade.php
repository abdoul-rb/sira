{{-- blade-formatter-disable --}}
@extends('layouts.app')

@section('title', __('Mentions légales'))

@section('content')
    <main class="mx-auto max-w-4xl px-6 md:px-0 py-12 mb-12">
        <div class="border-b border-gray-300 pb-4">
            <h1 class="text-4xl font-bold tracking-wide text-gray-900">
                {{ __('Mentions légales') }}
            </h1>

            <p class="mt-2 text-sm leading-7 text-gray-500">
                {{ __("Dernière mise à jour:") }} {{ date('M Y') }}
            </p>
        </div>

        <div
            class="mt-4 prose-sm text-gray-900 text-base prose prose-gray prose-a:font-medium prose-a:text-blue-600 hover:prose-a:text-blue-700 max-w-3xl">
            <h2>{{ __('Éditeur du site') }}</h2>

            <p>
                {{ __("Le site :url est édité par :app_name, plateforme de mise en relation entre voyageurs et expéditeurs.", ['url' => 'https://doniin.com', 'app_name' => config('app.name')]) }}
            </p>

            <p>
                {!! __("<span class='font-semibold'>Éditeur:</span> :app_name", ['app_name' => config('app.name')]) !!}
            </p>

            <p>
                {!! __("<span class='font-semibold'>Contact:</span> <a href='mailto::url'>:url</a>", ['url' => config('app.support.email')]) !!}
            </p>

            {{-- <p>
                Ce site est édité par [Nom de votre entreprise], société [forme juridique de votre entreprise] au
                capital de [montant du capital social], immatriculée au registre du commerce et des sociétés de
                [lieu d'immatriculation] sous le numéro [numéro d'immatriculation], dont le siège social est situé
                au [adresse du siège social].
            </p> --}}

            <h2>{{ __('Directeur de la publication') }}</h2>

            <p>
                {{ __("Le directeur de la publication est l'équipe :app_name.", ['app_name' => config('app.name')]) }}
            </p>

            <p>
                {!! __("<span class='font-semibold'>Contact:</span> <a href='mailto::url'>:url</a>", ['url' => config('app.url')]) !!}
            </p>

            <h2>{{ __('Hébergement du site') }}</h2>

            <p>
                {!! __("Le site <a href='mailto::url'>:url</a> est hébergé par :", ['url' => config('app.url')]) !!}
            </p>

            <pre class="bg-transparent text-black font-sans">
                        IONOS SARL
                        7, place de la Gare — BP 70109
                        57201 SARREGUEMINES CEDEX — France
                        Site web : https://www.ionos.fr

                        Téléphone : 0970 808 911 (appel non surtaxé)
                    </pre>

            <h2>{{ __('Propriété Intellectuelle') }}</h2>

            <p>
                {{ __("L'ensemble du contenu présent sur le site doniin.com (textes, images, logos, code source, design, etc.) est la propriété exclusive du projet Doniin, sauf mention contraire. Toute reproduction, distribution ou utilisation sans autorisation préalable est interdite.") }}
            </p>

            <p>
                © Doniin – 2025. {{ __("Tous droits réservés") }}.
            </p>

            <h2>{{ __("Données personnelles (RGPD)") }}</h2>

            <p>
                {{ __("Le site :app_name collecte et traite certaines données personnelles dans le cadre de son fonctionnement (création de compte, réservations, messagerie).", ['app_name' => config('app.name')]) }}
            </p>

            <strong>{{ __("Finalités de la collecte :") }}</strong>

            <ul>
                <li>{{ __("Gestion des comptes utilisateurs") }}</li>
                <li>{{ __("Mise en relation entre voyageurs et expéditeurs") }}</li>
                <li>{{ __("Communication interne via la messagerie") }}</li>
                <li>{{ __("Amélioration du service") }}</li>
            </ul>

            <p>
                <strong>{{ __("Base légale du traitement") }}</strong> :
                {{ __("consentement et exécution du contrat (article 6 du RGPD).") }}
            </p>

            <p>
                <strong>{{ __("Durée de conservation") }}</strong> :
                {{ __("les données sont conservées pendant la durée d'activité du compte, puis supprimées à la demande de l'utilisateur.") }}
            </p>

            <strong>{{ __("Droits des utilisateurs") }}</strong>

            <p>
                {{ __("Conformément au Règlement Général sur la Protection des Données (RGPD), vous disposez des droits suivants :") }}
            </p>

            <ul>
                <li>{{ __("Droit d'accès, de rectification et d'effacement") }}</li>
                <li>{{ __("Droit à la limitation et à l'opposition du traitement") }}</li>
                <li>{{ __("Droit à la portabilité de vos données.") }}</li>
            </ul>

            <p>
                {{ __("Vous pouvez exercer ces droits en nous contactant à : :email", ['email' => config('app.support.email')]) }}
            </p>

            <p>
                {{ __("Aucune donnée personnelle n'est vendue ni transmise à des tiers à des fins commerciales.") }}
            </p>

            <h2>{{ __("Conditions Générales d'Utilisation") }}</h2>

            <p>
                {{ __("Veuillez consulter nos conditions générales d'utilisation pour les termes et conditions régissant l'utilisation de notre plateforme.") }}
            </p>

            <h3>{{ __('Politique de Confidentialité') }}</h3>

            <p>
                {{ __("Veuillez consulter notre politique de confidentialité pour en savoir plus sur la manière dont nous collectons, utilisons et protégeons vos données personnelles.") }}
            </p>

            <h3>{{ __('Cookies') }}</h3>
            <p>
                {{ __("Le site Doniin utilise des cookies techniques nécessaires à son bon fonctionnement (authentification, sécurité, préférences utilisateur). Aucun cookie publicitaire ou de suivi externe n'est actuellement utilisé.") }}
            </p>

            <h3>{{ __('Responsabilité') }}</h3>

            <p>
                {{ __("L'équipe :app_name met tout en œuvre pour garantir l'exactitude des informations diffusées sur le site, mais ne saurait être tenue responsable des erreurs ou omissions éventuelles. L'utilisation du site se fait sous la seule responsabilité de l'utilisateur.", ['app_name' => config('app.name')]) }}
            </p>

            <h3>{{ __('Droit Applicable') }}</h3>
            <p>
                {{ __("Les présentes mentions légales sont régies par les lois françaises et tout litige relatif à l'interprétation ou à l'exécution de celles-ci relève de la compétence exclusive des tribunaux français.") }}
            </p>

            <h2>{{ __('Contact') }}</h2>
            <p>
                {{ __("Pour toute question concernant le site ou les mentions légales, veuillez nous écrire à :") }}
            </p>

            <p>
                📧
                {!! __("<span class='font-semibold'>Contact:</span> <a href='mailto::url'>:url</a>", ['url' => config('app.support.email')]) !!}
            </p>
        </div>

    </main>
@endsection