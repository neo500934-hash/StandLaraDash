@extends('layouts.app')

@section('title', 'Categories')

@section('content-class', 'page-dashboard')

@section('content')
    <div class="la-dashboard-v2">
        <div class="d-flex align-items-center justify-content-between gap-2 mb-4">
            <div>
                <h4 class="mb-0">{{ __('Categories') }}</h4>
            </div>
            <div class="d-flex align-items-center gap-2">
                <button type="button" id="bulk-delete-btn" class="btn btn-outline-danger d-none"
                    data-bs-toggle="modal" data-bs-target="#bulkDeleteModal">
                    <i class="bi bi-trash me-2"></i>{{ __('Delete Selected') }} (<span id="bulk-delete-count">0</span>)
                </button>
                <a href="{{ route('categories.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-lg me-2"></i>{{ __('Add Category') }}
                </a>
            </div>
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
                    <table class="table table-hover align-middle" id="categories-table" style="width: 100%;">
                        <thead>
                            <tr>
                                <th style="width: 2.5rem;">
                                    <input type="checkbox" class="form-check-input" id="select-all-categories"
                                        aria-label="{{ __('Select all') }}">
                                </th>
                                <th>{{ __('Name') }}</th>
                                <th class="d-none d-md-table-cell">{{ __('Parent Category') }}</th>
                                <th class="d-none d-md-table-cell">{{ __('Slug') }}</th>
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

    <form id="bulk-delete-form" action="{{ route('categories.bulk-destroy') }}" method="POST" class="d-none">
        @csrf
        @method('DELETE')
    </form>

    <div class="modal fade" id="bulkDeleteModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('Delete Selected Categories') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    {{ __('Are you sure you want to delete the') }}
                    <strong id="bulk-delete-modal-count">0</strong>
                    {{ __('selected categories? This cannot be undone.') }}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
                    <button type="button" id="bulk-delete-confirm" class="btn btn-danger">
                        <i class="bi bi-trash me-1"></i>{{ __('Delete') }}
                    </button>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const $table = $('#categories-table');

                const dataTable = $table.DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: '{{ route('categories.data') }}',
                    order: [
                        [4, 'desc']
                    ],
                    columns: [
                        {data: 'select', name: 'select', orderable: false, searchable: false},
                        {data: 'name', name: 'name'},
                        {data: 'parent', name: 'parent', orderable: false, searchable: false, className: 'd-none d-md-table-cell'},
                        {data: 'slug', name: 'slug', className: 'd-none d-md-table-cell'},
                        {data: 'created_at', name: 'created_at', className: 'd-none d-md-table-cell'},
                        {data: 'actions', name: 'actions', orderable: false, searchable: false, className: 'text-end'},
                    ],
                    language: {
                        search: '',
                        searchPlaceholder: '{{ __('Search categories...') }}',
                        emptyTable: '{{ __('No categories yet. Create your first category to get started.') }}',
                        zeroRecords: '{{ __('No categories found') }}',
                        info: '{{ __('Showing _START_ to _END_ of _TOTAL_ categories') }}',
                        infoEmpty: '{{ __('No categories to show') }}',
                        infoFiltered: '({{ __('filtered from') }} _MAX_ {{ __('total') }})',
                    },
                });

                const selectAll = document.getElementById('select-all-categories');
                const bulkDeleteBtn = document.getElementById('bulk-delete-btn');
                const bulkDeleteCount = document.getElementById('bulk-delete-count');
                const bulkDeleteModalCount = document.getElementById('bulk-delete-modal-count');
                const bulkDeleteForm = document.getElementById('bulk-delete-form');
                const bulkDeleteConfirm = document.getElementById('bulk-delete-confirm');
                const selected = new Set();

                function visibleCheckboxes() {
                    return Array.from($table[0].querySelectorAll('tbody .row-select-category'));
                }

                function syncUi() {
                    const visible = visibleCheckboxes();

                    visible.forEach((checkbox) => {
                        checkbox.checked = selected.has(checkbox.value);
                    });

                    if (selectAll) {
                        selectAll.checked = visible.length > 0 && visible.every((checkbox) => selected.has(checkbox.value));
                        selectAll.indeterminate = !selectAll.checked && visible.some((checkbox) => selected.has(checkbox.value));
                    }

                    bulkDeleteCount.textContent = selected.size;
                    bulkDeleteModalCount.textContent = selected.size;
                    bulkDeleteBtn.classList.toggle('d-none', selected.size === 0);
                }

                $table.on('change', '.row-select-category', function() {
                    if (this.checked) {
                        selected.add(this.value);
                    } else {
                        selected.delete(this.value);
                    }

                    syncUi();
                });

                if (selectAll) {
                    selectAll.addEventListener('change', function() {
                        visibleCheckboxes().forEach((checkbox) => {
                            if (selectAll.checked) {
                                selected.add(checkbox.value);
                            } else {
                                selected.delete(checkbox.value);
                            }
                        });

                        syncUi();
                    });
                }

                dataTable.on('draw.dt', syncUi);

                bulkDeleteConfirm.addEventListener('click', function() {
                    bulkDeleteForm.querySelectorAll('input[name="ids[]"]').forEach((input) => input.remove());

                    selected.forEach((id) => {
                        const input = document.createElement('input');
                        input.type = 'hidden';
                        input.name = 'ids[]';
                        input.value = id;
                        bulkDeleteForm.appendChild(input);
                    });

                    bulkDeleteForm.submit();
                });
            });
        </script>
    @endpush
@endsection
