<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreLeadRequest;

use App\Models\Lead;

class LeadController extends Controller
{
    public function store(StoreLeadRequest $request)
    {
        $data = $request->validated();

        // normalize เบอร์แบบง่าย
        $data['whatsapp_phone'] = preg_replace('/\s+/', '', $data['whatsapp_phone']);

        Lead::create($data);

        return redirect()->route('thankyou');
    }
}
