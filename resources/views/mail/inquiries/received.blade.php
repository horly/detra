<!DOCTYPE html>
<html lang="fr">
<head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1"><title>Nouvelle demande DETRA</title></head>
<body style="margin:0;background:#f5f3ef;color:#252b2d;font-family:Arial,Helvetica,sans-serif;line-height:1.6">
<table role="presentation" width="100%" cellpadding="0" cellspacing="0"><tr><td style="padding:24px 12px">
<table role="presentation" cellpadding="0" cellspacing="0" style="width:100%;max-width:640px;margin:0 auto;background:#fff">
<tr><td style="padding:28px 32px;background:#252b2d;color:#fff;border-bottom:4px solid #b77548"><strong style="font-size:26px;letter-spacing:3px">DETRA SARL</strong><div style="color:#dedbd6">Nouvelle demande depuis le site web</div></td></tr>
<tr><td style="padding:28px 32px">
<p style="margin:0 0 8px;color:#a65d32;font-weight:bold">{{ $reference }}</p>
<h1 style="margin:0 0 24px;font-size:24px">{{ $service }}</h1>
<table cellpadding="0" cellspacing="0" width="100%" style="border-collapse:collapse;font-size:15px;text-align:left">
<tr><th scope="row" style="padding:8px 16px 8px 0;vertical-align:top">Nom</th><td style="padding:8px 0;overflow-wrap:anywhere">{{ $inquiry->name }}</td></tr>
<tr><th scope="row" style="padding:8px 16px 8px 0;vertical-align:top">Entreprise</th><td style="padding:8px 0;overflow-wrap:anywhere">{{ $inquiry->company ?: 'Non renseignée' }}</td></tr>
<tr><th scope="row" style="padding:8px 16px 8px 0;vertical-align:top">E-mail</th><td style="padding:8px 0;overflow-wrap:anywhere">{{ $inquiry->email }}</td></tr>
<tr><th scope="row" style="padding:8px 16px 8px 0;vertical-align:top">Téléphone</th><td style="padding:8px 0;overflow-wrap:anywhere">{{ $inquiry->phone ?: 'Non renseigné' }}</td></tr>
<tr><th scope="row" style="padding:8px 16px 8px 0;vertical-align:top">Langue du formulaire</th><td style="padding:8px 0">{{ $inquiry->locale === 'en' ? 'Anglais' : 'Français' }}</td></tr>
<tr><th scope="row" style="padding:8px 16px 8px 0;vertical-align:top">Date à Kinshasa</th><td style="padding:8px 0">{{ $inquiry->created_at->timezone('Africa/Kinshasa')->format('d/m/Y à H:i') }}</td></tr>
</table>
<h2 style="font-size:18px;margin:28px 0 12px">Le projet</h2>
<div style="padding:20px;background:#f5f3ef;border-left:3px solid #b77548;white-space:pre-wrap;overflow-wrap:anywhere">{{ $inquiry->message }}</div>
<p style="font-size:14px;color:#62696b;margin-top:24px">Utilisez « Répondre » dans votre messagerie pour contacter directement {{ $inquiry->name }}.</p>
</td></tr>
<tr><td style="padding:20px 32px;border-top:1px solid #e8e4df;font-size:12px;color:#62696b">DETRA SARL · Kinshasa, R.D. Congo<br>Le visiteur a accepté le traitement de ses informations pour cette demande.</td></tr>
</table>
</td></tr></table>
</body>
</html>
