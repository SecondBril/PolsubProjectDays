<div class="relative">
    <label class="block text-xs font-semibold text-slate-700 mb-1.5">
        Ketua Kelompok (Mahasiswa) <span class="text-rose-500">*</span>
    </label>

    {{-- Input Hidden untuk mengirimkan ID ke Controller saat form disubmit --}}
    <input type="hidden" name="team_lead_id" value="{{ $selectedLeadId }}" required>

    @if($selectedLeadId)
        {{-- Tampilan saat Ketua sudah terpilih --}}
        <div class="flex items-center justify-between p-2.5 bg-indigo-50 border border-indigo-200 rounded-lg text-xs">
            <div class="flex items-center gap-2">
                <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-indigo-200 text-indigo-700">Ketua</span>
                <span class="text-slate-900 font-medium">{{ $selectedLeadNim }} - {{ $selectedLeadName }}</span>
            </div>
            <button type="button" wire:click="removeLead" class="text-rose-500 hover:text-rose-700 font-bold text-sm px-1">
                &times;
            </button>
        </div>
    @else
        {{-- Input pencarian saat Ketua belum dipilih --}}
        <input type="text" wire:model.live="search"
               placeholder="Ketik NIM atau Nama untuk mencari Ketua Kelompok..."
               class="w-full text-xs rounded-lg border border-slate-200 p-[9.5px_12px] outline-none text-textCustom-900 bg-white focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500">

        {{-- Dropdown Hasil Pencarian --}}
        @if(!empty($searchResults))
            <div class="absolute z-20 mt-1 w-full bg-white border border-slate-200 rounded-md shadow-lg max-h-60 overflow-y-auto divide-y divide-slate-100">
                @foreach($searchResults as $student)
                    @php
                        $nim = $student->nim_nidn ?? $student->nim;
                    @endphp
                    <button type="button"
                            wire:click="selectLead('{{ $student->id }}', '{{ addslashes($student->name) }}', '{{ $nim }}')"
                            class="w-full text-left px-4 py-2.5 text-xs hover:bg-slate-50 text-slate-900 transition flex justify-between items-center">
                        <span class="font-medium">{{ $student->name }}</span>
                        <span class="text-slate-500 font-mono bg-slate-100 px-1.5 py-0.5 rounded">{{ $nim }}</span>
                    </button>
                @endforeach
            </div>
        @endif
    @endif
</div>
