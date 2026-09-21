@extends('layouts.app')

@section('title', 'New Category')

@section('content-class', 'page-dashboard')

@section('content')
    <div class="la-dashboard-v2">
        <section class="card">
            <div class="card-header d-flex align-items-center justify-content-between flex-wrap gap-2">
                <div>
                    <h5 class="card-title mb-1">{{ __('New Category') }}</h5>
                </div>
                <a href="{{ route('categories.index') }}" class="btn btn-light btn-sm">
                    <i class="bi bi-arrow-left me-1"></i>{{ __('Back') }}
                </a>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('categories.store') }}">
                    @csrf

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="name" class="form-label">{{ __('Name') }}</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                                name="name" value="{{ old('name') }}" required>
                            @error('name')
                                <span class="invalid-feedback" role="alert">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="slug" class="form-label">{{ __('Slug') }}</label>
                            <input type="text" class="form-control @error('slug') is-invalid @enderror" id="slug"
                                name="slug" value="{{ old('slug') }}" required>
                            @error('slug')
                                <span class="invalid-feedback" role="alert">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="parent_id" class="form-label">{{ __('Parent Category') }}</label>
                            <select class="form-select @error('parent_id') is-invalid @enderror" id="parent_id"
                                name="parent_id">
                                <option value="">{{ __('None') }}</option>
                                @foreach ($categories as $parentOption)
                                    <option value="{{ $parentOption->id }}" @selected(old('parent_id') == $parentOption->id)>
                                        {{ $parentOption->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('parent_id')
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

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const nameInput = document.getElementById('name');
                const slugInput = document.getElementById('slug');
                let slugEdited = slugInput.value.length > 0;

                slugInput.addEventListener('input', () => {
                    slugEdited = true;
                });

                nameInput.addEventListener('input', () => {
                    if (slugEdited) {
                        return;
                    }

                    slugInput.value = nameInput.value
                        .toLowerCase()
                        .trim()
                        .replace(/[^a-z0-9]+/g, '-')
                        .replace(/(^-|-$)/g, '');
                });
            });
        </script>
    @endpush
@endsection
