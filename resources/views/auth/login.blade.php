@extends('layouts.empty', ['paceTop' => true, 'bodyExtraClass' => 'bg-dark'])

@section('title', 'Login Page')

@section('content')
	<!-- begin login -->
	<div class="login login-with-news-feed">
		<!-- begin news-feed -->
		<div class="news-feed">
			{{-- <div class="news-image" style="background-image: url(https://upload.wikimedia.org/wikipedia/commons/9/93/Kantor_Kelurahan_Telaga_Sari%2C_Balikpapan.jpg)"></div> --}}
			<div class="news-caption">
				<h4 class="caption-title"><b>SIM Notaris (Sistem Informasi Manajemen Notaris)</b> Balikpapan</h4>
				<p>
					<!--Sistem Informasi Data Inovasi Daerah-->
				</p>
			</div>
		</div>
		<!-- end news-feed -->
		<!-- begin right-content -->
		<div class="right-content">
			<!-- begin login-header -->
			<div class="login-header">
				<div class="brand">
				    {{-- <span><img style="max-width:50px; margin-top:-50px;" src="https://sidatabangda.balikpapan.go.id/assets/img/logo/logo_bpn.png" alt=""></span> --}}
					SIM Notaris <b> Balikpapan </b>
				</div>
				{{-- <div class="icon">
					<i class="fa fa-sign-in-alt"></i>
				</div> --}}
			</div>
			<!-- end login-header -->
			<!-- begin login-content -->
			<div class="login-content">
				<form method="POST" class="margin-bottom-0" action="{{ route('login') }}">
				{{ csrf_field() }}

					<div class="form-group m-b-15">
						<!-- <input type="text" class="form-control form-control-lg" placeholder="Email Address" required /> -->
						<input id="username" type="text" class="form-control form-control-lg {{ $errors->has('username') ? ' is-invalid' : '' }}"
                                name="username" value="{{ old('username') }}"  placeholder="Username " required autofocus>
						@if ($errors->has('username'))
						<span class="invalid-feedback">
							<strong>{{ $errors->first('username') ?: $errors->first('username') }}</strong>
						</span>
						@endif
					</div>
					<div class="form-group{{ $errors->has('password') ? ' has-error' : '' }} m-b-15">
						<input id="password" type="password" name="password" class="form-control form-control-lg" placeholder="Password" required />
						@if ($errors->has('password'))
							<span class="help-block">
								<strong>{{ $errors->first('password') }}</strong>
							</span>
						@endif
					</div>
					<!-- <div class="checkbox checkbox-css m-b-30">
						<input type="checkbox" id="remember_me_checkbox" value="" name="remember" {{ old('remember') ? 'checked' : '' }} />
						<label for="remember_me_checkbox">
						Remember Me
						</label>
					</div> -->
					<div class="login-buttons">
						<button type="submit" class="btn btn-teal btn-block btn-lg"> <i class="fa fa-sign-in-alt"></i> Masuk</button>
					</div>
					<div class="m-t-20 m-b-40 p-b-5 text-inverse">
						{{-- Belum Mempunya Akun ? Klik <a href="{{ route('register') }}">Disini</a> Untuk Daftar --}}
						<button type="button" class="btn btn-warning btn-lg"> <i class="fa fa-book"></i> Buku Tamu</button>
						<a href="https://goo.gl/maps/iV1H2maPz7Ajnycq8" target="_blank"><button type="button" class="btn btn-danger btn-lg"> <i class="fa fa-map"></i> Lokasi</button></a>
					</div>
					<!-- <div class="m-t-20 m-b-40 p-b-40 text-inverse">
					 <a href="" target="_blank" class="f-s-20"><i class="fas fa-lg fa-fw m-r-10 fa-cloud-download-alt"></i> Download Document here</a>
					</div> -->
					<hr />
					<p class="text-center text-grey-darker mb-0">
						<a href="https:://pinday.co.id">pinday.co.id</a> &copy; 2020
					</p>
				</form>
			</div>
			<!-- end login-content -->
		</div>
		<!-- end right-container -->
	</div>
	<!-- end login -->
@endsection
