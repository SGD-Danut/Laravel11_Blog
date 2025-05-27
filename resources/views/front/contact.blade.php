@extends('front.template.master-page')

@section('current-page-name')
<!-- Banner Starts Here -->
<div class="heading-page header-text">
  <section class="page-heading">
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <div class="text-content">
            <h4>Contacteză-ne</h4>
            <h2>Să păstrăm legătura!</h2>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>
<!-- Banner Ends Here -->
@endsection

@section('content')
<section class="contact-us">
  <div class="container">
    <div class="row">
    
      <div class="col-lg-12">
        <div class="down-contact">
          <div class="row">
            <div class="col-lg-8">
              <div class="sidebar-item contact-form">
                @include('admin.template.parts.messages')
                <div class="sidebar-heading">
                  <h2>Send us a message</h2>
                </div>
                <div class="content">
                  <form id="contact" action="{{ route('front.create-new-contact-message') }}" method="post">
                    @csrf
                    <div class="row">
                      <div class="col-md-6 col-sm-12">
                        <fieldset>
                          <input name="name" type="text" id="name" placeholder="Your name" required="">
                        </fieldset>
                      </div>
                      <div class="col-md-6 col-sm-12">
                        <fieldset>
                          <input name="email" type="text" id="email" placeholder="Your email" required="">
                        </fieldset>
                      </div>
                      <div class="col-md-12 col-sm-12">
                        <fieldset>
                          <input name="subject" type="text" id="subject" placeholder="Subject">
                        </fieldset>
                      </div>
                      <div class="col-lg-12">
                        <fieldset>
                          <select name="category" class="form-select" aria-label="Default select example">
                            <option selected>Alege o categorie</option>
                            <option value="general">General</option>
                            <option value="tehnic">Tehnic</option>
                            <option value="despre-postari">Despre postări</option>
                          </select>
                        </fieldset>
                      </div>
                      <div class="col-lg-12">
                        <fieldset>
                          <textarea name="message" rows="6" id="message" placeholder="Your Message" required=""></textarea>
                        </fieldset>
                      </div>
                      <div class="col-md-2 col-sm-4">
                        <fieldset>
                          <label for="accept-terms"><strong>Accept termenii și condițiile.</strong></label>
                          <input class="accept-terms" name="accept-terms" type="checkbox" id="accept-terms" value="true" required>
                        </fieldset>
                      </div>
                      <div class="col-lg-12">
                        <fieldset>
                          <button type="submit" id="form-submit" class="main-button">Send Message</button>
                        </fieldset>
                      </div>
                    </div>
                  </form>
                </div>
              </div>
            </div>
            <div class="col-lg-4">
              <div class="sidebar-item contact-information">
                <div class="sidebar-heading">
                  <h2>contact information</h2>
                </div>
                <div class="content">
                  <ul>
                    <li>
                      <h5>090-484-8080</h5>
                      <span>PHONE NUMBER</span>
                    </li>
                    <li>
                      <h5>info@company.com</h5>
                      <span>EMAIL ADDRESS</span>
                    </li>
                    <li>
                      <h5>123 Aenean id posuere dui, 
                        <br>Praesent laoreet 10660</h5>
                      <span>STREET ADDRESS</span>
                    </li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      
      <div class="col-lg-12">
        <div id="map">
          <iframe src="https://maps.google.com/maps?q=Av.+L%C3%BAcio+Costa,+Rio+de+Janeiro+-+RJ,+Brazil&t=&z=13&ie=UTF8&iwloc=&output=embed" width="100%" height="450px" frameborder="0" style="border:0" allowfullscreen></iframe>
        </div>
      </div>
      
    </div>
  </div>
</section>
@endsection