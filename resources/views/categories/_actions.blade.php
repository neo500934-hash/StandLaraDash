<div class="btn-group btn-group-sm" role="group">
    <a href="{{ route('categories.edit', $category) }}" class="btn btn-outline-primary" title="{{ __('Edit') }}">
        <i class="bi bi-pencil"></i>
    </a>
    <form action="{{ route('categories.destroy', $category) }}" method="POST" class="d-inline"
        onsubmit="return confirm('{{ __('Are you sure you want to delete this category?') }}');">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-outline-danger" title="{{ __('Delete') }}">
            <i class="bi bi-trash"></i>
        </button>
    </form>
</div>
