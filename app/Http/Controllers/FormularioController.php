<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class FormularioController extends Controller
{


    public function descargar_cv()
    {
        $archivo = public_path('assets/files/Cristian-Perdomo_CVT.pdf');
        $headers = array(
            'Content-Type: application/pdf',
        );
        return response()->download($archivo, 'cristian-perdomo-cv.pdf', $headers);
    }

    public function sendContactForm(Request $request)
{
    $rules = [
        'name' => 'required',
        'email' => 'required|email',
        'subject' => 'required',
        'msg' => 'required',
    ];

    $validator = Validator::make($request->all(), $rules);

    if ($validator->fails()) {
        return redirect('/')
            ->withErrors($validator)
            ->withInput();
    }

    Mail::send('/', ['request' => $request], function ($message) use ($request) {
        $message->from($request->input('email'), $request->input('name'));
        $message->to('cristian2020til@gmail.com');
        $message->subject($request->input('subject'));
    });

    $request->session()->flash('mensaje', 'Tu mensaje ha sido enviado!');
    return redirect('/')
        ->with('status', 'Tu mensaje ha sido enviado!');
}


}
