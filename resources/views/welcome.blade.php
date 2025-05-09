@extends('layouts.master')

@section('title', 'Welcome')

@section('style')
.container {
  max-width: 960px;
}
@endsection

@section('content')
<div class="container">
    <div class="py-5 text-center">
      <svg class="bi" width="100" height="100"><use xlink:href="#build"/></svg>
      <h2>Enrollment form</h2>
      <p class="lead">A "toy" form that does not work for registration. It's an use example about read data from database and put it in a <code>HTML select</code> element.</p>
    </div>

    <div class="row g-5">
      <div class="col-md-5 col-lg-4 order-md-last">
        <h4 class="d-flex justify-content-between align-items-center mb-3">
          <span class="text-primary">Our benefits</span>
          <span class="badge bg-primary rounded-pill"><i class="fas fa-clipboard-list"></i> </span>
        </h4>
        <ul class="list-group mb-3">
          <li class="list-group-item d-flex justify-content-between lh-sm">
            <div>
              <h6 class="my-0">Personal attention</h6>
              <small class="text-body-secondary"> </small>
            </div>
            <span class="badge bg-success rounded-pill"><i class="far fa-life-ring"></i> </span>
          </li>
          <li class="list-group-item d-flex justify-content-between lh-sm">
            <div>
              <h6 class="my-0">You are our priority</h6>
              <small class="text-body-secondary"></small>
            </div>
            <span class="badge bg-success rounded-pill"> <i class="fas fa-user-friends"></i></span>
          </li>
          <li class="list-group-item d-flex justify-content-between lh-sm">
            <div>
              <h6 class="my-0">We offer great experiencies</h6>
              <small class="text-body-secondary"> </small>
            </div>
            <span class="badge bg-success rounded-pill"><i class="fas fa-child"></i> </span>
          </li>
          <li class="list-group-item d-flex justify-content-between bg-body-tertiary">
            <div class="text-success">
              <h6 class="my-0">We are the best</h6>
              <small>With 25 years off experience</small>
            </div>
            <span class=" text-warning "> <i class="fas fa-trophy fa-3x"></i></span>
          </li>
        </ul>

      </div>
      <div class="col-md-7 col-lg-8">
        <h4 class="mb-3">You can enter your information below</h4>
        <form class="needs-validation" novalidate>
          <div class="row g-3">
            <div class="col-sm-6">
              <label for="firstName" class="form-label">First name</label>
              <input type="text" class="form-control" id="firstName" placeholder="" value="" required>
              <div class="invalid-feedback">
                Valid first name is required.
              </div>
            </div>

            <div class="col-sm-6">
              <label for="lastName" class="form-label">Last name</label>
              <input type="text" class="form-control" id="lastName" placeholder="" value="" required>
              <div class="invalid-feedback">
                Valid last name is required.
              </div>
            </div>

            <div class="col-12">
              <label for="email" class="form-label">Email <span class="text-body-secondary">(Optional)</span></label>
              <input type="email" class="form-control" id="email" placeholder="you@example.com" required>
              <div class="invalid-feedback">
                Please enter a valid email address for updates.
              </div>
            </div>

            <div class="col-12">
              <label for="address" class="form-label">Address</label>
              <input type="text" class="form-control" id="address" placeholder="1234 Main St" required>
              <div class="invalid-feedback">
                Please enter your shipping address.
              </div>
            </div>

            <div class="col-12">
              <label for="address2" class="form-label">Address 2 <span class="text-body-secondary">(Optional)</span></label>
              <input type="text" class="form-control" id="address2" placeholder="Apartment or suite">
            </div>
            @php
              $helperPluck = pluckDBSelectOptions('campuses_select_options');
              $campuses = $helperPluck['data'];
              $placeholder = $helperPluck['placeholder'];
            @endphp
            
            
            <div class="col-md-4">
              <label for="campus" class="form-label text-danger">Campus</label>
              <select class="form-select" id="campus" required>
                <option value="">{{$placeholder}}</option>
                @foreach($campuses as $key=>$value)
                  <option value="{{$key}}">{{$value}}</option>
                @endforeach
              </select>
              <div class="invalid-feedback">
                Please select a valid campus.
              </div>
            </div>

            <div class="col-md-4">
              <label for="way" class="form-label text-primary">Student type</label>
              <select class="form-select" id="way" required>
                <option value="">Choose...</option>
                <option>Part-time student</option>
                <option>Full-time student</option>
              </select>
              <div class="invalid-feedback">
                Please select one.
              </div>
            </div>

            
          </div>

          <hr class="my-4">

          <div class="form-check">
            <input type="checkbox" class="form-check-input" id="terms-conditions" required>
            <label class="form-check-label" for="terms-conditions">I accept terms and conditions</label>
            <div class="invalid-feedback">
                Please accept terms and conditions.
            </div>
          </div>

          

          <hr class="my-4">

          <button class="w-100 btn btn-primary btn-lg" type="submit">Continue</button>
        </form>
      </div>
    </div>
</div>
@endsection
@section('script')
<script>
    // Example starter JavaScript for disabling form submissions if there are invalid fields
    (() => {
    'use strict'

    // Fetch all the forms we want to apply custom Bootstrap validation styles to
    const forms = document.querySelectorAll('.needs-validation')

    // Loop over them and prevent submission
    Array.from(forms).forEach(form => {
        form.addEventListener('submit', event => {
        if (!form.checkValidity()) {
            event.preventDefault()
            event.stopPropagation()
        }

        form.classList.add('was-validated')
        }, false)
    })
    })()
</script>
@endsection