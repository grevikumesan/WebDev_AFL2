@foreach($users as $user)
    <tr>
        <td>
            @if($user->image)
                <img src="{{ asset('storage/' . $user->image) }}" alt="{{ $user->name }}" style="width: 50px; height: 50px; object-fit: cover; border-radius: 50%;">
            @else
                <img src="{{ asset('images/default-profile.png') }}" alt="{{ $user->name }}" style="width: 50px; height: 50px; object-fit: cover; border-radius: 50%;">
            @endif
        </td>
        <td>{{ $user->name }}</td>
        <td>{{ $user->email }}</td>
        <td>{{ $user->role }}</td>
        <td>
            </td>
    </tr>
@endforeach
