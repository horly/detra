# Déploiement de production

Mise en ligne le 10 septembre 2026 sur **https://www.detradrc.com**, hébergement LWS. Les variantes HTTP et le domaine sans `www` redirigent vers cette adresse en HTTPS. Version active depuis le 11 septembre : `20260911-01`, avec les notifications SMTP des formulaires.

## Organisation sur le serveur

L'accès FTP fourni est limité à la racine Web `/htdocs`. Son répertoire parent n'est pas inscriptible. Les fichiers internes sont donc dans `.detra`, dont l'accès HTTP est interdit par son propre `.htaccess` et par celui de la racine. Cette protection a été vérifiée avant le transfert, puis sur la configuration, la base SQLite, les dépendances et l'archive.

| Emplacement | Contenu |
| --- | --- |
| `/htdocs/index.php` | Point d'entrée vers la version `20260911-01` |
| `/htdocs/.htaccess` | Redirections HTTPS, interdiction des chemins cachés, routage Laravel |
| `/htdocs/build`, `/htdocs/images` | Assets Vite et images WebP |
| `/htdocs/.detra/releases/20260911-01` | Application Laravel et dépendances Composer de production |
| `/htdocs/.detra/releases/20260910-01` | Version précédente conservée pour retour arrière |
| `/htdocs/.detra/shared/.env` | Configuration de production et clé de chiffrement |
| `/htdocs/.detra/shared/database.sqlite` | Base persistante : demandes, sessions et cache |
| `/htdocs/.detra/backups/20260910-01` | Page d'attente précédente et sauvegarde initiale cohérente de la base |
| `/htdocs/.detra/backups/20260911-01` | Base avant migration SMTP, configuration et point d'entrée précédents |

Le `.env` partagé a également été copié dans la version active. Le point d'entrée de production fixe le chemin public à `/htdocs`. Le projet local conserve son point d'entrée Laravel standard.

Le numéro public a été remplacé par `+243 818 822 223` le 11 septembre 2026, dans la configuration, les fichiers d'environnement et le cache de la version active. Les liens `tel:+243818822223` ont été vérifiés sur les accueils et les pages Contact français et anglais. La configuration précédente est sauvegardée dans `.detra/backups/phone-20260911-7087228e72a5591e`.

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

Les demandes sont enregistrées en base puis notifiées par SMTP vers `sales@detradrc.com`. L'authentification et l'expéditeur utilisent `tonymukash@detradrc.com`, sur `mail.detradrc.com:465` avec `MAIL_SCHEME=smtps`. L'adresse du visiteur est utilisée comme adresse de réponse. Les mots de passe restent dans les fichiers d'environnement privés. Voir [mail.md](mail.md) pour la configuration et la reprise des demandes en attente.

La commande `php artisan detra:inquiries` permet de consulter les demandes depuis un terminal de l'hébergement, si disponible, en se plaçant dans la version active. Aucun accès SSH n'a été fourni ni configuré pendant ce déploiement.

Pour une prochaine version, préserver la clé de production et `.detra/shared/database.sqlite`, effectuer une sauvegarde cohérente de la base, préparer un nouveau dossier de version, exécuter ses migrations et caches sur le serveur, puis basculer le point d'entrée. Les caches de configuration générés localement ne doivent pas être transférés. Les sauvegardes décrites ici ont été réalisées lors des déploiements ; aucune sauvegarde périodique n'a été configurée.
