@extends('layouts.app')

@section('title', 'تعديل قاعدة جدار ناري')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>✏️ تعديل قاعدة جدار ناري: {{ $id }}</h1>
        <a href="{{ route('firewall.index', ['device_id' => $device->id ?? 1]) }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> العودة
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('firewall.update', ['id' => $id]) }}" method="POST">
                @csrf
                @method('PUT')

                <input type="hidden" name="device_id" value="{{ $device->id ?? 1 }}">

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="chain" class="form-label">السلسلة (Chain)</label>
                        <select name="chain" id="chain" class="form-control">
                            <option value="input" {{ ($rule['chain'] ?? '') == 'input' ? 'selected' : '' }}>Input</option>
                            <option value="output" {{ ($rule['chain'] ?? '') == 'output' ? 'selected' : '' }}>Output</option>
                            <option value="forward" {{ ($rule['chain'] ?? '') == 'forward' ? 'selected' : '' }}>Forward</option>
                            <option value="hs-input" {{ ($rule['chain'] ?? '') == 'hs-input' ? 'selected' : '' }}>Hotspot Input</option>
                            <option value="hs-unauth" {{ ($rule['chain'] ?? '') == 'hs-unauth' ? 'selected' : '' }}>Hotspot Unauthenticated</option>
                            <option value="hs-unauth-to" {{ ($rule['chain'] ?? '') == 'hs-unauth-to' ? 'selected' : '' }}>Hotspot Unauthenticated To</option>
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="action" class="form-label">الإجراء (Action)</label>
                        <select name="action" id="action" class="form-control">
                            <option value="accept" {{ ($rule['action'] ?? '') == 'accept' ? 'selected' : '' }}>Accept (قبول)</option>
                            <option value="drop" {{ ($rule['action'] ?? '') == 'drop' ? 'selected' : '' }}>Drop (إسقاط)</option>
                            <option value="reject" {{ ($rule['action'] ?? '') == 'reject' ? 'selected' : '' }}>Reject (رفض)</option>
                            <option value="log" {{ ($rule['action'] ?? '') == 'log' ? 'selected' : '' }}>Log (تسجيل)</option>
                            <option value="jump" {{ ($rule['action'] ?? '') == 'jump' ? 'selected' : '' }}>Jump (قفز)</option>
                            <option value="passthrough" {{ ($rule['action'] ?? '') == 'passthrough' ? 'selected' : '' }}>Passthrough (تمرير)</option>
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="src_address" class="form-label">عنوان المصدر (src-address)</label>
                        <input type="text" class="form-control" id="src_address" name="src_address" 
                               value="{{ $rule['src_address'] ?? '' }}" placeholder="مثال: 192.168.1.0/24">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="dst_address" class="form-label">عنوان الوجهة (dst-address)</label>
                        <input type="text" class="form-control" id="dst_address" name="dst_address" 
                               value="{{ $rule['dst_address'] ?? '' }}" placeholder="مثال: 8.8.8.8/32">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="protocol" class="form-label">البروتوكول</label>
                        <select name="protocol" id="protocol" class="form-control">
                            <option value="">كل البروتوكولات</option>
                            <option value="tcp" {{ ($rule['protocol'] ?? '') == 'tcp' ? 'selected' : '' }}>TCP</option>
                            <option value="udp" {{ ($rule['protocol'] ?? '') == 'udp' ? 'selected' : '' }}>UDP</option>
                            <option value="icmp" {{ ($rule['protocol'] ?? '') == 'icmp' ? 'selected' : '' }}>ICMP</option>
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="dst_port" class="form-label">منفذ الوجهة (dst-port)</label>
                        <input type="text" class="form-control" id="dst_port" name="dst_port" 
                               value="{{ $rule['port'] ?? '' }}" placeholder="مثال: 80,443 أو 22">
                    </div>

                    <div class="col-md-12 mb-3">
                        <label for="comment" class="form-label">التعليق (Comment)</label>
                        <input type="text" class="form-control" id="comment" name="comment" 
                               value="{{ $rule['comment'] ?? '' }}" placeholder="وصف القاعدة">
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
