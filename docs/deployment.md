# Déploiement de production

Mise en ligne le 10 septembre 2026 sur **https://www.detradrc.com**, hébergement LWS. Les variantes HTTP et le domaine sans `www` redirigent vers cette adresse en HTTPS.

## Organisation sur le serveur

L'accès FTP fourni est limité à la racine Web `/htdocs`. Son répertoire parent n'est pas inscriptible. Les fichiers internes sont donc dans `.detra`, dont l'accès HTTP est interdit par son propre `.htaccess` et par celui de la racine. Cette protection a été vérifiée avant le transfert, puis sur la configuration, la base SQLite, les dépendances et l'archive.

| Emplacement | Contenu |
| --- | --- |
| `/htdocs/index.php` | Point d'entrée vers la version `20260910-01` |
| `/htdocs/.htaccess` | Redirections HTTPS, interdiction des chemins cachés, routage Laravel |
| `/htdocs/build`, `/htdocs/images` | Assets Vite et images WebP |
| `/htdocs/.detra/releases/20260910-01` | Application Laravel et dépendances Composer de production |
| `/htdocs/.detra/shared/.env` | Configuration de production et clé de chiffrement |
| `/htdocs/.detra/shared/database.sqlite` | Base persistante : demandes, sessions et cache |
| `/htdocs/.detra/backups/20260910-01` | Page d'attente précédente et sauvegarde initiale cohérente de la base |

Le `.env` partagé a également été copié dans la version active. Le point d'entrée de production fixe le chemin public à `/htdocs`. Le projet local conserve son point d'entrée Laravel standard.

## Configuration et compilation

- PHP serveur : 8.5.10, avec `pdo_sqlite`, `mbstring`, `openssl`, `zip` et les autres extensions nécessaires.
- `APP_ENV=production`, `APP_DEBUG=false`, `APP_URL=https://www.detradrc.com` ; nouvelle clé générée pour la production.
- Sessions chiffrées, cookies `Secure`, `HttpOnly` et `SameSite=Lax`.
- Installation depuis `composer.lock`, sans dépendances de développement, autoload optimisé.
- Assets compilés avec `npm run build` ; fichiers PNG originaux et base locale exclus du paquet.
- `package:discover`, `migrate --force`, `config:cache`, `route:cache`, `view:cache` et `event:cache` exécutés sur le serveur.
- Transfert FTPS avec vérification TLS : certificat LWS `*.lwspanel.com`, nom TLS `ftp.lwspanel.com` résolu explicitement vers l'IP fournie `193.203.239.74`.

L'installation initiale a utilisé un outil PHP temporaire : jeton aléatoire obligatoire dans un en-tête HTTPS, expiration, actions fixes et contrôle SHA-256 du paquet. Il a été supprimé à la fin de l'installation, ainsi que l'archive de transfert et les marqueurs de contrôle.

## Vérifications

- 56 tests Laravel, 259 assertions ; aucun avis de vulnérabilité signalé par `composer audit --no-dev --locked`.
- 15 pages FR/EN et 10 assets contrôlés en HTTP, redirections et chemins privés vérifiés.
- Envoi réel depuis l'accueil français et la page contact anglaise : confirmation affichée et données retrouvées en base. Seules les deux demandes techniques identifiées ont ensuite été supprimées.
- POST sans jeton CSRF refusé avec le statut 419.
- Contrôles Chrome à 390 et 1440 pixels, en français et en anglais : menu, clavier, chargement du logo après actualisation, formulaire, présence de la carte et absence de débordement horizontal.

Les rapports et captures locaux se trouvent dans `storage/app/previews/deployment`, répertoire ignoré par Git. Il contient également une sauvegarde de la configuration de production et de la base : ces fichiers sont confidentiels et ne doivent pas être publiés.

## Exploitation

Les demandes de contact sont enregistrées en base. **Aucune notification e-mail automatique n'est encore implémentée** ; `MAIL_MAILER=log`. Le lien `sales@detradrc.com` reste un lien vers la messagerie du visiteur.

La commande `php artisan detra:inquiries` permet de consulter les demandes depuis un terminal de l'hébergement, si disponible, en se plaçant dans la version active. Aucun accès SSH n'a été fourni ni configuré pendant ce déploiement.

Pour une prochaine version, préserver la clé de production et `.detra/shared/database.sqlite`, effectuer une sauvegarde cohérente de la base, préparer un nouveau dossier de version, exécuter ses migrations et caches sur le serveur, puis basculer le point d'entrée. Les caches de configuration générés localement ne doivent pas être transférés. La sauvegarde décrite ici est une sauvegarde initiale ; aucune sauvegarde périodique n'a été configurée.
