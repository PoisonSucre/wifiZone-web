<?php

namespace App\Http\Livewire\Vendor;

use App\Models\Hotspot;
use Livewire\Component;

class WalledGardenModal extends Component
{
    public bool $show = false;
    public ?int $hotspotId = null;
    public ?string $hotspotName = '';
    public ?string $mikrotikUrl = '';
    public string $config = '';

    protected $listeners = [
        'open-walled-garden' => 'open',
    ];

    public function open(int $hotspotId): void
    {
        $hotspot = Hotspot::where('id', $hotspotId)->where('vendeur_id', auth()->id())->first();
        if (!$hotspot) {
            $this->dispatch('toast', type: 'error', message: 'Hotspot introuvable.');
            return;
        }

        $this->hotspotId = $hotspot->id;
        $this->hotspotName = $hotspot->name;
        $this->mikrotikUrl = $hotspot->mikrotik_url ?? '';
        $this->config = $this->generateConfig();
        $this->show = true;
    }

    public function close(): void
    {
        $this->show = false;
        $this->hotspotId = null;
        $this->hotspotName = '';
        $this->mikrotikUrl = '';
        $this->config = '';
    }

    private function generateConfig(): string
    {
        $platformUrl = parse_url(config('app.url'), PHP_URL_HOST) ?? 'localhost';
        $platformIp = gethostbyname($platformUrl);
        if ($platformIp === $platformUrl) {
            $platformIp = 'VOTRE_IP_SERVEUR';
        }

        $paymentUrl = config('app.url');
        $vendeurId = auth()->id();
        $hotspotId = $this->hotspotId;
        $hotspotName = $this->hotspotName;
        $dateGen = date('d/m/Y H:i');
        $shopLink = $paymentUrl . '/shop/' . $vendeurId . ($hotspotId ? '?hotspot=' . $hotspotId : '');

        return <<<MIKROTIK
# ============================================================
#  CONFIGURATION WALLED GARDEN - MIKROTIK
#  Hotspot : {$hotspotName}
#  Généré le : {$dateGen}
# ============================================================
#
# Le Walled Garden permet aux clients non authentifiés d'accéder
# à la plateforme de paiement sans être connectés à Internet.
# Le client paie en ligne via LigdiCash, reçoit ses identifiants,
# puis se connecte au portail MikroTik.
#
# --- INSTALLATION ---
# Copiez-collez les commandes ci-dessous dans le Terminal MikroTik
# (Winbox → New Terminal)
# ============================================================

# --- 1. Accès à la plateforme de paiement ---
/ip hotspot walled-garden
add dst-host={$platformUrl} comment="Plateforme"
add dst-host="*.{$platformUrl}" comment="Sous-domaines plateforme"
add dst-address={$platformIp} comment="IP plateforme"

# --- 2. Accès à LigdiCash (passerelle de paiement) ---
add dst-host=ligdicash.com comment="LigdiCash"
add dst-host=*.ligdicash.com comment="LigdiCash sous-domaines"

# --- 3. Ressources nécessaires (CSS, icônes) ---
add dst-host=cdnjs.cloudflare.com comment="FontAwesome / CDN"

# --- 4. ngrok (si la plateforme utilise ngrok) ---
add dst-host=ngrok-free.app comment="ngrok"
add dst-host=*.ngrok-free.app comment="ngrok sous-domaines"

# --- Lien de paiement de votre boutique ---
# {$shopLink}
MIKROTIK;
    }

    public function render()
    {
        return view('livewire.vendor.walled-garden-modal');
    }
}
