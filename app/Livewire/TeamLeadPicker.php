<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;
use App\Models\Project; // Impor model jika diperlukan

class TeamLeadPicker extends Component
{
    public $search = '';
    public $selectedLeadId = null;
    public $selectedLeadName = '';
    public $selectedLeadNim = '';
    public $leaderContribution = ''; // PERBAIKAN: Tambahkan properti penampung data

    // Menerima data awal jika dalam mode Edit Proyek
    public function mount($oldLeadId = null, $project = null)
    {
        if ($oldLeadId) {
            $lead = User::find($oldLeadId);
            if ($lead) {
                $this->selectedLeadId = $lead->id;
                $this->selectedLeadName = $lead->name;
                $this->selectedLeadNim = $lead->nim_nidn;

                // PERBAIKAN: Jika objek proyek dilemparkan, cari kontribusi lama dari pivot table
                if ($project) {
                    $pivot = $project->teamMembers->where('id', $oldLeadId)->first();
                    $this->leaderContribution = $pivot ? $pivot->pivot->contribution : '';
                }
            }
        }
    }

    public function selectLead($id, $name, $nim)
    {
        $this->selectedLeadId = $id;
        $this->selectedLeadName = $name;
        $this->selectedLeadNim = $nim;
        $this->search = '';
        $this->dispatch('teamLeadChanged', $id);
    }

    public function removeLead()
    {
        $this->selectedLeadId = null;
        $this->selectedLeadName = '';
        $this->selectedLeadNim = '';
        $this->leaderContribution = ''; // Reset kontribusi saat ketua dihapus
        $this->dispatch('teamLeadChanged', null);
    }

    public function render()
    {
        $searchResults = [];

        if (strlen($this->search) >= 2) {
            $searchResults = User::where('role', 'mahasiswa')
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
