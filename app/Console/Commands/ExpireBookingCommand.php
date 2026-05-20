<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;

use App\Models\Booking;
use App\Models\Fasilitas;

class ExpireBookingCommand extends Command
{
    protected $signature = 'booking:expire';

    protected $description = 'Membatalkan booking yang belum bayar DP dalam 24 jam';

    public function handle()
    {
        $bookings = Booking::with('fasilitas')
            ->where('status_booking', 'menunggu_pembayaran')
            ->where('created_at', '<=', Carbon::now()->subHours(24))
            ->get();

        foreach ($bookings as $booking) {

            // kembalikan stok fasilitas
            foreach ($booking->fasilitas as $item) {

                $fasilitas = Fasilitas::find($item->id);

                if ($fasilitas) {
                    $fasilitas->increment('stok', $item->pivot->jumlah);
                }
            }

            // ubah status booking
            $booking->update([
                'status_booking' => 'dibatalkan'
            ]);
        }

        $this->info('Booking expired berhasil diproses');
    }
}