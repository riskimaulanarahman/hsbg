@extends('layouts.empty', ['paceTop' => true, 'bodyExtraClass' => 'bg-dark'])

@section('title', 'Login Page')

@section('content')
	<!-- begin login -->
	<div class="login login-with-news-feed">
		<!-- begin news-feed -->
		<div class="news-feed">
			
			<div class="news-image" style="background-image: url(/assets/img/newbglogin.jpg)"></div>
			<div class="note note-with-end-icon mb-2" style="background-color: rgba(255, 255, 255, 0.6);">
				<div class="note-content text-black" style="font-size: 16px">
					<h4><b>Salam Hangat!</b></h4>
					<p>
						Selamat datang di website Kantor Notaris dan PPAT Nurvida Shanti.
					</p>
					<p>
						Website ini kami disajikan untuk dapat membantu memberikan informasi praktis secara online mengenai hal-hal yang berhubungan dengan pelayanan jasa Notaris dan PPAT (Pejabat Pembuat Akta Tanah) dari kantor kami.
					</p>
					<p>
						Disediakan pula beberapa tautan yang dapat diunduh sebagai bahan bacaan, yaitu terkait hal-hal yang paling sering dibutuhkan oleh klien selama pengurusan di kantor kami yaitu:
						<ul>
							<li>Apa saja yang wajib dan/atau disarankan dibuat dalam Akta Notaris dan apa saja yang wajib dan/atau disarankan dibuat dalam Akta PPAT.</li> 
							<li>Persyaratan Pendirian: Perseroan Terbatas (PT), Yayasan, Perkumpulan dan CV.
							<li>Persyaratan atas hal-hal yang terkait dengan Pertanahan: Jual Beli, Hibah, Sewa Menyewa, dll.</li>
							<li>Beberapa artikel yang bersifat informasi praktis mengenai hukum dan layanan kantor Notaris dan PPAT.</li>
						</ul>
					<p>	Untuk hal-hal lain yang tidak ditemukan pada tautan dan artikel yang kami sediakan di website ini, atau ingin menanyakan informasi lebih lanjut, tinggalkan pesan di “Buku Tamu” dengan mengisi nama, email dan pesan. Notaris atau Legal Officer kantor kami akan membantu membalas pesan Bapak / Ibu.</p>
						Hormat Kami,<br>
						{{-- Kantor Notaris dan PPAT Nurvida Shanti --}}
					</p>
				</div>
				<div class="note-icon"><i class="fa fa-lightbulb"></i></div>
			</div>
			<div class="col-md-12 text-white">
				{{-- <h1>title</h1> --}}
			</div>
			<div class="news-caption">
				<h4 class="caption-title">NOTARIS & PPAT</h4>
				<h4 class="caption-title"><b>Nurvida Shanti, S.H.,M.Kn.</b></h4>
				<small>Jln. RE Martadinata No.22 RT.037 Telaga Sari Kota Balikpapan</small>
				<p><small>Telp. 081 330 669 686</small></p>
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
			<div id="poptamu"></div>
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
						<button type="button" id="btnbukutamu" class="btn btn-warning btn-lg"> <i class="fa fa-book"></i> Buku Tamu</button>
						<a href="https://goo.gl/maps/iV1H2maPz7Ajnycq8" target="_blank"><button type="button" class="btn btn-danger btn-lg"> <i class="fa fa-map"></i> Lokasi</button></a>
					</div>
					<div class="m-t-20 m-b-40 p-b-40 text-inverse">
						<a href="https://drive.google.com/file/d/13BYeb2GZ0YNbJbnbRaK9tJsyCeJcofkK/view?usp=sharing" target="_blank" class="f-s-20"><i class="fas fa-lg fa-fw m-r-10 fa-cloud-download-alt"></i> Download Document here</a>
					</div>
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
                        dataField: 'nama_tamu',
                        label: {text: 'Nama'},
                        validationRules: [{type: 'required'}],
                    },
                    {
                        dataField: 'notelp_tamu',
                        label: {text: 'No. Telp'},
                        editorType: 'dxNumberBox',
                        validationRules: [{type: 'required'}],
                    }, 
                    {
                        dataField: 'email_tamu',
                        label: {text: 'Email'},
                        validationRules: [{type: 'required'}],
                    }, 
                    {
                        dataField: 'pesan_tamu',
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

            var result = dxFormInstance.validate();
            if(result.isValid) {
                // sendRequest(apiurl + "/dokumen", "POST", valuespr).then(function(response){

                //     dataGrid.refresh();
                        
                //     setTimeout(() => {
                //         if(response.status !== 'error') {
                //             $('#btndaftarid'+response.data.id).trigger('click')
                //         }
                //     }, 5000);

                // });
                // DevExpress.ui.dialog.alert("ok","Success");
				DevExpress.ui.notify("Berhasil Dikirim!", "success");
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
