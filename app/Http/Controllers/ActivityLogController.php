<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use Illuminate\Http\Request;

class ActivityLogController extends Controller
{
    public function index(Request $request)
    {
        if (auth()->user()->isStaff()) {
            return redirect()->route('products.index')
                ->with('error', '⛔ Vai trò Nhân viên (Staff) không có quyền xem Lịch sử hoạt động hệ thống!');
        }

        $query = ActivityLog::with('user');

        if ($request->filled('action')) {
            $query->where('action', $request->action);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('description', 'like', "%{$search}%")
                  ->orWhereHas('user', function ($u) use ($search) {
                      $u->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                  });
            });
        }

        $logs = $query->latest()->paginate(15)->withQueryString();

        return view('activity_logs.index', compact('logs'));
    }
}
