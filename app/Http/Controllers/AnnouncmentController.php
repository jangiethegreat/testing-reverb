<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Announcment;
use Illuminate\Http\Request;
use App\Events\AnnouncementCreate;

class AnnouncmentController extends Controller
{
    public function index()
    {
        $announcements = Announcment::latest()->get(); // Corrected the spelling of the model
        return view('announcements', compact('announcements'));
    }

    public function store(Request $request)
    {
        $request->validate([
            "title" => "required",
            "body" => "required"

        ]);

        $announcement = Announcment::create([
            "title" => $request->title,
            "body" => $request->body
        ]);
        event(new AnnouncementCreate($announcement));
        return redirect()->back();
    }
}
