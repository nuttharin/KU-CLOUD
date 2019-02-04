@extends('layouts.mainCompany') 
@section('title','User | Company') 
@section('content')


<select id="select-resource">
    <option value=""></option>
<select>
<textarea id="data" class="form-control"></textarea>
<ul id="data-list" class="list-group">

</ul>

@for ($i = 0; $i < sizeof($output); $i++)
    {{trim($output[$i])}}
    <br>
@endfor

<script>
function getFlatObject(object) {
    function iter(o, p) {
        if (Array.isArray(o) ){
            o.forEach(function (a, i) {
                iter(a, p.concat(i));
            });
            return;
        }
        if (o !== null && typeof o === 'object') {
            Object.keys(o).forEach(function (k) {
                iter(o[k], p.concat(k));
            });
            return;
        }
        path[p.join('.')] = o;
    }

    var path = {};
    iter(object, []);
    return path;
}

var obj = {
	"Stations" :{
		"_id" : "5c51a53d46967b0d404ce91d",
		"WmoNumber" : "48439",
    		"StationNameTh" : "กบินทร์บุรี",
    		"StationNameEng" : "KABIN BURI",
    		"Province" : "ปราจีนบุรี",
    "Latitude" : {
        "Value" : "13.983333",
        "Unit" : "decimal degree"
    },
    "Longitude" : {
        "Value" : "101.707222",
        "Unit" : "decimal degree"

    },
    "Observe" : {
        "Time" : "30/1/2019 19:00:00",
        "Temperature" : {
            "Value" : 30.3,
            "Unit" : "celcius"
        },
        "StationPressure" : {
            "Value" : 1008.8,
            "Unit" : "hPa"
        },
        "MeanSeaLevelPressure" : {
            "Value" : 1010.2,
            "Unit" : "hPa"
        },
        "DewPoint" : {
            "Value" : 22.5,
            "Unit" : "celcius"
        },
        "RelativeHumidity" : {
            "Value" : 63,
            "Unit" : "%"
        },
        "VaporPressure" : {
            "Value" : 27.3,
            "Unit" : "hPa"
        },
        "LandVisibility" : {
            "Value" : 8,
            "Unit" : "km"
        },
        "WindDirection" : {
            "Value" : "000",
            "Unit" : "degree"
        },
        "WindSpeed" : {
            "Value" : 0,
            "Unit" : "km/h"
        },
        "Rainfall" : {
            "Value" : 0,
            "Unit" : "mm"
        },
        "TotolCloud" : "ท้องฟ้าแจ่มใส"
    }
    

	}
    
},
    path = getFlatObject(obj);
	
console.log(path);

</script>
@endsection