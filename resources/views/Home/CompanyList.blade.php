@extends('layouts.home')
@section('content')
<style>
    body{
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        background-color: #f2f8f9;
    }
</style>

<link href="{{url('css/homepage.css')}}" rel="stylesheet">

<input type="hidden" id="path_src" value="{{url('imagemenu/graph/bar.png')}}"/>

<div class="container" style="margin-top:150px;">
    <h1 class="mb-3">Company list</h1>
    <form id="search_company">
        <div class="form-group">
            <input type="text" class="form-control" placeholder="Search company" id="search_company_input">
        </div>
    </form>
</div>

<div class="container" style="margin-top:40px;">
    <div class="row" id="space_list">
        
    </div>
</div>


<div class="modal fade" id="company_detail">
    <div class="modal-dialog modal-lg" style="width:50%">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title"></h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
                <form id="form-add-user">
                    <div class="container">
                        <div class="row">
                            <div class="col-4 mt-2">
                                <img src="{{url('imagemenu/graph/bar.png')}}" alt="Card image cap" style="width: inherit; height: 200px;">
                            </div>
                            <div class="col-4 mt-2">        
                                <h5 class="text-left">ADDRESS</h5>
                                <h6 id="address_detail" class="text-left"></h6>
                                <h6 id="address_district" class="text-left"></h6>
                                <h6 id="address_amphure" class="text-left"></h6>
                                <h6 id="address_province" class="text-left"></h6>
                            </div>
                            <div class="col-4 mt-2">        
                                <h5 class="text-left">Web service</h5>
                                <h6 class="text-left">service 1</h6>
                                <h6 class="text-left">service 2</h6>
                                <h6 class="text-left">service 3</h6>
                                <h6 class="text-left">service 4</h6>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>


<script src="{{asset('js/home/CompanyList.min.js')}}"></script>

@endsection
