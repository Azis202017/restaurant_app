<?php

namespace App\Http\Controllers\web;

use App\Models\Report;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ReportController extends Controller
{
    public function index()
    {
        $reports = Report::with(['community'])->get();
        return view('admin.report', compact('reports'));
    }
    public function delete($id)
    {
        $report = Report::find($id);
        if ($report) {
            // Retrieve the associated community
            $community = $report->community;

            // Delete the report
            $report->delete();

            // Delete the community if it exists
            if ($community) {
                $community->delete();
            }

            return back();
        } else {
            return back();
        }
    }
}
