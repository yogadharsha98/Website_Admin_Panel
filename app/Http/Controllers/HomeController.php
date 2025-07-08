<?php

namespace App\Http\Controllers;

use App\Models\Animal;
use App\Models\AnimalVaccination;
use App\Models\AnimalWeight;
use App\Models\Farmer;
use App\Models\KidDetail;
use App\Models\MedicineRecord;
use App\Models\Stock;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

}
