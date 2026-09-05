<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\Transaction;
use App\Models\Vendeur;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function installation()
    {
        return view('livewire.installation.installation-page');
    }

    public function contact()
    {
        return view('pages.contact');
    }

    public function merci(Request $request)
    {
        $token = $request->query('invoiceToken');
        $vendeurId = $request->query('vendeur_id');

        $transaction = null;
        $ticket = null;
        $mikrotikUrl = null;

        if ($token) {
            $transaction = Transaction::where('token', $token)->first();
            if ($transaction) {
                $transaction->update(['verification_status' => 'verifie']);
                $ticket = $transaction->ticket()->with('hotspot')->first();
                $mikrotikUrl = $ticket?->hotspot?->mikrotik_url;
            }
        }

        return view('pages.merci', compact('token', 'transaction', 'ticket', 'mikrotikUrl'));
    }

    public function annule(Request $request)
    {
        $token = $request->query('token');

        if ($token) {
            Transaction::where('token', $token)
                ->where('statut', 'pending')
                ->update(['statut' => 'cancelled']);
        }

        return view('pages.annule', compact('token'));
    }

    public function portailIndisponible(Request $request)
    {
        $vendeur = Vendeur::find((int) $request->query('vendeur_id', 0));
        $raison = (string) $request->query('raison', '');

        return view('pages.portail-indisponible', compact('vendeur', 'raison'));
    }

    public function recupererTicket(Request $request)
    {
        $token = $request->input('token') ?? $request->query('token');
        $phone = $request->input('phone') ?? $request->query('phone');
        $ticket = null;
        $message = null;

        $query = Transaction::where('statut', 'completed')
            ->where('verification_status', 'verifie');

        if ($token) {
            $query->where('token', $token);
        } elseif ($phone) {
            $query->where('phone_number', $phone);
        } else {
            $message = 'missing_input';
            return view('pages.recuperer-ticket', compact('token', 'phone', 'ticket', 'message'));
        }

        $transaction = $query->first();

        if ($transaction && $transaction->ticket) {
            $ticket = $transaction->ticket->load('vendeur');
            $message = 'success';
            session(['recupered_ticket_id' => $ticket->id]);
            session(['recupered_ticket_expires' => now()->addMinutes(5)->timestamp]);
        } else {
            $message = 'not_found';
            session()->forget('recupered_ticket_id');
        }

        return view('pages.recuperer-ticket', compact('token', 'phone', 'ticket', 'message'));
    }

    public function ticketPassword(Request $request, Ticket $ticket)
    {
        if (session('recupered_ticket_id') !== $ticket->id) {
            abort(403);
        }

        $expires = session('recupered_ticket_expires');
        if (!$expires || now()->timestamp > $expires) {
            session()->forget(['recupered_ticket_id', 'recupered_ticket_expires']);
            abort(403);
        }

        return response()->json(['password' => $ticket->password]);
    }
}
