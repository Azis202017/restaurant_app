<?php

namespace App\Http\Controllers;

use App\Models\Report;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function create(Request $request) {
        $data = Report::create(
            ['community_id' => $request->community_id]
        );
        return response()->json($data);
    }
}
