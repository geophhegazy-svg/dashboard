@extends('layouts.app')

@section('title', 'تعديل عقد إيجار')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>✏️ تعديل عقد إيجار: {{ $id }}</h1>
        <a href="{{ route('dhcp.index', ['device_id' => $device->id ?? 1]) }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> العودة
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('dhcp.update', ['id' => $id]) }}" method="POST">
                @csrf
                @method('PUT')

                <input type="hidden" name="device_id" value="{{ $device->id ?? 1 }}">

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="address" class="form-label">عنوان IP</label>
                        <input type="text" class="form-control" id="address" name="address" 
                               value="{{ $lease['address'] ?? '' }}" placeholder="مثال: 192.168.1.100">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="mac_address" class="form-label">عنوان MAC</label>
                        <input type="text" class="form-control" id="mac_address" name="mac_address" 
                               value="{{ $lease['mac_address'] ?? '' }}" placeholder="مثال: 00:11:22:33:44:55">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="hostname" class="form-label">اسم المضيف (hostname)</label>
                        <input type="text" class="form-control" id="hostname" name="hostname" 
                               value="{{ $lease['hostname'] ?? '' }}" placeholder="مثال: PC-Office-1">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="comment" class="form-label">التعليق (Comment)</label>
                        <input type="text" class="form-control" id="comment" name="comment" 
                               value="{{ $lease['comment'] ?? '' }}" placeholder="وصف العقد">
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
