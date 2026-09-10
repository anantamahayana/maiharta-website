<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactSubmission;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function index(Request $request)
    {
        $filter = $request->query('filter', 'semua');
        $search = trim((string) $request->query('q', ''));

        $messages = ContactSubmission::query()
            ->when($filter === 'belum-dibaca', fn ($q) => $q->where('is_read', false))
            ->when($filter === 'dibaca', fn ($q) => $q->where('is_read', true))
            ->when($search !== '', fn ($q) => $q->where(function ($w) use ($search) {
                $w->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('company', 'like', "%{$search}%")
                    ->orWhere('message', 'like', "%{$search}%");
            }))
            ->latest()
            ->paginate(12)
            ->withQueryString();

        return view('admin.messages.index', [
            'messages' => $messages,
            'filter' => $filter,
            'search' => $search,
            'unreadCount' => ContactSubmission::where('is_read', false)->count(),
            'selected' => $request->query('open') ? ContactSubmission::find($request->query('open')) : null,
        ]);
    }

    public function show(ContactSubmission $message)
    {
        if (! $message->is_read) {
            $message->update(['is_read' => true]);
        }

        return redirect()->route('admin.messages.index', ['open' => $message->id] + request()->only('filter', 'q'));
    }

    public function toggle(ContactSubmission $message)
    {
        $message->update(['is_read' => ! $message->is_read]);

        return back()->with('status', $message->is_read ? 'Pesan ditandai sudah dibaca.' : 'Pesan ditandai belum dibaca.');
    }

    public function destroy(ContactSubmission $message)
    {
        $message->delete();

        return redirect()->route('admin.messages.index')->with('status', 'Pesan dihapus.');
    }
}
