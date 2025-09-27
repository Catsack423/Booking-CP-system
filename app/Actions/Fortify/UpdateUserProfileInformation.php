<?php

namespace App\Actions\Fortify;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\UpdatesUserProfileInformation; // ✅ เพิ่ม use

class UpdateUserProfileInformation implements UpdatesUserProfileInformation // ✅ implements interface
{
    /**
     * Validate and update the given user's profile information.
     */
    public function update($user, array $input): void
    {
        $validator = Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users')->ignore($user->id),
            ],
            'photo' => ['nullable', 'image', 'max:1024'],
        ]);

        // ✅ เพิ่มเช็ค: ถ้าชื่อใหม่เหมือนชื่อเดิม ให้ error ที่ field 'name'
        $validator->after(function ($validator) use ($user, $input) {
            if (array_key_exists('name', $input)) {
                $new = trim((string) $input['name']);
                $old = trim((string) $user->name);
                if ($new === $old) {
                    $validator->errors()->add('name', 'ชื่อผู้ใช้เหมือนเดิม ไม่มีการเปลี่ยนแปลง');
                }
            }
        });

        // ใช้ error bag ที่ Jetstream คาดหวัง
        $validator->validateWithBag('updateProfileInformation');

        if ($input['email'] !== $user->email && $user instanceof MustVerifyEmail) {
            $this->updateVerifiedUser($user, $input);
        } else {
            $user->forceFill([
                'name'  => $input['name'],
                'email' => $input['email'],
            ])->save();
        }

        if (isset($input['photo'])) {
            $user->updateProfilePhoto($input['photo']);
        }
    }

    protected function updateVerifiedUser($user, array $input): void
    {
        $user->forceFill([
            'name'              => $input['name'],
            'email'             => $input['email'],
            'email_verified_at' => null,
        ])->save();

        $user->sendEmailVerificationNotification();
    }
}
