<?php

namespace App\Http\Controllers\web;

use App\Models\Report;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ReportController extends Controller
{
    public function index() {
     $reports = Report::with(['community'])->get();
     return view('admin.report', compact('reports'));
    }


}
