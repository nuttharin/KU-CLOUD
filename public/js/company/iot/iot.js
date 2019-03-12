var IotserviceRepository = new (function(){
    let iotserviceList = [];
    let datatableObject = null;
    let modalDetail = null;


    this.initialAndRun = () => {
        this.refreshDatatable();
    };

    this.refreshDatatable = () => {
        showLoadingStatus(true);
        $.ajax({
            url: "http://localhost:8000/api/iot/iotservicedata",
            method: 'GET',
            success: function (result) {
                console.log(result);
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
            ret[0] = item.name;
            ret[1] = item.alias;
            ret[2] = item.strJson;
            ret[3] = item.status;
            if(item.type=="output")
            {
                    console.log(index)
                    ret[4] = ` <center>
                            <button type="button" class="btn btn-primary btn-sm btn-detail" index=${index} data-toggle="tooltip"
                                data-placement="top" title="Detail">
                                <i class="fas fa-list"></i>
                            </button>                           
                            <button type="button" class="btn btn-danger btn-sm btn-delete"  index=${index}  data-toggle="tooltip"
                                data-placement="top" title="Delete">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                            <button type="button" class="btn btn-warning btn-sm btn-setting"  index=${index}  data-toggle="tooltip"
                                data-placement="top" title="setting">
                                <i class="fas fa-share-square"></i>
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

    }

    let onDetailClick = (key) =>{
        if (modalDetail === null) {
            modalDetail =
                `<div class="modal fade" id="detailIot">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="title-company">Webservice Details</h5>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        <div class="modal-body">
                            <h6>Status : <span id="status-iot"><span></h6>
                            <h6>Service Name : <span id="name-iot"><span></h6>
                            <h6>Alias : <span id="alias-iot"><span></h6>
                            <h6>Description : <span id="note-iot"><span></h6>
                            <h6>Create Date : <span id="create-iot"><span></h6>
                            <h6>Update Date : <span id="update-iot"><span></h6>
                        </div>
                    </div>
                </div>
            </div>`;

            $('body').append(modalDetail);
        }

        $('#name-iot').html(iotserviceList[key].name);
        $('#alias-iot').html(iotserviceList[key].alias);
        $('#status-iot').html(iotserviceList[key].status);
        $('#note-iot').html(iotserviceList[key].description);
        $('#create-iot').html(iotserviceList[key].created_at);
        $('#update-iot').html(iotserviceList[key].updated_at);

        $("#detailIot").modal('show');
    }
    let onSettingClick = async (key) =>{
        
        let data = await JSON.parse(iotserviceList[key].strJson) ;
        let dataOther ="";
        let dataPin ="";
        let css ='border-radius: 4px;border: none;padding: 5px 20px; cursor: pointer; padding: 6px;'
        console.log(typeof data)

        Object.keys(data).forEach(function (key) {
            // if(data.other != undefined){
            //     console.log(data.other)
            // }
            if(key == "other"){
                console.log(data[key])
                let datatemp = data[key] ;
                Object.keys(datatemp).forEach(function (key){
                    dataOther = dataOther +`<input type='text' value=${key} class='mb-2 ' 
                        style='border-radius: 4px;border: none;padding: 5px 20px; cursor: pointer; padding: 6px; border: 1px solid #AED6F1 ;' disabled>&nbsp;
                    <input type='text' 
                        style='border-radius: 4px;border: none;padding: 5px 20px; cursor: pointer; padding: 6px; border: 1px solid #AED6F1 ;' value=${datatemp[key]} >
                    </input>` ;
                    
                })
            }
            else if(key == "pin"){
                console.log(data[key])
                Object.keys(data[key]).forEach(function (key){
                    dataPin = dataPin+`<input type=text value=${key} class='mb-2 ' 
                    style='border-radius: 4px;border: none;padding: 5px 20px; cursor: pointer; padding: 6px; border: 1px solid #AED6F1 ;'
                    disabled></input><br>`;
                })
            }
            
            
        })
        if (modalDetail === null) {
            modalDetail =
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
                            ${dataOther}
                            <h6>Pins Setting</h6>
                            ${dataPin}
                            <button type="button" class="btn btn-success btn-sm btn-send"  data-toggle="tooltip"
                                data-placement="top" title="Delete">
                                send  
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            `
            ;

            $('body').append(modalDetail);
        }

        $('#name-iot').html(iotserviceList[key].name);
        $('#alias-iot').html(iotserviceList[key].alias);
        $('#status-iot').html(iotserviceList[key].status);
        $('#note-iot').html(iotserviceList[key].description);
        $('#create-iot').html(iotserviceList[key].created_at);
        $('#update-iot').html(iotserviceList[key].updated_at);

        $("#settingIot").modal('show');
    }


})

$(document).ready(function(){
    let iot =  IotserviceRepository;
    iot.initialAndRun({});
});