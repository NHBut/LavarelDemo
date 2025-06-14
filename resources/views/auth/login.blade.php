@extends('layouts.app')

@section('content')
<div class="form-container">
    <h2>Đăng Nhập</h2>
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if ($errors->any())
        <div class="alert alert-error">
            @foreach ($errors->all() as $error)
                {{ $error }}
            @endforeach
        </div>
    @endif
    <form id="loginForm" action="{{ route('login') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" value="{{ old('email') }}">
            <span class="error" id="emailError">Vui lòng nhập email hợp lệ.</span>
        </div>
        <div class="form-group">
            <label for="password">Mật Khẩu</label>
            <input type="password" id="password" name="password">
            <span class="error" id="passwordError">Vui lòng nhập mật khẩu ít nhất 6 ký tự.</span>
        </div>
        <button type="submit">Đăng Nhập</button>
    </form>
</div>

<script>
function validateField(id, value) {
    const errorElement = document.getElementById(id + 'Error');
    if (id === 'email') {
        if (!value || !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(value)) {
            errorElement.style.display = 'block';
            return false;
        }
    }
    if (id === 'password') {
        if (!value || value.length < 6) {
            errorElement.style.display = 'block';
            return false;
        }
    }
    errorElement.style.display = 'none';
    return true;
}

['email', 'password'].forEach(id => {
    const input = document.getElementById(id);
    input.addEventListener('input', function() {
        validateField(id, this.value.trim());
    });
    input.addEventListener('blur', function() {
        if (this.value.trim()) {
            validateField(id, this.value.trim());
        }
    });
});

document.getElementById('loginForm').addEventListener('submit', function(e) {
    let isValid = true;
    const email = document.getElementById('email').value.trim();
    const password = document.getElementById('password').value;

    if (!validateField('email', email)) isValid = false;
    if (!validateField('password', password)) isValid = false;

    if (!isValid) e.preventDefault();
});
</script>
@endsection