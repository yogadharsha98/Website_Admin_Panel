@foreach ($animals as $animal)
    <tr>
        <td>
            <input type="checkbox" id="animal-{{ $animal->id }}" name="animals[]" value="{{ $animal->id }}">
            <label for="animal-{{ $animal->id }}"></label>
        </td>
        <td>{{ $animal->id }}</td>
        <td>{{ $animal->tag_id }}</td>
        <td>{{ $animal->gender }}</td>
        <td>{{ $animal->created_at }}</td>
    </tr>
@endforeach
