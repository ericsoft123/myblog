@extends('layouts.app')
@section('content')

<div class="limiter">

		<div class="container-login100" style="background-image: url('loginfolder/images/bg-012.jpg');">
			<div class="wrap-login100 p-l-55 p-r-55 p-t-65 p-b-54">
				<form class="login100-form validate-form" method="POST" action="{{ route('resend_email') }}">
				{{ csrf_field() }}
					
				<a href="index.html"><span style="visibility:hidden">Back Home</span></a><span class="login100-form-title p-b-49">
				Resend Email
				</span>
                @if (\Session::has('errors'))
				<div class="alert alert-danger alert-dismissible fade show" role="alert">
  <strong>Hi</strong>{!! \Session::get('errors') !!}
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>
@endif
					@if (\Session::has('status'))
				<div class="alert alert-success alert-dismissible fade show" role="alert">
  <strong></strong>{!! \Session::get('status') !!}
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>
@endif
@if (\Session::has('encryptdata'))
					<div class="wrap-input100 validate-input m-b-23 d-none" data-validate = "Username is required">
						<span class="label-input100">Email or Phone</span>
						<input class="input100" type="text" name="email" placeholder="Email or Phone" value="{{\Session::get('encryptdata')}}">
						<span class="focus-input100" data-symbol="&#xf15a;"></span>
				
						<span class="help-block"  style="color:red">
							<strong></strong>
						</span>
                        
					</div>
                    @endif
					


					
					
                    <div class="text-right p-t-8 p-b-31" style="color:blue">
						
					</div>
					
					<div class="container-login100-form-btn">
						<div class="wrap-login100-form-btn">
							<div class="login100-form-bgbtn"></div>
							<button class="login100-form-btn">
								Resend Email
							</button>
						</div>
					</div>
                    <div class="text-right p-t-8 p-b-31" >
						<a href="loginpage" style="color:blue">
						Login
						</a>
					</div>

					

				
				</form>
			</div>
		</div>
	</div>
	
@endsection