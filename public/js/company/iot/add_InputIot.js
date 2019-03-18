class iotService {
    constructor(iotName,iotAlias,iotdescription,status,fields)
    {
        let nameiot = iotName  ;
        let keyiot;
        let alias = iotAlias;
        let description = iotdescription ;
        let stats = status;
        let datajson = fields;
        let time ;
        let companyID;
        

        this.getDataforInsert = () => {
            // get id company
            $.ajax({
                url: "http://localhost:8000/api/company/webservice/getCompanyID",
                dataType: 'json',
                method: "GET",
                async: false,
                success: (res) => {
                    companyID = res.companyID ;
                    console.log(companyID);
                },
                error: (res) => {                
                    console.log(res);
                }
            });

            // create token
            $.ajax({
                url: "http://localhost:8081/iotService/getKeyiot",
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

            //register DB
            $.ajax({
                url: "http://localhost:8000/api/iot/addRegisIotService",
                dataType: 'json',
                method: "POST",
                async: false,
                data:
                {
                    strUrl: 'ss',
                    alias: alias,
                    ServiceName: nameiot,
                    description: description,
                    valueCal: '1',
                    valueGroupby: '1',
                    // updatetime_input: '1',
                    stats: stats,
                    datajson:datajson,
                    type: 'input',
                    
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

        this.increaseDataTableDB = () => {
            //console.log('cccccc')    
            //get company id
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
        }

        this.showDetail = () => {
            // let data =JSON.parse(datajson);
            // let strJson="";
            // let count = Object.keys(data).length;
            // let i=0;
            // console.log(count);
            // Object.keys(data).forEach(function(key) {
            //     strJson+=key +'=' +data[key];
            //     if(i == count-1)
            //     {
            //     }
            //     else
            //     {
            //         strJson+='&';
            //     }
            //     i++;
            // })
            let otheroutput="";
            for(let i=0;i<fields.length;i++)
            {
                
                if(i==fields.length-1)
                {
                    otheroutput += fields[i] +"=[value]";
                }
                else
                {
                    otheroutput += fields[i] +"=[value]&";
                }
            }
            //console.log(otheroutput)
            $('#Nameiot').val(nameiot);
            $('#Apiiot').val('http://localhost:8081/iotService/insertData?keyIot='+keyiot+'&nameDW=IoT.Input.'+nameiot+'.'+companyID+'&'+otheroutput);
            $('#Keyiot').val(keyiot);
        }  

        this.showSelectValueCal = () => {    
          
            let strModal = `<div class='modal fade' id='myModal' role='dialog'>
                                <div class='modal-dialog'>
                                    <div class='modal-content'>
                                        <div id='modal-header-val' class='modal-header'>
                                                <h4 class='modal-title'>Choose the value to calculate</h4>
                                                <button type='button' class='close' data-dismiss='modal'>&times;</button>
                                        </div>
                                        <div id='modal-body' class='modal-body'>
                                            <p id='xxx'>The selected value will be calculated in the summary table.</p>
                                        </div>
                                        <div class='modal-footer'>
                                            <button type='button' id='submitChkValCal' class='btn btn-info swal-button--confirm' data-toggle='modal'>Submit</button>
                                            <button type='button' class='btn btn-default' data-dismiss='modal'>Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>`;
            $('.modalCalValue').empty();
            $('.modalCalValue').append(strModal);
            for(let i =0 ;i<datajson.length;i++)
            {
                console.log(datajson[i])
                $("#modal-body").append("<label class='customcheck'>"+datajson[i]+"<input type='checkbox' class='chkall'  value='"+datajson[i]+"' id='datajson"+i+"'><span class='checkmark'></span></label>");

            }        
            $('#myModal').modal('show');
            $('#submitChkValCal').click(function(){
                $('#myModal').modal('hide');
                $('#ShowDetailiotModal').modal('show');
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

        this.checkFormatJson = (data) =>{
            console.log(data)     
            try {
                //JSON.parse(JSON.stringify(data));
                JSON.parse(data)
                
            } catch (e) {
                return false;
            }
            return true;
            
        }


    }
}


class Validation{
    constructor(iotName,iotAlias,iotdescription,status,fields)
    {
        this.validate = () =>{
            
            if(iotName == "" || iotAlias =="")
            {
                if(iotName == ""){
                    swal("คุณไม่ได้กรอก IoT Name  !", "", "error");
                }
                else if(iotAlias ==""){
                    swal("คุณไม่ได้กรอก Alias  !", "", "error");
                }
                
            }
            else
            {
                let lenFields = fields.length ;
                if(fields[lenFields-1] == "")
                {
                    console.log('1')
                    swal("คุณไม่ได้กรอก Data format !", "", "error");
                }
                else {
                    let iot = new iotService(iotName,iotAlias,iotdescription,status,fields);
                    iot.getDataforInsert();
                    iot.showSelectValueCal();
                }
              
              
            }            
            


        }
        


    }
}


$(document).ready(function () {
    //var clipboard = new ClipboardJS('#Keyiot');
    //let cron = new cronTap();
    //let manage = new Managememt();
    //cron.exampleCron();
    //manage.checkFormTime();

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
    $('#showvalue').click(function(){
        
        let iotName = $('#name-iotservice').val();
        let iotAlias = $('#alias-iotservice').val();
        let iotdescription = $('#description-iotservice').val();
        let status = $('#status').val();
        let dataformat= $('#dataFormat-iotservice').val();
        let inputs = document.getElementsByClassName("fields");
        let fields  = [].map.call(inputs, function( input ) {
            return input.value;
        });
        console.log(fields)
        console.log(fields.length)
        console.log(typeof fields)
       

        let validate = new Validation(iotName,iotAlias,iotdescription,status,fields);
        validate.validate();

       
        //iot.showDetail();
      

    })
    

    
    $('#checkFormat').click(function(){
        let data = $('#dataFormat-iotservice').val();
        console.log(data)
        let x = manage.checkFormatJson(data);
        console.log(x)
        if(x==true)
        {
            $('.showCheckJson').html('<i class="fa fa-check-circle fa-lg " style="color:green; padding-top:7px" aria-hidden="true">&emsp;</i>');
        }
        else {
            $('.showCheckJson').html('<i class="fa fa-times-circle fa-lg " style="color:#CB4335; padding-top:7px" aria-hidden="true">&emsp;</i>');

        }
        let u = {"name":"John","age":30,"city":"New York"} 
      
    })
   


})




