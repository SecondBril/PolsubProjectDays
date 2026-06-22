<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;

class TeamMemberPicker extends Component
{
    public $search = '';
    public $selectedMembers = [];

    public function render()
    {
        $searchResults = [];
        if (strlen($this->search) >= 2) {
            // KUNCI UTAMA: Filter role mahasiswa, lalu kelompokkan OR pencariannya
            $searchResults = User::where('role', 'mahasiswa')
                ->where(function ($query) {
                    $query->where('nim_nidn', 'like', '%' . $this->search . '%')
                          ->orWhere('name', 'like', '%' . $this->search . '%');
                })
                ->take(5)
                ->get();
        }

        // Memanggil berkas view di resources/views/livewire/team-member-picker.blade.php
        return view('livewire.team-member-picker', [
            'searchResults' => $searchResults
        ]);
    }

    public function addMember($userId)
    {
        $user = User::find($userId);
        if ($user && !collect($this->selectedMembers)->contains('id', $userId)) {
            $this->selectedMembers[] = [
                'id' => $user->id,
                'name' => $user->name,
                'nim_nidn' => $user->nim_nidn,
                'contribution' => '' // Sediakan key kontribusi kosong untuk diisi di form
            ];
        }
        $this->search = '';
    }

    public function removeMember($userId)
    {
        $this->selectedMembers = collect($this->selectedMembers)
            ->filter(fn($member) => $member['id'] !== $userId)
            ->toArray();
    }
}
