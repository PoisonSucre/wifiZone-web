<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EmailVerificationController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\TemplateDownloadController;
use App\Http\Controllers\PaymentInitController;


// --- Public ---
Route::get('/', fn () => view('pages.landing'))->name('home');
Route::get('/shop/{id}', [ShopController::class, 'show'])->name('shop');
Route::get('/contact', fn () => view('pages.contact'))->name('contact');
Route::get('/installation', [PageController::class, 'installation'])->name('installation');
Route::get('/merci', [PageController::class, 'merci'])->name('merci');
Route::get('/annule', [PageController::class, 'annule'])->name('annule');
Route::get('/recuperer-ticket', [PageController::class, 'recupererTicket'])->name('recuperer-ticket');
Route::post('/recuperer-ticket', [PageController::class, 'recupererTicket'])->middleware('throttle:5,1');
Route::get('/recuperer-ticket/password/{ticket}', [PageController::class, 'ticketPassword'])->name('recuperer-ticket.password')->middleware('throttle:10,1');
Route::post('/payment/init', [PaymentInitController::class, 'init'])->name('payment.init')->middleware('throttle:10,60');

// --- Auth (Vendeur) ---
Route::middleware('guest')->group(function () {
    Route::get('/auth/login', [AuthController::class, 'showLogin'])->name('vendor.login');
    Route::post('/auth/login', [AuthController::class, 'login'])->name('vendor.login.post')->middleware('throttle:5,1');
    Route::get('/auth/register', [AuthController::class, 'showRegister'])->name('vendor.register');
    Route::post('/auth/register', [AuthController::class, 'register'])->name('vendor.register.post')->middleware('throttle:3,60');
    Route::get('/login', fn () => redirect()->route('vendor.login'))->name('login');
    Route::get('/register', fn () => redirect()->route('vendor.register'))->name('register');

    Route::get('/auth/forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('vendor.forgot-password');
    Route::post('/auth/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('vendor.forgot-password.post')->middleware('throttle:3,60');
    Route::get('/auth/reset-password/{token}', [ForgotPasswordController::class, 'showResetForm'])->name('vendor.reset-password');
    Route::post('/auth/reset-password', [ForgotPasswordController::class, 'reset'])->name('vendor.reset-password.post')->middleware('throttle:3,60');
});
Route::post('/auth/logout', [AuthController::class, 'logout'])->name('vendor.logout')->middleware('auth');

Route::get('/auth/pending', [AuthController::class, 'pending'])->name('vendor.pending');
Route::get('/auth/suspended', [AuthController::class, 'suspended'])->name('vendor.suspended');

Route::get('/auth/verify-email', [EmailVerificationController::class, 'notice'])->name('vendor.verify-email');
Route::get('/auth/verify-email/{id}/{hash}', [EmailVerificationController::class, 'verify'])->name('vendor.verify')->middleware('signed');
Route::post('/auth/verify-email/resend', [EmailVerificationController::class, 'resend'])->name('vendor.verify-email.resend');

// --- Auth (Admin) ---
Route::middleware('guest:admin')->group(function () {
    Route::get('/raider/login', [AdminAuthController::class, 'showLogin'])->name('admin.login');
    Route::post('/raider/login', [AdminAuthController::class, 'login'])->name('admin.login.post')->middleware('throttle:5,1');
    Route::get('/raider/forgot-password', [AdminAuthController::class, 'showForgotPasswordForm'])->name('admin.forgot-password');
    Route::post('/raider/forgot-password', [AdminAuthController::class, 'sendSetPasswordEmail'])->name('admin.forgot-password.post')->middleware('throttle:5,60');
    Route::get('/raider/reset-password/{token}', [AdminAuthController::class, 'showSetPasswordForm'])->name('admin.set-password');
    Route::post('/raider/reset-password', [AdminAuthController::class, 'setPassword'])->name('admin.set-password.post')->middleware('throttle:5,60');
});
Route::post('/raider/logout', [AdminAuthController::class, 'logout'])->name('admin.logout')->middleware('auth:admin');

// --- Vendor Dashboard ---
Route::middleware(['auth', 'vendeur.status'])->prefix('vendeur')->name('vendor.')->group(function () {
    Route::get('/', fn () => view('vendor.dashboard'))->name('dashboard');
    Route::get('/tickets', fn () => view('vendor.tickets'))->name('tickets');
    Route::get('/boutique', fn () => view('vendor.boutique'))->name('boutique');
    Route::get('/alertes', fn () => view('vendor.alertes'))->name('alertes');
    Route::get('/boutique/download', [TemplateDownloadController::class, 'download'])->name('boutique.download');
    Route::get('/apercu', function () {
        $vendeur = auth()->user();
        $hsId = (int) request()->query('hotspot', 0);
        $hotspot = $hsId > 0 ? \App\Models\Hotspot::where('id', $hsId)->where('vendeur_id', $vendeur->id)->first() : null;

        $pKey = fn ($k) => $hotspot ? "preview_{$k}_{$hotspot->id}" : "preview_{$k}";

        if ($hotspot) {
            $couleur = session($pKey('couleur'), $hotspot->couleur);
            $couleur_top = session($pKey('couleur_top'), $hotspot->couleur_top);
            $nom_portail = session($pKey('nom_portail'), $hotspot->nom_portail);
            $message_bienvenue = session($pKey('message'), $hotspot->message_bienvenue);
            $logo = session($pKey('logo'), $hotspot->logo);
        } else {
            $couleur = session($pKey('couleur'), $vendeur->couleur);
            $couleur_top = session($pKey('couleur_top'), $vendeur->couleur_top);
            $nom_portail = session($pKey('nom_portail'), $vendeur->nom_portail);
            $message_bienvenue = session($pKey('message'), $vendeur->message_bienvenue);
            $logo = session($pKey('logo'), $vendeur->logo);
        }

        $vendeur->couleur = $couleur;
        $vendeur->couleur_top = $couleur_top;
        $vendeur->nom_portail = $nom_portail;
        $vendeur->message_bienvenue = $message_bienvenue;
        $vendeur->logo = $logo;

        $forfaits = $hotspot
            ? $hotspot->forfaits()->orderBy('ordre')->get()
            : $vendeur->forfaits()->orderBy('ordre')->get();
        return view('shop.template.preview', compact('vendeur', 'forfaits'));
    })->name('preview');
    Route::get('/import', fn () => view('vendor.import'))->name('import');
    Route::get('/hotspot', fn () => view('vendor.hotspot'))->name('hotspot');
    Route::get('/hotspot/{hotspot}', function (\App\Models\Hotspot $hotspot) {
        abort_if($hotspot->vendeur_id !== auth()->id(), 404);
        return view('vendor.hotspot-details', ['hotspot' => $hotspot]);
    })->name('hotspot.details');
    Route::get('/profil', fn () => view('vendor.profil'))->name('profil');
    Route::get('/retraits', fn () => view('vendor.retraits'))->name('retraits');
    Route::get('/template', function (\Illuminate\Http\Request $request) {
        $format = $request->query('format', 'csv');
        $mode = $request->query('mode', 'with_password');

        if ($mode === 'without_password') {
            $headers = 'user,forfait,montant';
            $sample = "user01,Forfait 1h,500\nuser02,Forfait 24h,1000";
        } else {
            $headers = 'user,password,forfait,montant';
            $sample = "user01,motdepasse1,Forfait 1h,500\nuser02,mdp2024,Forfait 24h,1000";
        }

        if ($format === 'excel') {
            $content = $headers . "\n" . $sample;
            $tempFile = tempnam(sys_get_temp_dir(), 'template_') . '.csv';
            file_put_contents($tempFile, $content);

            return response()->download($tempFile, 'template_tickets.csv', [
                'Content-Type' => 'text/csv',
            ])->deleteFileAfterSend(true);
        }

        return response()->streamDownload(function () use ($headers, $sample) {
            echo $headers . "\n" . $sample;
        }, 'template_tickets.csv', [
            'Content-Type' => 'text/csv',
        ]);
    })->name('template');
});

// --- Admin Dashboard ---
Route::middleware(['auth:admin', 'admin'])->prefix('raider')->name('admin.')->group(function () {
    Route::get('/', fn () => view('admin.dashboard'))->name('dashboard');
    Route::get('/vendeurs', fn () => view('admin.vendeurs'))->name('vendeurs');
    Route::get('/transactions', fn () => view('admin.transactions'))->name('transactions');
    Route::get('/tickets', fn () => view('admin.tickets'))->name('tickets');


    Route::get('/parametres', fn () => view('admin.parametres'))->name('parametres');
    Route::get('/personnalisation', fn () => view('admin.personnalisation'))->name('personnalisation');
    Route::get('/retraits', fn () => view('admin.retraits'))->name('retraits');
    Route::get('/admins', fn () => view('admin.admins'))->name('admins');
    Route::get('/journalisation', fn () => view('admin.journalisation'))->name('journalisation');
    Route::get('/revenus-details', fn () => view('admin.revenus-details'))->name('revenus.details');
});
