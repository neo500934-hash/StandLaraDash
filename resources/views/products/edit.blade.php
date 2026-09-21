@extends('layouts.app')

@section('title', 'Edit Product')

@section('content-class', 'page-dashboard')

@section('content')
    <div class="la-dashboard-v2">
        <section class="card">
            <div class="card-header d-flex align-items-center justify-content-between flex-wrap gap-2">
                <div>
                    <h5 class="card-title mb-1">{{ __('Edit Product') }}</h5>
                </div>
                <a href="{{ route('products.index') }}" class="btn btn-light btn-sm">
                    <i class="bi bi-arrow-left me-1"></i>{{ __('Back') }}
                </a>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('products.update', $product) }}">
                    @csrf
                    @method('PUT')

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="name" class="form-label">{{ __('Name') }}</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                                name="name" value="{{ old('name', $product->name) }}" required>
                            @error('name')
                                <span class="invalid-feedback" role="alert">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="slug" class="form-label">{{ __('Slug') }}</label>
                            <input type="text" class="form-control @error('slug') is-invalid @enderror" id="slug"
                                name="slug" value="{{ old('slug', $product->slug) }}" required>
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
                                    <option value="{{ $category->id }}"
                                        @selected(old('category_id', $product->category_id) == $category->id)>
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
                                    <option value="{{ $status->value }}"
                                        @selected(old('status', $product->status->value) === $status->value)>
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
                                name="description" rows="4">{{ old('description', $product->description) }}</textarea>
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

        <section class="card mt-4">
            <div class="card-header">
                <h5 class="card-title mb-0">{{ __('Images') }}</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('products.images.store', $product) }}" enctype="multipart/form-data"
                    class="d-flex align-items-start gap-2 flex-wrap mb-4">
                    @csrf
                    <div class="flex-grow-1" style="min-width: 240px;">
                        <input type="file" name="images[]" class="form-control @error('images') is-invalid @enderror @error('images.*') is-invalid @enderror"
                            accept="image/*" multiple required>
                        @error('images')
                            <span class="invalid-feedback d-block" role="alert">{{ $message }}</span>
                        @enderror
                        @error('images.*')
                            <span class="invalid-feedback d-block" role="alert">{{ $message }}</span>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-upload me-1"></i>{{ __('Upload') }}
                    </button>
                </form>

                @if ($product->images->isEmpty())
                    <p class="text-muted mb-0">{{ __('No images yet.') }}</p>
                @else
                    <div class="row g-3">
                        @foreach ($product->images->sortBy('sort_order') as $image)
                            <div class="col-6 col-md-3 col-lg-2">
                                <div class="border rounded p-2 h-100 d-flex flex-column">
                                    <img src="{{ $image->url }}" alt="{{ $image->alt_text }}"
                                        class="w-100 rounded mb-2" style="height: 120px; object-fit: cover;">

                                    @if ($image->is_primary)
                                        <span class="badge text-bg-success mb-2">{{ __('Primary') }}</span>
                                    @endif

                                    <div class="mt-auto d-flex flex-wrap gap-1">
                                        <form method="POST" action="{{ route('products.images.move', [$product, $image]) }}">
                                            @csrf
                                            <input type="hidden" name="direction" value="up">
                                            <button type="submit" class="btn btn-outline-secondary btn-sm" title="{{ __('Move up') }}">
                                                <i class="bi bi-arrow-left"></i>
                                            </button>
                                        </form>
                                        <form method="POST" action="{{ route('products.images.move', [$product, $image]) }}">
                                            @csrf
                                            <input type="hidden" name="direction" value="down">
                                            <button type="submit" class="btn btn-outline-secondary btn-sm" title="{{ __('Move down') }}">
                                                <i class="bi bi-arrow-right"></i>
                                            </button>
                                        </form>
                                        @unless ($image->is_primary)
                                            <form method="POST" action="{{ route('products.images.primary', [$product, $image]) }}">
                                                @csrf
                                                <button type="submit" class="btn btn-outline-primary btn-sm" title="{{ __('Set as primary') }}">
                                                    <i class="bi bi-star"></i>
                                                </button>
                                            </form>
                                        @endunless
                                        <form method="POST" action="{{ route('products.images.destroy', [$product, $image]) }}"
                                            onsubmit="return confirm('{{ __('Delete this image?') }}');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger btn-sm" title="{{ __('Delete') }}">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </section>

        <section class="card mt-4">
            <div class="card-header d-flex align-items-center justify-content-between flex-wrap gap-2">
                <h5 class="card-title mb-0">{{ __('Sizes, Variants & Inventory') }}</h5>
                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addVariantModal">
                    <i class="bi bi-plus-lg me-1"></i>{{ __('Add Variant') }}
                </button>
            </div>
            <div class="card-body">
                @if ($product->variants->isEmpty())
                    <p class="text-muted mb-0">{{ __('No variants yet.') }}</p>
                @else
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>{{ __('SKU') }}</th>
                                    <th>{{ __('Size / Label') }}</th>
                                    <th>{{ __('Regular Price') }}</th>
                                    <th>{{ __('Current Price') }}</th>
                                    <th>{{ __('Stock') }}</th>
                                    <th>{{ __('Active') }}</th>
                                    <th class="text-end">{{ __('Actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($product->variants as $variant)
                                    <tr>
                                        <td>{{ $variant->sku }}</td>
                                        <td>{{ $variant->size ?? $variant->variant_label ?? __('—') }}</td>
                                        <td>${{ number_format((float) $variant->regular_price, 2) }}</td>
                                        <td>
                                            ${{ number_format((float) $variant->current_price, 2) }}
                                            @if ((float) $variant->current_price < (float) $variant->regular_price)
                                                <span class="badge text-bg-danger ms-1">{{ __('Promo') }}</span>
                                            @endif
                                        </td>
                                        <td>
                                            {{ $variant->inventory->quantity_on_hand }} {{ __('on hand') }}
                                            <br>
                                            <small class="text-muted">
                                                {{ __(':available available, reorder at :threshold', ['available' => $variant->inventory->available, 'threshold' => $variant->inventory->reorder_threshold]) }}
                                            </small>
                                        </td>
                                        <td>
                                            @if ($variant->is_active)
                                                <span class="badge text-bg-success">{{ __('Active') }}</span>
                                            @else
                                                <span class="badge text-bg-secondary">{{ __('Inactive') }}</span>
                                            @endif
                                        </td>
                                        <td class="text-end">
                                            <div class="btn-group btn-group-sm" role="group">
                                                <button type="button" class="btn btn-outline-primary" title="{{ __('Edit') }}"
                                                    data-bs-toggle="modal" data-bs-target="#editVariantModal{{ $variant->id }}">
                                                    <i class="bi bi-pencil"></i>
                                                </button>
                                                <form action="{{ route('products.variants.destroy', [$product, $variant]) }}"
                                                    method="POST" class="d-inline"
                                                    onsubmit="return confirm('{{ __('Delete this variant?') }}');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-outline-danger" title="{{ __('Delete') }}">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </section>
    </div>

    {{-- Add Variant Modal --}}
    <div class="modal fade" id="addVariantModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="POST" action="{{ route('products.variants.store', $product) }}">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">{{ __('Add Variant') }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">{{ __('SKU') }}</label>
                                <input type="text" name="sku" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">{{ __('Size') }}</label>
                                <input type="text" name="size" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">{{ __('Variant Label') }}</label>
                                <input type="text" name="variant_label" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">{{ __('Regular Price') }}</label>
                                <input type="number" step="0.01" min="0" name="regular_price" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">{{ __('Initial Stock (Qty on Hand)') }}</label>
                                <input type="number" min="0" name="quantity_on_hand" class="form-control" value="0" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">{{ __('Reorder Threshold') }}</label>
                                <input type="number" min="0" name="reorder_threshold" class="form-control" value="0" required>
                            </div>
                            <div class="col-12">
                                <div class="form-check">
                                    <input type="checkbox" name="is_active" value="1" class="form-check-input" id="addVariantActive" checked>
                                    <label class="form-check-label" for="addVariantActive">{{ __('Active') }}</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
                        <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Edit Variant Modals --}}
    @foreach ($product->variants as $variant)
        <div class="modal fade" id="editVariantModal{{ $variant->id }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">{{ __('Edit Variant') }} — {{ $variant->sku }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" action="{{ route('products.variants.update', [$product, $variant]) }}">
                            @csrf
                            @method('PUT')
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">{{ __('SKU') }}</label>
                                    <input type="text" name="sku" class="form-control" value="{{ $variant->sku }}" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">{{ __('Size') }}</label>
                                    <input type="text" name="size" class="form-control" value="{{ $variant->size }}">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">{{ __('Variant Label') }}</label>
                                    <input type="text" name="variant_label" class="form-control" value="{{ $variant->variant_label }}">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">{{ __('Regular Price') }}</label>
                                    <input type="number" step="0.01" min="0" name="regular_price" class="form-control"
                                        value="{{ $variant->regular_price }}" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">{{ __('Qty on Hand') }}</label>
                                    <input type="number" min="0" name="quantity_on_hand" class="form-control"
                                        value="{{ $variant->inventory->quantity_on_hand }}" required>
                                    <small class="text-muted">{{ __('Reserved: :qty', ['qty' => $variant->inventory->quantity_reserved]) }}</small>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">{{ __('Reorder Threshold') }}</label>
                                    <input type="number" min="0" name="reorder_threshold" class="form-control"
                                        value="{{ $variant->inventory->reorder_threshold }}" required>
                                </div>
                                <div class="col-12">
                                    <div class="form-check">
                                        <input type="checkbox" name="is_active" value="1" class="form-check-input"
                                            id="editVariantActive{{ $variant->id }}" @checked($variant->is_active)>
                                        <label class="form-check-label" for="editVariantActive{{ $variant->id }}">{{ __('Active') }}</label>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-3 text-end">
                                <button type="submit" class="btn btn-primary btn-sm">{{ __('Save Variant') }}</button>
                            </div>
                        </form>

                        <hr>

                        <h6>{{ __('Promotional Prices') }}</h6>
                        @if ($variant->promotionalPrices->isEmpty())
                            <p class="text-muted small">{{ __('No promotional prices set.') }}</p>
                        @else
                            <ul class="list-group mb-3">
                                @foreach ($variant->promotionalPrices as $promo)
                                    <li class="list-group-item d-flex align-items-center justify-content-between">
                                        <span>
                                            ${{ number_format((float) $promo->promo_price, 2) }}
                                            <small class="text-muted">
                                                ({{ $promo->starts_at->format('M d, Y H:i') }} &rarr; {{ $promo->ends_at->format('M d, Y H:i') }})
                                            </small>
                                        </span>
                                        <form method="POST"
                                            action="{{ route('products.variants.promotional-prices.destroy', [$product, $variant, $promo]) }}"
                                            onsubmit="return confirm('{{ __('Remove this promotional price?') }}');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger btn-sm">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </li>
                                @endforeach
                            </ul>
                        @endif

                        <form method="POST"
                            action="{{ route('products.variants.promotional-prices.store', [$product, $variant]) }}"
                            class="row g-2 align-items-end">
                            @csrf
                            <div class="col-md-3">
                                <label class="form-label">{{ __('Promo Price') }}</label>
                                <input type="number" step="0.01" min="0" name="promo_price" class="form-control" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">{{ __('Starts At') }}</label>
                                <input type="datetime-local" name="starts_at" class="form-control" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">{{ __('Ends At') }}</label>
                                <input type="datetime-local" name="ends_at" class="form-control" required>
                            </div>
                            <div class="col-md-1">
                                <button type="submit" class="btn btn-primary w-100" title="{{ __('Add') }}">
                                    <i class="bi bi-plus-lg"></i>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endsection
