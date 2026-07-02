<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Contact\StoreContactRequest;
use App\Http\Resources\ContactCollection;
use App\Http\Resources\ContactResource;
use App\Models\Contact;
use App\Services\ContactService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ContactController extends Controller
{
    public function __construct(
        private readonly ContactService $contactService
    ) {}

    /**
     * POST /api/v1/contacts
     * Kirim pesan kontak baru.
     * Bisa diakses oleh guest maupun user yang sudah login.
     */
    public function store(StoreContactRequest $request): JsonResponse
    {
        $contact = $this->contactService->store(
            data: $request->validated(),
            user: $request->user(), // null jika guest
            ipAddress: $request->ip() ?? 'unknown',
        );

        return response()->json([
            'success' => true,
            'message' => 'Pesan berhasil dikirim. Terima kasih telah menghubungi kami!',
            'data'    => new ContactResource($contact),
        ], Response::HTTP_CREATED);
    }

    /**
     * GET /api/v1/contacts
     * List semua pesan (khusus admin).
     * Mendukung filter by status: ?status=unread|read|replied
     */
    public function index(Request $request): JsonResponse
    {
        $status   = $request->query('status');
        $perPage  = (int) $request->query('per_page', 15);
        $contacts = $this->contactService->getAll($status, $perPage);

        return response()->json([
            'success' => true,
            'message' => 'Data pesan berhasil diambil.',
            'data'    => ContactResource::collection($contacts->items()),
            'meta'    => [
                'total'        => $contacts->total(),
                'per_page'     => $contacts->perPage(),
                'current_page' => $contacts->currentPage(),
                'last_page'    => $contacts->lastPage(),
            ],
        ]);
    }

    /**
     * GET /api/v1/contacts/{id}
     * Detail pesan — otomatis tandai 'read' (khusus admin).
     */
    public function show(int $id): JsonResponse
    {
        $contact = $this->contactService->findAndMarkRead($id);

        return response()->json([
            'success' => true,
            'message' => 'Detail pesan berhasil diambil.',
            'data'    => new ContactResource($contact),
        ]);
    }

    /**
     * PATCH /api/v1/contacts/{contact}/status
     * Update status pesan: unread | read | replied (khusus admin).
     */
    public function updateStatus(Request $request, Contact $contact): JsonResponse
    {
        $request->validate([
            'status' => ['required', 'in:unread,read,replied'],
        ], [
            'status.required' => 'Status tidak boleh kosong.',
            'status.in'       => 'Status harus salah satu dari: unread, read, replied.',
        ]);

        $contact = $this->contactService->updateStatus($contact, $request->status);

        return response()->json([
            'success' => true,
            'message' => 'Status pesan berhasil diperbarui.',
            'data'    => new ContactResource($contact),
        ]);
    }

    /**
     * DELETE /api/v1/contacts/{contact}
     * Hapus pesan (soft delete, khusus admin).
     */
    public function destroy(Contact $contact): JsonResponse
    {
        $this->contactService->delete($contact);

        return response()->json([
            'success' => true,
            'message' => 'Pesan berhasil dihapus.',
            'data'    => null,
        ], Response::HTTP_OK);
    }
}
