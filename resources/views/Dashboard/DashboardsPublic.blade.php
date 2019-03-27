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

    #dashboardList {
        width: 100%;
        height: 200px;

    }

    #dashboardList div {
        width: 100%;
        height: 100%;

    }

    .form-control.search-input {
        border: 0;
        box-shadow: 0 5px 10px 0 rgba(0, 0, 0, 0.13);
        border-radius: 5.25rem;
    }

    .form-control.search-input:hover {
        box-shadow: 0 5px 10px 0 rgba(0, 0, 0, 0.25);
    }

    .dashboard-list.card {
        cursor: pointer;
        border-radius: 1.25rem;
        box-shadow: 0 5px 10px 0 rgba(0, 0, 0, 0.13);
        border: none;
        transition: all .2s ease-in-out;
    }

    .dashboard-list.card:hover {
       
        transform: scale(1.05);
        box-shadow: 0 5px 10px 0 rgba(0, 0, 0, 0.25);
        color: #308ee0;
  
    }
</style>


<div class="container" style="margin-top:130px;">
    <h1 class="mb-3 text-white text-shadow">Dashboards public</h1>
    <form id="search_dashboard">
        <div class="form-group">
            <input type="text" class="form-control search-input" placeholder="Search dashboards"
                id="search_dashboard_input">
        </div>
    </form>
    <h6 id="total_dashboard" class="text-white text-shadow"></h6>
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
    <div class="card mt-4 mb-4 dashboard-list">
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
