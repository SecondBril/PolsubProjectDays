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
            $searchResults = User::where('nim_nidn', 'like', '%' . $this->search . '%')
                ->orWhere('name', 'like', '%' . $this->search . '%')
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
                'nim_nidn' => $user->nim_nidn
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
