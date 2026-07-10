@extends('layouts.app')

@section('title', 'إضافة قاعدة جدار ناري جديدة')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>➕ إضافة قاعدة جدار ناري جديدة</h1>
        <a href="{{ route('firewall.index', ['device_id' => $device->id ?? 1]) }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> العودة
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('firewall.store') }}" method="POST">
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
                        <label for="chain" class="form-label">السلسلة (Chain) *</label>
                        <select name="chain" id="chain" class="form-control @error('chain') is-invalid @enderror" required>
                            <option value="input">Input</option>
                            <option value="output">Output</option>
                            <option value="forward">Forward</option>
                            <option value="hs-input">Hotspot Input</option>
                            <option value="hs-unauth">Hotspot Unauthenticated</option>
                            <option value="hs-unauth-to">Hotspot Unauthenticated To</option>
                        </select>
                        @error('chain')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="action" class="form-label">الإجراء (Action) *</label>
                        <select name="action" id="action" class="form-control @error('action') is-invalid @enderror" required>
                            <option value="accept">Accept (قبول)</option>
                            <option value="drop">Drop (إسقاط)</option>
                            <option value="reject">Reject (رفض)</option>
                            <option value="log">Log (تسجيل)</option>
                            <option value="jump">Jump (قفز)</option>
                            <option value="passthrough">Passthrough (تمرير)</option>
                        </select>
                        @error('action')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="protocol" class="form-label">البروتوكول</label>
                        <select name="protocol" id="protocol" class="form-control">
                            <option value="">كل البروتوكولات</option>
                            <option value="tcp">TCP</option>
                            <option value="udp">UDP</option>
                            <option value="icmp">ICMP</option>
                        </select>
                        @error('protocol')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="src_address" class="form-label">عنوان المصدر (src-address)</label>
                        <input type="text" class="form-control @error('src_address') is-invalid @enderror" 
                               id="src_address" name="src_address" value="{{ old('src_address') }}" 
                               placeholder="مثال: 192.168.1.0/24">
                        @error('src_address')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="dst_address" class="form-label">عنوان الوجهة (dst-address)</label>
                        <input type="text" class="form-control @error('dst_address') is-invalid @enderror" 
                               id="dst_address" name="dst_address" value="{{ old('dst_address') }}" 
                               placeholder="مثال: 8.8.8.8/32">
                        @error('dst_address')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="dst_port" class="form-label">منفذ الوجهة (dst-port)</label>
                        <input type="text" class="form-control @error('dst_port') is-invalid @enderror" 
                               id="dst_port" name="dst_port" value="{{ old('dst_port') }}" 
                               placeholder="مثال: 80,443 أو 22">
                        @error('dst_port')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="comment" class="form-label">تعليق (comment)</label>
                        <input type="text" class="form-control @error('comment') is-invalid @enderror" 
                               id="comment" name="comment" value="{{ old('comment') }}" 
                               placeholder="وصف القاعدة">
                        @error('comment')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> إنشاء قاعدة
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
