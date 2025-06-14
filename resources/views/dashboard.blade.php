@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="dashboard-container">
    <h2>Dashboard</h2>
    @if (session('error'))
        <div class="alert alert-error">{{ session('error') }}</div>
    @endif
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="stats">
        <div class="stat-card">
            <h3>Tổng Người Dùng</h3>
            <p>{{ $totalUsers }}</p>
        </div>
        <div class="stat-card">
            <h3>Tổng Lượt Đăng Nhập</h3>
            <p>{{ $totalLogins }}</p>
        </div>
    </div>

    <div class="chart-section">
        <h3>Thống kê tài khoản theo ngày</h3>
        <canvas id="userChart"></canvas>
    </div>

    <div class="chart-section">
        <h3>Thống kê lượt đăng nhập theo ngày</h3>
        <canvas id="loginChart"></canvas>
    </div>
</div>

<script>
    const userCounts = @json($userCounts);
    const loginCounts = @json($loginCounts);
    const labels = @json($dates);
    console.log('User Counts:', userCounts);
    console.log('Login Counts:', loginCounts);
    console.log('Labels:', labels);

    if (typeof window.Chart === 'undefined') {
        console.error('Chart.js không tải được. Kiểm tra npm run build hoặc CDN.');
    } else {
        document.addEventListener('DOMContentLoaded', function() {
            try {
                const userCtx = document.getElementById('userChart').getContext('2d');
                new Chart(userCtx, {
                    type: 'bar',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Số tài khoản',
                            data: Object.values(userCounts),
                            backgroundColor: 'rgba(54, 162, 235, 0.6)',
                            borderColor: 'rgba(54, 162, 235, 1)',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        scales: {
                            y: {
                                beginAtZero: true,
                                title: { display: true, text: 'Số tài khoản' }
                            },
                            x: {
                                title: { display: true, text: 'Ngày' }
                            }
                        },
                        plugins: {
                            legend: { display: true, position: 'top' }
                        }
                    }
                });

                const loginCtx = document.getElementById('loginChart').getContext('2d');
                new Chart(loginCtx, {
                    type: 'bar',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Số lượt đăng nhập',
                            data: Object.values(loginCounts),
                            backgroundColor: 'rgba(153, 102, 255, 0.6)',
                            borderColor: 'rgba(153, 102, 255, 1)',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        scales: {
                            y: {
                                beginAtZero: true,
                                title: { display: true, text: 'Số lượt đăng nhập' }
                            },
                            x: {
                                title: { display: true, text: 'Ngày' }
                            }
                        },
                        plugins: {
                            legend: { display: true, position: 'top' }
                        }
                    }
                });
            } catch (error) {
                console.error('Lỗi khi tạo biểu đồ:', error);
            }
        });
    }
</script>
@endsection