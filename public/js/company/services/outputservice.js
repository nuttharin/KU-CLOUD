$(document).ready(function () {

    $('#card_1').hide();
    $('#card_1_h').on('click',function(){
        $('#card_1').show();
    })
    let data;
    let jsondata;
    let dataIoT;
    let detailtryit = (detail_tryit)=>
        { 
            $("#show_detail_tryit").show();
            $("#call").empty();
            $('#clear_result').html( "clear result" );
           // $('#call').append( "Call<br/><p class='solid'>"+detail_tryit[0].data.header+"</p>" );
           //text='"+detail_tryit+"'
            $('#call').append("<textarea type='text' rows='10' class='form-control mb-2'  id='result2'></textarea><button class='btn btn-info' id='download-file'>Download</button>");
            jsondata = JSON.stringify(detail_tryit);
            //console.log(jsondata);
            $('#result2').val(JSON.stringify(detail_tryit, undefined, 2));
            $('#clear_result').on("click", function () {
                $("#show_detail_tryit").hide();
            });
            $('#download-file').on("click", function () {
                
                $.ajax({
                    url: END_POINT+"company/webservice/downloadJSONFile",
                    dataType: 'json',
                    method: "POST",
                    data:
                    {
                        jsondata: jsondata
                    },
                    success: (res) => {
                        //console.log("success")
                        console.log(res);
                    },
                    error: (res) => {
                        console.log(res);
                    }
                });
            });             
        }
    let insertintoDW = (table_DW,summary_table)=>
        { 
            $.ajax({
                url: API_DW+"webService/getDataAggregation",
                dataType: 'json',
                method: "POST",
                headers: {"Authorization": getCookie('token')},
                data:
                {
                    tableDW_name: table_DW,
                    Agrregation_type:summary_table,
                },
                success: (res) => {
                    //console.log("success")
                    console.log(res);
                    let detail_tryit = res;
                    detailtryit(detail_tryit);
                },
                error: (res) => {
                    console.log(res);
                }
            });
        }
    let selectdata = (data)=>
        { 
            //console.log(data)
            for(var i=0;i<data.length;i++)
            {
                $('#table_DW').append($("<option/>", {
                    value: data[i].service_name_DW,
                    text: data[i].name
                }));
                $('#table_IoT_DW').append($("<option/>", {
                    value: data[i].iot_name_DW,
                    text: data[i].name
                }));
            }
            
        }
        $.ajax({
            url: END_POINT+"api/iot/getAllIotserviceData",
            dataType: 'json',
            method: "GET",
            async: false,
            success: (res) => {
                dataIoT = res.iotService;
                console.log(dataIoT)
            },
            error: (res) => {
                console.log(res);
            }
        });
        $.ajax({
            url: END_POINT+"company/webservicedata",
            dataType: 'json',
            method: "GET",
            async: false,
            success: (res) => {
                data = res.webService;
                console.log(data)
            },
            error: (res) => {
                console.log(res);
            }
        });
        $('#try_it').on("click", function () {
            let table_DW = $("#table_DW").val();
            let summary_table = $('#summary_table').val();
            insertintoDW(table_DW,summary_table)
        });
        
        selectdata(dataIoT);
        selectdata(data);
        
});