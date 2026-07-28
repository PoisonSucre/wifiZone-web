<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EmailVerificationController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\TemplateDownloadController;


// --- Public ---
Route::get('/', fn () => view('pages.landing'))->name('home');
Route::get('/shop/{id}', [ShopController::class, 'show'])->name('shop');
Route::get('/contact', fn () => view('pages.contact'))->name('contact');
Route::get('/merci', [PageController::class, 'merci'])->name('merci');
Route::get('/annule', [PageController::class, 'annule'])->name('annule');
Route::match(['get', 'post'], '/recuperer-ticket', [PageController::class, 'recupererTicket'])->name('recuperer-ticket');

// --- Auth (Vendeur) ---
Route::middleware('guest')->group(function () {
    Route::get('/auth/login', [AuthController::class, 'showLogin'])->name('vendor.login');
    Route::post('/auth/login', [AuthController::class, 'login'])->name('vendor.login.post')->middleware('throttle:5,1');
    Route::get('/auth/register', [AuthController::class, 'showRegister'])->name('vendor.register');
    Route::post('/auth/register', [AuthController::class, 'register'])->name('vendor.register.post');
    Route::get('/login', fn () => redirect()->route('vendor.login'))->name('login');
    Route::get('/register', fn () => redirect()->route('vendor.register'))->name('register');

    Route::get('/auth/forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('vendor.forgot-password');
    Route::post('/auth/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('vendor.forgot-password.post');
    Route::get('/auth/reset-password/{token}', [ForgotPasswordController::class, 'showResetForm'])->name('vendor.reset-password');
    Route::post('/auth/reset-password', [ForgotPasswordController::class, 'reset'])->name('vendor.reset-password.post');
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
});
Route::post('/raider/logout', [AdminAuthController::class, 'logout'])->name('admin.logout')->middleware('auth:admin');

// --- Vendor Dashboard ---
Route::middleware(['auth', 'vendeur.status'])->prefix('vendeur')->name('vendor.')->group(function () {
    Route::get('/', fn () => view('vendor.dashboard'))->name('dashboard');
    Route::get('/tickets', fn () => view('vendor.tickets'))->name('tickets');
    Route::get('/boutique', fn () => view('vendor.boutique'))->name('boutique');
    Route::get('/boutique/download', [TemplateDownloadController::class, 'download'])->name('boutique.download');
    Route::get('/apercu', function () {
        $vendeur = auth()->user();
        $vendeur->couleur = session('preview_couleur', $vendeur->couleur);
        $vendeur->couleur_top = session('preview_couleur_top', $vendeur->couleur_top);
        $vendeur->nom_portail = session('preview_nom_portail', $vendeur->nom_portail);
        $vendeur->message_bienvenue = session('preview_message', $vendeur->message_bienvenue);
        $vendeur->logo = session('preview_logo', $vendeur->logo);
        $forfaits = $vendeur->forfaits()->orderBy('ordre')->get();
        return view('shop.template.preview', compact('vendeur', 'forfaits'));
    })->name('preview');
    Route::get('/import', fn () => view('vendor.import'))->name('import');
    Route::get('/hotspot', fn () => view('vendor.hotspot'))->name('hotspot');
    Route::get('/hotspot/{hotspot}', fn (\App\Models\Hotspot $hotspot) => view('vendor.hotspot-details', ['hotspot' => $hotspot]))->name('hotspot.details');
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
    Route::get('/retraits', fn () => view('admin.retraits'))->name('retraits');
    Route::get('/revenus-details', fn () => view('admin.revenus-details'))->name('revenus.details');
});
