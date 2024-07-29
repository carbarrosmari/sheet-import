<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Mail;
use App\Mail\Email;
use App\Models\CompanyFinancials;

class MailController extends Controller
{
    public function sendEmail($id)
    {
        $financials = CompanyFinancials::findOrFail($id);

        $toEmail = $financials->email;
        $message = $financials;
        $subject = 'Assunto: Informações do Boleto de Pagamento';

        Mail::to($toEmail)->send(new Email($message, $subject));

        return redirect()->back()->with('success', 'Email enviado com sucesso!');
    }
}
