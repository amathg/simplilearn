<?php
namespace App\Mail;

use App\Models\Vente;
use App\Models\Boutique;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class CommandeConfirmationClient extends Mailable {
    use Queueable, SerializesModels;

    public Vente $vente;
    public Boutique $boutique;

    public function __construct(Vente $vente, Boutique $boutique) {
        $this->vente    = $vente;
        $this->boutique = $boutique;
    }

    public function envelope(): Envelope {
        return new Envelope(
            subject: "✅ Commande {$this->vente->reference} confirmée — {$this->boutique->nom}",
        );
    }

    public function content(): Content {
        return new Content(
            view: 'emails.commande-client',
        );
    }
}