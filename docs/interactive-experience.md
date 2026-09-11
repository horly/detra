# Images et interactions

- Carrousel d’accueil : trois images, fondu et zoom, navigation par métier, boutons précédent/suivant et lecture/pause. Rotation toutes les sept secondes, suspendue au survol, au focus, hors écran, lorsque l’onglet est masqué ou en mode de réduction des mouvements. Une sélection manuelle arrête le défilement.
- Galerie d’accueil : liens directs vers les images sans JavaScript, agrandissement dans une boîte de dialogue avec JavaScript. Navigation par boutons ou flèches du clavier, fermeture par Échap et retour du focus.
- Catalogue : photographies sur les quatre familles de produits, filtres existants conservés.
- Contact rapide : appel téléphonique, e-mail, itinéraire et formulaire, disponibles sur chaque page. Ces liens n’envoient aucun message automatiquement.
- Pied de page corporate : invitation au contact, navigation et expertises, carte des coordonnées commerciales, liens FR/EN et retour en haut. Vérification des liens et du rendu à 320, 390, 768, 1024 et 1440 pixels dans les deux langues.
- Navigation corporate : coordonnées dans le bandeau supérieur, rubrique active mise en évidence, accès déroulant aux trois métiers, sélecteur FR/EN et bouton de contact. Menu mobile avec icônes et contacts directs ; fermeture avec Échap, au clic extérieur et lors d’un changement de taille, avec gestion du focus. Des liens restent accessibles sans JavaScript sur mobile.
- Chargement : logo DETRA et indicateur cuivre au chargement et à l’actualisation des pages. Présentation brève de 420 ms minimum, fondu de 240 ms, retrait automatique après 4,5 secondes si une ressource reste en attente. Le script critique fonctionne indépendamment du bundle applicatif. L’écran reste masqué sans JavaScript, respecte les mouvements réduits et se retire immédiatement au clavier ou au clic. La mention sous le logo de navigation a été supprimée.
- Bloc de contact : introduction commune, panneau commercial illustré, formulaire blanc organisé en deux groupes, icônes dans les champs et compteur de caractères. Le formulaire précède les coordonnées sur mobile. Le focus des erreurs et confirmations est appliqué après la navigation vers l’ancre de retour, pour que le navigateur ne l’annule pas.
- Google Maps : carte externe chargée à la demande du navigateur près du formulaire de l’accueil et de la page Contact, liens de recherche et d’itinéraire, copie de l’adresse avec confirmation.

Google Maps reconnaît actuellement le secteur de Ngaliema à partir de l’adresse fournie. Le point exact des bureaux n’est pas confirmé. Un lien Maps précis fourni par DETRA permettra de remplacer cette recherche par un repère vérifié. Aucun identifiant de lieu ou coordonnées géographiques n’a été inventé.

La page Confidentialité indique la présence du service externe Google Maps. Les demandes du formulaire restent enregistrées par le traitement Laravel existant.

La navigation et le bloc de contact ont été contrôlés à 320, 390, 768, 1024 et 1440 pixels en français et en anglais. La validation réelle du formulaire, le maintien des valeurs invalides, le focus des erreurs, le préremplissage produit, les préférences de mouvement réduit et les versions sans JavaScript ont également été vérifiés dans le navigateur isolé. Les essais de validation ne créent aucune demande en base.

Vérifications : suite Pest (56 tests, 259 assertions), Pint, compilation Vite ; contrôles dans un navigateur isolé en FR/EN à 390 et 1440 pixels pour le carrousel, la galerie, le clavier, les raccourcis, la copie de l’adresse, les filtres, les liens de carte, l’absence de débordement horizontal et les modes sans JavaScript / mouvements réduits. Chargement des tuiles Google Maps vérifié séparément.
