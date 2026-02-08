{{-- blade-formatter-disable --}}
@extends('layouts.app')

@section('title', __('Conditions Générales d\'Utilisation'))

@section('content')
    <main class="mx-auto max-w-4xl px-6 md:px-0 py-12 mb-12">
        <div class="border-b border-gray-300 pb-4">
            <h1 class="text-4xl font-bold tracking-wide text-gray-900">
                {{ __('Conditions Générales d\'Utilisation') }}
            </h1>

            <p class="mt-2 text-sm leading-7 text-gray-500">{{ __("Date de dernière mise à jour:") }} {{ date('D M Y') }}
            </p>
        </div>

        <div
            class="mt-4 prose-sm text-gray-900 text-base prose prose-gray prose-a:font-medium prose-a:text-blue-600 hover:prose-a:text-blue-700 max-w-3xl">
            <p>
                {{ __("Veuillez lire attentivement les conditions générales d'utilisation (CGU) suivantes avant d'utiliser notre plateforme de mise en relation entre voyageurs et expéditeurs de colis. En utilisant notre plateforme, vous acceptez les présentes CGU et vous vous engagez à les respecter. Si vous n'acceptez pas ces conditions, veuillez ne pas utiliser notre plateforme.") }}
            </p>

            <h2>1. {{ __('Description du Service') }}</h2>
            <p>
                {{ __("Notre plateforme permet aux utilisateurs de proposer des services de transport de colis et de rechercher des expéditeurs pour envoyer leurs colis à destination. Nous agissons uniquement en tant qu'intermédiaire entre les voyageurs et les expéditeurs et ne sommes pas responsables des transactions effectuées entre les utilisateurs.") }}
            </p>

            <h2>2. {{ __('Inscription') }}</h2>
            <p>
                {{ __("Pour utiliser certains services de notre plateforme, vous devez vous inscrire et créer un compte. Vous êtes responsable de maintenir la confidentialité de votre compte et de vos informations de connexion, et vous acceptez de ne pas partager votre compte avec d'autres personnes. Vous êtes entièrement responsable de toutes les activités qui se déroulent sous votre compte.") }}
            </p>

            <h2>3. {{ __('Réservation et paiement') }}</h2>
            <p>
                {{ __("Lorsque vous réservez un service de transport de colis sur notre plateforme, vous acceptez de payer le montant total de la réservation, y compris les frais de service applicables. Le paiement est effectué en ligne via notre passerelle de paiement sécurisée. Les réservations sont soumises à disponibilité et peuvent être soumises à des conditions supplémentaires spécifiques à chaque annonce.") }}
            </p>

            <h2>4. {{ __('Annulation et remboursement') }}</h2>
            <p>
                {{ __("Vous pouvez annuler une réservation conformément à notre politique d'annulation. Les annulations peuvent être soumises à des frais d'annulation et des conditions de remboursement spécifiques. Les annulations effectuées dans les délais spécifiés peuvent donner lieu à un remboursement automatique conformément à nos politiques.") }}
            </p>

            <h2>5. {{ __('Transaction financière') }}</h2>
            <p>
                {{ __("Nous ne sommes pas responsables des transactions financières établies en dehors de notre plateforme. Toutes les transactions financières, y compris les paiements pour les services de transport de colis, doivent être effectuées uniquement via notre passerelle de paiement sécurisée intégrée à la plateforme. Nous déclinons toute responsabilité en cas de transactions effectuées en dehors de notre plateforme, y compris les échanges d'informations financières et les paiements directs entre les utilisateurs. Nous recommandons aux utilisateurs de ne jamais partager d'informations financières sensibles en dehors de notre plateforme afin de garantir la sécurité et la protection des données.") }}
            </p>

            <h2>6. {{ __('Responsabilités des Utilisateurs') }}</h2>
            <p>
                {{ __("Les utilisateurs sont entièrement responsables du contenu qu'ils publient sur notre plateforme, y compris les annonces de colis et les messages de communication. Les utilisateurs acceptent de ne pas publier de contenu illégal, offensant, diffamatoire ou trompeur.") }}
            </p>

            <h2>7. {{ __('Modifications des Conditions Générales') }}</h2>
            <p>
                {{ __("Nous nous réservons le droit de modifier les présentes conditions générales à tout moment et sans préavis. Les modifications entrent en vigueur dès leur publication sur notre plateforme. Il est de votre responsabilité de consulter régulièrement les CGU pour rester informé des mises à jour.") }}
            </p>

            <h2>8. {{ __('Limitation de Responsabilité') }}</h2>
            <p>
                {{ __("Nous ne sommes pas responsables des dommages directs, indirects, accessoires, spéciaux ou consécutifs découlant de l'utilisation de notre plateforme ou de l'incapacité à utiliser notre plateforme.") }}
            </p>

            <h2>8. {{ __('Limitation de Responsabilité') }}</h2>
            <p>
                {{ __("Nous ne sommes pas responsables des dommages directs, indirects, accessoires, spéciaux ou consécutifs découlant de l'utilisation de notre plateforme ou de l'incapacité à utiliser notre plateforme.") }}
            </p>

            <h2>9. {{ __('Droit Applicable') }}</h2>
            <p>
                {!! __("Les présentes conditions générales sont régies par les lois en vigueur dans votre pays de résidence et tout litige découlant de ces conditions générales sera soumis à la juridiction exclusive des tribunaux compétents de votre pays. En utilisant notre plateforme, vous acceptez d'être lié par ces conditions générales d'utilisation. Si vous avez des questions concernant ces conditions, veuillez nous contacter à <a href=''>contact@donin.fr</a>") !!}
            </p>
        </div>
    </main>
@endsection