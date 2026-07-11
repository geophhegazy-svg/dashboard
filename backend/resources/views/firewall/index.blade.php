@extends('layouts.app')

@section('title', 'إدارة قواعد الجدار الناري - Firewall')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>🛡️ إدارة قواعد الجدار الناري (Firewall)</h1>
        <div>
            <a href="{{ route('firewall.create', ['device_id' => $device->id ?? 1]) }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> إضافة قاعدة جديدة
            </a>
            <a href="{{ route('firewall.index', ['device_id' => $device->id ?? 1]) }}" class="btn btn-secondary">
                <i class="fas fa-sync"></i> تحديث
            </a>
        </div>
    </div>

    <!-- اختيار الجهاز -->
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('firewall.index') }}" class="row g-3">
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

    <!-- جدول قواعد الجدار الناري -->
    <div class="card">
        <div class="card-header">
            <h5>قائمة قواعد الجدار الناري ({{ count($rules) }})</h5>
        </div>
        <div class="card-body">
            @if($connected && count($rules) > 0)
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>ID</th>
                                <th>السلسلة (Chain)</th>
                                <th>الإجراء (Action)</th>
                                <th>المصدر</th>
                                <th>الوجهة</th>
                                <th>البروتوكول</th>
                                <th>المنفذ</th>
                                <th>التعليق (Comment)</th>
                                <th>الحالة</th>
                                <th>الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($rules as $index => $rule)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td><code>{{ $rule['id'] ?? '-' }}</code></td>
                                <td><span class="badge bg-info">{{ $rule['chain'] ?? '-' }}</span></td>
                                <td><span class="badge bg-warning text-dark">{{ $rule['action'] ?? '-' }}</span></td>
                                <td>{{ $rule['src_address'] ?? '-' }}</td>
                                <td>{{ $rule['dst_address'] ?? '-' }}</td>
                                <td>{{ $rule['protocol'] ?? '-' }}</td>
                                <td>{{ $rule['port'] ?? '-' }}</td>
                                <td>{{ $rule['comment'] ?? '-' }}</td>
                                <td>
                                    <span class="badge {{ isset($rule['disabled']) && $rule['disabled'] ? 'bg-danger' : 'bg-success' }}">
                                        {{ isset($rule['disabled']) && $rule['disabled'] ? '⛔ معطل' : '✅ مفعل' }}
                                    </span>
                                </td>
                                <td>
                                    <!-- 🔥 زر التعديل -->
                                    <a href="{{ route('firewall.edit', ['id' => $rule['id'], 'device_id' => $device->id ?? 1]) }}" 
                                       class="btn btn-sm btn-primary">
                                        <i class="fas fa-edit"></i> تعديل
                                    </a>

                                    <form action="{{ route('firewall.destroy', ['id' => $rule['id']]) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <input type="hidden" name="device_id" value="{{ $device->id ?? 1 }}">
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('هل أنت متأكد من حذف هذه القاعدة؟')">
                                            🗑️ حذف
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @elseif(!$connected)
                <div class="alert alert-warning">
                    ⚠️ لا يمكن الاتصال بالجهاز. تأكد من إعدادات الجهاز.
                </div>
            @else
                <div class="alert alert-info">
                    ℹ️ لا توجد قواعد جدار ناري على هذا الجهاز.
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
