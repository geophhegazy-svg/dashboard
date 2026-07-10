@extends('layouts.app')

@section('title', 'إضافة عقد إيجار جديد')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>➕ إضافة عقد إيجار جديد</h1>
        <a href="{{ route('dhcp.index', ['device_id' => $device->id ?? 1]) }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> العودة
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('dhcp.store') }}" method="POST">
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
                        <label for="address" class="form-label">عنوان IP *</label>
                        <input type="text" class="form-control @error('address') is-invalid @enderror" 
                               id="address" name="address" value="{{ old('address') }}" 
                               placeholder="مثال: 192.168.1.100" required>
                        @error('address')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="mac_address" class="form-label">عنوان MAC *</label>
                        <input type="text" class="form-control @error('mac_address') is-invalid @enderror" 
                               id="mac_address" name="mac_address" value="{{ old('mac_address') }}" 
                               placeholder="مثال: 00:11:22:33:44:55" required>
                        @error('mac_address')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="hostname" class="form-label">اسم المضيف (hostname)</label>
                        <input type="text" class="form-control @error('hostname') is-invalid @enderror" 
                               id="hostname" name="hostname" value="{{ old('hostname') }}" 
                               placeholder="مثال: PC-Office-1">
                        @error('hostname')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> إنشاء عقد
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
