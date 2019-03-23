@extends('layouts.home')
@section('content')
<style>
    body {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        background-color: #f2f8f9;
    }

    #dashboardList {
        width: 100%;
        height: 200px;

    }

    #dashboardList div {
        width: 100%;
        height: 100%;
        
    }

    .card {
        box-shadow: 0 0 0.5cm rgba(0,0,0,0.5) 
    }

    .link {
        cursor: pointer;
    }

    .link:hover{
        color: #308ee0;
    }

    .form-control {
        border-radius: 5.25rem;
        box-shadow: 1px 1px 10px 1px #0000;
    }

</style>


<div class="container" style="margin-top:150px;">
    <h1 class="mb-3">Dashboards public</h1>
    <form id="search_dashboard">
        <div class="form-group">
            <input type="text" class="form-control" placeholder="Search dashboard" id="search_dashboard_input">
        </div>
    </form>
    <h6 id="total_dashboard"></h6>
    <div id="dashboardList">
        
        <div>

        </div>
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

<script src="{{asset('js/dashboards/DashboardListPublic.min.js')}}"></script>

<div id="layoutList" hidden>
    <div class="card mt-4" >
        <div class="card-body">
            <div class="link" key="[[key]]">
                    <h2>[[name]]</h2>
                    <br>
                    [[des]]
                    <br>
            </div>
        </div> 
        
    </div>
</div>
@endsection
