<?php

namespace App\Http\Controllers;

use App\Report;
use App\Order;
use App\Product;
use App\UserProfile;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index(Request $request)
{
    //MENGAMBIL DATA CUSTOMER
    $customers = UserProfile::orderBy('name', 'ASC')->get();
    //MENGAMBIL DATA USER YANG MEMILIKI ROLE KASIR
   // $users = User::role('kasir')->orderBy('name', 'ASC')->get();
    //MENGAMBIL DATA TRANSAKSI
    $orders = Order::orderBy('booking_date', 'DESC')->with('order_detail', 'customers');

 
    //JIKA PELANGGAN DIPILIH PADA COMBOBOX
    if (!empty($request->_id)) {
        //MAKA DITAMBAHKAN WHERE CONDITION
        $orders = $orders->where('customer_id', $request->customer_id);
    }

 
    //JIKA USER / KASIR DIPILIH PADA COMBOBOX
    //if (!empty($request->user_id)) {
        //MAKA DITAMBAHKAN WHERE CONDITION
      //  $orders = $orders->where('user_id', $request->user_id);
    //}

 
    //JIKA START DATE & END DATE TERISI
    if (!empty($request->start_date) && !empty($request->end_date)) {
        //MAKA DI VALIDASI DIMANA FORMATNYA HARUS DATE
        $this->validate($request, [
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date'
        ]);
        
        //START & END DATE DI RE-FORMAT MENJADI Y-m-d H:i:s
        $start_date = Carbon::parse($request->start_date)->format('Y-m-d') . ' 00:00:01';
        $end_date = Carbon::parse($request->end_date)->format('Y-m-d') . ' 23:59:59';

 
        //DITAMBAHKAN WHEREBETWEEN CONDITION UNTUK MENGAMBIL DATA DENGAN RANGE
        $orders = $orders->whereBetween('booking_date', [$start_date, $end_date])->get();
    } else {
        //JIKA START DATE & END DATE KOSONG, MAKA DI-LOAD 10 DATA TERBARU
        $orders = $orders->take(10)->skip(0)->get();
    }

 
    //MENAMPILKAN KE VIEW
    return view('orders.index', [
        'orders' => $orders,
        'sold' => $this->countItem($orders),
        'total' => $this->countTotal($orders),
        'total_customer' => $this->countCustomer($orders),
        'customers' => $customers,
        
    ]);
}
//Penjelasan: Terdapat 3 buah method yang terlibat, yakni: countItem(): untuk mengambil total item yang terjual, countTotal(): untuk mengambil total omset dan countCustomer(): untuk mengambil total customer.

//Masih di dalam file OrderController.php, tambahkan code berikut:

private function countCustomer($orders)
{
    //ARRAY KOSONG DIDEFINISIKAN
    $customer = [];
    //JIKA TERDAPAT DATA YANG AKAN DITAMPILKAN
    if ($orders->count() > 0) {
        //DI-LOOPING UNTUK MENYIMPAN EMAIL KE DALAM ARRAY
        foreach ($orders as $row) {
            $customer[] = $row->customer->email;
        }
    }
    //MENGHITUNG TOTAL DATA YANG ADA DI DALAM ARRAY
    //DIMANA DATA YANG DUPLICATE AKAN DIHAPUS MENGGUNAKAN ARRAY_UNIQUE
    return count(array_unique($customer));
}

private function countTotal($orders)
{
    //DEFAULT TOTAL BERNILAI 0
    $total = 0;
    //JIKA DATA ADA
    if ($orders->count() > 0) {
        //MENGAMBIL VALUE DARI TOTAL -> PLUCK() AKAN MENGUBAHNYA MENJADI ARRAY
        $sub_total = $orders->pluck('total')->all();
        //KEMUDIAN DATA YANG ADA DIDALAM ARRAY DIJUMLAHKAN
        $total = array_sum($sub_total);
    }
    return $total;
}

private function countItem($order)
{
    //DEFAULT DATA 0
    $data = 0;
    //JIKA DATA TERSEDIA
    if ($order->count() > 0) {
        //DI-LOOPING
        foreach ($order as $row) {
            //UNTUK MENGAMBIL QTY 
            $qty = $row->order_detail->pluck('qty')->all();
            //KEMUDIAN QTY DIJUMLAHKAN
            $val = array_sum($qty);
            $data += $val;
        }
    } 
    return $data;
}

public function invoicePdf($invoice)
{

}

public function invoiceExcel($invoice)
{

}
