@extends('layouts.mainCompany') 
@section('title','User | Company') 
@section('content')
<select id="select-resource">
    <option value=""></option>
<select>
<textarea id="data" class="form-control"></textarea>
<ul id="data-list" class="list-group">

</ul>
<style>
 .list-group-item:hover{
    z-index: 2;
    color: #fff;
    background-color: #007bff;
    border-color: #007bff;
 }
</style>
<script>
    let datasources = {
        api : null,
    }

    let tt = "datasources['api']['Stations']['2']['StationNameEng']"

    let dataAccess = ['api','Stations','2','Observe','Temperature','Value'];

    let apiSelect = "datasources";
    let dataTest = "";

    let keyTest = [];

    let re = /([a-zA-Z0-9_]+)/g;

    function saveData(res){
        datasources.api = res;
        //console.log(getData(1,datasources[dataAccess[0]]));
        let key = Object.keys(datasources);
        $("#select-resource").append(key.map(_key => {
            return `<option value="${_key}">${_key}</option>`;
        }))
        
    }

    function getData(index,data){
        // let re = /([a-zA-Z0-9_]+)/g;
        // console.log( tt.match(re));
        if(typeof(data[dataAccess[index]]) == 'object'){
            return getData(index+1,data[dataAccess[index]]);
        }
        return data[dataAccess[index]];
    };

    function getKey(index,data){
        if(typeof(data) == 'object'){
            if(index == keyTest.length){
                return  Object.keys(data) ? Object.keys(data) : [];
            }
            return getKey(index+1,data[keyTest[index]]);
        }
    }

    function checkType(value){
        keyTest = value.match(re);
        let key =  getKey(2,datasources[keyTest[1]])
        $("#data-list").empty();
        key.map(_key => {
            let test = value + "['"+_key+"']";
            $("#data-list").append(`<li class="value-data list-group-item" style="cursor:pointer" value="${_key}">${_key} : ${eval(test)}</li>`)
        });

        $(".value-data").click(function(){
            let a = $("#data").html();
            a += `['${$(this).attr('value')}']`;
            $("#data").html(a);
            checkType($("#data").html());
        });       
    }

    $.ajax({
        //https://data.tmd.go.th/api/WeatherToday/V1/?type=json
        url:'/js/company/test-api2.json',
        success:(res) => {
            saveData(res);
            
        },
        error:(res)=> {
            console.log(res);
        }
    })

    $(document).ready(function(){
        function createDataList(api){
            
            $("#data-list").empty();
            let js = apiSelect + "['"+api+"']";
            $("#data").html(js);
            checkType(js);       
        }

        $("#select-resource").change(function(){
            createDataList($(this).val())
        });

       

    });

</script>
@endsection