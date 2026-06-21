<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;

class TeamLeadPicker extends Component
{
    public $search = '';
    public $selectedLeadId = null;
    public $selectedLeadName = '';
    public $selectedLeadNim = '';

    // Menerima data awal jika dalam mode Edit Proyek
    public function mount($oldLeadId = null)
    {
        if ($oldLeadId) {
            $lead = User::find($oldLeadId);
            if ($lead) {
                $this->selectedLeadId = $lead->id;
                $this->selectedLeadName = $lead->name;
                $this->selectedLeadNim = $lead->nim_nidn ?? $lead->nim; // sesuaikan kolom NIM Anda
            }
        }
    }

    public function selectLead($id, $name, $nim)
    {
        $this->selectedLeadId = $id;
        $this->selectedLeadName = $name;
        $this->selectedLeadNim = $nim;
        $this->search = ''; // Reset form pencarian setelah dipilih

        // Opsional: Kirim event ke komponen lain jika diperlukan
        $this->dispatch('teamLeadChanged', $id);
    }

    public function removeLead()
    {
        $this->selectedLeadId = null;
        $this->selectedLeadName = '';
        $this->selectedLeadNim = '';
        $this->dispatch('teamLeadChanged', null);
    }

    public function render()
    {
        $searchResults = [];

        if (strlen($this->search) >= 1) {
            $searchResults = User::role('mahasiswa')
                ->where(function($query) {
                    $query->where('name', 'like', '%' . $this->search . '%')
                          ->orWhere('nim_nidn', 'like', '%' . $this->search . '%');
                })
                ->take(5)
                ->get();
        }

        return view('livewire.team-lead-picker', [
            'searchResults' => $searchResults
        ]);
    }
}
