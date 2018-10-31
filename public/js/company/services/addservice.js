class Service{
    constructor(){
        let dataFromUrl;
        let dataHeader ;
        let dataHeaderList ;

        this.initService = (url) =>{
            console.log("init service")
            let treeView = new TreeView();
            treeView.clearValue();
            dataFromUrl = treeView.getDataFormUrl();
            dataHeader = treeView.getHeaderFormData(dataFromUrl);
            dataHeaderList = treeView.getDataHeaderAll();
            dataHeader = JSON.stringify(dataHeader);
          
            console.log(dataHeader);
            console.log(dataHeaderList);
           
       
        }

        

        
    }

     

}

class TreeView{
    constructor()
    {
        
        //this.strUrl = this.url;
        
        let arrData = [] ;
        let dataChild = [];

        let dataHeaderAll = [];
        let num =0 ;
        let num2 =0 ;
        //let num2 =1 ;
        //this.dataFromUrl;

        this.clearValue = () => {
            arrData = [] ;
            dataChild = [] ;
        }

        this.getDataHeaderAll = () =>{
            return dataHeaderAll ;
        }

        this.getDataFormUrl = () =>{
            let dataTemp ;
            $.ajax({ 
                url: "http://data.tmd.go.th/api/Weather3Hours/V1/?type=json", 
                method: "GET", 
                dataType: "json",
                async : false,
                success: function (data) { 
                    //console.log("Get Json Com")                    
                    dataTemp = data ;
                       
                }, 
                error: function (data) { 
                    console.log("Error Get Json");
                } 
            })  
            return dataTemp ;

        }

        this.getHeaderFormData = (data) => {
            let dataTemp ;
            arrData = [] ;
            
           
            if( typeof(data) !== 'object')
            {

            }
            else {
                let temp ;
                Object.keys(data).forEach(function(key){
                    if(Array.isArray(data[key]))
                    {
                        temp  = data[key][0];
                    }
                    else {
                        temp = data[key];
                    }
                   
                    //num = num2;
                   
                    getHeader(temp,key); 
                    num2++;
                    arrData.push({ 'id': num2,'text' : key , 'children' : dataChild });
                    dataHeaderAll.push({'id': num2,'text' :key });
                   

                    
                    dataChild = [];


                });
            }
            dataTemp = arrData ;
            arrData = [] ;
            return dataTemp ;
            //return dataHeaderAll;
        }      

        let getHeader = (dataIn) =>{

            let arrDataIn = [] ;
            if(typeof(dataIn) !== 'object')
            {

            }
            else 
            {
                Object.keys(dataIn).forEach(function(key){

                    if(typeof(dataIn[key]) === 'object')
                    {
                        // 
                        // num2++;
                        
                        getHeader(dataIn[key]);
                        num2++;
                        arrDataIn.push({  'id': num2 ,'text' : key , 'children' : dataChild });
                        dataHeaderAll.push({'id': num2, 'text' :key });
                        

                    }
                    else {
                        // 
                        // num2++;
                        num2++;
                        arrDataIn.push({ 'id': num2,'text' : key , 'children' : null });
                        dataHeaderAll.push({'id': num2 ,'text' :key });
                        ///num++;

                    }
                    

                });
                dataChild = arrDataIn ;
                arrDataIn = [] ;
                return dataChild ;
                //return arrDataIn;

            }

        }

    }
    




    


}

$(document).ready(function(){

    $(".show-header").click(function(){
        //console.log("kuy");
        let url  = $("#url-webservice").val();
        //console.log(url);
        let service = new Service();
        service.initService();


    })

    $(".show-header").click(function(){
       

    })



})
