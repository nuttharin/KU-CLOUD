var IotserviceRepository = new (function(){
    let iotserviceList = [];
    let datatableObject = null;
    let modalDetail = null;
    let modalDelete = null;
    let modalOutput = null;
    let modalRegis = null;
    let idDB=null;
    //let idIoT;


    this.initialAndRun = () => {
        this.refreshDatatable();
    };

    this.refreshDatatable = () => {
        showLoadingStatus(true);
        $.ajax({
            url: END_POINT+"iot/iotservicedata",
            method: 'GET',
            success: function (result) {
                //console.log(result.iotService.length);
                console.log(result.iotService);
                initialDatatable();
                iotserviceList = result.iotService;
                showLoadingStatus(false);
                updateDatatableData(result);

                
            },
            error: function (error) {
                console.log(error);
            }
        });

    };

    let initialDatatable = () => {
        if(datatableObject !== null)
        {
            return false ;
        }
        datatableObject = $('#datatable-iotservice').dataTable();
    }

    let showLoadingStatus = (show) => {
        if(show)
        {
            $('#datatable-iotservice').hide();
            $('#total-iotservice').hide();
        }
        else{
            $('#datatable-iotservice').show();
            $('#total-iotservice').show();
            $('.lds-roller').hide();
        }
    }

    let updateDatatableData = (iotserviceList) => {
        let Datatable = new Array();
        datatableObject.fnClearTable();
        let total_iotservice = 0;
        let str="";
        $.each(iotserviceList.iotService, function (index, item) {
            var ret = [];
            idDB=item.id;
            ret[0] = item.name;
            ret[1] = item.alias;
            ret[2] = item.type;
            ret[3] = item.status;
            if(item.type=="output")
            {
                    console.log(index)
                    ret[4] = ` <center>
                            <button type="button" class="btn btn-primary btn-sm btn-detail" index=${index} data-toggle="tooltip"
                                data-placement="top" title="Detail">
                                <i class="fas fa-list"></i>
                            </button>                           
                            <button type="button" class="btn btn-warning btn-sm btn-setting"  index=${index}  data-toggle="tooltip"
                                data-placement="top" title="output">
                                <i class="fas fa-share-square"></i>
                            </button>
                            <button type="button" class="btn btn-secondary btn-sm btn-regis"  index=${index}  data-toggle="tooltip"
                                data-placement="top" title="Clone IoT Service" disabled>
                                <i class="far fa-clone"></i>
                            </button>
                            <button type="button" class="btn btn-danger btn-sm btn-delete"  index=${index}  data-toggle="tooltip"
                                data-placement="top" title="Delete">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </center>`;
            }
            else
            {
                    ret[4] = ` <center>
                            <button type="button" class="btn btn-primary btn-sm btn-detail" index=${index} data-toggle="tooltip"
                                data-placement="top" title="Detail">
                                <i class="fas fa-list"></i>
                            </button>
                            <button type="button" class="btn btn-warning btn-sm btn-setting"  index=${index}  data-toggle="tooltip" disabled
                                data-placement="top" title="setting">
                                <i class="fas fa-cog"></i>
                            </button>                
                            <button type="button" class="btn btn-secondary btn-sm btn-regis"  index=${index}  data-toggle="tooltip"
                                data-placement="top" title="Clone IoT Service">
                                <i class="far fa-clone"></i>
                            </button>
                            <button type="button" class="btn btn-danger btn-sm btn-delete"  index=${index}  data-toggle="tooltip"
                                data-placement="top" title="Delete">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </center>`;
            }
            Datatable.push(ret);
            total_iotservice++;
        });
        datatableObject.fnAddData(Datatable);
        console.log(total_iotservice)
        $('#total-iotservice').html(`Total ${total_iotservice} IoTservices`)
        $('#datatable-iotservice').on('click', '.btn-detail', function () {
            console.log('ssss')
            onDetailClick($(this).attr('index'));
        });
        $('#datatable-iotservice').on('click', '.btn-setting', function () {
            console.log('btn-setting')
            onSettingClick($(this).attr('index'));
        });
        $('#datatable-iotservice').on('click', '.btn-delete', function () {
            console.log('btn-delete')
            onDeleteClick($(this).attr('index'));
        });
        $('#datatable-iotservice').on('click', '.btn-regis', function () {
            console.log('btn-regis')
            onRegisClick($(this).attr('index'));
        });
        

    }

    let onDetailClick = (key) =>{
        if (modalDetail === null) {
            modalDetail =
                `<div class="modal fade" id="detailIot">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="title-company">IoT Details</h5>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        <div class="modal-body">
                            <h6>Status : <span id="status-iot"><span></h6>
                            <h6>Service Name : <span id="name-iot"><span></h6>
                            <h6>Alias : <span id="alias-iot"><span></h6>
                            <h6>Description : <span id="note-iot"><span></h6>
                            <h6>Url : <span id="url-iot"><span></h6>
                            <h6>Create Date : <span id="create-iot"><span></h6>
                            <h6>Update Date : <span id="update-iot"><span></h6>
                        </div>
                    </div>
                </div>
            </div>`;

            $('body').append(modalDetail);
        }
        let createdate = new Date(iotserviceList[key].created_at);
        let updatedate = new Date(iotserviceList[key].updated_at);
        $('#name-iot').html(iotserviceList[key].name);
        $('#alias-iot').html(iotserviceList[key].alias);
        $('#status-iot').html(iotserviceList[key].status);
        $('#note-iot').html(iotserviceList[key].description);
        $('#url-iot').html("<input type='text' id='Apiiot' class='form-control' style='min-width: 100%' value='"+iotserviceList[key].url+"' readonly><button class='' id='CopyUrl' data-clipboard-target='#Apiiot'><i class='far fa-copy'></i></button>");
        $('#create-iot').html(createdate.getDate()+"/"+createdate.getMonth()+"/"+createdate.getFullYear()+" "+createdate.toTimeString().split(' ')[0]);
        $('#update-iot').html(updatedate.getDate()+"/"+updatedate.getMonth()+"/"+updatedate.getFullYear()+" "+updatedate.toTimeString().split(' ')[0]);
        $("#detailIot").modal('show');
        let copyUrl = new ClipboardJS('#CopyUrl');
            copyUrl.on('success', function(e) {
            console.log(e);
        });
            copyUrl.on('error', function(e) {
            console.log(e);
        });
    }
    let onDeleteClick = (key) => {
        if (modalDelete === null) {
            modalDelete = `
                        <div class="modal fade" id="DeleteUser">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title">Delete IoT Service</h4>
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    </div>

                                    <div class="modal-body">
                                        <form id="form-delete-user">
                                            <h6 id="span-text-confirm"></h6>
                                        </form>
                                    </div>

                                    <div class="modal-footer">
                                        <button type="button" id="btn-delete-submit" class="btn btn-danger btn-block">Delete</button>
                                    </div>
                                </div>
                            </div>
                        </div>`;
            $('body').append(modalDelete);
        }

        $('#span-text-confirm').html("Are you sure to delete " + iotserviceList[key].name + " ? ");
        $('#DeleteUser').modal('show');

        $('#btn-delete-submit').click(function () {
            // alert('fffff')
            $('#DeleteUser').modal('hide');

            let chk = true ;

            $.ajax({
                url: END_POINT+"iot/deleteIoT",
                dataType: 'json',
                method: "POST",
                async: false,
                data:
                {
                    id:iotserviceList[key].id,
                },
                success: (res) => {
                    //swal("Delete Success!", "You clicked the button!", "success");
                    // toastr["success"]("Delete Success");
                    console.log("delete db success")
                },
                error: (res) => {
                    chk = false ;
                    console.log(res);
                }
            });

            $.ajax({
                url: API_DW+"iotService/DeleteInputIotService",
                dataType: 'json',
                method: "POST",
                async: false,
                data:
                {
                    nameDW:iotserviceList[key].iot_name_DW,
                    typeService:iotserviceList[key].type
                },
                success: (res) => {
                    
                    swal("Delete Success!", "You clicked the button!", "success");
                    
                   console.log("delete dw success")
                    
                    
                },
                error: (res) => {
                    console.log(res);
                }
            })
            $(".swal-button--confirm").click(function (){
                location.reload();
            })
            
        });
        
    };
    let onSettingClick = async (key) =>{
        console.log(key)
        let keyvalue=key;
        let data = await JSON.parse(iotserviceList[key].strJson) ;
        let dataOther ="";
        let dataPin ="";        
        console.log(data)
        Object.keys(data).forEach(function (key) {
            // if(data.other != undefined){
            //     console.log(data.other)
            // }
            if(key == "other"){
                console.log(data[key])
                let datatemp = data[key] ;
                Object.keys(datatemp).forEach(function (key){
                    dataOther = dataOther +`<input type='text' class="othername mb-2" name="othername[]" value=${key} class='mb-2 ' 
                    ' disabled>&nbsp;
                    <input type='text' class="othervalue mb-2" name="othervalue[]" id="other"
                         value=${datatemp[key]} >
                    </input>` ;
                    
                })
            }
            else if(key == "pin"){
                console.log(data[key])
                let i=0;
                let valkey = data[key];
                Object.keys(valkey).forEach(function (key){
                    let check=""
                    if(valkey[key]==1)
                    {
                        check = "checked";
                    }
                    dataPin = dataPin+`<input type=text value=${key} name="pinname[]" class='pinname mb-2 ' disabled> </input> &nbsp;
                    OFF
                    <label class="switch">
                        <input type="checkbox" id="pinvalue${i}" ${check}>
                        <span class="slider round"></span>
                    </label>
                    ON
                    <br>
                    `;
                    i++;
                })
            }
            
            
        })
        if (modalOutput === null) {
            modalOutput =
                `<div class="modal fade" id="settingIot">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="title-company">Send Output Data</h5>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        <div class="modal-body">
                            <h6>Status : <span id="status-iot"><span></h6>
                            <h6>Service Name : <span id="name-iot"><span></h6>
                            <h6>Alias : <span id="alias-iot"><span></h6>
                            <h6>Description : <span id="note-iot"><span></h6>
                            <h6>Create Date : <span id="create-iot"><span></h6>
                            <h6>Update Date : <span id="update-iot"><span></h6>
                            <br>
                            <h6>Other Inputs</h6> 
                            <div id="dataOther"></div>   
                            <h6>Pins Setting</h6>
                            <div id="dataPin"></div>
                            <button type="button" class="btn btn-success  btn-send" style="float:right;" index=${keyvalue} id="send_outputIoT">
                                send  
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            `;

            $('body').append(modalOutput);
        }

        $('#name-iot').html(iotserviceList[key].name);
        $('#alias-iot').html(iotserviceList[key].alias);
        $('#status-iot').html(iotserviceList[key].status);
        $('#note-iot').html(iotserviceList[key].description);
        $('#create-iot').html(iotserviceList[key].created_at);
        $('#update-iot').html(iotserviceList[key].updated_at);
        $('#dataOther').html(dataOther);
        $('#dataPin').html(dataPin);

        $("#settingIot").modal('show');
        $('#send_outputIoT').click(function(){
            //let key = $(this).attr('index')
            //console.log(key)
            //console.log(iotserviceList[key])
            let othername = document.getElementsByClassName("othername");
            let other_name  = [].map.call(othername, function( input ) {
                return input.value;
            });
            let othervalue = document.getElementsByClassName("othervalue");
            let other_value  = [].map.call(othervalue, function( input ) {
                return input.value;
            });
            let pinname = document.getElementsByClassName("pinname");
            let pin_name  = [].map.call(pinname, function( input ) {
                return input.value;
            });
            
            let stroutput={};
            let dataOutput ={} ;
            let dupstr={};
            for(let i=0;i<other_name.length;i++)
            {
                stroutput[other_name[i]] = other_value[i];
                dupstr[other_name[i]] = other_value[i];
            }
            dataOutput['other'] = dupstr ;
            dupstr={};
            for(let i=0;i<pin_name.length;i++)
            {
                let num_val = $('#pinvalue'+i).prop('checked')
                if(num_val==true)
                {
                    stroutput[pin_name[i]] = 1;
                    dupstr[pin_name[i]] = 1;
                }
                else
                {
                    stroutput[pin_name[i]] = 0;
                    dupstr[pin_name[i]] = 0;
                }
            }
            dataOutput['pin'] = dupstr ;
            let data_Output = JSON.stringify(dataOutput, undefined, 2);
            let str_output = JSON.stringify(stroutput, undefined, 2);
            let str_output1 = JSON.stringify(stroutput);
            console.log(stroutput)
            $.ajax({
                url: END_POINT+"iot/iotupdatedata",
                dataType: 'json',
                method: "POST",
                async: false,
                data:
                {
                    id_DB: idDB,
                    strJson:str_output,
                    pinfilds:data_Output,
                    
                },
                success: (res) => {
                    // toastr["success"]("Success");
                    console.log("success DB")
                },
                error: (res) => {
                    console.log(res);
                }
            });
            $.ajax({
                url: API_DW + "iotService/insertOutputIot",
                dataType: 'json',
                method: "POST",
                async: false,
                data:
                {
                    id_DB:idDB,
                    nameDW: iotserviceList[key].iot_name_DW,
                    strJson:str_output1,
                },
                success: (res) => {
                    // toastr["success"]("Success");
                    swal("Success!", "You clicked the button!", "success");
                    console.log("success DW")
                },
                error: (res) => {
                    console.log(res);
                }
            });
            $(".swal-button--confirm").click(function (){
                location.reload();
            })
        });
    }
    let onRegisClick = (key) =>{
        modalRegis = null
        if (modalRegis === null) {
            modalRegis = `
                        <div class="modal fade" id="regisModal">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title">Register IoT Service</h4>
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    </div>
                                    <div class="modal-body">

                                        <h5 >Clone IoT Service from :  <span id="name-iot-old"><span></h5>
                                        <h5 class=" mb-2">Data of input iot :   <span id="data-iot"><span></h5>
                                        <h5>Name Iot (New )  :
                                            <input type='text' class=" mb-2"  id="name-iot-new" >
                                            </input>
                                        </h5>
                                    </div>

                                    <div class="modal-footer">
                                        <button type="button" id="btn-regis-submit" class="btn btn-success btn-block">Register</button>
                                    </div>
                                </div>
                            </div>
                        </div>`;
            $('body').append(modalRegis);
        }

        $("#name-iot-old").html(iotserviceList[key].name)
        $("#data-iot").html(iotserviceList[key].dataformat)
        $("#regisModal").modal('show');
        $("#btn-regis-submit").click(function(){
            //$("#regisModal").modal('hide');
            let nameIotNew = $("#name-iot-new").val();
            let keyiot = "";
            let str = "";
            let strInsert = "";
            let idIoT ;
            if(nameIotNew =="")
            {
                swal("Good job!", "You clicked the button!", "error");
            }
            else if(nameIotNew !="")
            {
                nameIotNew = $("#name-iot-new").val();
                $.ajax({
                    url: END_POINT+"iot/checkServicename",
                    dataType: 'json',
                    method: "POST",
                    async: false,
                    data:
                    {
                        ServiceName: nameIotNew,
                    },
                    success: (res) => {
                            // toastr["success"]("Success");
                        chkName = res.iotService;
                        console.log("name" + chkName)
                            //increaseDataTableDW();
                    },
                    error: (res) => {
                        swal("Good job!", "You clicked the button!", "error");
                        console.log(res);
                    }
                });
                if(chkName!="")
                {
                    swal("Duplicate Service Name!", "Please enter a new Service Name.", "error");
                }
                else if(chkName=="")
                {
                    $.ajax({
                        url: API_DW +"iotService/getKeyiot",
                        dataType: 'json',
                        method: "POST",
                        async: false,
                        headers: {"Authorization": getCookie('token')},
                        data:
                        {                
                            companyID : nameIotNew+iotserviceList[key].idCompany                    
                        },
                        success: (res) => { 
                            keyiot = res.key
                            //console.log(res);                        
                        },
                        error: (res) => {
                            console.log(res);
                        }
                    });
                    console.log(keyiot)
                    
                    //$("#name-iot-old").empty()
                    //modalRegis = null ;
                    //register DB
                    let otheroutput="";
                    let insertFristTimeDw = "";
                    let dataSelect = iotserviceList[key].dataformat.split(',')
                    for(let i=0;i<dataSelect.length;i++)
                    {
                        
                        if(i==dataSelect.length-1)
                        {
                            otheroutput += dataSelect[i] +"=[value]";
                            insertFristTimeDw += dataSelect[i] +"=0";
                        }
                        else
                        {
                            otheroutput += dataSelect[i] +"=[value]&";
                            insertFristTimeDw += dataSelect[i] +"=0&";
                        }
                    }
                    str = API_DW +'iotService/InsertInputService?keyIot='+keyiot+'&ID='+idIoT+'&nameDW=IoT.Input.'+nameIotNew+'.'+iotserviceList[key].idCompany+'&'+otheroutput;
                    strInsert = API_DW +'iotService/InsertInputService?keyIot='+keyiot+'&ID='+idIoT+'&nameDW=IoT.Input.'+nameIotNew+'.'+iotserviceList[key].idCompany+'&'+insertFristTimeDw;
                    // regis iot 
                    $.ajax({
                        url: END_POINT+"iot/addRegisIotService",
                        dataType: 'json',
                        method: "POST",
                        async: false,
                        data:
                        {
                            //"IoT.Input.pitest1.2"
                            alias: iotserviceList[key].alias,
                            ServiceName: nameIotNew,
                            description: iotserviceList[key].description,
                            valueCal: iotserviceList[key].value_cal ,
                            valueGroupby: '1', 
                            updatetime_input: '1',
                            status: iotserviceList[key].status,
                            datajson:iotserviceList[key].dataformat,
                            type: iotserviceList[key].type,
                            urls: strInsert
                            
                        },
                        success: (res) => {
                            // toastr["success"]("Success"); 
                            idIoT = res.iotService.iotservice_id ;
                            console.log(res.iotService)
                            console.log("success DB")
                        
                            //console.log(idIoT);
                        },
                        error: (res) => {
                            console.log(res);
                        }
                    });
                    
                    console.log(str)
                    console.log(strInsert)
                    //"http://localhost:8081/iotService/InsertInputService?keyIot=eyJhbGciOiJIU&ID=1&nameDW=IoT.Input.pitest1.2&x1=0&x2=0"
                    $.ajax({
                        url: strInsert,               
                        method: "POST",
                        async: false,               
                        success: (res) => {                    
                            console.log("success DW")
                        },
                        error: (res) => {
                            console.log(strUrl)
                            console.log(res);
                        }
                    });
                    //aggregate
                    $.ajax({
                        url: API_DW +"iotService/AggregateDataInputIot",
                        dataType: 'json',
                        method: "POST",
                        async: false,  
                        headers: {"Authorization": getCookie('token')},
                        data:
                        {
                            nameDW: 'IoT.Input.'+nameIotNew+'.'+iotserviceList[key].idCompany,
                            strValueCal:iotserviceList[key].value_cal   
                        },
                        success: (res) => {
                            console.log("success agg");
                            swal("Register Success!", "You clicked the button!", "success");                  
                        },
                        error: (res) => {
                            console.log(res);
                        }
                    });
                    $(".swal-button--confirm").click(function (){
                        location.reload();
                    })
                }
            }
            //console.log(nameIotNew)
        })
    }


})

$(document).ready(function(){
    let iot =  IotserviceRepository;
    iot.initialAndRun({});
    
});