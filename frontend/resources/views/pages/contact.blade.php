@extends('layouts.app')
@section('content')

    <!--End header-->
    <main class="main pages">
        <div class="page-header breadcrumb-wrap">
            <div class="container">
                <div class="breadcrumb">
                    <a href="{{ route('index') }}" rel="nofollow"><i class="fi-rs-home mr-5"></i>Home</a>
                    <span></span> Contact
                </div>
            </div>
        </div>
        <div class="page-content py-3">           
            <div class="container">
               <div class="row">
                <div class="col-xl-6">
                    <div class="contact-from-area padding-20-row-col">
                        <h5 class="text-brand mb-2">Contact form</h5>
                        <!-- <h2 class="mb-10">Drop Us a Line</h2>
                        <p class="text-muted mb-30 font-sm">Your email address will not be published. Required fields are marked *</p> -->

                        @if(session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        @if(session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @endif

                        <form class="contact-form-style mt-2" id="contact-form" action="{{ route('pages.contact.store') }}" method="post" novalidate>
                            @csrf
                            <div class="row m-0 p-0">
                                <div class="col-lg-6 col-xs-12 p-0 mb-3">
                                    <input name="name" id="name" class="form-control mb-1" placeholder="Name" type="text" value="{{ old('name') }}" required />
                                    <small class="text-danger d-none" id="nameError">Name is required</small>
                                    @error('name') <small class="text-danger">{{ $message }}</small> @enderror
                                </div>
                                <div class="col-lg-6 col-xs-12 p-0 mb-3">
                                    <input name="email" id="email" class="form-control mb-1" placeholder="Your Email" type="email" value="{{ old('email') }}" required />   
                                    <small class="text-danger d-none" id="emailError">Email is required</small>
                                    @error('email') <small class="text-danger">{{ $message }}</small> @enderror
                                </div>
                                <div class="col-lg-12 col-xs-12 p-0 mb-3">
                                    <input name="telephone" id="telephone" class="form-control mb-1" placeholder="Mobile Number" type="text" value="{{ old('telephone') }}" required minlength="10" maxlength="10" oninput="this.value=this.value.replace(/[^0-9]/g,'')" />
                                    <small class="text-danger d-none" id="telephoneError">Mobile number must be 10 digits</small>
                                    @error('telephone') <small class="text-danger">{{ $message }}</small> @enderror
                                </div>
                            </div>
                            <div class="row m-0 p-0">
                                <div class="col-12 p-0 mb-3">
                                    <textarea style="height:150px;" name="message" id="message" class="form-control mb-1" placeholder="Message" required>{{ old('message') }}</textarea>                                    
                                    <small class="text-danger d-none" id="messageError">Message is required</small>
                                    @error('message') <small class="text-danger">{{ $message }}</small> @enderror
                                </div>
                                <button class="submit submit-auto-width col-xs-12 mb-2" type="submit"><img src="{{ asset('assets/imgs/theme/icons/icon-email-2.svg') }} "
                                    alt="" /> Send message</button>
                                </div>
                        </form>
                        <script>
                            document.getElementById('contact-form').addEventListener('submit', function (e) {
                                e.preventDefault();
                                
                                let valid = true;
                                function check(id, errorId, condition) {
                                    let input = document.getElementById(id);
                                    let error = document.getElementById(errorId);
                                    if (condition || !input.value.trim()) {
                                        error.classList.remove('d-none');
                                        valid = false;
                                    } else {
                                        error.classList.add('d-none');
                                    }
                                }

                                check('name', 'nameError');
                                check('email', 'emailError');
                                check('telephone', 'telephoneError', document.getElementById('telephone').value.length !== 10);
                                check('message', 'messageError');

                                if (!valid) return;

                                const form = this;
                                const formData = new FormData(form);
                                const btn = form.querySelector('button[type="submit"]');
                                const originalBtnText = btn.innerHTML;

                                btn.disabled = true;
                                btn.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Sending...';

                                fetch(form.action, {
                                    method: 'POST',
                                    headers: {
                                        'X-Requested-With': 'XMLHttpRequest',
                                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                                    },
                                    body: formData
                                })
                                .then(response => response.json())
                                .then(data => {
                                    btn.disabled = false;
                                    btn.innerHTML = originalBtnText;

                                    if (data.success) {
                                        if (typeof toastr !== 'undefined') {
                                            toastr.success(data.message);
                                        } else {
                                            alert(data.message);
                                        }
                                        form.reset();
                                        // Hide all error messages after successful submission
                                        document.querySelectorAll('.text-danger').forEach(el => el.classList.add('d-none'));
                                    } else {
                                        if (typeof toastr !== 'undefined') {
                                            toastr.error(data.message || 'Something went wrong');
                                        } else {
                                            alert(data.message || 'Something went wrong');
                                        }
                                    }
                                })
                                .catch(error => {
                                    btn.disabled = false;
                                    btn.innerHTML = originalBtnText;
                                    console.error('Error:', error);
                                    if (typeof toastr !== 'undefined') {
                                        toastr.error('Failed to send message. Please try again.');
                                    } else {
                                        alert('Failed to send message. Please try again.');
                                    }
                                });
                            });
                        </script>
                        <p class="form-messege"></p>
                    </div>
                </div>
                <div class="col-lg-6 d-lg-block d-none">
                    <!-- <div class="col-md-4 mb-4 mb-md-0"> -->
                    
                    <h5 class="mb-2 text-brand">Corporate Office</h5>
                    <p class="d-flex align-items-center"><img src="{{ asset('assets/imgs/theme/icons/icon-location.svg') }} "
                                    alt="" style="height:25px; padding-right:15px;" /> New # 15/Old # 8,
                    Muthu Street, Mylapore,<br />
                    Chennai - 600004<br />
                    </p>
                    <p class="d-flex align-items-center"><img src="{{ asset('assets/imgs/theme/icons/icon-contact.svg') }} "
                                    alt="" style="height:25px; padding-right:15px;"/> +91 90946 76665</p>
                    <p class="d-flex align-items-center"><img src="{{ asset('assets/imgs/theme/icons/icon-email-2.svg') }} "
                                    alt="" style="height:25px; padding-right:15px;"/> care@chennaiangadi.com</p>
                    <!-- <abbr title="Phone">Phone:</abbr> <a href="tel:+919094676665"></a> <br />
                    <abbr title="Email">Email: </abbr> <a href="mailto:care@chennaiangadi.com">care@chennaiangadi.com</a> <br /> -->
                    <!-- <a class="btn btn-sm font-weight-bold text-white mt-20 border-radius-5 btn-shadow-brand hover-up"><i class="fi-rs-marker mr-5"></i>View map</a> -->
                    <!-- <img class="border-radius-15 mt-50" src="{{ asset('assets/imgs/images/contact-img.jpg') }}" alt="contact image" /> -->
                     <div class="row m-0 p-0">
                        <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d15548.328816782998!2d80.27582400000001!3d13.030437!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3a5267d8a17c2b43%3A0xcd08e1f34cff3789!2swww.chennaiangadi.com!5e0!3m2!1sen!2sus!4v1774459857777!5m2!1sen!2sus" width="100%" height="300" style="border:0; padding-left:0; padding-top:15px;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                     </div>
                </div>
               </div>                  
            </div>
        </div>
    </main>
  @endsection