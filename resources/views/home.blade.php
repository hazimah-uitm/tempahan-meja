@extends('layouts.master')
@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12 col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <!-- Booking Table -->
                        <div class="table-responsive mt-2">
                            <h4 class="mb-3 text-center text-uppercase">Senarai Tempahan</h4>
                            <div class="position-relative">
                                <form action="{{ route('home') }}" method="GET" id="searchForm"
                                    class="d-lg-flex align-items-center gap-3">
                                    <div class="input-group">
                                        <input type="text" class="form-control rounded" placeholder="Carian..."
                                            name="search" value="{{ request('search') }}" id="searchInput">

                                        <input type="hidden" name="perPage" value="{{ request('perPage', 10) }}">
                                        <button type="submit" class="btn btn-primary ms-1 rounded" id="searchButton">
                                            <i class="bx bx-search"></i>
                                        </button>
                                        <button type="button" class="btn btn-secondary ms-1 rounded" id="resetButton">
                                            Reset
                                        </button>
                                    </div>
                                </form>
                            </div>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>No Meja</th>
                                        <th>Jumlah Kerusi</th>
                                        <th>Kerusi Kosong</th>
                                        <th>Status</th>
                                        <th>Senarai Staf</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (count($tables) > 0)
                                        @foreach ($tables as $table)
                                            <tr>
                                                <td>{{ ($tables->currentPage() - 1) * $tables->perPage() + $loop->iteration }}
                                                </td>
                                                <td>{{ $table->table_no }}</td>
                                                <td>{{ $table->total_seat }}</td>
                                                <td>{{ $table->available_seat }}</td>
                                                <td>
                                                    @if ($table->status == 'Tersedia')
                                                        <span class="badge bg-success">Tersedia</span>
                                                    @else
                                                        <span class="badge bg-warning">Penuh</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @php
                                                        $bookingCount = $table->booking->count();
                                                    @endphp

                                                    @if ($bookingCount > 1)
                                                        @foreach ($table->booking as $index => $book)
                                                            <p>{{ $index + 1 }}. {{ $book->staff->name }} ({{ $book->staff->no_pekerja }}) </p>
                                                        @endforeach
                                                    @elseif ($bookingCount === 1)
                                                        <p>{{ $table->booking->first()->staff->name }} ({{ $table->booking->first()->staff->no_pekerja }})</p>
                                                    @else
                                                        <p>Tiada tempahan.</p>
                                                    @endif
                                                </td>

                                            </tr>
                                        @endforeach
                                    @else
                                        <td colspan="6">Tiada rekod</td>
                                    @endif
                                </tbody>
                            </table>

                            <!-- Pagination and Per-Page Controls -->
                            <div class="mt-3 d-flex justify-content-between align-items-center">
                                <div class="d-flex align-items-center">
                                    <span class="me-2">Jumlah rekod per halaman:</span>
                                    <form action="{{ request()->url() }}" method="GET" id="perPageForm"
                                        class="d-flex align-items-center">
                                        <input type="hidden" name="search" value="{{ request('search') }}">
                                        <select name="perPage" id="perPage" class="form-select form-select-sm"
                                            onchange="document.getElementById('perPageForm').submit()">
                                            <option value="5" {{ request('perPage') == '5' ? 'selected' : '' }}>5
                                            </option>
                                            <option value="10" {{ request('perPage') == '10' ? 'selected' : '' }}>10
                                            </option>
                                            <option value="20" {{ request('perPage') == '20' ? 'selected' : '' }}>20
                                            </option>
                                            <option value="30" {{ request('perPage') == '30' ? 'selected' : '' }}>30
                                            </option>
                                        </select>
                                    </form>
                                </div>

                                <div class="d-flex justify-content-end align-items-center">
                                    <span class="mx-2 mt-2 small text-muted">
                                        Menunjukkan {{ $tables->firstItem() }} hingga {{ $tables->lastItem() }}
                                        daripada
                                        {{ $tables->total() }} rekod
                                    </span>
                                    <div class="pagination-wrapper">
                                        {{ $tables->appends([
                                                'search' => request('search'),
                                            ])->links('pagination::bootstrap-4') }}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <hr />
                        <!-- Layout Plan Accordion -->
                        <div class="mt-4">
                            <div class="accordion" id="layoutAccordion">
                                <div class="accordion-item">
                                    <h4 class="accordion-header" id="headingOne">
                                        <button class="accordion-button text-uppercase" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#collapseLayout" aria-expanded="true"
                                            aria-controls="collapseLayout">
                                            Paparan Pelan Meja Sebenar
                                        </button>
                                    </h4>
                                    <div id="collapseLayout" class="accordion-collapse collapse"
                                        aria-labelledby="headingOne" data-bs-parent="#layoutAccordion">
                                        <div class="accordion-body">
                                            <img src="{{ asset('public/assets/images/layout.jpg') }}" alt="Pelan Meja"
                                                class="img-fluid">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Hall Layout -->
                        <div class="hall-layout position-relative text-center mt-4">
                            <!-- Tables -->
                            <div class="row justify-content-center mt-4">
                                @foreach ($tableList as $table)
                                    <div class="col-6 col-md-4 col-lg-3 d-flex justify-content-center mb-4">
                                        <div class="table-round p-3 
                                        @if ($table->available_seat > 0) bg-success
                                        @else bg-secondary text-light @endif"
                                            id="table-container-{{ $table->id }}">
                                            <div>
                                                <label class="text-dark">
                                                    <strong>{{ $table->table_no }}</strong>
                                                </label>
                                            </div>
                                            <div class="table-info">
                                                @if ($table->available_seat == 0)
                                                    <p>Penuh</p>
                                                @else
                                                    <p>{{ $table->available_seat }} kerusi kosong</p>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Auto-submit the form on input change
            document.getElementById('searchInput').addEventListener('input', function() {
                document.getElementById('searchForm').submit();
            });

            // Reset form
            document.getElementById('resetButton').addEventListener('click', function() {
                document.getElementById('searchForm').reset();
                // Clear hidden fields to reset pagination and filters
                document.getElementById('searchForm').querySelector('input[name="search"]').value = '';
                document.getElementById('searchForm').submit();
            });
        });
    </script>
@endsection
