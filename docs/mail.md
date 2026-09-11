# Notifications du formulaire de contact

Chaque demande valide est d'abord enregistrée en base, puis envoyée immédiatement à `sales@detradrc.com` avec Laravel Mail. Aucun worker de queue n'est nécessaire sur l'hébergement FTP actuel.

Le message contient la référence DTR, le service, les coordonnées, la langue du formulaire, la date à Kinshasa et le projet. Il existe en HTML et en texte brut. L'expéditeur reste la boîte DETRA authentifiée ; l'adresse du visiteur est placée dans `Reply-To` pour permettre une réponse directe. Le visiteur ne peut pas choisir le destinataire.

## SMTP LWS

Le 11 septembre 2026, les DNS du domaine indiquent `mail.detradrc.com` (`213.255.195.65`, nom inverse `mail93.lwspanel.com`). La connexion TLS à `mail.detradrc.com:465` a été vérifiée sans authentification et avec validation du certificat.

[LWS recommande le port 465 avec SSL/TLS et le mot de passe de la boîte mail](https://aide.lws.fr/base/Email/Adresses-mail--Premiers-pas/Quels-ports-utiliser-pour-la-configuration-dune-adresse-email). Les accès FTP et les accès à la boîte mail sont distincts.

Configuration des fichiers d'environnement privés : la boîte `tonymukash@detradrc.com` authentifie l'envoi, et `sales@detradrc.com` reçoit les demandes.

```dotenv
MAIL_MAILER=smtp
MAIL_SCHEME=smtps
MAIL_HOST=mail.detradrc.com
MAIL_PORT=465
MAIL_USERNAME=tonymukash@detradrc.com
MAIL_PASSWORD="MOT_DE_PASSE_DE_LA_BOITE_MAIL"
MAIL_TIMEOUT=15
MAIL_EHLO_DOMAIN=detradrc.com
MAIL_FROM_ADDRESS=tonymukash@detradrc.com
MAIL_FROM_NAME="DETRA SARL"
DETRA_INQUIRY_EMAIL=sales@detradrc.com
```

`MAIL_SCHEME=smtps` est la configuration prise en charge par la version Laravel/Symfony installée pour TLS dès la connexion. La validation du certificat reste active. Si le mot de passe contient des caractères spéciaux, conserver un encodage compatible avec les guillemets du fichier dotenv ; ne pas le placer dans une URL SMTP, le dépôt ou une ligne de commande.

En production, conserver les autres valeurs du `.env`, notamment la clé Laravel et le chemin de la base partagée. Mettre à jour le `.env` partagé et celui de la version active, puis régénérer le cache avec `php artisan config:cache`.

En développement, `MAIL_MAILER=log` écrit seulement le message dans le journal. Les tests utilisent le transport `array` ou des fakes et n'envoient pas de mail réel.

## Échecs et reprise

La migration `2026_09_11_074015_add_notification_sent_at_to_inquiries_table.php` ajoute une date nullable, sans modifier les demandes existantes. La date est renseignée après l'envoi réussi. En cas d'exception SMTP, la demande reste enregistrée, la confirmation d'enregistrement demeure affichée au visiteur, et le journal contient uniquement l'identifiant de la demande et la classe d'erreur, sans contenu du message ni identifiants SMTP.

Les demandes en attente peuvent être transmises depuis un terminal de l'hébergement, si disponible :

```sh
php artisan detra:inquiries:notify --limit=20
php artisan detra:inquiries:notify --id=42
```

La commande exige le transport SMTP et ignore les demandes déjà notifiées. Un verrou par demande évite deux tentatives simultanées. Elle permet aussi de transmettre les demandes reçues avant l'ajout des notifications. Aucun renvoi périodique n'est configuré automatiquement.

L'acceptation d'un message par SMTP ne garantit pas son placement dans la boîte de réception. Le test final de production doit contrôler l'acceptation SMTP, puis faire confirmer sa réception dans `sales@detradrc.com`.

## Activation du 11 septembre 2026

La version `20260911-01` est active sur `www.detradrc.com`. L'authentification TLS a réussi depuis l'hébergement LWS. La demande antérieure `DTR-000003` a été transmise, puis les formulaires français et anglais ont produit les notifications de test `DTR-000004` et `DTR-000005`, acceptées par le SMTP. L'utilisateur a confirmé la réception des deux e-mails dans `sales@detradrc.com`. Les deux lignes de test ont été supprimées de la base ; la demande réelle et sa date de notification ont été conservées. Aucune demande n'était en attente à la fin du contrôle.

La base, le point d'entrée et l'environnement précédents ont été sauvegardés dans `.detra/backups/20260911-01` avant migration. Les rapports HTTP et une copie privée de la configuration sont conservés localement dans `storage/app/previews/mail-deployment`, ignoré par Git.
