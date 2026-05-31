<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Nouvelle commande</title>
  <style>
    body{margin:0;padding:0;background:#F5F5F0;font-family:'Helvetica Neue',Arial,sans-serif;color:#1A1A1A}
    .wrapper{max-width:600px;margin:2rem auto;background:#fff;border-radius:8px;overflow:hidden;box-shadow:0 4px 20px rgba(0,0,0,.08)}
    .header{background:#1A1A1A;padding:2rem 2.5rem;display:flex;align-items:center;justify-content:space-between}
    .header-logo{font-size:20px;font-weight:800;color:#F5B72E}
    .header-badge{background:#22C55E;color:#fff;font-size:11px;font-weight:700;padding:4px 12px;border-radius:50px}
    .body{padding:1.5rem 2.5rem 2rem}
    .alert{background:#F0FDF4;border:1px solid #BBF7D0;border-radius:8px;padding:1.25rem 1.5rem;margin-bottom:1.5rem;display:flex;align-items:center;gap:1rem}
    .alert-icon{font-size:28px;flex-shrink:0}
    .alert-text{font-size:14px;line-height:1.5}
    .alert-text strong{font-size:16px;display:block;margin-bottom:.25rem}
    .card{background:#F9F9F7;border-radius:8px;padding:1.5rem;margin-bottom:1.25rem}
    .card-title{font-size:11px;text-transform:uppercase;letter-spacing:1px;color:#888;font-weight:700;margin-bottom:1rem}
    .row{display:flex;justify-content:space-between;padding:.5rem 0;border-bottom:1px solid #EEEEEA;font-size:13px}
    .row:last-child{border-bottom:none}
    .row-key{color:#888}
    .row-val{font-weight:600;text-align:right}
    .items-table{width:100%;border-collapse:collapse;font-size:13px}
    .items-table th{text-align:left;padding:.5rem;font-size:10px;text-transform:uppercase;letter-spacing:.5px;color:#888;border-bottom:1px solid #EEEEEA}
    .items-table td{padding:.625rem .5rem;border-bottom:1px solid #F5F5F0;vertical-align:middle}
    .items-table tr:last-child td{border-bottom:none}
    .total-row{display:flex;justify-content:space-between;padding:.75rem 0;font-size:16px;font-weight:800;border-top:2px solid #1A1A1A;margin-top:.5rem}
    .total-val{color:#F5B72E}
    .btn{display:block;background:#F5B72E;color:#1A1A1A;text-decoration:none;padding:14px 28px;border-radius:8px;font-weight:700;font-size:14px;text-align:center;margin:1.5rem auto 0;width:fit-content}
    .footer{background:#F5F5F0;padding:1.25rem 2.5rem;text-align:center;font-size:12px;color:#888;border-top:1px solid #EEEEEA}
  </style>
</head>
<body>
<div class="wrapper">
  <!-- HEADER -->
  <div class="header">
    <div class="header-logo">⬡ {{ $boutique->nom }}</div>
    <div class="header-badge">🛒 Nouvelle commande</div>
  </div>

  <!-- BODY -->
  <div class="body">
    <!-- ALERTE -->
    <div class="alert">
      <div class="alert-icon">🎉</div>
      <div class="alert-text">
        <strong>Nouvelle commande reçue !</strong>
        <strong>{{ $vente->client?->prenom }} {{ $vente->client?->nom }}</strong>
        vient de passer une commande de
        <strong style="color:#F5B72E">{{ number_format($vente->total_ttc,0,',',' ') }} {{ $boutique->devise }}</strong>.
      </div>
    </div>

    <!-- INFOS CLIENT -->
    <div class="card">
      <div class="card-title">Informations client</div>
      <div class="row">
        <span class="row-key">Nom</span>
        <span class="row-val">{{ $vente->client?->prenom }} {{ $vente->client?->nom }}</span>
      </div>
      <div class="row">
        <span class="row-key">Email</span>
        <span class="row-val">{{ $vente->client?->email }}</span>
      </div>
      @if($vente->client?->telephone)
      <div class="row">
        <span class="row-key">Téléphone</span>
        <span class="row-val">{{ $vente->client->telephone }}</span>
      </div>
      @endif
      @if($vente->client?->adresse)
      <div class="row">
        <span class="row-key">Adresse</span>
        <span class="row-val">{{ $vente->client->adresse }}</span>
      </div>
      @endif
    </div>

    <!-- DÉTAILS COMMANDE -->
    <div class="card">
      <div class="card-title">Détails de la commande</div>
      <div class="row">
        <span class="row-key">Référence</span>
        <span class="row-val" style="color:#F5B72E;font-family:monospace">{{ $vente->reference }}</span>
      </div>
      <div class="row">
        <span class="row-key">Date</span>
        <span class="row-val">{{ $vente->created_at->format('d/m/Y à H:i') }}</span>
      </div>
      <div class="row">
        <span class="row-key">Canal</span>
        <span class="row-val">Boutique en ligne</span>
      </div>
      <div class="row">
        <span class="row-key">Paiement</span>
        <span class="row-val">{{ ucfirst(str_replace('_',' ',$vente->mode_paiement)) }}</span>
      </div>
      @if($vente->notes)
      <div class="row">
        <span class="row-key">Notes</span>
        <span class="row-val">{{ $vente->notes }}</span>
      </div>
      @endif
    </div>

    <!-- ARTICLES -->
    @if($vente->lignes && $vente->lignes->count() > 0)
    <div class="card">
      <div class="card-title">Articles commandés ({{ $vente->lignes->count() }})</div>
      <table class="items-table">
        <thead>
          <tr>
            <th>Produit</th>
            <th style="text-align:center">Qté</th>
            <th style="text-align:right">Prix unit.</th>
            <th style="text-align:right">Total</th>
          </tr>
        </thead>
        <tbody>
          @foreach($vente->lignes as $ligne)
          <tr>
            <td><strong>{{ $ligne->nom_produit }}</strong></td>
            <td style="text-align:center">{{ $ligne->quantite }}</td>
            <td style="text-align:right">{{ number_format($ligne->prix_unitaire,0,',',' ') }} {{ $boutique->devise }}</td>
            <td style="text-align:right;font-weight:700;color:#F5B72E">{{ number_format($ligne->prix_unitaire * $ligne->quantite,0,',',' ') }} {{ $boutique->devise }}</td>
          </tr>
          @endforeach
        </tbody>
      </table>
      <div class="total-row">
        <span>TOTAL À ENCAISSER</span>
        <span class="total-val">{{ number_format($vente->total_ttc,0,',',' ') }} {{ $boutique->devise }}</span>
      </div>
    </div>
    @endif

    <a href="#" class="btn">Voir dans l'admin →</a>
  </div>

  <!-- FOOTER -->
  <div class="footer">
    <p>Notification automatique — {{ $boutique->nom }}</p>
    <p>© {{ date('Y') }} BoutiqueConnect</p>
  </div>
</div>
</body>
</html>