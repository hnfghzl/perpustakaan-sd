<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class AnggotaProfilComponent extends Component
{
    public $anggota;
    public $alertPesan = '';
    public $alertTipe = '';

    public function mount()
    {
        // Get authenticated anggota
        $this->anggota = Auth::guard('anggota')->user();
    }

    public function render()
    {
        $data['anggota'] = $this->anggota;
        $data['alertPesan'] = $this->alertPesan;
        $data['alertTipe'] = $this->alertTipe;
        $data['title'] = 'Profil Saya';
        
        return view('livewire.anggota-profil', $data)->layoutData($data);
    }
}
