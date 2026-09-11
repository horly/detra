# DETRA SARL

Site corporate Laravel 12 / Blade / Tailwind CSS 4, en français et en anglais, pour les services d’import-export d’hydrocarbures de DETRA à Kinshasa.

## Démarrer en local

Prérequis : PHP 8.2+, Composer, Node.js et npm. La configuration locale utilise SQLite.

```powershell
composer install
npm install
Copy-Item .env.example .env # uniquement si .env n’existe pas
php artisan key:generate # uniquement pour une nouvelle installation
php artisan migrate
npm run build
php artisan serve --host=127.0.0.1 --port=8000
```

- Français : http://localhost:8000/fr
- English : http://localhost:8000/en
- La racine `/` affiche l’accueil français, avec une URL canonique `/fr`.
- Pour modifier les styles en direct : `npm run dev` dans un second terminal.

## Pages et fonctionnalités

Accueil, À propos, Services, Produits, Engagements, Contact et Confidentialité. Les URL sont localisées et le sélecteur de langue conserve la page courante. Le site comprend une navigation mobile accessible au clavier, un catalogue filtrable, des liens préparant la demande selon le service ou le produit sélectionné, et des métadonnées canonical / hreflang / Open Graph.

Le formulaire partagé est disponible sur l’accueil et sur la page Contact. Depuis l’accueil, la confirmation et les erreurs reviennent à la section `#contact`, dans la langue choisie. Il valide les données côté serveur, conserve la langue et le consentement, enregistre une demande dans `inquiries`, puis affiche une référence. Il applique la protection CSRF, un champ anti-robot et une limite de cinq envois par minute et par adresse IP, commune aux deux pages et aux deux langues.

Les animations comprennent une entrée progressive du titre d’accueil, un léger mouvement de l’image au défilement sur ordinateur, des apparitions de sections et de cartes, des effets au survol, une ouverture animée du menu mobile et une barre de progression. Elles respectent `prefers-reduced-motion`. Le contenu et les formulaires restent disponibles sans JavaScript.

## Consulter les demandes

Depuis un accès serveur autorisé :

```powershell
php artisan detra:inquiries
php artisan detra:inquiries --limit=50
php artisan detra:inquiries --id=1
```

Les demandes ne sont pas exposées sur une route publique. Aucune notification par e-mail n’est envoyée dans cette version. Le formulaire enregistre les demandes en base ; la configuration d’un destinataire, d’un transport SMTP et des notifications constitue une évolution distincte.

## Personnaliser le contenu

- Textes : `lang/fr/site.php` et `lang/en/site.php`.
- Messages de validation français : `lang/fr/validation.php`.
- Implantation et URL : `config/site.php`.
- Coordonnées publiques dans `.env` : `DETRA_EMAIL`, `DETRA_PHONE`, `DETRA_ADDRESS`, `DETRA_WEBSITE`. Les coordonnées fournies par le client sont préconfigurées ; les valeurs volontairement laissées vides ne sont pas affichées. Exécuter `php artisan config:clear` après modification si la configuration était en cache.
- Vue générale : `resources/views/layouts/site.blade.php`.
- Pages : `resources/views/pages/`.
- Styles et interactions : `resources/css/app.css`, `resources/js/app.js`.

Le logo et les coordonnées proviennent des indications du client : 25c, Dr MANKOYI, Kinshasa – Ngaliema / R.D. Congo ; (+243) 999 964 546 ; sales@detradrc.com ; www.detradrc.com. Le domaine est affiché comme coordonnée publique ; l’adresse du serveur de développement reste locale. Le catalogue (gasoil, essence, fioul, lubrifiants) est indicatif et reste à confirmer, ainsi que les textes commerciaux et les conditions de traitement et de conservation des demandes avant publication.

## Visuels

Le logo fourni est conservé dans `public/images/detra-logo.png` et cadré en CSS. Les photographies industrielles sont des illustrations générées ; elles ne représentent pas une flotte ou des installations de DETRA. Les prompts et fichiers sources sont documentés dans `docs/visual-assets.md`.

Le site sert des versions WebP optimisées. Pour les régénérer avec PHP GD :

```powershell
php -d extension=gd scripts/optimize-images.php
```

La police Manrope est hébergée localement dans `resources/fonts/` et incluse dans le build, avec sa licence SIL OFL. Aucun service de police distant, outil publicitaire ou outil de suivi d’audience n’est requis au chargement.

## Vérification

```powershell
php artisan test --compact
php vendor/bin/pint --test
npm run build
```

La suite comporte 56 tests (259 assertions), dont les pages bilingues, les formulaires valides et invalides, les retours vers le formulaire d’accueil, l’échappement des champs, les paramètres de confiance, la confirmation et la limitation partagée des envois. Des vérifications locales de navigateur ont également couvert les affichages 390 px / 1440 px, le menu mobile, les filtres du catalogue, les animations au défilement, la réduction des mouvements et l’accès au contenu sans JavaScript. Les captures se trouvent dans `storage/app/previews/` (ignoré par Git).

## Hébergement

Configurer le serveur web pour servir exclusivement `public/`, renseigner l’URL et les variables de production, désactiver `APP_DEBUG`, exécuter les migrations puis générer le build. Prévoir les sauvegardes de la base contenant les demandes. Le site est actuellement préparé et lancé localement ; aucun déploiement public n’a été effectué.
