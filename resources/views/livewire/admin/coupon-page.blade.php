<div>
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <h2 class="page-title">
                        Kupon
                    </h2>
                </div>
            </div>
        </div>
    </div>

    <div class="page-body">
        <div class="container-xl">

            {{-- Flash Message --}}
            @if (session('success'))
                <div class="alert alert-success alert-dismissible" role="alert">
                    <div>{{ session('success') }}</div>
                    <a class="btn-close" data-bs-dismiss="alert" aria-label="close"></a>
                </div>
            @endif

            <div class="row row-cards">

                {{-- Card Form Generator --}}
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Generate Kupon Baru</h3>
                        </div>
                        <div class="card-body">
                            <form wire:submit="generate">
                                <div class="mb-3">
                                    <label class="form-label">Jumlah Kupon</label>
                                    <input type="number" wire:model="amount"
                                        class="form-control @error('amount') is-invalid @enderror"
                                        placeholder="Contoh: 1000">
                                    @error('amount')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-hint">Maksimal 50.000 sekali proses.</small>
                                </div>

                                <div class="d-flex justify-content-between">
                                    <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">
                                        <!-- Loading State Text -->
                                        <span wire:loading.remove wire:target="generate">
                                            Generate
                                        </span>
                                        <span wire:loading wire:target="generate">
                                            Memproses...
                                        </span>
                                    </button>

                                    <!-- Tombol Reset (Hati-hati) -->
                                    {{-- <button type="button" wire:click="resetCoupons"
                                        wire:confirm="Yakin ingin menghapus SEMUA kupon?" class="btn btn-ghost-danger">
                                        Reset Data
                                    </button> --}}
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                {{-- Card Tabel Data --}}
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Daftar Kupon Terbaru</h3>
                            <div class="card-actions">
                                <!-- Tombol Refresh untuk cek data baru dari Queue -->
                                <button wire:click="$refresh" class="btn btn-sm btn-secondary">
                                    Refresh Data
                                </button>
                            </div>
                        </div>

                        <!-- Polling: Update tabel otomatis setiap 2 detik jika user diam (berguna saat menunggu queue) -->
                        <div class="table-responsive" wire:poll.5s>
                            <table class="table card-table table-vcenter text-nowrap datatable">
                                <thead>
                                    <tr>
                                        <th class="w-1">No</th>
                                        <th>Kode Kupon</th>
                                        <th>Status</th>
                                        <th>Participant ID</th>
                                        <th>Dibuat Pada</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($coupons as $index => $coupon)
                                        <tr wire:key="{{ $coupon->id }}">
                                            <td><span class="text-muted">{{ $coupons->firstItem() + $index }}</span>
                                            </td>
                                            <td>
                                                <span
                                                    class="badge bg-blue text-blue-fg fs-3">{{ $coupon->kode_kupon }}</span>
                                            </td>
                                            <td>
                                                @if ($coupon->status_kupon == 'Aktif')
                                                    <span class="badge bg-green text-green-fg">Aktif</span>
                                                @else
                                                    <span
                                                        class="badge bg-red text-red-fg">{{ $coupon->status_kupon }}</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($coupon->participant_id)
                                                    {{ $coupon->participant_id }}
                                                @else
                                                    <span class="text-muted fst-italic">- Belum ada -</span>
                                                @endif
                                            </td>
                                            <td>{{ \Carbon\Carbon::parse($coupon->created_at)->format('d M Y H:i:s') }}
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center py-4">
                                                <div class="text-muted">Belum ada kupon yang digenerate.</div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        {{-- Pagination --}}
                        <div class="card-footer d-flex align-items-center">
                            {{ $coupons->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
