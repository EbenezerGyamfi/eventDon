 <section class="row* mx-auto justify-content-center* pt-5 mt-5" id="inTouch">
     <div class="col-6 position-relative d-none d-lg-block">
         <h2 class="position-relative head mx-5">We’d Love to hear from you</h2>

         <img class="img-fluid people" src="{{ asset('img/person-email.png') }}" alt="People" />
     </div>


     <div class="pt-xl-5* col-6">
         <form id="sendMessage" action="{{ route('send.message') }}" method="post"
             class="pt-lg-5 mt-lg-5 mb-5 mb-lg-0 pb-3 rounded intouch-form col-10 col-md-9 col-lg-11 p-5 p-lg-0 mx-auto mx-lg-0 row">
             @csrf
             <h2 class="fw-bolder pt-lg-5 mt-lg-5 pb-2 moreButton text-center">Get In Touch</h2>

             <div class="mt-2* mt-xl-5 p-3 p-lg-0 ">
                 <input required type="email" class="form-control border-start-0 border-end-0 border-top-0"
                     name="email" placeholder="Email" />
             </div>


             <div class="mt-4 mt-xl-5 p-3 p-lg-0 ">
                 <input required type="text" class="form-control border-start-0 border-end-0 border-top-0"
                     name="name" placeholder="Name" />
             </div>

             <div class="mt-4 mt-xl-5 p-3 p-lg-0 ">
                 <input required type="tel" class="form-control border-start-0 border-end-0 border-top-0"
                     name="phone" placeholder="Phone Number" />
             </div>

             <div class="mt-4 mt-xl-5 ">
                 <textarea required class="form-control border-start-0 border-end-0 border-top-0" name="message"
                     id="exampleFormControlTextarea1" placeholder="Message"></textarea>
             </div>

             <div class="mx-auto text-center mt-4 mt-xl-5">
                 <button type="submit" class="pt-2 moreButton deepOrange">
                     Send Message <i class="bi deepOrange bi-arrow-right"></i>
                 </button>
             </div>


         </form>
     </div>
 </section>



 @push('scripts')
     <script>
         var sendEmail = $('#sendMessage');
         console.log(sendEmail);
         sendEmail.on('submit', function() {
             event.preventDefault();

             $.ajax({
                     url: '/send/message',
                     method: 'POST',
                     cache: false,
                     contentType: false,
                     processData: false,
                     dataType: 'json',
                     data: new FormData(sendEmail[0])

                 })
                 .done(function(data) {

                     Swal.fire({
                         title: 'Message sent successfully',
                         icon: 'success',
                         showConfirmButton: true
                     });

                     sendEmail[0].reset();

                 })
                 .fail(function(xhr) {
                     let response = xhr.responseJSON;

                     if (response.errors) {
                         Swal.fire({
                             title: 'An error occurred',
                             text: response.errors.code[0],
                             icon: 'error',
                             toast: true,
                             position: 'top-end',
                             showCloseButton: true,
                             showConfirmButton: false
                         });
                     }
                 })

         });
     </script>
 @endpush
