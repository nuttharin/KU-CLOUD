class iotService {
    constructor(iotName,iotAlias,iotdescription,status,OutputData,jsonencode)
    {
        let nameiot = iotName  ;
        let keyiot;
        let alias = iotAlias;
        let description = iotdescription ;
        let stats = status;
        let time ;
        let companyID;
        let showJsonstr = OutputData;
        let pinfilds = jsonencode;
        let strUrlInsert = ""
        let strurl;

        this.getDataforInsert = () => {
            // get id company
            $.ajax({
                url: END_POINT+"company/webservice/getCompanyID",
                dataType: 'json',
                method: "GET",
                async: false,
                success: (res) => {
                    companyID = res.companyID ;
                },
                error: (res) => {                
                    console.log(res);
                }
            });

            // create token
            $.ajax({
                url: API_DW +"iotService/getKeyiot",
                dataType: 'json',
                method: "POST",
                async: false,
                headers: {"Authorization": getCookie('token')},
                data:
                {                
                    companyID : companyID                    
                },
                success: (res) => { 
                    keyiot = res.key
                    //console.log(res);                        
                },
                error: (res) => {
                    console.log(res);
                }
            });

            strurl = API_DW +'iotService/getOutputIot?keyIot='+keyiot+'&nameDW=IoT.Output.'+nameiot+'.'+companyID;
        }
        
        let registerDB = () => {
            console.log("register")
             //register DB
             $.ajax({
                url: END_POINT+"iot/addOutputRegisIotService",
                dataType: 'json',
                method: "POST",
                async: false,
                data:
                {
                    alias: alias,
                    ServiceName: nameiot,
                    description: description,
                    urls:strurl,
                    stats: stats,
                    pinfilds : pinfilds,
                    showJsonstr:showJsonstr,
                    type: 'output',
                    
                },
                success: (res) => {
                    // toastr["success"]("Success");
                    console.log("success DB")
                },
                error: (res) => {
                    console.log(res);
                }
            });
        }

        let increaseDataTableDWFristTime = () => {
            let nametable = 'IoT.Output.'+nameiot+'.'+companyID
            $.ajax({
                url: API_DW +"iotService/insertOutputIot",
                dataType: 'json',
                method: "POST",
                async: false,
                data:
                {                    
                    nameDW: nametable,
                    strJson:jsonencode,
                },
                success: (res) => {
                    // toastr["success"]("Success");
                   
                    console.log("success DW")
                },
                error: (res) => {
                    console.log(res);
                }
            });
        }

        this.showDetail = () => {
            $('#Nameiot').val(nameiot);
            let strurl = API_DW +'iotService/getOutputIot?keyIot='+keyiot+'&nameDW=IoT.Output.'+nameiot+'.'+companyID;
            $('#URLiot').val(API_DW +'iotService/getOutputIot?keyIot='+keyiot+'&nameDW=IoT.Output.'+nameiot+'.'+companyID);
            // $('#Keyiot').val(keyiot);            
            $('#Dataformat').val(pinfilds);
            //strUrlInsert = 'http://localhost:8081/iotService/getOutputIot?keyIot='+keyiot+'&nameDW=IoT.Output.'+nameiot+'.'+companyID ;
            $('#ShowDetailiotModal').modal('show');
            $('#close-modal-show').click(function(){
                registerDB();
                increaseDataTableDWFristTime();
                swal("Registration Success.", "", "success")
                .then((value) => {
                    location.reload();
                });
            })

        }  
    }       
}

class cronTap {
    constructor()
    {
        this.exampleCron = () => {
             // example cron
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
        }
        
 
    }       
}

class Validation{
    constructor(iotName,iotAlias,iotdescription,status,OutputData,jsonencode,fields,nameoutput,valueoutput)
    {
        
        this.validate = () =>{
            let chkDatas;
            let chkName;
            console.log(nameoutput.length) 
            console.log( nameoutput[0])
            if(iotdescription == ""){

                iotdescription = "";
            }
            $.ajax({
                url: END_POINT+"iot/checkServicename",
                dataType: 'json',
                method: "POST",
                async: false,
                data:
                {
                    ServiceName: iotName,
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
                if(iotName == "")
                {
                    swal("คุณไม่ได้กรอก IoT Name  !", "", "error");
                }
                else if(iotName != "")
                {
                    if(iotAlias =="")
                    {
                        console.log("ll" + iotAlias)
                        swal("คุณไม่ได้กรอก Alias  !", "", "error");
                    }
                    else if(iotAlias !="")
                    {
                    
                        for(let i =0 ;i< nameoutput.length; i++)
                            {
                                if(nameoutput[i] == "" || valueoutput[i] == "")
                                {
                                    swal(" Others Output ไม่ถุกต้อง !", "", "error");
                                }
                                else if(nameoutput[i] != "" || valueoutput[i] != "")
                                {
                                    for(let i =0 ;i<fields.length; i++)
                                    {
                                        if(fields[i] == "")
                                        {
                                            swal(" Pin names ไม่ถุกต้อง !", "", "error");
                                        }
                                        else if(i==fields.length-1 &&(fields[i] != ""))
                                        {
                                            let iot = new iotService(iotName,iotAlias,iotdescription,status,OutputData,jsonencode,fields);
                                            iot.getDataforInsert();
                                            iot.showDetail();
                                        }
                                    }

                                }
                            }       
                    }
                }
            }
            
        }

    }
}
class Validation1{
    constructor(iotName,iotAlias,iotdescription,status,OutputData,jsonencode,fields)
    {
        
        this.validate = () =>{
            let chkData = true ;
            let chkName;
            if(iotdescription == ""){
                iotdescription = "";
            }
            $.ajax({
                url: END_POINT+"iot/checkServicename",
                dataType: 'json',
                method: "POST",
                async: false,
                data:
                {
                    ServiceName: iotName,
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
                if(iotName == "" || iotAlias =="")
                {
                    
                    if(iotName == ""){
                        swal("คุณไม่ได้กรอก IoT Name  !", "", "error");
                    }
                    else if(iotAlias ==""){
                        console.log("ll" + iotAlias)
                        swal("คุณไม่ได้กรอก Alias  !", "", "error");
                    }                
                }            
                else if(iotName != "" || iotAlias !="")
                {
                    chkData = true ;
                    for(let i =0 ;i<fields.length; i++)
                    {
                        if(fields[i] == "")
                        {
                            chkData = false ;
                            break;
                        }                        
                    }
                
                    if(chkData) {
                        console.log(status)
                        let iot = new iotService(iotName,iotAlias,iotdescription,status,OutputData,jsonencode);
                        iot.getDataforInsert();
                        iot.showDetail();
                    }
                    else {
                        swal(" Pin Names ไม่ถุกต้อง !", "", "error");
                    }
                }
            }
        }

    }
}

class Managememt{
    constructor()
    {
        this.checkFormTime = () => {
            $(".set-time").hide()
            $('#checktime-iotservice').change(function(){
                let checkUpTime = $('#checktime-iotservice').prop("checked");
                if(checkUpTime==true)
                {
                    $(".set-time").slideDown("fast");            
                }
                else 
                {
                    $(".set-time").hide()
                    $("#time-webservice-minute").val("")
                    $("#time-webservice-hour").val("")
                    //onsole.log('scvv')

                }
                
            })
        }
    }
}



$(document).ready(function () {
    //var clipboard = new ClipboardJS('#Keyiot');
    let cron = new cronTap();
    let manage = new Managememt();
    let fields;
    let valueoutput;
    let nameoutput;
    let otheroutput={};
    let dataOutput ={} ;
    let showJson={};
    let count=0;
    cron.exampleCron();
    manage.checkFormTime();
    $('#nameOutput').attr('disabled',true)
    $('#valueOutput').attr('disabled',true)
    $('.btn-adds').attr('disabled',true)
    $(document).on('click', '.btn-add', function(e)
    {
        e.preventDefault();

        var controlForm = $('.controls form:first'),
        currentEntry = $(this).parents('.entry:first'),
        newEntry = $(currentEntry.clone()).appendTo(controlForm);

        newEntry.find('input').val('');
        controlForm.find('.entry:not(:last) .btn-add')
            .removeClass('btn-add').addClass('btn-remove')
            .removeClass('btn-success').addClass('btn-danger')
            .html('<span>-</span>');
        }).on('click', '.btn-remove', function(e)
        {
            $(this).parents('.entry:first').remove();

            e.preventDefault();
            return false;
    });

    $(document).on('click', '.btn-adds', function(e)
    {
        e.preventDefault();
        var controlForm = $('.controlsoutput form:first'),
        currentEntry = $(this).parents('.entry:first'),
        newEntry = $(currentEntry.clone()).appendTo(controlForm);
        count++;
        newEntry.find('input').val('');
        controlForm.find('.entry:not(:last) .btn-adds')
            .removeClass('btn-adds').addClass('btn-removes')
            .removeClass('btn-success').addClass('btn-danger')
            .html('<span>-</span>');
        }).on('click', '.btn-removes', function(e)
        {
            $(this).parents('.entry:first').remove();
            count--;
            e.preventDefault();
            return false;
    });
    $('#chk_otheroutput').change(function() {
        console.log(count)
        if($('#chk_otheroutput').prop('checked')==false)
        {
            if(count==0)
            {
                $(".nameoutput").val("");
                $(".valueoutput").val("");
                $(".btn-adds").remove();
                $(".adds").append(`<button class="btn btn-success btn-adds" type="button"><span>+</span></button>`);
                $(".nameoutput").attr('disabled',true)
                $('.valueoutput').attr('disabled',true)
                $('.btn-adds').attr('disabled',true)
            }
            else
            {
                for(let i=count;i>0;i--)
                {
                $(".nameoutput").val("");
                $(".valueoutput").val("");
                $(".nameoutput")[i].remove();
                $(".valueoutput")[i].remove();
                // $(".btn-adds").remove();
                $(".btn-removes").remove();
                $(".otherfiled")[i].remove();
                }
            count=0;
            $(".adds").append(`<button class="btn btn-success btn-adds" type="button"><span>+</span></button>`);
            $(".nameoutput").attr('disabled',true)
            $('.valueoutput').attr('disabled',true)
            $('.btn-adds').attr('disabled',true)
            }
            
        }
        
        else
        {   
            $(".nameoutput").attr('disabled',false)
            $('.valueoutput').attr('disabled',false)
            $('.btn-adds').attr('disabled',false)
            $('.btn-removes').attr('disabled',false) 
        }
        
    });
    $('#showvalue').click(function(){
        
        let iotName = $('#name-iotservice').val();
        let iotAlias = $('#alias-iotservice').val();
        let iotdescription = $('#description-iotservice').val();
        let status = $('#status').val();
        let inputs = document.getElementsByClassName("fields");
        //pin
        fields  = [].map.call(inputs, function( input ) {
            return input.value;
        });
        // orther output
        let nameout = document.getElementsByClassName("nameoutput");
        let valueout = document.getElementsByClassName("valueoutput");
        valueoutput  = [].map.call(valueout, function( input ) {
            return input.value;
        });
        nameoutput  = [].map.call(nameout, function( input ) {
            return input.value;
        });
        
        otheroutput={};
        dataOutput ={} ;
        showJson={};
        //console.log(nameoutput)
        if(nameoutput == "" || nameoutput == null)
        {
            otheroutput = {}
            if(fields.length>0){
                for(let i=0;i<fields.length;i++)
                {
                    showJson[fields[i]] = 0;
                    otheroutput[fields[i]] = 0;
                    console.log(otheroutput)
                }
            }
            dataOutput['pin'] = otheroutput ;
        }
        else
        {
            for(let i=0;i<nameoutput.length;i++)
            {
                showJson[nameoutput[i]] = valueoutput[i];
                otheroutput[nameoutput[i]] = valueoutput[i];
            }
            dataOutput['other'] = otheroutput ;
            otheroutput = {}
            if(fields.length>0){
                for(let i=0;i<fields.length;i++)
                {
                    showJson[fields[i]] = 0;
                    otheroutput[fields[i]] = 0;
                    console.log(otheroutput)
                }
            }
            dataOutput['pin'] = otheroutput ;

        }
        //console.log(showJson)
        let OutputData = JSON.stringify(dataOutput, undefined, 2);
        let jsonencode = JSON.stringify(showJson, undefined, 2);
        //console.log(jsonencode);

       
        // console.log(fields)
        // console.log(valueoutput)
        // console.log(nameoutput)
        // console.log(OutputData)
        // console.log(jsonencode)
        console.log($('#chk_otheroutput').prop('checked'))
        if($('#chk_otheroutput').prop('checked')==false){
            let validate = new Validation1(iotName,iotAlias,iotdescription,status,OutputData,jsonencode,fields);
            validate.validate();
        }
        else if($('#chk_otheroutput').prop('checked')==true)
        {
            let validate = new Validation(iotName,iotAlias,iotdescription,status,OutputData,jsonencode,fields,nameoutput,valueoutput);
            validate.validate();
    
        }
        // let iot = new iotService(iotName,iotAlias,iotdescription,status,OutputData,jsonencode);
        // iot.getDataforInsert();
        // iot.showDetail();
      

    })
    
   


})




