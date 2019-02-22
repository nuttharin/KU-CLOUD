toastr.options = {
    "closeButton": false,
    "debug": false,
    "newestOnTop": false,
    "progressBar": true,
    "positionClass": "toast-top-right",
    "preventDuplicates": false,
    "onclick": null,
    "showDuration": "300",
    "hideDuration": "1000",
    "timeOut": "3000",
    "extendedTimeOut": "1000",
    "showEasing": "swing",
    "hideEasing": "linear",
    "showMethod": "fadeIn",
    "hideMethod": "fadeOut"
};

class Service {
    constructor(strUrl, alias, ServiceName, description,status,time) {
        let dataFromUrl;
        let dataHeader;
        var dataHeaderList;
        let idDB;
        let headerLow;
        let companyID;
        let listSelect2;
        let strValCal ;
        let strValGroup;
        let listChkArr ;
        let strArr ;




        this.initService = () => {
            console.log("init service")
            let treeView = new TreeView();
            treeView.clearValue();
            dataFromUrl = treeView.getDataFormUrl(strUrl);
            dataHeader = treeView.getHeaderFormData(dataFromUrl);
            dataHeaderList = treeView.getDataHeaderAll();
            dataHeader = JSON.stringify(dataHeader);
            listChkArr = checkArray(strUrl);

            this.createTreeView();

            //console.log(dataHeader);
            // console.log(dataHeaderList);
          
        }

        this.createTreeView = () => {

            //console.log("Sssssss");
            //console.log(dataHeader);
            $('loading').show();
            let str = "<a href='select'></a><div id='select'><form id='search'><input class='mb-2 mr-2' type='search' id='id_search' placeholder='Search'/><button class='btn btn-primary' type='submit'>Search</button></form><div id='check'></div><div id='submitcheck'></div></div>"
            document.getElementById('checkshow').innerHTML = str;
            document.getElementById('detail-show1').innerHTML = "<h6 style='font-style: oblique;'> Where is tree from?</h6><div id='detail-show'><p>Tree comes from URL that you input in the form to get API.</p></div>"
            document.getElementById('detail-show2').innerHTML = "<h6 style='font-style: oblique;'> How to use? </h6><div id='detail-show'><p>Click check on the left side to select the column that you are interested in and you can search keyword that you want to find.When done,click Submit.</p></div></div>"

            $('#check').jstree({
                'core': {
                    'data': JSON.parse(dataHeader),
                    'themes': {
                        'name': 'proton',
                        "icons": false,
                        // 'responsive': true
                    },
                },
                "plugins": ["checkbox", "wholerow", "search"]
            });

            $('#check').on('ready.jstree', function () {
                $('loading').hide();
                $("#check").jstree("open_all");
                $("#check").jstree("check_all");
            });

            document.getElementById('submitcheck').innerHTML = "<button id='submitcheckform' class='btn btn-primary' data-toggle='modal' >Submit</button>"+
                                                                "<div class='modal fade' id='myModal' role='dialog'>"+
                                                                    "<div class='modal-dialog'>"+
                                                                        "<div class='modal-content'>"+
                                                                            "<div id='modal-header-val' class='modal-header'>"+
                                                                                    "<h4 class='modal-title'>Choose the value to calculate</h4>"+
                                                                                    "<button type='button' class='close' data-dismiss='modal'>&times;</button>"+
                                                                            "</div>"+
                                                                            "<div id='modal-body' class='modal-body'>"+
                                                                                "<p id='xxx'>The selected value will be calculated in the summary table.</p>"+
                                                                            "</div>"+
                                                                            "<div class='modal-footer'>"+
                                                                                "<button type='button' id='submitChkValCal' class='btn btn-info swal-button--confirm' data-toggle='modal'>Submit</button>"+
                                                                                "<button type='button' class='btn btn-default' data-dismiss='modal'>Close</button>"+
                                                                            "</div>"+
                                                                        "</div>"+
                                                                    "</div>"+
                                                                "</div>"+
                                                                "<div class='modal fade' id='myModal2' role='dialog'>"+
                                                                    "<div class='modal-dialog'>"+
                                                                        "<div class='modal-content'>"+
                                                                            "<div id='modal-header-val' class='modal-header'>"+
                                                                                "<h4 class='modal-title'>Choose the value to group by</h4>"+
                                                                                "<button type='button' class='close' data-dismiss='modal'>&times;</button>"+
                                                                            "</div>"+
                                                                            "<div id='modal-body2' class='modal-body'>"+
                                                                                "<p id='xxx'>The selected value will by group by in the summary table.</p>"+
                                                                            "</div>"+
                                                                            "<div class='modal-footer'>"+
                                                                                "<button type='button' id='submitChkValCal2' class='btn btn-info swal-button--confirm'>Submit</button>"+
                                                                                "<button type='button' class='btn btn-default' data-dismiss='modal'>Close</button>"+
                                                                            "</div>"+
                                                                        "</div>"+
                                                                    "</div>"+
                                                                "</div>"+
                                                                "<div class='modal fade' id='myModal3' role='dialog'>"+ // modal select array
                                                                    "<div class='modal-dialog'>"+
                                                                        "<div class='modal-content'>"+
                                                                            "<div id='modal-header-val' class='modal-header'>"+
                                                                                "<h4 class='modal-title'>Choose the value to group by</h4>"+
                                                                                "<button type='button' class='close' data-dismiss='modal'>&times;</button>"+
                                                                            "</div>"+
                                                                            "<div id='modal-body3' class='modal-body'>"+
                                                                                "<p id='xxx'>The selected array.</p>"+
                                                                            "</div>"+
                                                                            "<div class='modal-footer'>"+
                                                                                "<button type='button' id='selectArr' class='btn btn-info swal-button--confirm'>Submit</button>"+
                                                                                "<button type='button' class='btn btn-default' data-dismiss='modal'>Close</button>"+
                                                                            "</div>"+
                                                                        "</div>"+
                                                                    "</div>"+
                                                                "</div>";
            
          
            
            if(listChkArr.length > 0)
            {
                for(let i =0 ;i<listChkArr.length;i++)
                {
                    $("#modal-body3").append("<label class='customcheck'>"+listChkArr[i]+"<input type='checkbox' class='chkall'  value='"+listChkArr[i]+"' id='listChkArr"+i+"'><span class='checkmark'></span></label>");

                }
            }

            $('#submitcheckform').on("click", function () {

                if(listChkArr.length > 0)
                {                   
                    $('#myModal3').modal('show');
                    $('#selectArr').on("click" , function(){
                        strArr = "" ;
                        //เก็บค่า array
                        for(let i=0 ; i<listChkArr.length ; i++)
                        {
                            if($('#listChkArr'+i).is(':checked') == true )
                            {
                                strArr = strArr + $('#listChkArr'+i).val()  +','  ;
                            }
                        }
                        //let lengthStrValCal = strValCal.length ;
                        strArr = strArr.substring(0,strArr.length -1 );
                        console.log(strArr)

                        $('#myModal3').modal('hide');
                        $('#myModal').modal('show');
                        var selectedElmsIds = $('#check').jstree("get_selected", true);
                        //console.log(selectedElmsIds);
                        listSelect2 = deepCopy(selectedElmsIds);
                        createListQuery(selectedElmsIds);
                        let headerList = headerLow.split(',');
                        //console.log(listSelect2)
                        $("#modal-body").html("<button class='btn btn-success'  id='checkall'>Check All</button>&nbsp<button class='btn btn-danger' id='clearall'>Clear All</button><br/><br/>");
                        for(var j=0;j<headerList.length;j++)
                        {
                            //console.log(headerList[j]);
                            if(headerList[j] == "undefined" || headerList[j]=="")
                            {
                                continue;
                            }
                            else
                            {
                               
                                $("#modal-body").append("<label class='customcheck'>"+headerList[j]+"<input type='checkbox' class='chkall'  value='"+headerList[j]+"' id='valueCalChk"+j+"'><span class='checkmark'></span></label>");
                                $("#modal-body2").append("<label class='customcheck'>"+headerList[j]+"<input type='radio' name='valuegroupbyChk' value='"+headerList[j]+"' id='valuegroupbyChk"+j+"'><span class='checkmark'></span></label>");

                            }
                            
                        }

                    })

                }  
                else {
                    $('#myModal').modal('show');
                    var selectedElmsIds = $('#check').jstree("get_selected", true);
                    //console.log(selectedElmsIds);
                    listSelect2 = deepCopy(selectedElmsIds);
                    createListQuery(selectedElmsIds);
                    let headerList = headerLow.split(',');
                    //console.log(listSelect2)
                    $("#modal-body").html("<button class='btn btn-success'  id='checkall'>Check All</button>&nbsp<button class='btn btn-danger' id='clearall'>Clear All</button><br/><br/>");
                    for(var j=0;j<headerList.length;j++)
                    {
                        console.log(headerList[j]);
                        if(headerList[j] == "undefined" || headerList[j]=="")
                        {
                            continue;
                        }
                        else
                        {
                           
                            $("#modal-body").append("<label class='customcheck'>"+headerList[j]+"<input type='checkbox' class='chkall'  value='"+headerList[j]+"' id='valueCalChk"+j+"'><span class='checkmark'></span></label>");
                            $("#modal-body2").append("<label class='customcheck'>"+headerList[j]+"<input type='radio' name='valuegroupbyChk' value='"+headerList[j]+"' id='valuegroupbyChk"+j+"'><span class='checkmark'></span></label>");

                        }                        
                    }
                }
                
                $('#checkall').on('click', function (e) {
                    e.preventDefault();
                    $('.chkall').prop('checked', true);
                });
                $('#clearall').on('click', function (e) {
                    e.preventDefault();
                    $('.chkall').prop('checked', false);
                });       
            });
       

            $('#submitChkValCal').on("click", function () {
                $('#myModal').modal('hide');
                $('#myModal2').modal('show');
                var selectedElmsIds = $('#check').jstree("get_selected", true);
                //console.log(selectedElmsIds);
                listSelect2 = deepCopy(selectedElmsIds);
                createListQuery(selectedElmsIds);
                let headerList = headerLow.split(',');
                //console.log(listSelect2)
                            
                $('#submitChkValCal2').click(function(){
                    strValCal = "" ;
                    for(let i=0 ;i<headerList.length; i++)
                    {
                        if($('#valueCalChk'+i).is(':checked') == true )
                        {
                            strValCal = strValCal + $('#valueCalChk'+i).val()  +','  ;
                        }
                    }
                    //let lengthStrValCal = strValCal.length ;
                    strValCal = strValCal.substring(0,strValCal.length -1 );
                   // console.log(strValCal)

                    strValGroup = "" ;
                    for(let i=0 ;i<headerList.length; i++)
                    {
                        if($('#valuegroupbyChk'+i).is(':checked') == true )
                        {
                            strValGroup = strValGroup + $('#valuegroupbyChk'+i).val()  +','  ;
                        }
                    }
                    //let lengthStrValCal = strValCal.length ;
                    strValGroup = strValGroup.substring(0,strValGroup.length -1 );
                    //console.log(strValGroup)
                    increaseDataTableDB();
                    
                })

            });

            
            $("#search").submit(function (e) {
                e.preventDefault();
                $("#check").jstree(true).search($("#id_search").val());
            });
            
        }

        let deepCopy = (data) => {
            let obj = data.map((item) => {
                return Object.assign({}, item);
            });
            return obj;
        };

            

        let createListQuery = (listSelect) => {
            let list = listSelect;
            let list2 = listSelect;
            let lengthMaxList = 0;
            //console.log(list)
            // find max length parents
            //console.log(list2)
            for (let i = 0; i < list.length; i++) {

                if (list[i].parents.length >= lengthMaxList) {
                    lengthMaxList = list[i].parents.length;

                }
            }

            for (let i = 1; i <= lengthMaxList; i++) {
                //=1 #
                //=2 45,#
                for (let j = 0; j < list.length; j++) {
                    //console.log("num I - "+i+" --- "+list[j].text+" len"+list[j].parents.length)
                    if (list[j].parents.length === i) {

                        //console.log(" 1 st "+list[j].text)

                        let lengthChild = list[j].children_d.length;
                        for (let k = lengthChild - 1; k >= 0; k--) {
                            //console.log(list)
                            let idDelect = list[j].children_d[k].toString();
                            for (let q = 0; q < list.length; q++) {
                                //console.log(idDelect+"------------"+list[q].id+"***"+list[q].text)


                                if (idDelect == list[q].id.toString()) {
                                    //console.log("+"+list[q].text)
                                    //list.splice(q, 1);
                                    list[j].text = null
                                    break;
                                }
                            }

                        }

                    }
                }
            }

            //console.log(list)
            createQueryHeader(list);




        }
        
        let createQueryHeader = (list) => {
            // header,Stations
            //header.Url,Stations.Latitude.Value
            let arrData = []; // list new
            let str = "";
            let tempNameParents;
            // take-out value list[i] == text 
            //console.log(list)
            for (let i = 0; i < list.length; i++) {
                if (list[i].text != null) {
                    arrData.push(list[i]);
                }
            }
            //console.log(arrData)
            
            // Create data to be stored in database DB
            for (let i = 0; i < arrData.length; i++) {
                //console.log(str)

                if (str != "") {
                    str = str + ",";
                }
                if (arrData[i].parents.length == 1) {
                    //str = str + arrData[i].text;
                    //console.log(str)
                    // console.log("if -- "+arrData[i].text);
                    for(let k =0 ;k<arrData[i].children_d.length; k++)
                    {
                        //console.log(arrData[i].children_d[k])
                        if (str != "") {
                            str = str + ",";
                        }
                        for(let l =0 ;l<listSelect2.length;l++)
                        {
                            if(arrData[i].children_d[k] == listSelect2[l].id)
                            {
                                //console.log( listSelect2[l])
                                for (let m = listSelect2[l].parents.length - 2; m >= 0; m--) {
                                    //console.log(arrData[i].parents[j])
                                    for (let n = 0; n < dataHeaderList.length; n++) {
                                        if (listSelect2[l].parents[m] == dataHeaderList[n].id) {
                                            str = str + dataHeaderList[n].text;
                                            str = str + ".";
                                            break;
                                        }
                                    }
                                }
                                //console.log("if -- length "+arrData[i].parents.length+" ++ ."+arrData[i].text);
                                str = str + listSelect2[l].text;


                            }
                        }
                        
                    }
                    
                }
                else if (arrData[i].parents.length > 1) {
                    //console.log("else if")
                    for (let j = arrData[i].parents.length - 2; j >= 0; j--) {
                        //console.log(arrData[i].parents[j])
                        for (let k = 0; k < dataHeaderList.length; k++) {
                            if (arrData[i].parents[j] == dataHeaderList[k].id) {
                                str = str + dataHeaderList[k].text;
                                str = str + ".";
                                break;
                            }
                        }
                    }
                    //console.log("if -- length "+arrData[i].parents.length+" ++ ."+arrData[i].text);
                    str = str + arrData[i].text;

                }



            }

            //console.log(str)
            //console.log(url)

            headerLow = str;
            str = "";
            //console.log(headerLow);
            //console.log(getCookie('token'));

            
            
            // increaseDataTableDW();

        }
        //console.log(status)
        let increaseDataTableDB = () => {
            
            $.ajax({
                url: "http://localhost:8000/api/company/webservice/addRegisWebService",
                dataType: 'json',
                method: "POST",
                async: false,
                data:
                {
                    strUrl: strUrl,
                    alias: alias,
                    ServiceName: ServiceName,
                    description: description,
                    header: headerLow,
                    valueCal: strValCal,
                    valueGroup:strValGroup,
                    status: status,
                    time: time
                },
                success: (res) => {
                    // toastr["success"]("Success");
                    idDB = res.webService.webservice_id;
                    console.log("success DB")
                    increaseDataTableDW();
                },
                error: (res) => {
                    swal("Good job!", "You clicked the button!", "error");
                    console.log(res);
                }
            });

        }

        let increaseDataTableDW = ()=>
        {    
            // get companyID
            $.ajax({
                    url: "http://localhost:8000/api/company/webservice/getCompanyID",
                    dataType: 'json',
                    method: "GET",
                    async: false,
                    success: (res) => {
                        //console.log(res.companyID);
                        companyID = res.companyID ;

                    },
                    error: (res) => {
                        
                        console.log(res);
                    }
            });
            //ลงทะเทียนฝั่ง dw
            console.log(ServiceName)
            $.ajax({
                url: "http://localhost:8081/webService/createRegisterTable",
                dataType: 'json',
                method: "POST",
                headers: {"Authorization": getCookie('token')},
                data:
                {
                    idDB:idDB,
                    strUrl: strUrl,
                    alias: alias,
                    ServiceName: ServiceName,
                    ServiceNameDW: ServiceName+"."+companyID,
                    description: description,
                    header: headerLow,
                    valueCal: strValCal,
                },
                success: (res) => {
                    swal("Good job!", "You clicked the button!", "success");
                    console.log("success DW")
                        
                },
                error: (res) => {
                    swal("Good job!", "You clicked the button!", "error");
                    console.log(res);
                }
                });
                // เพิ่มค่าในตารางข้อมูลครั้งเเรก
            $.ajax({
                url: "http://localhost:8081/webService/insertFirstDataTable",
                dataType: 'json',
                method: "POST",
                headers: {"Authorization": getCookie('token')},
                data:
                {
                    
                    strUrl: strUrl,
                    ServiceNameDW :ServiceName+"."+companyID,
                    header : headerLow,
                    strValCal : strValCal,
                    time:time
                },
                success: (res) => {
                    console.log("success insert Table")
                    console.log(res);
                        
                },
                error: (res) => {
                    console.log(res);
                }
            });

        }

        let checkArray = (strurl) => {
            let list = []
            let treeChk = new TreeView()
            let data = treeChk.getDataFormUrl();
            //console.log(data)
            Object.keys(data).forEach(function (key) {
                if (Array.isArray(data[key])) {
                    list.push(key)
                    // console.log(key)
                    // console.log('array')
                    //temp = data[key][0];
                }
                // else {
                //     //temp = dataChkArr[key];
                //     console.log(key)
                //     console.log('no array')
                // }

            })
            //console.log(list)
            return list 


        }

           

    }
}

class TreeView {
    constructor() {

        //this.strUrl = this.url;

        let arrData = [];
        let dataChild = [];

        let dataHeaderAll = [];
        let num = 0;
        let num2 = 0;
        //let num2 =1 ;
        //this.dataFromUrl;

        this.clearValue = () => {
            arrData = [];
            dataChild = [];
        }

        this.getDataHeaderAll = () => {
            return dataHeaderAll;
        }

        this.checkArray = (data) => {
                
        }

        this.getDataFormUrl = (strurl) => {
            let dataTemp;
            $.ajax({
                url: "https://data.tmd.go.th/api/Weather3Hours/V1/?type=json",
                method: "GET",
                dataType: "json",
                async: false,
                success: function (data) {
                    //console.log("Get Json Com")                    
                    dataTemp = data;

                },
                error: function (data) {
                    console.log("Error Get Json");
                }
            })
            return dataTemp;

        }

        this.getHeaderFormData = (data) => {
            let dataTemp;
            arrData = [];
            if (typeof (data) !== 'object') {

            }
            else {
                let temp;
                Object.keys(data).forEach(function (key) {
                    if (Array.isArray(data[key])) {
                        temp = data[key][0];
                    }
                    else {
                        temp = data[key];
                    }

                    //num = num2;

                    getHeader(temp, key);
                    num2++;
                    arrData.push({ 'id': num2, 'text': key, 'children': dataChild });
                    dataHeaderAll.push({ 'id': num2, 'text': key });
                    dataChild = [];
                });
            }
            dataTemp = arrData;
            arrData = [];
            return dataTemp;
            //return dataHeaderAll;
        }

        let getHeader = (dataIn) => {

            let arrDataIn = [];
            if (typeof (dataIn) !== 'object') {

            }
            else {
                Object.keys(dataIn).forEach(function (key) {

                    if (Array.isArray(dataIn[key]) == true) {
                        console.log("--" + key)
                        console.log(dataIn[key][0]);
                        dataIn[key] = dataIn[key][0];
                    }
                    if (typeof (dataIn[key]) === 'object') {


                        getHeader(dataIn[key]);
                        num2++;
                        arrDataIn.push({ 'id': num2, 'text': key, 'children': dataChild });
                        dataHeaderAll.push({ 'id': num2, 'text': key });
                    }
                    else {

                    
                        num2++;
                        arrDataIn.push({ 'id': num2, 'text': key, 'children': null });
                        dataHeaderAll.push({ 'id': num2, 'text': key });
                        //}

                    }
                });
                dataChild = arrDataIn;
                arrDataIn = [];
                return dataChild;
                //return arrDataIn;

            }

        }



    }
}

$(document).ready(function () {

    $("#every_minute").click(function () {
        $("#minute_input").val("*");
        $("#hour_input").val("*");
        $("#description_time").html("At every minute.");
    })
    $("#every_30_minute").click(function () {
        $("#minute_input").val("*/30");
        $("#hour_input").val("*");
        $("#description_time").html("At every 30th minute.");

    })
    $("#every_3_hour").click(function () {
        $("#minute_input").val("0");
        $("#hour_input").val("*/3");
        $("#description_time").html("At minute 0 past every 3rd hour.");
    })
    $("#every_day").click(function () {
        $("#minute_input").val("0");
        $("#hour_input").val("0");
        $("#description_time").html("At 00:00.");
    })
    $("#every_day_at_1am").click(function () {
        $("#minute_input").val("0");
        $("#hour_input").val("1");
        $("#description_time").html("At 01:00.");
    })
    $("#between_certain_hours").click(function () {
        $("#minute_input").val("0");
        $("#hour_input").val("9-17");
        $("#description_time").html("At minute 0 past every hour from 9 through 17.");
    })

    $(".show-header").click(function () {

        let url = $("#url-webservice").val();
        let alias = $('#alias-webservice').val();
        let ServiceName = $('#name-webservice').val();
        let description = $("#description-webservice").val();
        let status = $('#status-webservice').prop( "checked" );
        let minute = $('#time-webservice-minute').val();
        let hour = $('#time-webservice-hour').val();
        let time = minute+" "+hour+" * * *";
        
        //console.log(time)
        let minuteall = minute.split("*/");
        let hourall = hour.split("*/");
        let minute_to = minute.split("-");
        let hour_to = hour.split("-");
        //console.log(minuteall.length);
        // console.log(hourall.length);
        // console.log(minute_to.length);
        // console.log(hour_to.length);
        let type_time;
        let convert_time;
        if(minuteall.length == 2)
        {
            //console.log("minuteall")
            type_time = "minuteall"
            convert_time= minuteall[1] * 60;
        }
        else if(hourall.length == 2)
        {
            //console.log("hourall")
            type_time="hourall"
            convert_time= hourall[1] * 360;

        }
        else if(minute_to.length == 2)
        {
            //console.log("minuteto")
            type_time="minuteto"
        }
        else if(hour_to.length == 2)
        {
            //console.log("hourall")
            type_time="hourto"
            convert_time = hour
        }
        else
        {
            type_time="time"
            if(hour<10)
            {
                if(minute<10)
                {
                    convert_time = "0"+hour+".0"+minute
                }
                else
                {
                    convert_time = "0"+hour+"."+minute
                }
            }
            else
            {
                if(minute =='*' && hour=='*')
                {
                    convert_time = 60
                }
                else if(minute<10)
                {
                    convert_time = hour+".0"+minute
                }
                else
                {
                    convert_time = hour+"."+minute
                }
            }
            
            
        }
        // console.log(type_time)
        // console.log(convert_time)
        if(status == true)
        {
            status="public";
        }
        else
        {
            status="private";
        }

        let service = new Service(url, alias, ServiceName, description,status,time);
        service.initService();
      
        
    })

});