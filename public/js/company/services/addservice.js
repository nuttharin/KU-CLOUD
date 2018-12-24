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
    constructor(strUrl, alias, ServiceName, description) {
        let dataFromUrl;
        let dataHeader;
        var dataHeaderList;
        let idDB;
        let headerLow;
        let companyID;
        let listSelect2;




        this.initService = () => {
            console.log("init service")
            let treeView = new TreeView();
            treeView.clearValue();
            dataFromUrl = treeView.getDataFormUrl(strUrl);
            dataHeader = treeView.getHeaderFormData(dataFromUrl);
            dataHeaderList = treeView.getDataHeaderAll();
            dataHeader = JSON.stringify(dataHeader);

            this.createTreeView();

            //console.log(dataHeader);
            // console.log(dataHeaderList);
          
        }

        this.createTreeView = () => {

            //console.log("Sssssss");
            //console.log(dataHeader);
            $('loading').show();
            let str = "<a href='select'></a><div id='select'><form id='search'><input class='mb-2 mr-2' type='search' id='id_search' placeholder='Search'/><button class='btn btn-primary' type='submit'>Search</button></form><div id='check'></div><div id='submitcheck'></div>"
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

            document.getElementById('submitcheck').innerHTML = "<button id='submit' class='btn btn-primary' type='submit'>Submit</button></div>";
            $('#submit').on("click", function () {
                var selectedElmsIds = $('#check').jstree("get_selected", true);
                console.log(selectedElmsIds);
               
                listSelect2 = deepCopy(selectedElmsIds);
                createListQuery(selectedElmsIds);
                $(".swal-button--confirm").click(function (){
                    window.location.href="http://localhost:8000/Company/Service";
                })
                // window.location.href="http://localhost:8000/Company/Service";
                // listtest = selectedElmsIds ;
                
                
                //window.location.href = "http://localhost:8000/Company/Service";


                //instance.deselect_all();
                //instance.select_node('1');
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
                                    list[q].text = null
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
            console.log(list)
            for (let i = 0; i < list.length; i++) {
                if (list[i].text != null) {
                    arrData.push(list[i]);
                }
            }
            console.log(arrData)
            
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
            console.log(headerLow);
            console.log(getCookie('token'));

            
            increaseDataTableDB();
            increaseDataTableDW();
            //increasefirstDW();

        }
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
                    header: headerLow
                },
                success: (res) => {
                    // toastr["success"]("Success");
                    idDB = res.webService.webservice_id;
                    console.log("success DB")
                },
                error: (res) => {
                    console.log(res);
                }
            });

        }

        let increaseDataTableDW = ()=>
        {    
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
                    header: headerLow
                },
                success: (res) => {
                    swal("Good job!", "You clicked the button!", "success");
                    console.log("success DW")
                        
                },
                error: (res) => {
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
                    header : headerLow
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

                        // if(key == "Value" || key == "Unit")
                        // {

                        // }
                        // else 
                        // {
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

    $(".show-header").click(function () {

        let url = $("#url-webservice").val();
        let alias = $('#alias-webservice').val();
        let ServiceName = $('#name-webservice').val();
        let description = $("#description-webservice").val();
        let service = new Service(url, alias, ServiceName, description);
        service.initService();
        // let data = {
        //     api : null,
        // }
    
        // function saveData(res){
        //     data.api = res;
        //     let a = eval('data.api')
        //     //console.log(eval('data.api'));
        //     console.log(a)

        // }
    
        // $.ajax({
        //     url:"https://data.tmd.go.th/api/WeatherToday/V1/?type=json",
        //     success:(res) => {
        //         console.log(res)
        //         saveData(res);
        //     },
        //     error:(res)=> {
        //         console.log(res);
        //     }
        // })
        
    })




})

