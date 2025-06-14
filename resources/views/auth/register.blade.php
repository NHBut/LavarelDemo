@extends('layouts.app')

@section('content')
<div class="form-container">
    <h2>Đăng Ký</h2>
    <form id="registerForm" action="{{ route('register') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="name">Họ và Tên</label>
            <input type="text" id="name" name="name" value="{{ old('name') }}">
            <span class="error" id="nameError">Vui lòng nhập họ và tên.</span>
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" value="{{ old('email') }}">
            <span class="error" id="emailError">Vui lòng nhập email hợp lệ.</span>
        </div>
        <div class="form-group">
            <label for="password">Mật Khẩu</label>
            <input type="password" id="password" name="password">
            <span class="error" id="passwordError">Mật khẩu phải có ít nhất 6 ký tự.</span>
        </div>
        <div class="form-group">
            <label for="password_confirmation">Xác Nhận Mật Khẩu</label>
            <input type="password" id="password_confirmation" name="password_confirmation">
            <span class="error" id="confirmError">Xác nhận mật khẩu không khớp hoặc trống.</span>
        </div>
        <button type="submit">Đăng Ký</button>
    </form>
</div>

<style>
    .error {
        display: none;
        color: red;
        font-size: 0.9rem;
        margin-top: 4px;
    }
    .form-group input.error-border {
        border-color: red;
    }
</style>

<script>
function showError(id, message) {
    const errorElement = document.getElementById(id + 'Error') || (id === 'password_confirmation' && document.getElementById('confirmError'));
    const input = document.getElementById(id);
    if (errorElement) {
        errorElement.style.display = 'block';
        errorElement.textContent = message;
        input.classList.add('error-border');
    }
}

function hideError(id) {
    const errorElement = document.getElementById(id + 'Error') || (id === 'password_confirmation' && document.getElementById('confirmError'));
    const input = document.getElementById(id);
    if (errorElement) {
        errorElement.style.display = 'none';
        input.classList.remove('error-border');
    }
}

function validateField(id, value) {
    if (id === 'name') {
        if (!value.trim()) {
            showError(id, 'Vui lòng nhập họ và tên.');
            return false;
        }
    }

    if (id === 'email') {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!value.trim() || !emailRegex.test(value)) {
            showError(id, 'Vui lòng nhập email hợp lệ.');
            return false;
        }
    }

    if (id === 'password') {
        if (!value.trim() || value.length < 6) {
            showError(id, 'Mật khẩu phải có ít nhất 6 ký tự.');
            return false;
        }
        // Nếu người dùng đã nhập confirm, recheck confirm
        const confirmValue = document.getElementById('password_confirmation').value.trim();
        if (confirmValue !== '') {
            validateField('password_confirmation', confirmValue);
        }
    }

    if (id === 'password_confirmation') {
        const password = document.getElementById('password').value.trim();
        if (!value.trim() || value !== password) {
            showError(id, 'Xác nhận mật khẩu không khớp hoặc trống.');
            return false;
        }
    }

    hideError(id);
    return true;
}

// Thêm sự kiện realtime
['name', 'email', 'password', 'password_confirmation'].forEach(id => {
    const input = document.getElementById(id);
    input.addEventListener('input', () => {
        validateField(id, input.value);
    });
    input.addEventListener('blur', () => {
        if (input.value.trim() !== '') {
            validateField(id, input.value);
        }
    });
});

// Validate khi submit
document.getElementById('registerForm').addEventListener('submit', function(e) {
    let isValid = true;
    ['name', 'email', 'password', 'password_confirmation'].forEach(id => {
        const value = document.getElementById(id).value;
        if (!validateField(id, value)) isValid = false;
    });
    if (!isValid) {
        e.preventDefault();
    }
});
</script>
@endsection
