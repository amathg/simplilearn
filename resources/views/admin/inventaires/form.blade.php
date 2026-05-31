@extends('layouts.admin')
@section('title', 'Nouvel inventaire')
@section('content')

<div class="page-header">
  <h1>Nouvel inventaire</h1>
  <a href="{{ route('admin.inventaires.index') }}" class="btn btn-sm" style="background:#F5F5F0;color:#666;border:.5px solid #DDD">
    <i class="ti ti-arrow-left"></i> Retour
  </a>
</div>

<div class="card" style="padding:1.5rem">
  <form method="POST" action="{{ route('admin.inventaires.store') }}">
    @csrf
    <table style="margin-bottom:1.5rem">
      <thead>
        <tr><th>Produit</th><th>Stock théorique</th><th>Stock réel</th><th>Écart</th></tr>
      </thead>
      <tbody>
        @foreach($produits as $p)
        <tr>
          <td><strong>{{ $p->nom }}</strong><br><span style="font-size:11px;color:#888">{{ $p->code_barres }}</span></td>
          <td><strong>{{ $p->stock?->quantite ?? 0 }}</strong></td>
          <td>
            <input type="number" name="produits[{{ $p->id }}]"
                   value="{{ $p->stock?->quantite ?? 0 }}"
                   min="0" style="width:80px;border:.5px solid #DDD;border-radius:4px;padding:5px 8px;font-size:13px"
                   onchange="updateEcart(this, {{ $p->stock?->quantite ?? 0 }})">
          </td>
          <td id="ecart-{{ $p->id }}" style="color:#888">0</td>
        </tr>
        @endforeach
      </tbody>
    </table>
    <button type="submit" class="btn btn-gold"><i class="ti ti-device-floppy"></i> Enregistrer l'inventaire</button>
  </form>
</div>

<script>
function updateEcart(input, theorique) {
    const reel  = parseInt(input.value) || 0;
    const ecart = reel - theorique;
    const pid   = input.name.match(/\[(\d+)\]/)[1];
    const el    = document.getElementById('ecart-' + pid);
    if (el) {
        el.textContent = (ecart >= 0 ? '+' : '') + ecart;
        el.style.color = ecart === 0 ? '#888' : (ecart > 0 ? '#22C55E' : '#EF4444');
    }
}
</script>
@endsection