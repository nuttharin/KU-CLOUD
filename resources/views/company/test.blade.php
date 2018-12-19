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

    let apiSelect = "datasources";
    let dataTest = "";

    function saveData(res){
        datasources.api = res;
        let key = Object.keys(datasources);
        $("#select-resource").append(key.map(_key => {
            return `<option value="${_key}">${_key}</option>`;
        }))
        
    }

    function checkType(value){
        if(typeof(eval(value)) == 'object'){
            let key = Object.keys(eval(value));
                $("#data-list").empty();
                key.map(_key => {
                    let test = value + "['"+_key+"']";
                    $("#data-list").append(`<li class="value-data list-group-item" style="cursor:pointer" value="${_key}">${_key} : ${eval(test)}</li>`)
                })

                $(".value-data").click(function(){
                    let a = $("#data").html();
                    a += `['${$(this).attr('value')}']`;
                    $("#data").html(a);
                    checkType($("#data").html());
            });       
        }
        else{
            $("#data-list").empty();
        }
    }

    $.ajax({
        url:"https://data.tmd.go.th/api/WeatherToday/V1/?type=json",
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
            let key = Object.keys(eval(js));
            console.log(key);
            key.map(_key => {
                let test = js + "['"+_key+"']";
                $("#data-list").append(`<li class="value-data list-group-item" style="cursor:pointer" value="${_key}">${_key} : ${eval(test)}</li>`)
            })

            $(".value-data").click(function(){
                let a = $("#data").html();
                a += `['${$(this).attr('value')}']`;
                $("#data").html(a);
                checkType($("#data").html());
            });            
        }

        $("#select-resource").change(function(){
            createDataList($(this).val())
        });


    });

</script>
@endsection