<?php

namespace App\Livewire;

use App\Models\Peminjaman;
use Livewire\Component;
use Livewire\WithPagination;

class HistoryPeminjamanComponent extends Component
{
    use WithPagination;

    public $search = '';
    public $filterStatus = '';
    public $showDetail = false;
    public $detailPeminjaman = null;
    public $showStruk = false;
    public $lastPeminjaman = null;
    protected $paginationTheme = 'bootstrap';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $query = Peminjaman::query();

        // Filter berdasarkan status
        if ($this->filterStatus === 'dipinjam') {
            $query->where('status_buku', 'dipinjam');
        } elseif ($this->filterStatus === 'kembali') {
            $query->where('status_buku', 'kembali');
        }
        // Jika filterStatus kosong, tampilkan semua

        // Filter berdasarkan search
        $query->where(function ($q) {
            $q->whereHas('anggota', function ($subQ) {
                $subQ->where('nama_anggota', 'like', '%' . $this->search . '%');
            })
            ->orWhere('kode_transaksi', 'like', '%' . $this->search . '%');
        });

        $peminjaman = $query->with(['anggota', 'user', 'detailPeminjaman.eksemplar.buku'])
            ->latest()
            ->paginate(15);

        $data['peminjaman'] = $peminjaman;
        $data['filterStatus'] = $this->filterStatus;
        $data['search'] = $this->search;
        $data['showDetail'] = $this->showDetail;
        $data['detailPeminjaman'] = $this->detailPeminjaman;
        $data['showStruk'] = $this->showStruk;
        $data['lastPeminjaman'] = $this->lastPeminjaman;
        $data['title'] = 'History Peminjaman';
        $data['isPustakawan'] = auth()->user()->role === 'pustakawan';
        $data['isKepala'] = auth()->user()->role === 'kepala';

        return view('livewire.history-peminjaman-modern', $data)->layoutData($data);
    }

    public function viewDetail($id)
    {
        $this->detailPeminjaman = Peminjaman::with(['anggota', 'user', 'detailPeminjaman.eksemplar.buku'])
            ->find($id);
        $this->showDetail = true;
    }

    public function closeDetail()
    {
        $this->showDetail = false;
        $this->detailPeminjaman = null;
    }

    public function cetakStruk($id)
    {
        $this->lastPeminjaman = Peminjaman::with(['anggota', 'user', 'detailPeminjaman.eksemplar.buku'])
            ->find($id);
        $this->showStruk = true;
    }

    public function closeStruk()
    {
        $this->showStruk = false;
        $this->lastPeminjaman = null;
    }

    public function exportExcel()
    {
        // Placeholder untuk export excel
        return response()->json(['message' => 'Export akan diimplementasikan']);
    }
}

