<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class ActivityLogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Controller ini mengirim variabel dengan nama 'activityLogs'
        $activityLogs = ActivityLog::with('user')
            ->latest()
            ->paginate(15);

        return view('admin.activity_logs.index', compact('activityLogs'));
    }
}

