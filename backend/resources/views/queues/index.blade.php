@extends('layouts.app')

@section('title', 'إدارة قوائم الانتظار - Queues')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>📊 إدارة قوائم الانتظار (Queues)</h1>
        <div>
            <a href="{{ route('queues.create', ['device_id' => $device->id ?? 1]) }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> إضافة Queue جديدة
            </a>
            <a href="{{ route('queues.index', ['device_id' => $device->id ?? 1]) }}" class="btn btn-secondary">
                <i class="fas fa-sync"></i> تحديث
            </a>
        </div>
    </div>

    <!-- اختيار الجهاز -->
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('queues.index') }}" class="row g-3">
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

    <!-- جدول قوائم الانتظار -->
    <div class="card">
        <div class="card-header">
            <h5>قائمة الـ Queues ({{ count($queues) }})</h5>
        </div>
        <div class="card-body">
            @if($connected && count($queues) > 0)
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>الاسم</th>
                                <th>الهدف (Target)</th>
                                <th>الحد الأقصى</th>
                                <th>الأولوية</th>
                                <th>التعليق (Comment)</th>
                                <th>الحالة</th>
                                <th>الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($queues as $index => $queue)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td><strong>{{ $queue['name'] }}</strong></td>
                                <td>{{ $queue['target'] ?? '-' }}</td>
                                <td>{{ $queue['max_limit'] ?? '-' }}</td>
                                <td>{{ $queue['priority'] ?? '-' }}</td>
                                <td>{{ $queue['comment'] ?? '-' }}</td>
                                <td>
                                    <span class="badge {{ isset($queue['disabled']) && $queue['disabled'] ? 'bg-danger' : 'bg-success' }}">
                                        {{ isset($queue['disabled']) && $queue['disabled'] ? '⛔ معطل' : '✅ مفعل' }}
                                    </span>
                                </td>
                                <td>
                                    <!-- زر التعديل -->
                                    <a href="{{ route('queues.edit', ['name' => $queue['name'], 'device_id' => $device->id ?? 1]) }}" 
                                       class="btn btn-sm btn-primary">
                                        <i class="fas fa-edit"></i> تعديل
                                    </a>

                                    <form action="{{ route('queues.toggle', ['name' => $queue['name']]) }}" method="POST" class="d-inline">
                                        @csrf
                                        <input type="hidden" name="device_id" value="{{ $device->id ?? 1 }}">
                                        <input type="hidden" name="action" value="{{ isset($queue['disabled']) && $queue['disabled'] ? 'enable' : 'disable' }}">
                                        <button type="submit" class="btn btn-sm {{ isset($queue['disabled']) && $queue['disabled'] ? 'btn-success' : 'btn-warning' }}">
                                            {{ isset($queue['disabled']) && $queue['disabled'] ? '🔄 تفعيل' : '⏸️ تعطيل' }}
                                        </button>
                                    </form>

                                    <form action="{{ route('queues.destroy', ['name' => $queue['name']]) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <input type="hidden" name="device_id" value="{{ $device->id ?? 1 }}">
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('هل أنت متأكد من حذف هذه القائمة؟')">
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
                    ℹ️ لا توجد قوائم انتظار على هذا الجهاز.
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
