<?php

namespace App\Http\Controllers;

use App\Models\Tool;
use App\Models\Borrowing;
use App\Models\BorrowingDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserBorrowingController extends Controller
{
    public function dashboard()
    {
        $userId = Auth::id();

        $totalBorrowings = Borrowing::where('user_id', $userId)->count();
        $pending = Borrowing::where('user_id', $userId)->where('status', 'Pending')->count();
        $approved = Borrowing::where('user_id', $userId)->where('status', 'Approved')->count();
        $returned = Borrowing::where('user_id', $userId)->where('status', 'Returned')->count();

        $recent = Borrowing::with(['details.tool'])
            ->where('user_id', $userId)
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard', compact('totalBorrowings', 'pending', 'approved', 'returned', 'recent'));
    }

    public function create(Tool $tool)
    {
        if ($tool->status !== 'Tersedia' || $tool->stock < 1) {
            return redirect('/katalog')->with('error', 'Alat tidak tersedia untuk dipinjam.');
        }

        // Cek apakah user sudah punya pinjaman aktif untuk alat ini
        $hasActiveBorrowing = Borrowing::where('user_id', Auth::id())
            ->whereIn('status', ['Pending', 'Approved'])
            ->whereHas('details', function($query) use ($tool) {
                $query->where('tool_id', $tool->id);
            })->exists();

        if ($hasActiveBorrowing) {
            return redirect('/katalog')->with('error', 'Anda sudah memiliki pengajuan atau sedang meminjam alat ini. Silakan kembalikan terlebih dahulu.');
        }

        return view('borrowings.create', compact('tool'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tool_id' => 'required|exists:tools,id',
            'quantity' => 'required|integer|min:1',
            'borrowing_date' => 'required|date|after_or_equal:today',
            'return_date' => 'required|date|after:borrowing_date',
            'purpose' => 'required|string|max:255',
            'notes' => 'nullable|string',
        ]);

        $tool = Tool::findOrFail($request->tool_id);

        // Validasi stok
        if ($request->quantity > $tool->stock) {
            return back()->withErrors(['quantity' => 'Jumlah melebihi stok tersedia (' . $tool->stock . ').'])->withInput();
        }

        // Validasi: Cegah peminjaman ganda
        $hasActiveBorrowing = Borrowing::where('user_id', Auth::id())
            ->whereIn('status', ['Pending', 'Approved'])
            ->whereHas('details', function($query) use ($request) {
                $query->where('tool_id', $request->tool_id);
            })->exists();

        if ($hasActiveBorrowing) {
            return back()->with('error', 'Gagal: Anda sudah memiliki pengajuan atau sedang meminjam alat ini.')->withInput();
        }

        DB::beginTransaction();
        try {
            $code = 'PJM-' . date('Ymd') . '-' . strtoupper(substr(uniqid(), -5));

            $borrowing = Borrowing::create([
                'user_id' => Auth::id(),
                'borrowing_code' => $code,
                'borrowing_date' => $request->borrowing_date,
                'return_date' => $request->return_date,
                'purpose' => $request->purpose,
                'notes' => $request->notes,
                'status' => 'Pending',
            ]);

            BorrowingDetail::create([
                'borrowing_id' => $borrowing->id,
                'tool_id' => $tool->id,
                'quantity' => $request->quantity,
            ]);

            DB::commit();

            return redirect('/riwayat')->with('success', 'Peminjaman berhasil diajukan. Kode: ' . $code);
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal menyimpan peminjaman: ' . $e->getMessage());
        }
    }

    public function history()
    {
        $borrowings = Borrowing::with(['details.tool'])
            ->where('user_id', Auth::id())
            ->latest()
            ->paginate(10);

        return view('borrowings.history', compact('borrowings'));
    }
}
