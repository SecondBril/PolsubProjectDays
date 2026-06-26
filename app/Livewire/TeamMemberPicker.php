<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;

class TeamMemberPicker extends Component
{
    public $search = '';
    public $selectedMembers = [];

    // 1. Tambahkan properti untuk mengikat kontribusi ketua tim
    public $leaderContribution = '';

    // 2. Tangkap data prefill kontribusi ketua melalui parameter mount
    public function mount($selectedMembers = [], $leaderContribution = '')
    {
        $this->selectedMembers = old('team_members', $selectedMembers);
        $this->leaderContribution = old('leader_contribution', $leaderContribution);
    }

    public function render()
    {
        $searchResults = [];
        if (strlen($this->search) >= 2) {
            $searchResults = User::where('role', 'mahasiswa')
                ->where(function ($query) {
                    $query->where('nim_nidn', 'like', '%' . $this->search . '%')
                          ->orWhere('name', 'like', '%' . $this->search . '%');
                })
                ->take(5)
                ->get();
        }

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
                'contribution' => ''
            ];
        }
        $this->search = '';
    }

    public function removeMember($userId)
    {
        $this->selectedMembers = collect($this->selectedMembers)
            ->filter(fn($member) => $member['id'] !== $userId)
            ->values()
            ->toArray();
    }
}
