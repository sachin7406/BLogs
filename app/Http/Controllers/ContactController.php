<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class ContactController extends Controller
{
    public function store(Request $request)
    {
        // echo "<pre>";
        // print_R($request->all());
        // exit;
        //  dd('CHECKPOINT 3: CONTROLLER HIT', $request->all());
        // return;

        DB::enableQueryLog();
        // 1️⃣ Validate input
        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|digits:10',
            'company_name' => 'required|string|max:255',
            'solution' => 'required|string',
            'message' => 'required|string|min:10',
        ]);

        // Contact::create($validated);


        dd('CHECKPOINT 4: QUERY', DB::getQueryLog());

        // 3️⃣ Return response

        return redirect()
            ->back()
            ->with('success', 'Your message has been sent successfully!');
    }
}
