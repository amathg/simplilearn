<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Commande confirmée</title>
  <style>
    body{margin:0;padding:0;background:#F5F5F0;font-family:'Helvetica Neue',Arial,sans-serif;color:#1A1A1A}
    .wrapper{max-width:600px;margin:2rem auto;background:#fff;border-radius:8px;overflow:hidden;box-shadow:0 4px 20px rgba(0,0,0,.08)}
    .header{background:#1A1A1A;padding:2rem 2.5rem;text-align:center}
    .header-logo{font-size:22px;font-weight:800;color:#F5B72E;margin-bottom:.25rem}
    .header-sub{font-size:12px;color:rgba(255,255,255,.4)}
    .check{width:64px;height:64px;background:#22C55E;border-radius:50%;margin:2rem auto 1rem;display:flex;align-items:center;justify-content:center}
    .check svg{width:32px;height:32px;fill:#fff}
    .body{padding:0 2.5rem 2rem}
    .title{font-size:22px;font-weight:800;text-align:center;margin-bottom:.5rem;color:#1A1A1A}
    .subtitle{font-size:14px;color:#888;text-align:center;margin-bottom:2rem;line-height:1.6}
    .card{background:#F9F9F7;border-radius:8px;padding:1.5rem;margin-bottom:1.5rem}
    .card-title{font-size:11px;text-transform:uppercase;letter-spacing:1px;color:#888;font-weight:700;margin-bottom:1rem}
    .row{display:flex;justify-content:space-between;padding:.5rem 0;border-bottom:1px solid #EEEEEA;font-size:14px}
    .row:last-child{border-bottom:none}
    .row-key{color:#888}
    .row-val{font-weight:600;text-align:right}
    .total-row{display:flex;justify-content:space-between;padding:.75rem 0;font-size:16px;font-weight:800}
    .total-val{color:#F5B72E}
    .items-table{width:100%;border-collapse:collapse;font-size:13px}
    .items-table th{text-align:left;padding:.5rem;font-size:10px;text-transform:uppercase;letter-spacing:.5px;color:#888;border-bottom:1px solid #EEEEEA}
    .items-table td{padding:.625rem .5rem;border-bottom:1px solid #F5F5F0;vertical-align:middle}
    .items-table tr:last-child td{border-bottom:none}
    .pay-box{background:#FFFBEB;border:1px solid #F5B72E;border-radius:8px;padding:1.25rem;margin-bottom:1.5rem;font-size:13px;line-height:1.6}
    .pay-box strong{display:block;margin-bottom:.375rem;font-size:14px}
    .btn{display:block;background:#F5B72E;color:#1A1A1A;text-decoration:none;padding:14px 28px;border-radius:8px;font-weight:700;font-size:14px;text-align:center;margin:0 auto 2rem;width:fit-content}
    .footer{background:#F5F5F0;padding:1.5rem 2.5rem;text-align:center;font-size:12px;color:#888;border-top:1px solid #EEEEEA}
    .footer a{color:#F5B72E;text-decoration:none}
  </style>
</head>
<body>
<div class="wrapper">
  <!-- HEADER -->
  <div class="header">
    <div class="header-logo">⬡ {{ $boutique->nom }}</div>
    <div class="header-sub">Votre boutique en ligne</div>
  </div>

  <!-- BODY -->
  <div class="body">
    <div style="text-align:center">
      <div class="check">
        <svg viewBox="0 0 24 24"><path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/></svg>
      </div>
    </div>

    <div class="title">Commande confirmée !</div>
    <div class="subtitle">
      Bonjour <strong>{{ $vente->client?->prenom }}</strong>,<br>
      Merci pour votre commande. Nous allons la traiter dans les plus brefs délais.
    </div>

    <!-- DÉTAILS COMMANDE -->
    <div class="card">
      <div class="card-title">Détails de la commande</div>
      <div class="row">
        <span class="row-key">Référence</span>
        <span class="row-val">{{ $vente->reference }}</span>
      </div>
      <div class="row">
        <span class="row-key">Date</span>
        <span class="row-val">{{ $vente->created_at->format('d/m/Y à H:i') }}</span>
      </div>
      <div class="row">
        <span class="row-key">Mode de paiement</span>
        <span class="row-val">{{ ucfirst(str_replace('_',' ',$vente->mode_paiement)) }}</span>
      </div>
      <div class="row">
        <span class="row-key">Statut</span>
        <span class="row-val" style="color:#F59E0B">En attente de traitement</span>
      </div>
    </div>

    <!-- ARTICLES -->
    @if($vente->lignes && $vente->lignes->count() > 0)
    <div class="card">
      <div class="card-title">Articles commandés</div>
      <table class="items-table">
        <thead>
          <tr>
            <th>Produit</th>
            <th style="text-align:center">Qté</th>
            <th style="text-align:right">Prix</th>
            <th style="text-align:right">Total</th>
          </tr>
        </thead>
        <tbody>
          @foreach($vente->lignes as $ligne)
          <tr>
            <td>{{ $ligne->nom_produit }}</td>
            <td style="text-align:center">{{ $ligne->quantite }}</td>
            <td style="text-align:right">{{ number_format($ligne->prix_unitaire,0,',',' ') }}</td>
            <td style="text-align:right;font-weight:700">{{ number_format($ligne->prix_unitaire * $ligne->quantite,0,',',' ') }}</td>
          </tr>
          @endforeach
        </tbody>
      </table>
      <div class="total-row">
        <span>Total</span>
        <span class="total-val">{{ number_format($vente->total_ttc,0,',',' ') }} {{ $boutique->devise }}</span>
      </div>
    </div>
    @endif

    <!-- INFO PAIEMENT -->
    @if($vente->mode_paiement === 'orange_money')
    <div class="pay-box">
      <strong>🟠 Instructions de paiement Orange Money</strong>
      Envoyez <strong>{{ number_format($vente->total_ttc,0,',',' ') }} {{ $boutique->devise }}</strong>
      au numéro Orange Money de la boutique et mentionnez la référence <strong>{{ $vente->reference }}</strong>.
    </div>
    @elseif($vente->mode_paiement === 'wero')
    <div class="pay-box">
      <strong>🟣 Instructions de paiement Wero</strong>
      Envoyez <strong>{{ number_format($vente->total_ttc,0,',',' ') }} {{ $boutique->devise }}</strong>
      via Wero et mentionnez la référence <strong>{{ $vente->reference }}</strong>.
    </div>
    @elseif($vente->mode_paiement === 'sur_place')
    <div class="pay-box">
      <strong>💵 Paiement à la livraison</strong>
      Vous réglerez <strong>{{ number_format($vente->total_ttc,0,',',' ') }} {{ $boutique->devise }}</strong>
      à la réception de votre commande. Référence : <strong>{{ $vente->reference }}</strong>.
    </div>
    @endif

    <a href="#" class="btn">Voir ma commande</a>
  </div>

  <!-- FOOTER -->
  <div class="footer">
    <p>© {{ date('Y') }} {{ $boutique->nom }}</p>
    @if($boutique->telephone)<p>📞 {{ $boutique->telephone }}</p>@endif
    @if($boutique->ville)<p>📍 {{ $boutique->ville }}</p>@endif
    <p style="margin-top:.5rem">Propulsé par <a href="#">BoutiqueConnect</a></p>
  </div>
</div>
</body>
</html>