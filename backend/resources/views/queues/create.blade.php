@extends('layouts.app')

@section('title', 'إضافة Queue جديدة')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>➕ إضافة Queue جديدة</h1>
        <a href="{{ route('queues.index', ['device_id' => $device->id ?? 1]) }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> العودة
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('queues.store') }}" method="POST">
                @csrf

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="device_id" class="form-label">الجهاز *</label>
                        <select name="device_id" id="device_id" class="form-control @error('device_id') is-invalid @enderror" required>
                            @foreach($devices as $d)
                                <option value="{{ $d->id }}" {{ ($device->id ?? 1) == $d->id ? 'selected' : '' }}>
                                    {{ $d->name }} ({{ $d->ip_address }})
                                </option>
                            @endforeach
                        </select>
                        @error('device_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="name" class="form-label">اسم الـ Queue *</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror"
                               id="name" name="name" value="{{ old('name') }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="target" class="form-label">الهدف (Target) *</label>
                        <input type="text" class="form-control @error('target') is-invalid @enderror"
                               id="target" name="target" value="{{ old('target') }}"
                               placeholder="مثال: 192.168.1.0/24 أو ether1" required>
                        @error('target')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="max_limit" class="form-label">الحد الأقصى (max-limit) *</label>
                        <input type="text" class="form-control @error('max_limit') is-invalid @enderror"
                               id="max_limit" name="max_limit" value="{{ old('max_limit') }}"
                               placeholder="مثال: 10M/10M (تحميل/رفع)" required>
                        @error('max_limit')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="limit_at" class="form-label">الحد الأدنى (limit-at)</label>
                        <input type="text" class="form-control @error('limit_at') is-invalid @enderror"
                               id="limit_at" name="limit_at" value="{{ old('limit_at') }}"
                               placeholder="مثال: 5M/5M (اختياري)">
                        @error('limit_at')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="priority" class="form-label">الأولوية (1-8)</label>
                        <input type="number" class="form-control @error('priority') is-invalid @enderror"
                               id="priority" name="priority" value="{{ old('priority', 1) }}"
                               min="1" max="8">
                        @error('priority')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> إنشاء Queue
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
