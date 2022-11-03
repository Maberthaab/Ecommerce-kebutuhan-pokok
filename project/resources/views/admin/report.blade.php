@extends('admin.includes.master-admin')

@section('content')

    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row" id="main">
                <!-- Page Heading -->
                <div class="go-title">
                    <div class="pull-right">
                        <span><span style="background-color: lightgreen;">&nbsp;&nbsp;&nbsp;&nbsp;</span> Completed</span>
                        <span><span style="background-color: #d9edf7;">&nbsp;&nbsp;&nbsp;&nbsp;</span> Processing</span>
                    </div>
                       
                    <h3>Orders</h3>  
                    <img src="{{url('/')}}/y.png" alt="">
                    <div class="print-order text-right">

                                <button type="button" onclick="window.print();" class="print-order-btn">
                                    <i class="fa fa-print"></i> Print Order
                                </button>
                    <div class="go-line"></div>
                </div>
                <!-- Page Content -->
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div id="response">
                            @if(Session::has('message'))
                                <div class="alert alert-success alert-dismissable">
                                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                    {{ Session::get('message') }}
                                </div>
                            @endif
                        </div>
                                

                                <form action="{{ route('order.index') }}" method="get">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Mulai Tanggal</label>
                                            <input type="text" name="start_date" 
                                                class="form-control {{ $errors->has('start_date') ? 'is-invalid':'' }}"
                                                id="start_date"
                                                value="{{ request()->get('start_date') }}"
                                                >
                                        </div>
                                        <div class="form-group">
                                            <label for="">Sampai Tanggal</label>
                                            <input type="text" name="end_date" 
                                                class="form-control {{ $errors->has('end_date') ? 'is-invalid':'' }}"
                                                id="end_date"
                                                value="{{ request()->get('end_date') }}">
                                        </div>
                                        <div class="form-group">
                                            <button class="btn btn-primary btn-sm">Cari</button>
                                        </div>
                                    </div>
                                    </div>
                                    </form>

                                  @endforeach  

                                <div class="row">
                                <div class="col-4">
                                    <div class="small-box bg-info">
                                        <div class="inner">
                                            <h3>{{ $sold }}</h3>
                                            <p>Item Terjual</p>
                                        </div>
                                        <div class="icon">
                                            <i class="ion ion-bag"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="small-box bg-success">
                                        <div class="inner">
                                            <h3>Rp {{ number_format($total) }}</h3>
                                            <p>Total Omset</p>
                                        </div>
                                        <div class="icon">


<div class="table-responsive">
                                <table class="table table-hover table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Invoice</th>
                                            <th>Booking Date</th>
                                            <th>Product</th>
    										<th>Jumlah</th>
                                            <th>Total Belanja</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- LOOPING MENGGUNAKAN FORELSE, DIRECTIVE DI LARAVEL 5.6 -->
                                        @forelse ($orders as $row)
                                        <tr>
                                             <td><a target="_blank" href="{{url('/product')}}/{{$product->productid}}/{{str_replace(' ','-',strtolower(\App\Product::findOrFail($product->productid)->title))}}">{{\App\Product::findOrFail($product->productid)->title}}</a></td>

                                           <td>{{array_sum($order->quantities)}}</td>
                                   		<td>{{$settings[0]->currency_sign}}{!! $order->pay_amount !!}</td>
                                                <td>{{$order->booking_date}}</td>
                                            <td>{{ $row->created_at->format('d-m-Y H:i:s') }}</td>
                                            <td>
                                                <a href="{{ route('report.pdf', $row->invoice) }}" 
                                                    target="_blank"
                                                    class="btn btn-primary btn-sm">
                                                    <i class="fa fa-print"></i>
                                                </a>
                                                <a href="{{ route('report.excel', $row->invoice) }}" 
                                                    target="_blank"
                                                    class="btn btn-info btn-sm">
                                                    <i class="fa fa-file-excel-o"></i>
                                                </a>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td class="text-center" colspan="7">Tidak ada data transaksi</td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                         
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@section('js')
    <script>
        $('#start_date').datepicker({
            autoclose: true,
            format: 'yyyy-mm-dd'
        });

        $('#end_date').datepicker({
            autoclose: true,
            format: 'yyyy-mm-dd'
        });
    </script>

                          
    <!-- /#page-wrapper -->
@stop

@section('footer')

@stop