<?php

namespace App\Services;

use App\Models\Contact;
use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;

class ContactService
{
    /**
     * Simpan pesan kontak baru.
     * Mendukung guest (user null) maupun user teregistrasi.
     *
     * @param  array<string, mixed>  $data
     */
    public function store(array $data, ?User $user, string $ipAddress): Contact
    {
        return Contact::create([
            'user_id'    => $user?->id,
            'nama'       => $data['nama'],
            'email'      => $data['email'],
            'website'    => $data['website'] ?? null,
            'telp'       => $data['telp'],
            'pesan'      => $data['pesan'],
            'status'     => 'unread',
            'ip_address' => $ipAddress,
        ]);
    }

    /**
     * Ambil semua pesan dengan pagination dan filter status (untuk admin).
     */
    public function getAll(?string $status = null, int $perPage = 15): LengthAwarePaginator
    {
        $query = Contact::with('user')->latest();

        if ($status) {
            $query->byStatus($status);
        }

        return $query->paginate($perPage);
    }

    /**
     * Ambil detail satu pesan dan tandai sebagai 'read' jika masih 'unread'.
     */
    public function findAndMarkRead(int $id): Contact
    {
        $contact = Contact::with('user')->findOrFail($id);

        if ($contact->status === 'unread') {
            $contact->update(['status' => 'read']);
        }

        return $contact;
    }

    /**
     * Update status pesan (unread / read / replied).
     */
    public function updateStatus(Contact $contact, string $status): Contact
    {
        $contact->update(['status' => $status]);

        return $contact->fresh();
    }

    /**
     * Hapus pesan (soft delete).
     */
    public function delete(Contact $contact): void
    {
        $contact->delete();
    }
}
