@if ($errors->any())
<div id="error-message" class="alert alert-danger">
    <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

@if (session('success'))
<div id="success-message" class="alert alert-success">
    {{ session('success') }}
</div>
@endif