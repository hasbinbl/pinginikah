<?php

namespace App\Http\Controllers;

use App\Http\Requests\Wedding\StoreWeddingRequest;
use App\Models\Wedding;
use App\Models\WeddingSegment;
use App\Services\WeddingService;
use Illuminate\Http\Request;

class WeddingController extends Controller
{
    protected $weddingService;

    public function __construct(WeddingService $weddingService)
    {
        $this->weddingService = $weddingService;
    }

    public function index()
    {
        $title   = 'Project Wedding';
        $wedding = $this->weddingService->getUserWedding();

        return view('wedding.index', compact('title', 'wedding'));
    }

    public function create()
    {
        $title = 'Buat Project Wedding';

        if ($this->weddingService->getUserWedding()) {
            return redirect()->route('wedding.index')->with('warning', 'Anda sudah memiliki project wedding.');
        }

        return view('wedding.create', compact('title'));
    }

    public function store(StoreWeddingRequest $request)
    {
        $data = $request->validated();

        try {
            $this->weddingService->createWedding($data);
            return redirect()->route('wedding.index')->with('success', 'Project dibuat! Menunggu konfirmasi pasangan.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal membuat project wedding: ' . $e->getMessage())->withInput();
        }
    }

    public function storeSegment(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'wedding_id' => 'required'
        ]);

        $this->weddingService->addSegment($request->wedding_id, $request->name);

        return back()->with('success', 'Bagian acara berhasil ditambahkan.');
    }

    public function destroySegment(WeddingSegment $segment)
    {
        $this->weddingService->deleteSegment($segment->id);
        return back()->with('success', 'Bagian acara berhasil dihapus.');
    }

    public function viewAcceptInvitation($token)
    {
        $title   = 'Undangan Project Wedding';
        $wedding = Wedding::where('invitation_token', $token)->where('status', 'pending')->first();

        if (!$wedding) {
            return redirect()->route('dashboard')->with('error', 'Undangan tidak valid.');
        }

        return view('wedding.accept-invitation', compact('title', 'wedding', 'token'));
    }

    public function processAcceptInvitation($token)
    {
        try {
            $this->weddingService->acceptInvitation($token);
            return redirect()->route('dashboard')->with('success', 'Anda sudah tergabung kedalam project!');
        } catch (\Exception $e) {
            return redirect()->route('dashboard')->with('error', $e->getMessage());
        }
    }
}
