<!DOCTYPE html>
<html>
<head>
    <title>Employee Contact Details</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css"/>
    <link href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css" rel="stylesheet">
    <style type="text/css">
        .textv
        {
            font-weight:bold;
            font-size: 20px;
            height:58px;
        }
        .backlist
        {
            width: 133px;
            height: 42px;
            font-weight:bold;
        }
        .btn-danger
        {
            margin-top: 3px;
        }
        .mt-5
        {
            margin-top: 1rem!important;
        }

    </style>
</head>
<body>
    
<div class="container mt-5">

    <a href="contact" class="edit btn btn-success float-right">Create Employee</a><br><br>

    <button class="btn btn-info btn-block text-left textv" data-toggle="collapse" data-target="#demo">Click To Search Employee Details Country / State / Name Wise</button><br>

    <div id="demo" class="collapse">
        <form id="contactForm11" name="contactForm11" class="form-horizontal">
            @csrf
          <div class="row">
            <div class="col">
              <select id="country-dropdown1" name="countrydropdown1" class="form-control form_input required">
                <option value="">Select Country</option>
                @foreach ($countries as $country)
                    <option value="{{$country->id}}">{{$country->countryname}}</option>
                @endforeach
              </select>
            </div>
            <div class="col">
              <select id="state-dropdown1" name="statedropdown1" class="form-control form_input required"><option value="">Select State</option>
                @foreach ($states as $state)
                    <option value="{{$state->id}}">{{$state->statename}}</option>
                @endforeach
              </select>
            </div>
            <div class="col">
              <input type="text" class="form-control" id="searchname" name="searchname" placeholder="name">
            </div>
            <div class="col">
            <button type="button" name="search_button1" id="search_button" class="btn btn-primary backlist">SEARCH</button>        
            </div>
          </div>
        </form>
    </div><br>

    <button class="btn btn-info btn-block text-left textv">Employee Contact List</button>

    @if(session()->has('message'))
    <div class="alert alert-success">
        {{ session()->get('message') }}
    </div>
    @endif

    <br><br>
    <table class="table table-bordered yajra-datatable" id="user_table">
        <thead>
            <tr>
                <th>No</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Country</th>
                <th>State</th>
                <th>Organization</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>

<div class="modal fade" id="ajax-product-modal" aria-hidden="true">
<div class="modal-dialog">
<div class="modal-content">
    <div class="modal-header">
        <h4 class="modal-title" id="productCrudModal"></h4>
    </div>
    <div class="modal-body">
        
        <form id="productForm" name="productForm" class="form-horizontal">
           
            @csrf
             <div class="form-header">
                <h4>Edit Employee Information</h4>
             </div>

            <div class="form-group">
                <label class="required">Your Name</label>
                <input type="hidden" name="contact_id" id="contact_id">
                <input type="text" placeholder="Your Name" class="form-control" name="name" id="name">
                <span class="text-danger"></span>
            </div>

            <div class="form-group">
                <label>Email Id</label>
                <input type="text" placeholder="Email Id" class="form-control" name="email" id="email">
                <span class="text-danger"></span>
            </div>

            <div class="form-group">
                <label>Contact No</label>
                <input type="text" placeholder="Contact No" class="form-control" name="phone" id="phone">
                <span class="text-danger"></span>
            </div>

            <div class="form-group">
                <label>Address</label>
                <textarea id="address" name="address" class="form-control" placeholder="Address" rows="4"></textarea>
                <span class="text-danger"></span>
            </div>

            <div class="form-group">
                <label class="required">Country</label>
            <select id="country-dropdown" name="country" class="form-control form_input"></select>
            <span class="text-danger"></span>
            </div>

            <div class="form-group">
                <label class="required">State</label>
                <select class="form-control" name="state" id="state-dropdown">
                    <option value="">Select State</option>
                </select>
                <span class="text-danger"></span>
            </div>

            <div class="form-group">
                <label>Comments</label>
                <textarea id="comment" name="comment" class="form-control" placeholder="Comments" rows="4"></textarea>
                <span class="text-danger"></span>
            </div>

            <div class="form-group">
                <label class="required">Organization</label>
                <input type="text" placeholder="Organization" class="form-control" name="organization" id="organization">
                <span class="text-danger"></span>
            </div>

            <div class="form-group">
                <label class="required">Captcha</label>
                <input id="captcha" type="text" class="form-control" placeholder="Enter Captcha" name="captcha">
                <span class="text-danger"></span>
                 <div class="captcha">
                    <span>{!! captcha_img() !!}</span>
                    <button type="button" class="btn btn-danger" class="reload" id="reload">
                        &#x21bb;
                    </button>
                </div>
                
            </div>

            <div class="col-sm-offset-2 col-sm-10">
                 <button type="submit" class="btn btn-primary" id="btn-save" value="create">Save changes
                 </button>
                  <!-- <button type="submit" class="btn btn-danger" id="btn-cancel" value="create">Cancel
                 </button> -->
            </div>
        </form>
    </div>
    <div class="modal-footer">
         
    </div>
</div>
</div>
</div>

<div id="confirmModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h2 class="modal-title">Confirmation</h2>
            </div>
            <div class="modal-body">
                <h4 align="center" style="margin:0;">Are you sure you want to remove this data?</h4>
            </div>
            <div class="modal-footer">
             <button type="button" name="ok_button" id="ok_button" class="btn btn-danger">OK</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>



<div class="modal fade" id="ajax-contact-modal1" aria-hidden="true">
<div class="modal-dialog">
<div class="modal-content">
    <div class="modal-header">
        <h4 class="modal-title" id="productCrudModal"></h4>
    </div>
    <div class="modal-body">
        <form id="productForm1" name="productForm1" class="form-horizontal">
           
            @csrf

             <div class="form-header">
                <h4>View Employee Information</h4>
             </div>

            <div class="form-group">
                <label class="required">Your Name</label>
                <input type="text" placeholder="Your Name" class="form-control" name="name" id="vname" readonly>
            </div>

            <div class="form-group">
                <label>Email Id</label>
                <input type="text" placeholder="Email Id" class="form-control" name="email" id="vemail" readonly>
               
            </div>

            <div class="form-group">
                <label>Contact No</label>
                <input type="text" placeholder="Contact No" class="form-control" name="phone" id="vphone" readonly>
            </div>

            <div class="form-group">
                <labelclass="required">Address</label>
                <textarea id="vaddress" name="address" class="form-control" placeholder="Address" rows="4" readonly></textarea>
            </div>

            <div class="form-group">
                <label class="required">Country</label>
            <input type="text" placeholder="Country" class="form-control" name="organization" id="vcountry" readonly>
            </div>

            <div class="form-group">
                <label class="required">State</label>
                <input type="text" placeholder="State" class="form-control" name="organization" id="vstate" readonly>
            </div>

            <div class="form-group">
                <label>Comments</label>
                <textarea id="vcomment" name="comment" class="form-control" placeholder="Comments" rows="4" readonly></textarea>
            </div>

            <div class="form-group">
                <label class="required">Organization</label>
                <input type="text" placeholder="Organization" class="form-control" name="organization" id="vorganization" readonly>
            </div>

            <div class="form-group">
                <button type="button" class="btn btn-danger view-cancel" data-dismiss="modal">Cancel</button>
            </div>

        </form>
    </div>
    <div class="modal-footer">
         
    </div>
</div>
</div>
</div>









   
</body>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>  
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>

<script type="text/javascript">
$(document).ready(function(){
            $(document).on('click', '#reload', function(){
                $.ajax({
                    type: 'GET',
                    url: 'reload-captcha',
                    success: function (data) {
                        $(".captcha span").html(data.captcha);
                    }
                });
            });
            $(function(){
    
                var table = $('.yajra-datatable').DataTable({
                processing: true,
                serverSide: true,
                "bDestroy": true,
                // ajax: "{{ route('contact-list') }}",
                // data: function (d){
                //             d.name = $('select[name=country]').val();
                //             // d.category = $('option[name=category]').text();
                //         }

                "ajax": {
                        url: "{{ route('contact-list') }}",
                        data: function (d){
                            console.log(d);
                            // d.name = $('select[name=category]').val();
                            d.category = $('option[name=category]').text();
                        }
                    },
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'name', name: 'name'},
                    {data: 'email', name: 'email'},
                    {data: 'phone', name: 'phone'},
                    {data: 'Country', name: 'Country'},
                    {data: 'State', name: 'State'},
                    {data: 'organization', name: 'organization'},           
                    {
                        data: 'action', 
                        name: 'action', 
                        orderable: true, 
                        searchable: true
                    },
                ]
            });


        $(document).on('click', '.delete', function(){
              user_id = $(this).attr('id');
              $('#confirmModal').modal('show');
         });

        $('#ok_button').click(function(){
            $.ajax({
                   url:"contact/destroy/"+user_id,
                   beforeSend:function(){
                    $('#ok_button').text('Deleting...');
                   },
                   success:function(data)
                   {
                    setTimeout(function(){
                     $('#confirmModal').modal('hide');
                     $('#user_table').DataTable().ajax.reload();
                     alert('Data Deleted');
                    }, 2000);
                   }
                })
         });


         $('body').on('click', '.edit-product', function () {
              var contact_id = $(this).attr('id');
              $.get('contact-list/' + contact_id +'/edit', function (data) {
                 console.log(data);
                var countryoption = "";
                $.each(data.countries, function(index, value) {

                    selectedVal = data.user.country_id;
                    isSelected = selectedVal == value.id ? 'selected' : '';

                    countryoption += "<option value='" + value.id + "' " + isSelected + ">" + value.countryname + "</option>";
                    });
                $('#country-dropdown').html(countryoption);

                
                var stateoption = "";
                $.each(data.states, function(index, value) {
                    selectedstateVal = data.user.state_id;
                    isSelectedstate = selectedstateVal == value.id ? 'selected' : '';
                    stateoption += "<option value='" + value.id + "' " + isSelectedstate + ">" + value.statename + "</option>";
                    });
                $('#state-dropdown').html(stateoption);

                 // $('#title-error').hide();
                 // $('#product_code-error').hide();
                 // $('#description-error').hide();
                 // $('#productCrudModal').html("Edit Product");
                  $('#btn-save').val("edit-product");
                  $('#ajax-product-modal').modal('show');
                  $('#contact_id').val(data.id);
                  $('#name').val(data.name);
                  $('#email').val(data.email);
                  $('#phone').val(data.user.phone);
                  $('#address').val(data.user.address);
                  $('#comment').val(data.user.comment);
                  $('#organization').val(data.user.organization);
          })
        });


        if ($("#productForm").length > 0) {
            $("#productForm").validate({
  
                submitHandler: function(form)
                 {
  
                      var actionType = $('#btn-save').val();
                      $('#btn-save').html('Sending..');
                       
                     $.ajax({
                              data: $('#productForm').serialize(),
                              
                              url:"contact-list/store",
                              type: "POST",
                              dataType: 'json',
                              success: function (data) {
                                console.log("dgfd");
                              $('#productForm').trigger("reset");
                              $('#user_table').DataTable().ajax.reload();
                              $('#ajax-product-modal').modal('hide');
                              $('#btn-save').html('Save Changes');
                              var oTable = $('#laravel_datatable').dataTable();
                              oTable.fnDraw(false);
               
                              },
                              error: function (data) {
                                if(data.responseText)
                                {
                                    var errors = JSON.parse(data.responseText);
                                    if(errors.errors.name)
                                    {
                                        $('input[name="name"]').siblings('span').text(errors.errors.name[0]);
                                    }
                                    if(errors.errors.email)
                                    {
                                        $('input[name="email"]').siblings('span').text(errors.errors.email[0]);
                                    }
                                    if(errors.errors.phone)
                                    {
                                        $('input[name="phone"]').siblings('span').text(errors.errors.phone[0]);
                                    }
                                     if(errors.errors.address)
                                    {
                                        $('textarea[name="address"]').siblings('span').text(errors.errors.address[0]);
                                    }
                                    if(errors.errors.country)
                                    {
                                        $('input[name="country"]').siblings('span').text(errors.errors.country[0]);
                                    }
                                    if(errors.errors.state)
                                    {
                                        $('input[name="state"]').siblings('span').text(errors.errors.state[0]);
                                    }
                                    if(errors.errors.comment)
                                    {
                                        $('input[name="comment"]').siblings('span').text(errors.errors.comment[0]);
                                    }
                                    if(errors.errors.organization)
                                    {
                                        $('input[name="organization"]').siblings('span').text(errors.errors.organization[0]);
                                    }
                                    if(errors.errors.captcha)
                                    {
                                        $('input[name="captcha"]').siblings('span').text(errors.errors.captcha[0]);
                                    }
                                  // console.log('Error:', data);
                                  $('#btn-save').html('Save Changes');
                                }
                              }
                            });
                    }
            })
        }

        $('body').on('change', '#country-dropdown,#country-dropdown1', function () {
                var country_id = this.value;
                $("#state-dropdown").html('');
                $.ajax({
                    url:"{{url('get-states-by-country')}}",
                    type: "POST",
                    data: {
                    country_id: country_id,
                    _token: '{{csrf_token()}}' 
                    },
                    dataType : 'json',
                    success: function(result)
                    {
                         $('#state-dropdown').html('<option value="">Select State</option>'); 
                        $.each(result.states,function(key,value){
                        $("#state-dropdown").append('<option value="'+value.id+'">'+value.statename+'</option>');
                        });
                        $('#city-dropdown').html('<option value="">Select State First</option>'); 

                        $('#state-dropdown1').html('<option value="">Select State</option>'); 
                        $.each(result.states,function(key,value){
                        $("#state-dropdown1").append('<option value="'+value.id+'">'+value.statename+'</option>');
                        });
                        $('#city-dropdown1').html('<option value="">Select State First</option>'); 
                    }
                });
        });
        $('body').on('change', '#btn-cancel', function () {
            $('#ajax-product-modal').modal('hide');
        });


    $('body').on('click', '.view-product', function () {
          var contact_id = $(this).attr('id');
          $.get('contact-list/' + contact_id +'/view', function (data) {
            console.log(data);
             // $('#title-error').hide();
             // $('#product_code-error').hide();
             // $('#description-error').hide();
             // $('#productCrudModal').html("Edit Product");
              $('#btn-save').val("edit-product");
              $('#ajax-contact-modal1').modal('show');
              $('#contact_id').val(data.id);
              $('#vname').val(data.name);
              $('#vemail').val(data.email);
              $('#vphone').val(data.user.phone);
              $('#vaddress').val(data.user.address);
              $('#vcountry').val(data.countries.countryname);
              $('#vstate').val(data.states.statename);
              $('#vcomment').val(data.user.comment);
              $('#vorganization').val(data.user.organization);
      })
   });

    //Filter Search
    $('body').on('click', '#search_button', function () {
            
            var table = $('.yajra-datatable').DataTable({
                processing: true,
                serverSide: true,
                "bDestroy": true,

                "ajax": {
                            "url": "contact-list/searchFilter",
                            data: function (d) {
                                                d.countryid = $("#country-dropdown1").val();
                                                d.stateid = $("#state-dropdown1").val();
                                                d.searchname = $("#searchname").val();
                                            },
                     },
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'name', name: 'name'},
                    {data: 'email', name: 'email'},
                    {data: 'phone', name: 'phone'},
                    {data: 'Country', name: 'Country'},
                    {data: 'State', name: 'State'},
                    {data: 'organization', name: 'organization'},           
                    {
                        data: 'action', 
                        name: 'action', 
                        orderable: true, 
                        searchable: true
                    },
                ]
            });


        $('body').on('click', '.view-cancel', function () {
            alrt("hii");
        });
            

            
    });

   
});
});
</script>
</html>