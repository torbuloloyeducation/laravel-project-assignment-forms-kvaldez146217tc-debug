<x-layout>

    <h2>Email Form</h2>

    <!-- Success Message -->
    @if(session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @endif

    <!-- Error Message -->
    @if(session('error'))
        <p style="color: red;">{{ session('error') }}</p>
    @endif

    <!-- Validation Error -->
    @error('email')
        <p style="color: red;">{{ $message }}</p>
    @enderror

    <!-- Form -->
    <form method="POST" action="/submit-email">
        @csrf
        <input type="text" name="email" placeholder="Enter email">
        <button type="submit">Add Email</button>
    </form>

    <hr>

    <h3>Saved Emails:</h3>

    @foreach(session('emails', []) as $index => $email)
        <p>
            {{ $email }}

            <form method="POST" action="/delete-email/{{ $index }}">
                @csrf
                <button type="submit">Delete</button>
            </form>
        </p>
    @endforeach

</x-layout>