@extends('admin.includes.master-admin')

@section('content')

    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row" id="main">
                <!-- Page Heading -->
                <div class="go-title">
                
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
                        <table class="table table-striped table-bordered" cellspacing="0" id="example" width="100%">
                            <thead>
                            <tr>
                                <th>Customer Email</th>
                                <th width="15%">Customer Name</th>
                               
                                <th width="5%">Total Product</th>
                                <th width="10%">Total Cost</th>
                                <th>Payment Method</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($orders as $order)
                                @if($order->status == "completed")
                                    <tr style="background-color: lightgreen;">
                                @elseif($order->status == "processing")
                                    <tr class="info">
                                @else
                                    <tr class="">
                                @endif
                                    <td>{{$order->customer_email}}</td>
                                    <td>{{$order->customer_name}}</td>
                                  
                                    <td>{{array_sum($order->quantities)}}</td>
                                    <td>{{$settings[0]->currency_sign}}{!! $order->pay_amount !!}</td>
                                    <td>{{$order->method}}</td>

    

</tr>

                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- /#page-wrapper -->


@stop

@section('footer')

@stop