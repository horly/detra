DETRA SARL — Nouvelle demande depuis le site web

{{-- This view is used exclusively as text/plain; preserve the original text. --}}
Référence : {!! $reference !!}
Service : {!! $service !!}
Nom : {!! $inquiry->name !!}
Entreprise : {!! $inquiry->company ?: 'Non renseignée' !!}
E-mail : {!! $inquiry->email !!}
Téléphone : {!! $inquiry->phone ?: 'Non renseigné' !!}
Langue du formulaire : {{ $inquiry->locale === 'en' ? 'Anglais' : 'Français' }}
Date à Kinshasa : {{ $inquiry->created_at->timezone('Africa/Kinshasa')->format('d/m/Y à H:i') }}

LE PROJET
{!! $inquiry->message !!}

Utilisez « Répondre » dans votre messagerie pour contacter directement le visiteur.
Le visiteur a accepté le traitement de ses informations pour cette demande.
