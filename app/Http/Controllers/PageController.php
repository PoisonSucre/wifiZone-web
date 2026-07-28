<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\Transaction;
use App\Models\Vendeur;
use Illuminate\Http\Request;

class PageController extends Controller
{
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

        if ($token) {
            $transaction = Transaction::where('token', $token)->first();
            if ($transaction) {
                $transaction->update(['verification_status' => 'verifie']);
                $ticket = $transaction->ticket;
            }
        }

        return view('pages.merci', compact('token', 'transaction', 'ticket'));
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

    public function recupererTicket(Request $request)
    {
        $token = $request->input('token') ?? $request->query('token');
        $ticket = null;
        $message = null;

        if ($token) {
            $transaction = Transaction::where('token', $token)
                ->where('statut', 'completed')
                ->where('verification_status', 'verifie')
                ->first();

            if ($transaction && $transaction->ticket) {
                $ticket = $transaction->ticket->load('vendeur');
                $message = 'success';
            } else {
                $message = 'not_found';
            }
        }

        return view('pages.recuperer-ticket', compact('token', 'ticket', 'message'));
    }
}
