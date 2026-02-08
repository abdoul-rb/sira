{{-- blade-formatter-disable --}}
@extends('layouts.app')

@section('title', __('Politique de Confidentialité'))

@section('content')
    <section class="mx-auto max-w-4xl px-6 md:px-0 py-12 mb-12">
        <div class="border-b border-gray-300 pb-4">
            <h1 class="text-4xl font-bold tracking-wide text-gray-900">
                {{ __('Politique de Confidentialité') }}
            </h1>

            <p class="mt-2 text-sm leading-7 text-gray-500">Date de dernière mise à jour: {{ ucfirst(now()->translatedFormat('F Y')) }}</p>
        </div>

        <div
            class="mt-4 prose-sm text-gray-900 text-base prose prose-gray prose-a:font-medium prose-a:text-blue-600 hover:prose-a:text-blue-700 max-w-3xl">
            <p>
                {{ __('Chez :app_name, nous accordons une grande importance à la protection de vos données personnelles. Cette Politique de Confidentialité explique quelles données nous collectons, pourquoi nous les collectons et comment nous les utilisons.', ['app_name' => config('app.name')]) }}
            </p>
        
            <h2>{{ __("1. Qui sommes-nous ?") }}</h2>

            <p>{{ __("La plateforme Doniin est exploitée par [Nom de l'entreprise ou Nom personnel], dont le siège est situé à [Adresse], immatriculée sous le numéro [SIREN/SIRET].") }}</p>
            <p>{{ __("Nous sommes responsables du traitement de vos données personnelles.") }}</p>
            
            <h2>{{ __("2. Quelles données collectons-nous ?") }}</h2>

            <p>{{ __("Lorsque vous utilisez Doniin, nous collectons :") }}</p>

            <ul>
                <li>{{ __("Vos informations d'identité : prénom, nom, date de naissance.") }}</li>
                <li>{{ __("Vos informations de contact : adresse e-mail, numéro de téléphone.") }}</li>
                <li>{{ __("Vos informations de connexion : mot de passe (crypté), adresse IP.") }}</li>
                <li>{{ __("Vos documents d'identité (pour la vérification de compte).") }}</li>
                <li>{{ __("Vos données de paiement (via nos prestataires – nous ne stockons jamais vos numéros de carte bancaire).") }}</li>
                <li>{{ __("Les détails de vos publications (colis envoyés, trajets proposés).") }}</li>
                <li>{{ __("Votre historique d’utilisation de la plateforme.") }}</li>
            </ul>
            
            <h2>{{ __("3. Pourquoi collectons-nous vos données ?") }}</h2>

            <p>{{ __("Nous utilisons vos données pour :") }}</p>
            <ul>
                <li>{{ __("Permettre votre inscription et l'utilisation de la plateforme.") }}</li>
                <li>{{ __("Assurer la sécurité des échanges et la vérification d'identité.") }}</li>
                <li>{{ __("Faciliter les paiements et transactions.") }}</li>
                <li>{{ __("Améliorer nos services et votre expérience utilisateur.") }}</li>
                <li>{{ __("Vous envoyer des notifications liées au fonctionnement du service.") }}</li>
                <li>{{ __("Respecter nos obligations légales et lutter contre la fraude.") }}</li>
            </ul>
            
            <h2>{{ __("4. Partage de vos données") }}</h2>

            <p>{{ __("Vos données personnelles sont confidentielles. Elles peuvent être partagées uniquement avec :") }}</p>
            <ul>
                <li>{{ __("Nos prestataires de services (ex : Stripe pour les paiements, services d'hébergement sécurisés).") }}</li>
                <li>{{ __("Les utilisateurs avec qui vous entrez en contact via la plateforme (ex : lors de la prise en charge d'un colis).") }}</li>
                <li>{{ __("Les autorités compétentes en cas d'obligation légale.") }}</li>
            </ul>
            
            <h2>{{ __("5. Combien de temps conservons-nous vos données ?") }}</h2>

            <p>{{ __("Nous conservons vos données personnelles :") }}</p>
            <ul>
                <li>{{ __("Tant que votre compte est actif.") }}</li>
                <li>{{ __("Puis pendant [3 ans] maximum après la dernière activité pour répondre à nos obligations légales (ex : preuve en cas de litige).") }}</li>
            </ul>
            <p>{{ __("Vous pouvez demander la suppression de votre compte à tout moment.") }}</p>
            
            <h2>{{ __("6. Quels sont vos droits ?") }}</h2>

            <p>{{ __("Conformément au RGPD, vous disposez des droits suivants :") }}</p>
            <ul>
                <li>{{ __("Droit d'accès à vos données.") }}</li>
                <li>{{ __("Droit de rectification de vos informations personnelles.") }}</li>
                <li>{{ __("Droit d'effacement (\"droit à l'oubli\").") }}</li>
                <li>{{ __("Droit d'opposition au traitement.") }}</li>
                <li>{{ __("Droit à la portabilité de vos données.") }}</li>
            </ul>
            <p>{{ __("Pour exercer vos droits, contactez-nous à : support@doniin.com.") }}</p>
            
            <h2>{{ __("7. Sécurité") }}</h2>

            <p>{{ __("Nous mettons en œuvre toutes les mesures nécessaires pour protéger vos données :") }}</p>
            <ul>
                <li>{{ __("Connexions sécurisées (HTTPS).") }}</li>
                <li>{{ __("Stockage des mots de passe cryptés.") }}</li>
                <li>{{ __("Paiements gérés via Stripe (conforme PCI DSS).") }}</li>
            </ul>
            
            <h2>{{ __("8. Cookies") }}</h2>

            <p>{{ __("Notre plateforme utilise des cookies pour :") }}</p>
            <ul>
                <li>{{ __("Fonctionner correctement (cookies essentiels).") }}</li>
                <li>{{ __("Améliorer l'expérience utilisateur.") }}</li>
                <li>{{ __("Analyser le trafic.") }}</li>
            </ul>
            <p>{{ __("Vous pouvez paramétrer vos préférences de cookies directement depuis votre navigateur.") }}</p>
            
            <h2>{{ __("9. Modifications de cette politique") }}</h2>
            
            <p>{{ __("Nous nous réservons le droit de modifier cette Politique à tout moment.") }}</p>
            <p>{{ __("Vous serez informé(e) de toute mise à jour importante via l'application ou par email.") }}</p>  
        </div>
    </section>
@endsection
