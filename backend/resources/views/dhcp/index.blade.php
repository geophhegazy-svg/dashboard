@extends('layouts.app')

@section('title', 'إدارة عقود الإيجار - DHCP')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>🌐 إدارة عقود الإيجار (DHCP Leases)</h1>
        <div>
            <a href="{{ route('dhcp.create', ['device_id' => $device->id ?? 1]) }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> إضافة عقد جديد
            </a>
            <a href="{{ route('dhcp.index', ['device_id' => $device->id ?? 1]) }}" class="btn btn-secondary">
                <i class="fas fa-sync"></i> تحديث
            </a>
        </div>
    </div>

    <!-- اختيار الجهاز -->
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('dhcp.index') }}" class="row g-3">
                <div class="col-md-4">
                    <label for="device_id" class="form-label">اختر الجهاز</label>
                    <select name="device_id" id="device_id" class="form-control" onchange="this.form.submit()">
                        @foreach($devices as $d)
                            <option value="{{ $d->id }}" {{ ($device->id ?? 1) == $d->id ? 'selected' : '' }}>
                                {{ $d->name }} ({{ $d->ip_address }})
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4 d-flex align-items-end">
                    <span class="badge {{ $connected ? 'bg-success' : 'bg-danger' }} p-2">
                        {{ $connected ? '🟢 متصل' : '🔴 غير متصل' }}
                    </span>
                </div>
            </form>
        </div>
    </div>

    <!-- عرض الأخطاء والنجاح -->
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <!-- جدول عقود الإيجار -->
    <div class="card">
        <div class="card-header">
            <h5>قائمة عقود الإيجار ({{ isset($pagination) ? $pagination['total'] : 0 }})</h5>
        </div>
        <div class="card-body">
            @if($connected && count($leases) > 0)
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>ID</th>
                                <th>العنوان (IP)</th>
                                <th>عنوان MAC</th>
                                <th>اسم المضيف</th>
                                <th>التعليق (Comment)</th>
                                <th>الحالة</th>
                                <th>الخادم</th>
                                <th>الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($leases as $index => $lease)
                            <tr>
                                <td>{{ isset($pagination) ? $pagination['from'] + $index : $index + 1 }}</td>
                                <td><code>{{ $lease['id'] ?? '-' }}</code></td>
                                <td><strong>{{ $lease['address'] ?? '-' }}</strong></td>
                                <td><code>{{ $lease['mac_address'] ?? '-' }}</code></td>
                                <td>{{ $lease['hostname'] ?? '-' }}</td>
                                <td>{{ $lease['comment'] ?? '-' }}</td>
                                <td>
                                    <span class="badge {{ $lease['status'] == 'bound' ? 'bg-success' : 'bg-warning text-dark' }}">
                                        {{ $lease['status'] ?? 'waiting' }}
                                    </span>
                                </td>
                                <td>{{ $lease['server'] ?? '-' }}</td>
                                <td>
                                    <a href="{{ route('dhcp.edit', ['id' => $lease['id'], 'device_id' => $device->id ?? 1]) }}" 
                                       class="btn btn-sm btn-primary">
                                        <i class="fas fa-edit"></i> تعديل
                                    </a>
                                    <form action="{{ route('dhcp.destroy', ['id' => $lease['id']]) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <input type="hidden" name="device_id" value="{{ $device->id ?? 1 }}">
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('هل أنت متأكد من حذف هذا العقد؟')">
                                            🗑️ حذف
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if(isset($pagination) && $pagination['last_page'] > 1)
                    <nav aria-label="Page navigation">
                        <ul class="pagination justify-content-center">
                            <li class="page-item {{ $pagination['current_page'] == 1 ? 'disabled' : '' }}">
                                <a class="page-link" href="{{ route('dhcp.index', ['device_id' => $device->id ?? 1, 'page' => 1]) }}">الأولى</a>
                            </li>
                            <li class="page-item {{ $pagination['current_page'] == 1 ? 'disabled' : '' }}">
                                <a class="page-link" href="{{ route('dhcp.index', ['device_id' => $device->id ?? 1, 'page' => $pagination['current_page'] - 1]) }}">السابق</a>
                            </li>
                            
                            @php
                                $start = max(1, $pagination['current_page'] - 2);
                                $end = min($pagination['last_page'], $pagination['current_page'] + 2);
                            @endphp
                            
                            @for($i = $start; $i <= $end; $i++)
                                <li class="page-item {{ $i == $pagination['current_page'] ? 'active' : '' }}">
                                    <a class="page-link" href="{{ route('dhcp.index', ['device_id' => $device->id ?? 1, 'page' => $i]) }}">{{ $i }}</a>
                                </li>
                            @endfor
                            
                            <li class="page-item {{ $pagination['current_page'] == $pagination['last_page'] ? 'disabled' : '' }}">
                                <a class="page-link" href="{{ route('dhcp.index', ['device_id' => $device->id ?? 1, 'page' => $pagination['current_page'] + 1]) }}">التالي</a>
                            </li>
                            <li class="page-item {{ $pagination['current_page'] == $pagination['last_page'] ? 'disabled' : '' }}">
                                <a class="page-link" href="{{ route('dhcp.index', ['device_id' => $device->id ?? 1, 'page' => $pagination['last_page']]) }}">الأخيرة</a>
                            </li>
                        </ul>
                    </nav>
                    <div class="text-center">
                        <small>عرض {{ $pagination['from'] }} - {{ $pagination['to'] }} من {{ $pagination['total'] }} عقد</small>
                    </div>
                @endif

            @elseif(!$connected)
                <div class="alert alert-warning">
                    ⚠️ لا يمكن الاتصال بالجهاز. تأكد من إعدادات الجهاز.
                </div>
            @else
                <div class="alert alert-info">
                    ℹ️ لا توجد عقود إيجار على هذا الجهاز.
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
