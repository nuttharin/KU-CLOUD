class webService {
    constructor(datas) {
        this.initService = () => {
            selectdata(datas);
        }
        let detailtryit_Getlasttest_Aggregation = (detail_tryit)=>
        { 
            let jsondata;
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
                    url: "http://localhost:8000/api/company/webservice/downloadJSONFile",
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
        let detailtryit_Getall_Aggregation = (detail_tryit)=>
        { 
            let jsondata;
            $("#show_detail_tryit_Getall").show();
            $("#call_Getall").empty();
            $('#clear_result_Getall').html( "clear result" );
           // $('#call').append( "Call<br/><p class='solid'>"+detail_tryit[0].data.header+"</p>" );
           //text='"+detail_tryit+"'
            $('#call_Getall').append("<textarea type='text' rows='10' class='form-control mb-2'  id='result2_Getall'></textarea><button class='btn btn-info' id='download-file'>Download</button>");
            jsondata = JSON.stringify(detail_tryit);
            //console.log(jsondata);
            $('#result2_Getall').val(JSON.stringify(detail_tryit, undefined, 2));
            $('#clear_result_Getall').on("click", function () {
                $("#show_detail_tryit_Getall").hide();
            });
            $('#download-file').on("click", function () {
                
                $.ajax({
                    url: "http://localhost:8000/api/company/webservice/downloadJSONFile",
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
        let detailtryit_Getall_Data = (detail_tryit)=>
        { 
            let jsondata;
            $("#show_detail_tryit_Getall_Data").show();
            $("#call_Getall_Data").empty();
            $('#clear_result_Getall_Data').html( "clear result" );
           // $('#call').append( "Call<br/><p class='solid'>"+detail_tryit[0].data.header+"</p>" );
           //text='"+detail_tryit+"'
            $('#call_Getall_Data').append("<textarea type='text' rows='10' class='form-control mb-2'  id='Getall_Data'></textarea><button class='btn btn-info' id='download-file'>Download</button>");
            jsondata = JSON.stringify(detail_tryit);
            //console.log(jsondata);
            $('#Getall_Data').val(JSON.stringify(detail_tryit, undefined, 2));
            $('#clear_result_Getall_Data').on("click", function () {
                $("#show_detail_tryit_Getall_Data").hide();
            });
            $('#download-file').on("click", function () {
                
                $.ajax({
                    url: "http://localhost:8000/api/company/webservice/downloadJSONFile",
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
        let detailtryit_Getlasttest_Data = (detail_tryit)=>
        { 
            let jsondata;
            $("#show_detail_tryit_Getlasttest_Data").show();
            $("#call_Getlastest_Data").empty();
            $('#clear_result_Getlastest_Data').html( "clear result" );
           // $('#call').append( "Call<br/><p class='solid'>"+detail_tryit[0].data.header+"</p>" );
           //text='"+detail_tryit+"'
            $('#call_Getlastest_Data').append("<textarea type='text' rows='10' class='form-control mb-2'  id='GetLasttestData'></textarea><button class='btn btn-info' id='download-file'>Download</button>");
            jsondata = JSON.stringify(detail_tryit);
            //console.log(jsondata);
            $('#GetLasttestData').val(JSON.stringify(detail_tryit, undefined, 2));
            $('#clear_result_Getlastest_Data').on("click", function () {
                $("#show_detail_tryit_Getlasttest_Data").hide();
            });
            $('#download-file').on("click", function () {
                
                $.ajax({
                    url: "http://localhost:8000/api/company/webservice/downloadJSONFile",
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
    let insertintoDW_Getlasttest_Aggregation = (table_DW,summary_table)=>
        { 
            $.ajax({
                url: "http://localhost:8081/webService/getDataAggregation",
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
                    detailtryit_Getlasttest_Aggregation(detail_tryit);
                },
                error: (res) => {
                    console.log(res);
                }
            });
        }
        let insertintoDW_Getall_Aggregation = (table_DW)=>
        { 
            $.ajax({
                url: "http://localhost:8081/webService/getDataAggregation_Getall",
                dataType: 'json',
                method: "POST",
                headers: {"Authorization": getCookie('token')},
                data:
                {
                    tableDW_name: table_DW,
                },
                success: (res) => {
                    //console.log("success")
                    console.log(res);
                    let detail_tryit = res;
                    detailtryit_Getall_Aggregation(detail_tryit);
                },
                error: (res) => {
                    console.log(res);
                }
            });
        }
        let insertintoDW_Getlasttest_Data = (table_DW)=>
        { 
            $.ajax({
                url: "http://localhost:8081/webService/getLastestData",
                dataType: 'json',
                method: "POST",
                headers: {"Authorization": getCookie('token')},
                data:
                {
                    tableDW_name: table_DW,
                },
                success: (res) => {
                    //console.log("success")
                    console.log(res);
                    let detail_tryit = res;
                    detailtryit_Getlasttest_Data(detail_tryit);
                },
                error: (res) => {
                    console.log(res);
                }
            });
        }
        let insertintoDW_Getall_Data = (table_DW,summary_table)=>
        { 
            $.ajax({
                url: "http://localhost:8081/webService/getallData",
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
                    detailtryit_Getall_Data(detail_tryit);
                },
                error: (res) => {
                    console.log(res);
                }
            });
        }
        
        let selectdata = (datas)=>
        { 
            //console.log(data)
            for(var i=0;i<datas.length;i++)
            {
                $('#table_DW').append($("<option/>", {
                    value: datas[i].service_name_DW,
                    text: datas[i].name
                }));
                $('#table_DW_Getall').append($("<option/>", {
                    value: datas[i].service_name_DW,
                    text: datas[i].name
                }));
                $('#table_DW_Getall_Data').append($("<option/>", {
                    value: datas[i].service_name_DW,
                    text: datas[i].name
                }));
                $('#table_DW_Getlasttest_Data').append($("<option/>", {
                    value: datas[i].service_name_DW,
                    text: datas[i].name
                }));
            }
            
        }
        
        $('#try_it_Getall').on("click", function () {
            let table_DW = $("#table_DW").val();
            let summary_table = $('#summary_table').val();
            insertintoDW_Getall_Aggregation(table_DW,summary_table)
        });
        $('#try_it').on("click", function () {
            let table_DW = $("#table_DW").val();
            let summary_table = $('#summary_table').val();
            insertintoDW_Getlasttest_Aggregation(table_DW,summary_table)
        });
        $('#try_it_Getall_Data').on("click", function () {
            let table_DW = $("#table_DW").val();
            insertintoDW_Getall_Data(table_DW)
        });
        $('#try_it_Getlasttest_Data').on("click", function () {
            let table_DW = $("#table_DW").val();
            insertintoDW_Getlasttest_Data(table_DW)
        });
        
    }
}
class iotService{
    constructor(dataIoT) {
        this.initService = () => {
            selectIoTdata(dataIoT);
        }
        let detailtryit_Getall = (detail_tryit)=>
        { 
            let jsondata;
            $("#show_detail_iot_tryit_Getall").show();
            $("#call_IoT_Getall").empty();
            $('#clear_IoT_result_Getall').html( "clear result" );
           // $('#call').append( "Call<br/><p class='solid'>"+detail_tryit[0].data.header+"</p>" );
           //text='"+detail_tryit+"'
            $('#call_IoT_Getall').append("<textarea type='text' rows='10' class='form-control mb-2'  id='result2_Getall'></textarea><button class='btn btn-info' id='download_IoT_file'>Download</button>");
            jsondata = JSON.stringify(detail_tryit);
            //console.log(jsondata);
            $('#result2_Getall').val(JSON.stringify(detail_tryit, undefined, 2));
            $('#clear_IoT_result_Getall').on("click", function () {
                $("#show_detail_iot_tryit_Getall").hide();
            });
            $('#download_IoT_file').on("click", function () {
                
                $.ajax({
                    url: "http://localhost:8000/api/company/webservice/downloadJSONFile",
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
        let detailtryit = (detail_tryit)=>
        { 
            let jsondata;
            $("#show_detail_iot_tryit").show();
            $("#call_IoT").empty();
            $('#clear_IoT_result').html( "clear result" );
           // $('#call').append( "Call<br/><p class='solid'>"+detail_tryit[0].data.header+"</p>" );
           //text='"+detail_tryit+"'
            $('#call_IoT').append("<textarea type='text' rows='10' class='form-control mb-2'  id='result2'></textarea><button class='btn btn-info' id='download_IoT_file'>Download</button>");
            jsondata = JSON.stringify(detail_tryit);
            //console.log(jsondata);
            $('#result2').val(JSON.stringify(detail_tryit, undefined, 2));
            $('#clear_IoT_result').on("click", function () {
                $("#show_detail_iot_tryit").hide();
            });
            $('#download_IoT_file').on("click", function () {
                
                $.ajax({
                    url: "http://localhost:8000/api/company/webservice/downloadJSONFile",
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
        let insertintoIoTDW_Getall = (table_DW)=>
        { 
            $.ajax({
                url: "http://localhost:8081/iotService/getInputIoTData_Getall",
                dataType: 'json',
                method: "POST",
                headers: {"Authorization": getCookie('token')},
                data:
                {
                    tableDW_name: table_DW,
                },
                success: (res) => {
                    //console.log("success")
                    console.log(res);
                    let detail_tryit = res;
                    detailtryit_Getall(detail_tryit);
                },
                error: (res) => {
                    console.log(res);
                }
            });
        }
        let insertintoIoTDW = (table_DW)=>
        { 
            $.ajax({
                url: "http://localhost:8081/iotService/getInputIoTData",
                dataType: 'json',
                method: "POST",
                headers: {"Authorization": getCookie('token')},
                data:
                {
                    tableDW_name: table_DW,
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
        
        let selectIoTdata = (dataIoT)=>
        { 
            //console.log(data)
            for(var i=0;i<dataIoT.length;i++)
            {
                $('#table_IoT_DW').append($("<option/>", {
                    value: dataIoT[i].iot_name_DW,
                    text: dataIoT[i].name
                }));
                $('#table_IoT_DW_Getall').append($("<option/>", {
                    value: dataIoT[i].iot_name_DW,
                    text: dataIoT[i].name
                }));
            }
            
        }
        
        $('#try_iot_it').on("click", function () {
            let table_DW = $("#table_IoT_DW").val();
            //let summary_table = $('#summary_table').val();
            insertintoIoTDW(table_DW)
        });
        $('#try_iot_it_Getall').on("click", function () {
            let table_DW = $("#table_IoT_DW_Getall").val();
            //let summary_table = $('#summary_table').val();
            insertintoIoTDW_Getall(table_DW)
        });
    }
}
$(document).ready(function () {

    $('#card_1').hide();
    $('#card_1_h').on('click',function(){
        $('#card_1').show();
    })
    let data;
    let dataIoT;
        $.ajax({
            url: "http://localhost:8000/api/iot/IoTdata",
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
            url: "http://localhost:8000/api/company/webservicedata",
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
        let webservice = new webService(data);
        let iotservice = new iotService(dataIoT);
        webservice.initService();
        iotservice.initService();
        
});