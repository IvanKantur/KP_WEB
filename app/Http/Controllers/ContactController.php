<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactMail;
use App\Models\ContactMessage;

class ContactController extends Controller
{
    public function send(Request $request)
    {
        // Проверяем, что запрос AJAX
        if (!$request->ajax()) {
            return response()->json(['success' => false, 'message' => 'Invalid request'], 400);
        }

        try {
            $validator = validator($request->all(), [
                'name' => 'required|string|max:255',
                'email' => 'required|email|max:255',
                'message' => 'required|string|min:10',
            ]);

            if ($validator->fails()) {
                return response()->json(['success' => false, 'message' => $validator->errors()->first()], 422);
            }

            ContactMessage::create([
                'name' => $request->name,
                'email' => $request->email,
                'message' => $request->message,
            ]);

            return response()->json(['success' => true, 'message' => 'Сообщение отправлено']);
            
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
}