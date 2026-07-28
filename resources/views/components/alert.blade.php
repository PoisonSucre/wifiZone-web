@if(session('success'))
<div class="alert alert-success">
    <i class="fas fa-check-circle" style="margin-right:8px;"></i>{{ session('success') }}
</div>
@endif
@if(session('error'))
<div class="alert alert-error">
    <i class="fas fa-exclamation-circle" style="margin-right:8px;"></i>{{ session('error') }}
</div>
@endif
@if($errors->any())
<div class="alert alert-error">
    <i class="fas fa-exclamation-circle" style="margin-right:8px;"></i>
    <span>
        @foreach($errors->all() as $error)
            {{ $error }}@if(!$loop->last)<br>@endif
        @endforeach
    </span>
</div>
@endif
