@extends('layouts.app')

@section('title', 'Brands')

@section('content-class', 'page-dashboard')

@section('content')
    <div class="la-dashboard-v2">
        <section class="card">
            <div class="card-header d-flex align-items-center justify-content-between flex-wrap gap-2">
                <div>
                    <h5 class="card-title mb-1">{{ __('Brands') }}</h5>
                </div>
                <a href="{{ route('brands.create') }}" class="btn btn-primary btn-sm">
                    <i class="bi bi-plus-lg me-1"></i>{{ __('New Brand') }}
                </a>
            </div>
            <div class="card-body">
                @if (session('status'))
                    <div class="alert alert-success">{{ session('status') }}</div>
                @endif

                <div class="table-responsive">
                    <table class="table align-middle">
                        <thead>
                            <tr>
                                <th>{{ __('Name') }}</th>
                                <th>{{ __('Type') }}</th>
                                <th class="text-end">{{ __('Actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($brands as $brand)
                                <tr>
                                    <td>{{ $brand->name }}</td>
                                    <td>{{ $brand->type ?? '—' }}</td>
                                    <td class="text-end">
                                        <a href="{{ route('brands.edit', $brand) }}" class="btn btn-light btn-sm">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form action="{{ route('brands.destroy', $brand) }}" method="POST"
                                            class="d-inline"
                                            onsubmit="return confirm('{{ __('Delete this brand?') }}');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-light btn-sm text-danger">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center text-muted py-4">
                                        {{ __('No brands yet.') }}
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{ $brands->links() }}
            </div>
        </section>
    </div>
@endsection
