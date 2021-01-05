<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto|Courgette|Pacifico:400,700">
<title>Bootstrap Start Free Trail Sign up Form</title>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
<style>
body {
	color: #999;
	background: #e2e2e2;
	font-family: 'Roboto', sans-serif;
}
.form-control {
	min-height: 41px;
	box-shadow: none;
	border-color: #e1e1e1;
}
.form-control:focus {
	border-color: #00cb82;
}	
.form-control, .btn {        
	border-radius: 3px;
}
.form-header {
	margin: -30px -30px 20px;
	padding: 30px 30px 10px;
	text-align: center;
	background: #00cb82;
	border-bottom: 1px solid #eee;
	color: #fff;
}
.form-header h2 {
	font-size: 34px;
	font-weight: bold;
	margin: 0 0 10px;
	font-family: 'Pacifico', sans-serif;
}
.form-header p {
	margin: 20px 0 15px;
	font-size: 17px;
	line-height: normal;
	font-family: 'Courgette', sans-serif;
}
.signup-form {
	width: 390px;
	margin: 0 auto;	
	padding: 30px 0;	
}
.signup-form form {
	color: #999;
	border-radius: 3px;
	margin-bottom: 15px;
	background: #f0f0f0;
	box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);
	padding: 30px;
}
.signup-form .form-group {
	margin-bottom: 20px;
}		
.signup-form label {
	font-weight: normal;
	font-size: 14px;
}
.signup-form input[type="checkbox"] {
	position: relative;
	top: 1px;
}
.signup-form .btn {        
	font-size: 16px;
	font-weight: bold;
	background: #00cb82;
	border: none;
	min-width: 200px;
}
.signup-form .btn:hover, .signup-form .btn:focus {
	background: #00b073 !important;
	outline: none;
}
.signup-form a {
	color: #00cb82;		
}
.signup-form a:hover {
	text-decoration: underline;
}
</style>
</head>
<body>
<div class="signup-form">
    <form action="/examples/actions/confirmation.php" method="post">
		<div class="form-header">
			<h2>Sign Up</h2>
			<p>Fill out this form to start your free trial!</p>
		</div>
        @csrf

            <div class="form-group">
                <label class="required">Your Name</label>
                <input type="text" placeholder="Your Name" class="form-control" name="name" value="{{old('name')}}">
                @error('name')
                    <span class="error_message">{{$message}}</span>
                @enderror
            </div>

            <div class="form-group">
                <label>Email Id</label>
                <input type="text" placeholder="Email Id" class="form-control" name="email" value="{{old('email')}}">
                @error('email')
                    <span class="error_message">{{$message}}</span>
                @enderror
            </div>

            <div class="form-group">
                <label>Contact No</label>
                <input type="text" placeholder="Contact No" class="form-control" name="phone" value="{{old('phone')}}">
                @error('phone')
                    <span class="error_message">{{$message}}</span>
                @enderror
            </div>

             <div class="form-group">
                <label class="required">Address</label>
                <textarea id="form_message" name="address" class="form-control" placeholder="Address" rows="4">{{old('address') }}</textarea>
                @error('address')
                    <span class="error_message">{{$message}}</span>
                @enderror
            </div>

            <div class="form-group">
                <label class="required">Country</label>
                <select class="form-control" name="country" id="country-dropdown"value="{{old('country')}}">
                    <option value="">Select Country</option>
                    @foreach ($countries as $country) 
                        <option value="{{$country->id}}">{{$country->countryname}}</option>
                    @endforeach
                </select>
                @error('country')
                    <span class="error_message">{{$message}}</span>
                @enderror
            </div>

            <div class="form-group">
                <label class="required">State</label>
                <select class="form-control" name="state" id="state-dropdown" value="{{old('state')}}">
                    <option value="">Select State</option>
                </select>
                @error('state')
                    <span class="error_message">{{$message}}</span>
                @enderror
            </div>

            <div class="form-group">
                <label>Comments</label>
                <textarea id="form_message" name="comment" class="form-control" placeholder="Comments" rows="4">{{old('address') }}</textarea>
                @error('comment')
                    <span class="error_message">{{$message}}</span>
                @enderror
            </div>

            <div class="form-group">
                <label class="required">Organization</label>
                <input type="text" placeholder="Organization" class="form-control" name="organization" value="{{old('organization')}}">
                @error('organization')
                    <span class="error_message">{{$message}}</span>
                @enderror
            </div>

            <div class="form-group">
                <label class="required">Captcha</label>
                <input id="captcha" type="text" class="form-control" placeholder="Enter Captcha" name="captcha">
                @error('captcha')
                    <span class="error_message">{{$message}}</span>
                @enderror
                 <div class="captcha">
                    <span>{!! captcha_img() !!}</span>
                    <button type="button" class="btn btn-danger" class="reload" id="reload">
                        &#x21bb;
                    </button>
                </div>
                
            </div>
           

            <div class="form-group">
                <button type="submit" class="btn btn-primary float-right textv">Submit</button><br><br>
            </div>	
    </form>
	<div class="text-center small">Already have an account? <a href="#">Login here</a></div>
</div>
</body>

<script type="text/javascript">
    $('#reload').click(function () {
        $.ajax({
            type: 'GET',
            url: 'reload-captcha',
            success: function (data) {
                $(".captcha span").html(data.captcha);
            }
        });
    });

    $('#country-dropdown').on('change', function() {
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
                    }
                });
        });

    
</script>