@extends('layouts.mainCompany')
@section('title','Web Service | Company')
@section('content')

<div>
    <br>
    <h2>Web Service </h2>
    <hr>
    <br>    
</div>

<div class="row">
    <div class="col-6" >
        <h6>Number of registered web services is 6 </h6>
    </div>
    <div class="col-6 text-right" style="padding: 0px 15px 0px 0px; ">
        <a href="add_webService.php">
            <button type="button " class="btn btn-primary" >
                <i class="fa fa-plus-circle"></i>
                Add service
            </button>
        </a>     
    </div>
          

</div>
  
<div class="row" style="padding: 30px 0px 10px 0px">
    <div class="col-12">
        <div class="panel-body">
            <table style="width: 100%;" class="table table-striped table-bordered table-hover dt-responsive nowrap" id="example">
                <thead>
                    <tr>
                        <th>NameService(EN)</th>
                        <th>Description</th>
                        <th>Status</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><a href="add_webService.php">Weather3Hours</a></td>
                        <td><a href="add_webService.php">สภาพอากาศทุกๆ3ชั่วโมง</a></td>
                        <td>Active</td>
                        <td>
                            <center>
                                <button type="button" class="btn btn-primary btn-sm" onclick="">
                                    <i class="fas fa-list"></i>
                                </button>
                                <button type="button" class="btn btn-success btn-sm" onclick="">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button type="button" class="btn btn-secondary btn-sm" onclick="">
                                    <i class="fas fa-times"></i>
                                </button>
                                <button type="button" class="btn btn-danger btn-sm" onclick="">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </center>
                        </td>
                    </tr>
                    <tr>
                        <td>WeatherForecast7Days</td>
                        <td>สภาพอากาศทุกล่วงหน้า 7 วัน</td>
                        <td>Inactive</td>
                        <td>
                            <center>
                                <button type="button" class="btn btn-primary btn-sm" onclick="">
                                    <i class="fas fa-list"></i>
                                </button>
                                <button type="button" class="btn btn-success btn-sm" onclick="">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button type="button" class="btn btn-secondary btn-sm" onclick="">
                                    <i class="fas fa-times"></i>
                                </button>
                                <button type="button" class="btn btn-danger btn-sm" onclick="">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </center>
                        </td>
                    </tr>
                    <tr>
                        <td><a href="">WeatherToday<a></td>
                        <td><a href="">สภาพอากาศวันนี้<a></td>
                        <td>Inactive</td>
                        <td>
                            <center>
                                <button type="button" class="btn btn-primary btn-sm" onclick="">
                                    <i class="fas fa-list"></i>
                                </button>
                                <button type="button" class="btn btn-success btn-sm" onclick="">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button type="button" class="btn btn-secondary btn-sm" onclick="">
                                    <i class="fas fa-times"></i>
                                </button>
                                <button type="button" class="btn btn-danger btn-sm" onclick="">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </center>
                        </td>
                    </tr>
                  
                    
                   
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

