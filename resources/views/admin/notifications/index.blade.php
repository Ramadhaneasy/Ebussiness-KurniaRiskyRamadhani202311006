@extends('layouts.admin')

@section('content')
<div class="flex items-center justify-between mb-4">
    <div>
        <h2 class="text-xl font-bold text-sky-900">Notifications</h2>
        <p class="text-sm text-sky-600">All notifications for this admin account.</p>
    </div>

    <form method="POST" action="{{ route('admin.notifications.readAll') }}">
        @csrf
        <button class="px-4 py-2 rounded-xl bg-sky-600 text-white font-semibold hover:bg-sky-700">
            Mark all as read
        </button>
    </form>
</div>

<div class="rounded-2xl border border-sky-100 bg-white/70 overflow-hidden">
    @forelse($notifications as $n)
        <div class="p-4 border-b border-sky-100 flex items-start justify-between gap-4 {{ $n->read_at ? 'opacity-70' : '' }}">
            <div class="min-w-0">
                <div class="font-semibold text-sky-900">
                    {{ $n->data['title'] ?? 'Notification' }}
                    @if(!$n->read_at)
                        <span class="ml-2 inline-flex text-xs px-2 py-0.5 rounded-full bg-rose-100 text-rose-700 border border-rose-200">New</span>
                    @endif
                </div>

                <div class="text-sm text-slate-600 break-words">
                    {{ $n->data['message'] ?? '-' }}
                </div>

                <div class="text-xs text-slate-500 mt-1">
                    {{ $n->created_at->diffForHumans() }}
                </div>
            </div>

            <form method="POST" action="{{ route('admin.notifications.read', $n->id) }}">
                @csrf
                <button class="text-sky-700 font-semibold hover:underline">
                    Open
                </button>
            </form>
        </div>
    @empty
        <div class="p-6 text-slate-600">No notifications.</div>
    @endforelse
</div>

<div class="mt-4">
    {{ $notifications->links() }}
</div>
@endsection
