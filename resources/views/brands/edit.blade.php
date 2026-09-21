@extends('layouts.app')

@section('title', 'Edit Brand')

@section('content-class', 'page-dashboard')

@section('content')
    <div class="la-dashboard-v2">
        <section class="card">
            <div class="card-header d-flex align-items-center justify-content-between flex-wrap gap-2">
                <div>
                    <h5 class="card-title mb-1">{{ __('Edit Brand') }}</h5>
                </div>
                <a href="{{ route('brands.index') }}" class="btn btn-light btn-sm">
                    <i class="bi bi-arrow-left me-1"></i>{{ __('Back') }}
                </a>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('brands.update', $brand) }}">
                    @csrf
                    @method('PUT')

                    <div class="row g-3">
                        <div class="col-md">
                            <label for="name" class="form-label">{{ __('Name') }}</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                                name="name" value="{{ old('name', $brand->name) }}" required>
                            @error('name')
                                <span class="invalid-feedback" role="alert">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-md">
                            <label for="type" class="form-label">{{ __('Type') }}</label>
                            <input type="text" class="form-control @error('type') is-invalid @enderror" id="type"
                                name="type" value="{{ old('type', $brand->type) }}">
                            @error('type')
                                <span class="invalid-feedback" role="alert">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="mt-4">
                        <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
                    </div>
                </form>
            </div>
        </section>
    </div>
@endsection
