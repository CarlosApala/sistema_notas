<?php

namespace App\Http\Controllers;

use App\Models\Predio;
use Dotenv\Exception\ValidationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;

class OrganigramaController extends Controller{
    public function index(){
        return Inertia::render('sistema/Organigrama/Index');
    }
}
