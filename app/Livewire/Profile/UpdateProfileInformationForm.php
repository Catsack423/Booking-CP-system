<?php

namespace App\Http\Livewire\Profile;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

/** 
 * @property-read \App\Models\User $user
 */
class UpdateProfileInformationForm extends Component
{
    use WithFileUploads;

    public User $user;
    public array $state = [];
    public $photo;

    public function mount()
    {
        $this->user = Auth::user();
        $this->state = $this->user->only('name');
    }

    public function updateProfileInformation()
    {
        $user = Auth::user();

        $this->validate([
            'state.name' => 'required|string|max:255',
            'photo' => 'nullable|image|max:2048',
        ]);

        // อัปโหลดรูปโปรไฟล์
        if ($this->photo) {
            /** @var \Laravel\Jetstream\HasProfilePhoto $user */
            $user->updateProfilePhoto($this->photo);
        }

        // อัปเดตชื่อผู้ใช้
        $user->name = $this->state['name'];
        $user->save();

        $this->user->refresh();
        $this->photo = null;
        $this->dispatchBrowserEvent('profile-updated');
        session()->flash('message', 'บันทึกเรียบร้อยแล้ว!');
    }

    public function render()
    {
        return view('livewire.profile.update-profile-information-form');
    }
}
