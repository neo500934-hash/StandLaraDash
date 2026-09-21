@extends('layouts.app')

@section('title', 'Brands')

@section('content-class', 'page-dashboard')

@section('content')
    <div class="la-dashboard-v2">
        <div class="d-flex align-items-center justify-content-between gap-2 mb-4">
            <div>
                <h4 class="mb-0">{{ __('Brands') }}</h4>
            </div>
            <a href="{{ route('brands.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-lg me-2"></i>{{ __('Add Brand') }}
            </a>
        </div>

        <section class="card">
            <div class="card-body">
                @if (session('status'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('status') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <div class="table-responsive">
                    <table class="table table-hover align-middle" id="brands-table">
                        <thead class="table-light">
                            <tr>
                                <th>{{ __('Name') }}</th>
                                <th class="d-none d-md-table-cell">{{ __('Added By') }}</th>
                                <th class="d-none d-md-table-cell">{{ __('Date Added') }}</th>
                                <th class="text-end">{{ __('Actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($brands as $brand)
                                <tr>
                                    <td>
                                        <span class="fw-500">{{ $brand->name }}</span>
                                    </td>
                                    <td class="d-none d-md-table-cell">{{ $brand->user->name }}</td>
                                    <td class="d-none d-md-table-cell">
                                        <small class="text-muted">{{ $brand->created_at->format('M d, Y \a\t H:i') }}</small>
                                    </td>
                                    <td class="text-end">
                                        <div class="btn-group btn-group-sm" role="group">
                                            <a href="{{ route('brands.edit', $brand) }}" class="btn btn-outline-primary"
                                                title="{{ __('Edit') }}">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <form action="{{ route('brands.destroy', $brand) }}" method="POST"
                                                class="d-inline"
                                                onsubmit="return confirm('{{ __('Are you sure you want to delete this brand?') }}');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-outline-danger"
                                                    title="{{ __('Delete') }}">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="2" class="d-md-none text-center text-muted py-5">
                                        <i class="bi bi-inbox" style="font-size: 2rem; opacity: 0.5;"></i>
                                        <p class="mt-3 mb-0">{{ __('No brands yet. Create your first brand to get started.') }}</p>
                                    </td>
                                    <td colspan="4" class="d-none d-md-table-cell text-center text-muted py-5">
                                        <i class="bi bi-inbox" style="font-size: 2rem; opacity: 0.5;"></i>
                                        <p class="mt-3 mb-0">{{ __('No brands yet. Create your first brand to get started.') }}</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if ($brands->hasPages())
                    <nav class="mt-4">
                        {{ $brands->links() }}
                    </nav>
                @endif
            </div>
        </section>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const table = document.getElementById('brands-table');
                if (table) {
                    new DataTable(table, {
                        perPage: 25,
                        layout: {
                            top: '',
                            bottom: '{pager}',
                        },
                    });
                }
            });
        </script>
    @endpush
@endsection
