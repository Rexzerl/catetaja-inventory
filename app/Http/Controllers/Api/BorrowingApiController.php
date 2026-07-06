<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Borrowing;
use Illuminate\Http\Request;

class BorrowingApiController extends Controller
{
    public function index()
    {
        $borrowings = Borrowing::latest()->get();

        return response()->json([
            'success' => true,
            'message' => 'Data riwayat peminjaman berhasil diambil',
            'data'    => $borrowings
        ], 200);
    }
}