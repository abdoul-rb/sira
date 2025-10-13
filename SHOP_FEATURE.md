# Fonctionnalité de Gestion de Boutique

## Vue d'ensemble

Cette fonctionnalité permet aux entreprises de gérer les informations de leur boutique en ligne directement depuis la page des produits.

## Composants créés

### 1. Composant Livewire `Edit` (`app/Livewire/Dashboard/Shop/Edit.php`)

**Fonctionnalités :**
- Création et modification des informations de boutique
- Upload et gestion du logo de la boutique
- Validation des champs (nom requis, URLs valides)
- Gestion des réseaux sociaux (Facebook, Instagram)
- Statut actif/inactif

**Champs gérés :**
- `name` : Nom de la boutique (requis)
- `description` : Description de la boutique
- `facebook_url` : Lien vers la page Facebook
- `instagram_url` : Lien vers le compte Instagram
- `logo_path` : Logo de la boutique
- `active` : Statut de la boutique

### 2. Vue Blade (`resources/views/livewire/dashboard/shop/edit.blade.php`)

**Interface :**
- Zone d'upload de logo avec prévisualisation
- Formulaire responsive avec validation en temps réel
- Boutons d'action (Annuler/Enregistrer)
- Gestion des erreurs de validation

### 3. Modal (`resources/views/components/ui/modals/edit-shop-modal.blade.php`)

**Caractéristiques :**
- Taille moyenne (lg)
- Titre dynamique
- Intégration du composant Livewire

## Utilisation

### 1. Accès à la fonctionnalité

Sur la page des produits (`/dashboard/products`), cliquez sur l'icône d'édition à côté du nom de la boutique.

### 2. Création d'une boutique

Si aucune boutique n'existe :
- Remplissez le formulaire avec les informations de base
- Ajoutez un logo (optionnel)
- Sauvegardez

### 3. Modification d'une boutique existante

Si une boutique existe déjà :
- Les informations actuelles sont pré-remplies
- Modifiez les champs souhaités
- Changez le logo si nécessaire
- Sauvegardez les modifications

## Structure de la base de données

### Table `shops`

```sql
- id (clé primaire)
- company_id (clé étrangère vers companies)
- name (nom de la boutique)
- slug (URL personnalisée)
- logo_path (chemin vers le logo)
- description (description de la boutique)
- facebook_url (lien Facebook)
- instagram_url (lien Instagram)
- active (statut actif/inactif)
- timestamps
```

## Gestion des fichiers

### Stockage des logos

- **Chemin :** `storage/app/public/{company_id}/shop/`
- **Format accepté :** Images (jpg, png, gif, etc.)
- **Taille maximale :** 1MB
- **Nettoyage :** L'ancien logo est automatiquement supprimé lors du remplacement

## Événements Livewire

### Événements émis

- `close-modal` : Ferme la modal après sauvegarde
- `shop-updated` : Notifie la mise à jour des informations de la boutique

### Événements écoutés

- `product-created` : Rafraîchit la liste des produits
- `shop-updated` : Rafraîchit l'affichage des informations de la boutique

## Tests

### Fichier de test

`tests/Feature/Livewire/ShopEditTest.php`

**Tests couverts :**
- Création d'une nouvelle boutique
- Validation des champs requis
- Sauvegarde des données

## Sécurité

### Validation

- Tous les champs sont validés côté serveur
- Les URLs des réseaux sociaux sont validées
- La taille et le type des images sont contrôlés

### Autorisations

- Seuls les utilisateurs connectés peuvent accéder à la fonctionnalité
- La relation `company_id` assure l'isolation des données

## Améliorations futures possibles

1. **Gestion des images multiples** : Support de plusieurs images pour la boutique
2. **Thèmes personnalisables** : Choix de couleurs et de styles
3. **Intégration des réseaux sociaux** : Prévisualisation des posts
4. **Analytics** : Statistiques de visite de la boutique
5. **SEO** : Gestion des meta-tags et descriptions
