<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;

class AdminIndexController extends Controller
{
    public function adminDashboard()
    {
        return view('admin.pages.dashboard');
    }

    public function contacts()
    {

        $contacts = Contact::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.pages.message', compact('contacts'));
    }
}
