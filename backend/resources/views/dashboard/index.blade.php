<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>لوحة التحكم - EgyptNet ISP</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        .card-stats { border-radius: 15px; transition: transform 0.3s; }
        .card-stats:hover { transform: scale(1.02); }
        .stat-number { font-size: 2.5rem; font-weight: bold; }
        .online { color: #28a745; }
        .offline { color: #dc3545; }
    </style>
</head>
<body>
    <div class="container-fluid py-4">
        <h1 class="mb-4">📊 لوحة التحكم - EgyptNet ISP</h1>

        <!-- بطاقات الإحصائيات -->
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="card card-stats bg-primary text-white">
                    <div class="card-body">
                        <h5>👤 إجمالي المستخدمين</h5>
                        <div class="stat-number" id="total-users">{{ $totalUsers }}</div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card card-stats bg-success text-white">
                    <div class="card-body">
                        <h5>✅ المستخدمين النشطين</h5>
                        <div class="stat-number">{{ $activeUsers }}</div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card card-stats bg-info text-white">
                    <div class="card-body">
                        <h5>🟢 المتصلين حالياً</h5>
                        <div class="stat-number" id="online-users">{{ $onlineUsers }}</div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card card-stats bg-warning text-dark">
                    <div class="card-body">
                        <h5>📡 الأجهزة المتصلة</h5>
                        <div class="stat-number" id="online-devices">{{ $onlineDevices }} / {{ $devices->count() }}</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- الرسوم البيانية -->
        <div class="row mb-4">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h5>📊 توزيع المستخدمين حسب الباقة</h5>
                    </div>
                    <div class="card-body">
                        <canvas id="packageChart" height="250"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h5>📈 نمو المستخدمين (آخر 7 أيام)</h5>
                    </div>
                    <div class="card-body">
                        <canvas id="dailyChart" height="250"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- توزيع الباقات (قائمة) -->
        <div class="row mb-4">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h5>📊 توزيع المستخدمين حسب الباقة (تفصيلي)</h5>
                    </div>
                    <div class="card-body">
                        <ul class="list-group">
                            @foreach($packageStats as $stat)
                                <li class="list-group-item d-flex justify-content-between">
                                    <span>{{ $stat->profile ?? 'بدون باقة' }}</span>
                                    <span class="badge bg-primary">{{ $stat->total }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>

            <!-- المستخدمين المتصلين -->
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h5>🟢 المتصلين حالياً</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>المستخدم</th>
                                        <th>الباقة</th>
                                        <th>المدة</th>
                                    </tr>
                                </thead>
                                <tbody id="connected-users">
                                    @foreach($connectedUsers as $user)
                                        <tr>
                                            <td>{{ $user->username }}</td>
                                            <td>{{ $user->profile ?? 'default' }}</td>
                                            <td>{{ $user->uptime ? gmdate('H:i:s', $user->uptime) : '--' }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- حالة الأجهزة -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5>📡 حالة أجهزة MikroTik</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>الجهاز</th>
                                        <th>IP</th>
                                        <th>الحالة</th>
                                        <th>آخر اتصال</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($devices as $device)
                                        <tr>
                                            <td>{{ $device->name }}</td>
                                            <td>{{ $device->ip_address }}</td>
                                            <td>
                                                <span class="badge {{ $device->is_online ? 'bg-success' : 'bg-danger' }}">
                                                    {{ $device->is_online ? '🟢 متصل' : '🔴 غير متصل' }}
                                                </span>
                                            </td>
                                            <td>{{ $device->last_ping_at ? $device->last_ping_at->diffForHumans() : '--' }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // رسم بياني لتوزيع الباقات
        document.addEventListener('DOMContentLoaded', function() {
            const packageCtx = document.getElementById('packageChart').getContext('2d');
            const packageData = @json($packageStats);
            new Chart(packageCtx, {
                type: 'pie',
                data: {
                    labels: packageData.map(item => item.profile || 'بدون باقة'),
                    datasets: [{
                        data: packageData.map(item => item.total),
                        backgroundColor: ['#007bff', '#28a745', '#ffc107', '#dc3545', '#17a2b8', '#6f42c1', '#fd7e14']
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'bottom'
                        }
                    }
                }
            });

            // رسم بياني للنمو اليومي (بيانات تجريبية)
            const dailyCtx = document.getElementById('dailyChart').getContext('2d');
            new Chart(dailyCtx, {
                type: 'line',
                data: {
                    labels: ['يوم 1', 'يوم 2', 'يوم 3', 'يوم 4', 'يوم 5', 'يوم 6', 'اليوم'],
                    datasets: [{
                        label: 'مستخدمين جدد',
                        data: [5, 8, 3, 10, 7, 12, 6],
                        borderColor: '#007bff',
                        backgroundColor: 'rgba(0, 123, 255, 0.1)',
                        fill: true,
                        tension: 0.1
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'bottom'
                        }
                    }
                }
            });
        });

        // تحديث تلقائي كل 30 ثانية
        setInterval(function() {
            fetch('/api/dashboard/stats')
                .then(response => response.json())
                .then(data => {
                    document.getElementById('total-users').textContent = data.totalUsers;
                    document.getElementById('online-users').textContent = data.onlineUsers;
                    document.getElementById('online-devices').textContent = data.onlineDevices + ' / ' + data.totalDevices;
                })
                .catch(error => console.error('Error:', error));
        }, 30000);
    </script>
</body>
</html>
