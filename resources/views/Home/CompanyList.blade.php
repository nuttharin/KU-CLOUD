@extends('layouts.home')
@section('content')
<style>
body {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        /* background-color: #f2f8f9; */
        background: linear-gradient(-45deg, #00e4d0, #59a8e8, #23A6D5, #23D5AB);
        background-size: 400% 400%;
        -webkit-animation: Gradient 15s ease infinite;
        -moz-animation: Gradient 15s ease infinite;
        animation: Gradient 15s ease infinite;
        overflow-x: hidden;
    }

    .text-shadow {
        text-shadow: 2px 0px 5px rgba(0, 0, 0, 0.13);
    }

    @-webkit-keyframes Gradient {
        0% {
            background-position: 0% 50%
        }
        50% {
            background-position: 100% 50%
        }
        100% {
            background-position: 0% 50%
        }
    }

    @-moz-keyframes Gradient {
        0% {
            background-position: 0% 50%
        }
        50% {
            background-position: 100% 50%
        }
        100% {
            background-position: 0% 50%
        }
    }

    @keyframes Gradient {
        0% {
            background-position: 0% 50%
        }
        50% {
            background-position: 100% 50%
        }
        100% {
            background-position: 0% 50%
        }
    }

    .form-control.search-input {
        border: 0;
        box-shadow: 0 5px 10px 0 rgba(0, 0, 0, 0.13);
        border-radius: 5.25rem;
    }

    .form-control.search-input:hover {
        box-shadow: 0 5px 10px 0 rgba(0, 0, 0, 0.25);
    }

    .content-line{
        display:block;
    }
</style>

<link href="{{url('css/homepage.css')}}" rel="stylesheet">

<input type="hidden" id="path_src" value="{{url('flats.png')}}"/>

<div class="container" style="margin-top:130px;">
    <h1 class="mb-3 text-white text-shadow">Company list</h1>
    <form id="search_company>">
        <div class="form-group">
            <input type="text" class="form-control search-input" placeholder="Search company" id="search_company_input" />
        </div>
    </form>
    <h6 id="total_company" class="text-white text-shadow"></h6>
</div>

<div class="container" style="margin-top:40px; padding-bottom:25px;">
    <div class="row" id="space_list">       
    </div>
    <div class="lds-roller text-center" id="loading">
        <div></div>
        <div></div>
        <div></div>
        <div></div>
        <div></div>
        <div></div>
        <div></div>
        <div></div>
    </div>
</div>


<div class="modal fade" id="company_detail">
    <div class="modal-dialog modal-lg">
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
                        <div class="row mt-2 justify-content-center">
                            <div class="col-4 mt-2">
                                <img src="" id="modal_logo_company" alt="Card image cap" style="width: inherit;">
                            </div>
                        </div>
                        <div class="row mt-4">
                            <div class="col-xl-4 col-12 mt-2">        
                                <h5 class="text-left">ADDRESS</h5>
                                <div class="row">
                                    <div class="col-6">
                                        <h6 class="text-left content-line">Address detail : </h6>
                                        <h6 class="text-left content-line">District : </h6>
                                        <h6 class="text-left content-line">Amphure : </h6>
                                        <h6 class="text-left content-line">Province : </h6>
                                    </div>
                                    <div class="col-6">
                                        <h6 id="address_detail" class="text-left"></h6>
                                        <h6 id="address_district" class="text-left"></h6>
                                        <h6 id="address_amphure" class="text-left"></h6>
                                        <h6 id="address_province" class="text-left"></h6>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-4 col-12 mt-2">
                                <div class="row">
                                    <div class="col-6">
                                        <h4 class="text-left">Webservice</h4>
                                    </div>
                                    <div class="col-6">
                                        <h4 class="text-left">Description</h4>
                                    </div>
                                </div>
                                <div id="webserive_section">
                                </div>
                            </div>
                            <div class="col-xl-4 col-12 mt-2">
                                <div class="row">
                                    <div class="col-6">
                                        <h4 class="text-left">IoTservice</h4>
                                    </div>
                                    <div class="col-6">
                                        <h4 class="text-left">Description</h4>
                                    </div>
                                </div>
                                <div id="iotserive_section">
                                </div>
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
