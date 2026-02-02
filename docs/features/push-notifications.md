# Guide d'Implémentation PWA

## Résumé

Implémentation complète de la fonctionnalité Progressive Web App avec notifications push pour l'application Laravel Sira.

---

## Modifications Effectuées

### Packages Installés

- `ladumor/laravel-pwa` v0.0.5
- `laravel-notification-channels/webpush` v10.4.0 (compatible Laravel 12)

---

### Fichiers PWA Principaux

| Fichier | Description |
|---------|-------------|
| `public/manifest.json` | Manifeste de l'app avec icônes et paramètres d'affichage |
| `public/sw.js` | Service worker avec notifications push et support hors ligne |
| `public/offline.html` | Page de secours hors ligne avec style personnalisé |

---

### Layout & Composants

#### Modifié : `resources/views/layouts/base.blade.php`

Ajout des meta tags PWA, lien manifest et enregistrement du service worker :

```html
<!-- PWA Meta Tags -->
<meta name="theme-color" content="#14b8a6">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
<meta name="apple-mobile-web-app-title" content="{{ config('app.name') }}">

<!-- Manifest PWA -->
<link rel="manifest" href="/manifest.json">
<link rel="apple-touch-icon" href="/pwa-192x192.png">

<!-- Service Worker Registration -->
<script>
    if ('serviceWorker' in navigator) {
        navigator.serviceWorker.register('/sw.js')
            .then(reg => console.log('SW registered:', reg.scope))
            .catch(err => console.log('SW registration failed:', err));
    }
</script>

<!-- PWA Components -->
<x-pwa-install-prompt />
<x-push-notifications />
```

#### Nouveau : `resources/views/components/push-notifications.blade.php`

Composant Alpine.js pour l'inscription aux notifications push avec gestion des clés VAPID.

#### Nouveau : `resources/views/components/pwa-install-prompt.blade.php`

Invite d'installation PWA avec empreinte d'appareil et suivi des installations.

---

### Fichiers Backend

| Fichier | Description |
|---------|-------------|
| `app/Models/PwaInstallation.php` | Modèle avec détection de plateforme et statistiques |
| `app/Actions/CreatePwaInstallation.php` | Action pour créer les installations |
| `app/Http/Controllers/API/PwaInstallationController.php` | API pour le suivi |
| `app/Http/Controllers/API/PushSubscriptionController.php` | API pour les abonnements push |
| `app/Notifications/NewMessageNotification.php` | Exemple de notification push |

---

### Routes API

| Route | Description |
|-------|-------------|
| `POST /api/push-subscriptions` | Sauvegarder un abonnement push (auth requise) |
| `DELETE /api/push-subscriptions` | Supprimer un abonnement (auth requise) |
| `POST /api/pwa-installations` | Enregistrer une installation PWA |
| `POST /api/pwa-installations/check` | Vérifier si un appareil est enregistré |
| `GET /api/pwa-installations/stats` | Obtenir les statistiques (auth requise) |

---

### Administration Filament

| Fichier | Description |
|---------|-------------|
| `app/Filament/Resources/PwaInstallationResource.php` | Ressource pour gérer les installations |

Accessible à : `/admin/pwa-installations`

---

### Tests Créés

| Fichier | Tests |
|---------|-------|
| `tests/Feature/API/PwaInstallationApiTest.php` | Tests API (tracking, plateformes, doublons) |
| `tests/Feature/API/PushSubscriptionApiTest.php` | Tests abonnements push |
| `tests/Unit/Models/PwaInstallationTest.php` | Tests unitaires du modèle |
| `tests/Unit/Actions/CreatePwaInstallationTest.php` | Tests de l'action |

---

## Prochaines Étapes (Action Requise)

> **IMPORTANT**
> Vérifiez que les clés VAPID sont bien dans `.env` :
> ```bash
> php artisan webpush:vapid --show
> ```

Si les clés sont vides, régénérez-les :

```bash
php artisan webpush:vapid --force
```

### Test Manuel

1. **Test d'installation** : Ouvrir l'app dans Chrome, attendre ~2s pour l'invite
2. **Test notifications** : Se connecter, cliquer "Activer les notifications"
3. **Test Filament** : Aller à `/admin/pwa-installations`
4. **Test hors ligne** : Installer la PWA, couper internet, vérifier la page offline

### Envoyer des Notifications

```php
use App\Notifications\NewMessageNotification;

$user->notify(new NewMessageNotification(
    title: 'Nouveau message',
    body: 'Vous avez reçu un nouveau message',
    url: '/dashboard/messages'
));
```

### Lancer les Tests

```bash
php artisan test --filter=Pwa --filter=Push
```
