<div class="btn-group btn-group-sm" role="group">
    <a href="{{ route('products.edit', $product) }}" class="btn btn-outline-primary" title="{{ __('Edit') }}">
        <i class="bi bi-pencil"></i>
    </a>
    <form action="{{ route('products.destroy', $product) }}" method="POST" class="d-inline"
        onsubmit="return confirm('{{ __('Are you sure you want to delete this product?') }}');">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-outline-danger" title="{{ __('Delete') }}">
            <i class="bi bi-trash"></i>
        </button>
    </form>
</div>
