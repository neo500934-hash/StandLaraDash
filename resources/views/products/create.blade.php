@extends('layouts.app')

@section('title', 'New Product')

@section('content-class', 'page-dashboard')

@section('content')
    <div class="la-dashboard-v2">
        <section class="card">
            <div class="card-header d-flex align-items-center justify-content-between flex-wrap gap-2">
                <div>
                    <h5 class="card-title mb-1">{{ __('New Product') }}</h5>
                </div>
                <a href="{{ route('products.index') }}" class="btn btn-light btn-sm">
                    <i class="bi bi-arrow-left me-1"></i>{{ __('Back') }}
                </a>
            </div>
            <div class="card-body">
                <div class="alert alert-info">
                    {{ __('Save the product first — you can then add images, sizes/variants, prices, and stock from the edit page.') }}
                </div>

                <form method="POST" action="{{ route('products.store') }}">
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
                            <label for="category_id" class="form-label">{{ __('Category') }}</label>
                            <select class="form-select @error('category_id') is-invalid @enderror" id="category_id"
                                name="category_id">
                                <option value="">{{ __('None') }}</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" @selected(old('category_id') == $category->id)>
                                        {{ str_repeat("\u{00A0}\u{00A0}\u{00A0}\u{00A0}", $category->depth) }}{{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <span class="invalid-feedback" role="alert">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="status" class="form-label">{{ __('Status') }}</label>
                            <select class="form-select @error('status') is-invalid @enderror" id="status"
                                name="status">
                                @foreach (\App\Enums\ProductStatus::cases() as $status)
                                    <option value="{{ $status->value }}" @selected(old('status', 'draft') === $status->value)>
                                        {{ ucfirst($status->value) }}
                                    </option>
                                @endforeach
                            </select>
                            @error('status')
                                <span class="invalid-feedback" role="alert">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-12">
                            <label for="description" class="form-label">{{ __('Description') }}</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" id="description"
                                name="description" rows="4">{{ old('description') }}</textarea>
                            @error('description')
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
