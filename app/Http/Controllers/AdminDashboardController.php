<?php

namespace App\Http\Controllers;

use App\Models\Tool;
use App\Models\Borrowing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class AdminDashboardController extends Controller
{
        public function index(Request $request)
    {
        $totalTools = Tool::count();
        $totalStock = Tool::sum('stock');
        $borrowedCount = Borrowing::where('status', 'Approved')->count();
        $pendingCount = Borrowing::where('status', 'Pending')->count();

        $query = Borrowing::with(['user', 'details.tool']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('from')) {
            $query->whereDate('borrowing_date', '>=', $request->from);
        }
        if ($request->filled('to')) {
            $query->whereDate('borrowing_date', '<=', $request->to);
        }

        $borrowings = $query->latest()->paginate(10)->withQueryString();

        return view('admin.dashboard', compact(
            'totalTools', 'totalStock', 'borrowedCount', 'pendingCount', 'borrowings'
        ));
    }

        public function approve(Request $request, Borrowing $borrowing)
    {
        if ($borrowing->status !== 'Pending') {
            return back()->with('error', 'Hanya peminjaman Pending yang bisa di-approve.');
        }

        $request->validate([
            'admin_note' => 'nullable|string|max:255'
        ]);

        DB::beginTransaction();
        try {
            // ... (biarkan kode pengecekan dan pengurangan stok seperti sebelumnya) ...
            foreach ($borrowing->details as $detail) {
                $tool = Tool::find($detail->tool_id);
                if ($detail->quantity > $tool->stock) {
                    DB::rollBack();
                    return back()->with('error', "Stok {$tool->name} tidak cukup.");
                }
            }
            foreach ($borrowing->details as $detail) {
                $tool = Tool::find($detail->tool_id);
                $tool->stock -= $detail->quantity;
                if ($tool->stock <= 0) { $tool->status = 'Tidak Tersedia'; }
                $tool->save();
            }

            // Update status dan keterangan
            $borrowing->update([
                'status' => 'Approved',
                'admin_note' => $request->admin_note // <--- SIMPAN KETERANGAN
            ]);

            DB::commit();
            return back()->with('success', 'Peminjaman di-approve. Stok dikurangi.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal approve: ' . $e->getMessage());
        }
    }
        public function reject(Request $request, Borrowing $borrowing)
    {
        if ($borrowing->status !== 'Pending') {
            return back()->with('error', 'Hanya peminjaman Pending yang bisa di-reject.');
        }

        $request->validate([
            'rejection_reason' => 'required|string|max:255'
        ]);

        $borrowing->update([
            'status' => 'Rejected',
            'rejection_reason' => $request->rejection_reason
        ]);

        return back()->with('success', 'Peminjaman telah ditolak dengan alasan.');
    }

    public function returnTool(Borrowing $borrowing)
    {
        if ($borrowing->status !== 'Approved') {
            return back()->with('error', 'Hanya peminjaman Approved yang bisa dikembalikan.');
        }

        DB::beginTransaction();
        try {
            foreach ($borrowing->details as $detail) {
                $tool = Tool::find($detail->tool_id);
                $tool->stock += $detail->quantity;

                if ($tool->stock > 0) {
                    $tool->status = 'Tersedia';
                }

                $tool->save();
            }

            $borrowing->update(['status' => 'Returned']);

            DB::commit();
            return back()->with('success', 'Alat berhasil dikembalikan. Stok telah ditambah.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal return: ' . $e->getMessage());
        }
    }

    public function exportPdf(Request $request)
    {
        $query = Borrowing::with(['user', 'details.tool']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('from')) {
            $query->whereDate('borrowing_date', '>=', $request->from);
        }
        if ($request->filled('to')) {
            $query->whereDate('borrowing_date', '<=', $request->to);
        }

        $borrowings = $query->latest()->get();

        $pdf = Pdf::loadView('admin.pdf.borrowings', [
            'borrowings' => $borrowings,
            'generatedAt' => now()->format('d M Y H:i'),
            'filterStatus' => $request->status ?? 'Semua',
        ]);

        $pdf->setPaper('A4', 'landscape');

        return $pdf->download('laporan-peminjaman-sipal-' . date('Ymd-His') . '.pdf');
    }
        public function exportExcel(Request $request)
    {
        return \Maatwebsite\Excel\Facades\Excel::download(new \App\Exports\BorrowingsExport($request), 'laporan-peminjaman.xlsx');
    }
}