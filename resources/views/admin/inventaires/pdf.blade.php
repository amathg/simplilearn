<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<style>
  body { font-family: DejaVu Sans, sans-serif; font-size: 10px; color: #1A1A1A; }
  h1 { font-size: 18px; font-weight: 800; margin-bottom: 4px; }
  .subtitle { font-size: 11px; color: #888; margin-bottom: 16px; }
  .stats { display: flex; gap: 12px; margin-bottom: 16px; }
  .stat-box { border: 1px solid #E5E5E0; border-radius: 6px; padding: 8px 12px; text-align: center; flex: 1; }
  .stat-label { font-size: 9px; text-transform: uppercase; color: #888; margin-bottom: 3px; }
  .stat-value { font-size: 14px; font-weight: 800; }
  table { width: 100%; border-collapse: collapse; margin-top: 12px; }
  thead tr { background: #1A1A1A; color: #fff; }
  thead th { padding: 7px 8px; text-align: left; font-size: 9px; text-transform: uppercase; letter-spacing: .5px; }
  thead th.right { text-align: right; }
  tbody tr:nth-child(even) { background: #F9F9F6; }
  tbody tr.rupture { background: #FEF2F2; }
  tbody tr.alerte { background: #FFFBEB; }
  td { padding: 6px 8px; font-size: 9px; border-bottom: .5px solid #F0F0EB; }
  td.right { text-align: right; }
  tfoot td { font-weight: 800; background: #F0F0EB; padding: 7px 8px; font-size: 10px; }
  tfoot td.right { text-align: right; }
  .badge { display: inline-block; padding: 2px 6px; border-radius: 4px; font-size: 8px; font-weight: 700; }
  .badge-ok { background: #DCFCE7; color: #16A34A; }
  .badge-alerte { background: #FEF9C3; color: #CA8A04; }
  .badge-rupture { background: #FEE2E2; color: #DC2626; }
  .footer { margin-top: 20px; font-size: 9px; color: #aaa; text-align: center; border-top: .5px solid #E5E5E0; padding-top: 8px; }
</style>
</head>
<body>

<h1>Rapport d'inventaire — {{ $boutique->nom }}</h1>
<div class="subtitle">Généré le {{ now()->format('d/m/Y à H:i') }}</div>

<table style="width:100%;border-collapse:collapse;margin-bottom:16px">
  <tr>
    <td style="border:1px solid #E5E5E0;border-radius:6px;padding:8px 12px;text-align:center;width:16%">
      <div style="font-size:9px;color:#888;text-transform:uppercase;margin-bottom:3px">Produits</div>
      <div style="font-size:14px;font-weight:800">{{ $totalProduits }}</div>
      <div style="font-size:8px;color:#aaa">références</div>
    </td>
    <td style="border:1px solid #E5E5E0;padding:8px 12px;text-align:center;width:16%">
      <div style="font-size:9px;color:#888;text-transform:uppercase;margin-bottom:3px">Qté en stock</div>
      <div style="font-size:14px;font-weight:800">{{ number_format($totalQuantite,0,',',' ') }}</div>
      <div style="font-size:8px;color:#aaa">unités</div>
    </td>
    <td style="border:1px solid #E5E5E0;padding:8px 12px;text-align:center;width:16%">
      <div style="font-size:9px;color:#888;text-transform:uppercase;margin-bottom:3px">Valeur stock</div>
      <div style="font-size:13px;font-weight:800;color:#F5B72E">{{ number_format($valeurStock,0,',',' ') }}</div>
      <div style="font-size:8px;color:#aaa">prix achat</div>
    </td>
    <td style="border:1px solid #E5E5E0;padding:8px 12px;text-align:center;width:16%">
      <div style="font-size:9px;color:#888;text-transform:uppercase;margin-bottom:3px">Valeur vente</div>
      <div style="font-size:13px;font-weight:800;color:#22C55E">{{ number_format($valeurVente,0,',',' ') }}</div>
      <div style="font-size:8px;color:#aaa">prix vente</div>
    </td>
    <td style="border:1px solid #F59E0B;padding:8px 12px;text-align:center;width:16%">
      <div style="font-size:9px;color:#888;text-transform:uppercase;margin-bottom:3px">Alertes</div>
      <div style="font-size:14px;font-weight:800;color:#F59E0B">{{ $produitsAlertes }}</div>
      <div style="font-size:8px;color:#aaa">produits</div>
    </td>
    <td style="border:1px solid #EF4444;padding:8px 12px;text-align:center;width:16%">
      <div style="font-size:9px;color:#888;text-transform:uppercase;margin-bottom:3px">Ruptures</div>
      <div style="font-size:14px;font-weight:800;color:#EF4444">{{ $produitsRupture }}</div>
      <div style="font-size:8px;color:#aaa">produits</div>
    </td>
  </tr>
</table>

<table>
  <thead>
    <tr>
      <th>Produit</th>
      <th class="right">Stock actuel</th>
      <th class="right">Alerte</th>
      <th class="right">Prix achat</th>
      <th class="right">Prix vente</th>
      <th class="right">Valeur stock</th>
      <th class="right">Qté vendue</th>
      <th class="right">CA généré</th>
      <th style="text-align:center">État</th>
    </tr>
  </thead>
  <tbody>
    @foreach($statsParProduit as $p)
    @php
      $etat = $p['stock'] == 0 ? 'rupture' : ($p['stock'] <= $p['stock_alerte'] ? 'alerte' : 'ok');
    @endphp
    <tr class="{{ $etat }}">
      <td style="font-weight:600">{{ $p['nom'] }}</td>
      <td class="right" style="font-weight:700;color:{{ $etat==='rupture'?'#EF4444':($etat==='alerte'?'#F59E0B':'#1A1A1A') }}">
        {{ number_format($p['stock'],0,',',' ') }}
      </td>
      <td class="right" style="color:#888">{{ $p['stock_alerte'] }}</td>
      <td class="right">{{ number_format($p['prix_achat'],0,',',' ') }}</td>
      <td class="right">{{ number_format($p['prix_vente'],0,',',' ') }}</td>
      <td class="right" style="color:#F5B72E;font-weight:600">{{ number_format($p['valeur_stock'],0,',',' ') }}</td>
      <td class="right">{{ number_format($p['qte_vendue'],0,',',' ') }}</td>
      <td class="right" style="color:#22C55E;font-weight:700">{{ number_format($p['chiffre_affaire'],0,',',' ') }}</td>
      <td style="text-align:center">
        <span class="badge badge-{{ $etat }}">{{ $etat==='rupture'?'Rupture':($etat==='alerte'?'Alerte':'OK') }}</span>
      </td>
    </tr>
    @endforeach
  </tbody>
  <tfoot>
    <tr>
      <td>TOTAL</td>
      <td class="right">{{ number_format($totalQuantite,0,',',' ') }}</td>
      <td></td><td></td><td></td>
      <td class="right" style="color:#F5B72E">{{ number_format($valeurStock,0,',',' ') }}</td>
      <td class="right">{{ number_format($statsParProduit->sum('qte_vendue'),0,',',' ') }}</td>
      <td class="right" style="color:#22C55E">{{ number_format($statsParProduit->sum('chiffre_affaire'),0,',',' ') }}</td>
      <td></td>
    </tr>
  </tfoot>
</table>

<div class="footer">{{ $boutique->nom }} · Rapport généré automatiquement par BoutiqueConnect · {{ now()->format('d/m/Y à H:i') }}</div>
</body>
</html>
