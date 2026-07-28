<?php

namespace App\Http\Controllers;

use App\Models\Forfait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use ZipArchive;

class TemplateDownloadController extends Controller
{
    public function download(Request $request)
    {
        $vendeur = auth()->user();
        $forfaits = Forfait::where('vendeur_id', $vendeur->id)->orderBy('ordre')->get();
        $appUrl = config('app.url');
        $couleur = $vendeur->couleur ?? '#1ca04e';

        $tmpDir = sys_get_temp_dir() . '/template_' . $vendeur->id;
        if (!is_dir($tmpDir)) {
            mkdir($tmpDir, 0755, true);
        }

        $this->generateLoginHtml($tmpDir, $vendeur, $forfaits, $appUrl, $couleur);
        $this->copyAsset($tmpDir, 'style.css');
        $this->copyAsset($tmpDir, 'orange.png');
        $this->copyAsset($tmpDir, 'moov.png');
        $this->copyAsset($tmpDir, 'wave.png');

        if ($vendeur->logo && file_exists(public_path($vendeur->logo))) {
            $ext = pathinfo($vendeur->logo, PATHINFO_EXTENSION);
            copy(public_path($vendeur->logo), $tmpDir . '/logo.' . $ext);
        }

        $zipPath = sys_get_temp_dir() . '/mikrotik_portail_' . $vendeur->id . '.zip';
        $zip = new ZipArchive();
        if ($zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== true) {
            return back()->with('error', 'Impossible de créer le fichier ZIP.');
        }

        $files = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($tmpDir, \RecursiveDirectoryIterator::SKIP_DOTS)
        );
        foreach ($files as $file) {
            $relativePath = substr($file->getRealPath(), strlen($tmpDir) + 1);
            $zip->addFile($file->getRealPath(), $relativePath);
        }
        $zip->close();

        $this->cleanupDir($tmpDir);

        return response()->download($zipPath, 'mikrotik_portail.zip')->deleteFileAfterSend(true);
    }

    private function generateLoginHtml(string $tmpDir, $vendeur, $forfaits, string $appUrl, string $couleur): void
    {
        $templatePath = resource_path('views/shop/template/login.html');
        $html = file_get_contents($templatePath);

        $html = str_replace(
            ['https://51eb-102-180-122-130.ngrok-free.app'],
            $appUrl,
            $html
        );

        $html = str_replace(
            ['https://laksa19.github.io/myqr', 'https://51eb-102-180-122-130.ngrok-free.app/recuperer_ticket.php'],
            $appUrl . '/recuperer-ticket',
            $html
        );

        $html = str_replace(
            ['/payment_process.php', 'payment_process.php'],
            '/api/payment-process',
            $html
        );

        $html = str_replace('Bonne Année 2025', e($vendeur->prenom ?? '') . ' ' . e($vendeur->nom ?? ''), $html);
        $html = str_replace(
            '66-63-59-58 / 64-65-86-44',
            e($vendeur->telephone ?? ''),
            $html
        );
        $html = str_replace('content="#3B5998"', 'content="' . e($couleur) . '"', $html);
        $html = str_replace('#1ca04e', $couleur, $html);

        $forfaitRows = '';
        foreach ($forfaits as $f) {
            $forfaitRows .= "<tr>\n";
            $forfaitRows .= "  <td>" . e($f->label) . "</td>\n";
            $forfaitRows .= "  <td>" . number_format($f->montant, 0, ',', ' ') . " FCFA</td>\n";
            $forfaitRows .= "  <td>\n";
            $forfaitRows .= "    <form action=\"" . $appUrl . "/api/payment-process\" method=\"POST\" target=\"_blank\">\n";
            $forfaitRows .= "      <input type=\"hidden\" name=\"montant\" value=\"" . e($f->montant) . "\" />\n";
            $forfaitRows .= "      <input type=\"hidden\" name=\"forfait\" value=\"" . e($f->label) . "\" />\n";
            $forfaitRows .= "      <input type=\"hidden\" name=\"vendeur_id\" value=\"" . e($vendeur->id) . "\" />\n";
            $forfaitRows .= "      <input type=\"hidden\" name=\"order_id\" value=\"order_" . e($f->id) . "\" />\n";
            $forfaitRows .= "      <button type=\"submit\" class=\"pay-button\"><i class=\"fas fa-credit-card\" style=\"margin-right:5px\"></i> Payer</button>\n";
            $forfaitRows .= "    </form>\n";
            $forfaitRows .= "  </td>\n";
            $forfaitRows .= "</tr>\n";
        }

        $pattern = '/<tr>\s*<td>1 Heure<\/td>.*?<\/tr>(.*?)<\/table>/s';
        $replacement = $forfaitRows . '</table>';
        $html = preg_replace($pattern, $replacement, $html);

        if ($vendeur->logo && file_exists(public_path($vendeur->logo))) {
            $ext = pathinfo($vendeur->logo, PATHINFO_EXTENSION);
            $html = str_replace('href="style.css"', 'href="style.css" /><link rel="icon" href="logo.' . $ext . '"', $html);
        }

        file_put_contents($tmpDir . '/login.html', $html);
    }

    private function copyAsset(string $tmpDir, string $filename): void
    {
        $source = resource_path('views/shop/template/' . $filename);
        if (file_exists($source)) {
            copy($source, $tmpDir . '/' . $filename);
        }
    }

    private function cleanupDir(string $dir): void
    {
        $files = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($dir, \RecursiveDirectoryIterator::SKIP_DOTS),
            \RecursiveIteratorIterator::CHILD_FIRST
        );
        foreach ($files as $file) {
            if ($file->isDir()) {
                rmdir($file->getRealPath());
            } else {
                unlink($file->getRealPath());
            }
        }
        rmdir($dir);
    }
}
