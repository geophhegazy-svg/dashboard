@extends('layouts.app')

@section('title', 'تعديل Queue')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>✏️ تعديل Queue: {{ $name }}</h1>
        <a href="{{ route('queues.index', ['device_id' => $device->id ?? 1]) }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> العودة
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('queues.update', ['name' => $name]) }}" method="POST">
                @csrf
                @method('PUT')

                <input type="hidden" name="device_id" value="{{ $device->id ?? 1 }}">

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="max_limit" class="form-label">الحد الأقصى (max-limit) *</label>
                        <input type="text" class="form-control @error('max_limit') is-invalid @enderror" 
                               id="max_limit" name="max_limit" value="{{ old('max_limit', $queue['max_limit'] ?? '') }}" 
                               placeholder="مثال: 10M/10M (تحميل/رفع)" required>
                        @error('max_limit')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="limit_at" class="form-label">الحد الأدنى (limit-at)</label>
                        <input type="text" class="form-control @error('limit_at') is-invalid @enderror" 
                               id="limit_at" name="limit_at" value="{{ old('limit_at', $queue['limit_at'] ?? '') }}" 
                               placeholder="مثال: 5M/5M (اختياري)">
                        @error('limit_at')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="priority" class="form-label">الأولوية (1-8)</label>
                        <input type="number" class="form-control @error('priority') is-invalid @enderror" 
                               id="priority" name="priority" value="{{ old('priority', $queue['priority'] ?? 1) }}" 
                               min="1" max="8">
                        @error('priority')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="comment" class="form-label">التعليق (Comment)</label>
                        <input type="text" class="form-control @error('comment') is-invalid @enderror" 
                               id="comment" name="comment" value="{{ old('comment', $queue['comment'] ?? '') }}" 
                               placeholder="وصف القائمة">
                        @error('comment')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> حفظ التعديلات
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
