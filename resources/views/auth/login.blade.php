@extends('layouts.empty', ['paceTop' => true, 'bodyExtraClass' => 'bg-dark'])

@section('title', 'Login Page')

@section('content')
	<!-- begin login -->
	<div class="login login-with-news-feed">
		<!-- begin news-feed -->
		<div class="news-feed">
			
			<div class="news-image" style="background-image: url(/assets/img/login-bg/login-bg-7.jpg)"></div>
			<div class="col-md-12 text-white">
				{{-- <h1>title</h1> --}}
			</div>
			<div class="news-caption">
				<h4 class="caption-title"><span><img style="max-width:50px; margin-top:-50px;" src="/assets/img/logo/sigi.png" alt=""></span><b> HSBG PU SIGI</b></h4>
				<p><small>KABUPATEN SIGI</small></p>
			</div>
		</div>
		<!-- end news-feed -->
		<!-- begin right-content -->
		<div class="right-content">
			<!-- begin login-header -->
			<div class="login-header">
				<div class="brand">
				    HSBG PU SIGI
					{{-- SIM Notaris <b> Balikpapan </b> --}}
				</div>
				{{-- <div class="icon">
					<i class="fa fa-sign-in-alt"></i>
				</div> --}}
			</div>
			<!-- end login-header -->
			<!-- begin login-content -->
			<div id="poptamu"></div>
			<div class="login-content" style="margin-top:10px;">
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
						<button type="submit" class="btn btn-danger btn-block btn-lg"> <i class="fa fa-sign-in-alt"></i> Masuk</button>
					</div>
			
					<hr />
					<p class="text-center text-grey-darker mb-0">
						<a href="#">KABUPATEN SIGI</a> &copy; 2023
					</p>
				</form>
			</div>
			<!-- end login-content -->
		</div>
		<!-- end right-container -->
	</div>
	<!-- end login -->
@endsection

@push('scripts')

<script>
	$("#btnbukutamu").click(function(){
		// alert('ok')
		poptamu.option({
			contentTemplate: () => popupContentBukutamu(),
		});
		poptamu.show();
	})

	const popupContentBukutamu = function () {
        // maindata = {};

        // if(daftarid !== undefined) {
        //     $.getJSON(apiurl + "/dokumen/"+daftarid,function(response) {
        //         $.each(response,function(x,y){
        //             maindata[x] = y
        //         })
        //     })
        // }

        const scrollView = $('<div />');

        scrollView.append(
            $("<div id='bukutamuForm'>").dxForm({
                onInitialized: function(e) {
                    dxFormInstance = e.component;
                },
                labelMode : 'floating',
                readOnly: false,
                showColonAfterLabel: true,
                showValidationSummary: false,
                items: [ {
                itemType: 'group',
                caption: '',
                colCount : 1,
                items: [
                    {
                        dataField: 'nama',
                        label: {text: 'Nama'},
                        validationRules: [{type: 'required'}],
                    },
                    {
                        dataField: 'notelp',
                        label: {text: 'No. Telp'},
                        editorType: 'dxNumberBox',
                        validationRules: [{type: 'required'}],
                    }, 
                    {
                        dataField: 'email',
                        label: {text: 'Email'},
                        validationRules: [{type: 'required'},{type: 'email'}],
                    }, 
                    {
                        dataField: 'pesan',
                        label: {text: 'Pesan'},
                        colSpan: 2,
                        editorType: 'dxTextArea',
                        editorOptions: {
                            height: 90
                        },
                        validationRules: [{type: 'required'}],
                    }, 
                    ],
                }],
                
            }),
            $("<hr>"),
            
        );

        scrollView.dxScrollView({
            width: '100%',
            height: '100%',
        })

        return scrollView;

};

const poptamu = $('#poptamu').dxPopup({
    contentTemplate: popupContentBukutamu,
    width: 800,
    height: 500,
    // container: '.content',
    showTitle: true,
    title: 'Buku Tamu',
    visible: false,
    dragEnabled: false,
    hideOnOutsideClick: false,
    showCloseButton: true,
    fullScreen : false,
    toolbarItems: [{
      widget: 'dxButton',
      toolbar: 'bottom',
      location: 'before',
      options: {
        // icon: 'email',
        text: 'Simpan',
        onClick() {
            var valuespr = dxFormInstance.option("formData");
            // valuespr.mode = 'ignore';

            // console.log('from prompt :');
            // console.log(valuespr);
			console.log(valuespr)

            var result = dxFormInstance.validate();
            if(result.isValid) {
                sendRequest(apiurl + "/bukutamu", "POST", valuespr).then(function(response){

                        if(response.status !== 'error') {
							DevExpress.ui.notify("Berhasil Dikirim!", "success");
                        } else {
							DevExpress.ui.notify("Error!", "error");
						}

                });
				poptamu.hide();

            } else {
                DevExpress.ui.dialog.alert("Form Isian belum lengkap!","Error");
            }
        },
      },
    }, {
      widget: 'dxButton',
      toolbar: 'bottom',
      location: 'after',
      options: {
        text: 'Batal',
        onClick() {
          poptamu.hide();
        },
      },
    }],

}).dxPopup('instance');
</script>

@endpush
