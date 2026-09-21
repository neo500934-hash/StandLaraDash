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
                    <table class="table table-hover align-middle" id="brands-table" style="width: 100%;">
                        <thead>
                            <tr>
                                <th>{{ __('Name') }}</th>
                                <th class="d-none d-md-table-cell">{{ __('Added By') }}</th>
                                <th class="d-none d-md-table-cell">{{ __('Date Added') }}</th>
                                <th class="text-end">{{ __('Actions') }}</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </section>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                $('#brands-table').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: '{{ route('brands.data') }}',
                    order: [
                        [2, 'desc']
                    ],
                    columns: [
                        {data: 'name', name: 'name'},
                        {data: 'added_by', name: 'user.name', className: 'd-none d-md-table-cell'},
                        {data: 'created_at', name: 'created_at', className: 'd-none d-md-table-cell'},
                        {data: 'actions', name: 'actions', orderable: false, searchable: false, className: 'text-end'},
                    ],
                    language: {
                        search: '',
                        searchPlaceholder: '{{ __('Search brands...') }}',
                        emptyTable: '{{ __('No brands yet. Create your first brand to get started.') }}',
                        zeroRecords: '{{ __('No brands found') }}',
                        info: '{{ __('Showing _START_ to _END_ of _TOTAL_ brands') }}',
                        infoEmpty: '{{ __('No brands to show') }}',
                        infoFiltered: '({{ __('filtered from') }} _MAX_ {{ __('total') }})',
                    },
                });
            });
        </script>
    @endpush
@endsection
