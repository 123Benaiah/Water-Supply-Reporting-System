<tbody>
    @forelse($users as $user)
        <tr>
            <td class="py-3">
                <div class="d-flex align-items-center gap-2">
                    @if($user->profile_picture)
                        <img src="{{ asset('storage/' . $user->profile_picture) }}" alt="{{ $user->name }}" class="rounded-circle" width="40" height="40">
                    @else
                        <div class="rounded-circle bg-ocean-600 d-flex align-items-center justify-content-center text-white fw-bold small" style="width: 40px; height: 40px; background: linear-gradient(135deg, #0ea5e9, #0369a1);">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>
                    @endif
                    <span class="small fw-semibold text-ocean-900">{{ $user->name }}</span>
                </div>
            </td>
            <td class="py-3 text-nowrap small text-muted">{{ $user->email }}</td>
            <td class="py-3 text-nowrap">
                <span class="badge {{ $user->isAdmin() ? 'bg-ocean-700' : 'bg-secondary' }}">
                    {{ $user->isAdmin() ? 'Admin' : 'Reporter' }}
                </span>
            </td>
            <td class="py-3 text-nowrap small text-muted">{{ $user->reports_count }}</td>
            <td class="py-3 text-nowrap small text-muted">{{ $user->created_at->format('M d, Y') }}</td>
            <td class="py-3 text-nowrap">
                @if($user->id !== auth()->id())
                    <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure? This will delete all reports by {{ $user->name }}.');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger btn-sm">Delete</button>
                    </form>
                @else
                    <span class="small text-muted">(You)</span>
                @endif
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="6" class="text-center py-4 text-muted">No users found</td>
        </tr>
    @endforelse
</tbody>