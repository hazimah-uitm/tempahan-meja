@extends('layouts.app')

@section('content')
    <!--wrapper-->
    <div class="wrapper-main">
        <div class="d-flex align-items-center justify-content-center my-5 my-lg-0">
            <div class="container-fluid">
                <div class="row justify-content-center">
                    <div class="col-12 col-lg-9">
                        <h2 class="text-center text-uppercase mb-4">Maklumat Tempahan Meja</h2>
                        <div class="card ticket-card shadow-lg">
                            <div class="row">
                                <!-- Left Section: Ticket Info -->
                                <div class="col-12 col-md-8">
                                    <div class="ticket-info">
                                        <div class="ticket-header mb-4">
                                            <div
                                                class="d-flex justify-content-between align-items-center flex-column flex-md-row text-center text-md-start mb-2">
                                                <div class="mb-2 mb-md-0">
                                                    <img src="{{ asset('public/assets/images/logo-malam-gala.png') }}"
                                                        alt="Logo Malam Gala" class="img-fluid mx-auto d-block"
                                                        style="max-height: 90px; width: auto;">
                                                </div>
                                                <div>
                                                    <h5 class="text-uppercase">No. Meja: {{ $booking->table->table_no }}
                                                    </h5>
                                                </div>
                                            </div>
                                        </div>
                                        <table class="table table-borderless mb-0">
                                            <tr>
                                                <th class="text-uppercase">Nama</th>
                                                <td>{{ $booking->staff->name }}</td>
                                            </tr>
                                            <tr>
                                                <th class="text-uppercase">No. Pekerja</th>
                                                <td>{{ $booking->staff->no_pekerja }}</td>
                                            </tr>
                                            <tr>
                                                <th class="text-uppercase">No. Tempahan</th>
                                                <td>{{ $booking->booking_no }}</td>
                                            </tr>
                                            <tr>
                                                <th class="text-uppercase">Tarikh Tempahan</th>
                                                <td>{{ $booking->created_at->format('d-m-Y H:i') }}</td>
                                            </tr>
                                        </table>

                                        <!-- Footer: Notes and Download Button -->
                                        <div class="ticket-footer mt-4">
                                            <div class="text-center mt-2">
                                                <em>Sila imbas kod QR ini kepada urusetia semasa hadir ke Malam Gala.</em>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <!-- Right Section: QR Code or Logo -->
                                <div class="col-12 col-md-6 col-lg-4 d-flex justify-content-center align-items-center">
                                    <div
                                        class="qr-code-container d-flex justify-content-center align-items-center text-center">
                                         <img src="{{ $booking->qr_code }}" alt="QR Code">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="text-center mt-4">
                            <a href="{{ route('staff.booking.print', $booking->id) }}" class="btn btn-primary w-100"
                                target="_blank">
                                <i class="fas fa-download"></i> Muat Turun Tiket
                            </a>
                        </div>

                        <div class="card bg-light text-dark shadow-sm mt-3">
                            <div class="card-body">
                                <!-- Layout Plan Accordion -->
                                <div class="mt-4">
                                    <div class="accordion" id="layoutAccordion">
                                        <div class="accordion-item">
                                            <h4 class="accordion-header" id="headingOne">
                                                <button class="accordion-button text-uppercase" type="button"
                                                    data-bs-toggle="collapse" data-bs-target="#collapseLayout"
                                                    aria-expanded="true" aria-controls="collapseLayout">
                                                    Paparan Pelan Meja Sebenar
                                                </button>
                                            </h4>
                                            <div id="collapseLayout" class="accordion-collapse collapse"
                                                aria-labelledby="headingOne" data-bs-parent="#layoutAccordion">
                                                <div class="accordion-body">
                                                    <img src="{{ asset('public/assets/images/layout.jpg') }}"
                                                        alt="Pelan Meja" class="img-fluid">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Hall Layout -->
                                <div class="hall-layout position-relative text-center mt-4">
                                    <!-- Tables -->
                                    <div class="row justify-content-center mt-4">
                                        @foreach ($tables as $table)
                                            <div class="col-6 col-md-4 col-lg-3 d-flex justify-content-center mb-4">
                                                <div class="table-round p-3 
                                        @if ($table->id == $booking->table_id) bg-warning 
                                        @elseif ($table->available_seat > 0) bg-success
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
                                                        @if ($table->id == $booking->table_id)
                                                            <p style="font-size: 10px; font-weight:bold">
                                                                {{ $booking->staff->name }}
                                                            </p>
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
        </div>
    </div>
    <!--end wrapper-->
    <style>
    .qr-code-container {
    width: 300px; /* Increased width */
    margin: 0 auto;
}

.qr-code-container img {
    width: 100%; /* Ensure the QR code image fits the container */
    height: auto;
}

.ticket-card {
	border-radius: 15px;
	background-color: #000; /* Black background */
	padding: 15px;
	color: #fff; /* White text color */
}

.ticket-info h4, .ticket-info h5 {
	color: #fff; /* White text color */
	margin-bottom: 10px;
}

.ticket-info th {
	width: 40%;
	color: #ccc; /* Silver text color */
}

.ticket-info td {
	color: #fff; /* White text color */
}

.ticket-logo img, .ticket-barcode img {
	border-radius: 10px;
	margin-top: 20px;
}

.ticket-footer {
	padding: 10px 0;
	border-top: 1px solid #ccc; /* Silver border color */
	margin-top: 20px;
	color: #fff; /* White text color */
}

.ticket-header {
	padding: 10px 0;
	border-bottom: 1px solid #ccc; /* Silver border color */
	color: #fff; /* White text color */
}

</style>
@endsection
