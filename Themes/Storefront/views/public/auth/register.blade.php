@extends('public.layout')

@section('title', trans('user::auth.register'))

@section('content')

    <section class="form-wrap register-wrap">
        <div class="container">
            <div class="form-wrap-inner register-wrap-inner">
                <h2>{{ trans('user::auth.register') }}</h2>

                <form method="POST" action="{{ route('register.post') }}">
                    @csrf
                <div class="tab" style="display: none;">
                    <div class="form-group">
                        <label for="first-name">
                            {{ trans('user::auth.first_name') }}<span>*</span>
                        </label>

                        <input type="text" name="first_name" value="{{ old('first_name') }}" id="first-name" class="form-control">

                        @error('first_name')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="last-name">
                            {{ trans('user::auth.last_name') }}<span>*</span>
                        </label>

                        <input type="text" name="last_name" value="{{ old('last_name') }}" id="last-name" class="form-control">

                        @error('last_name')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="email">
                            {{ trans('user::auth.email') }}<span>*</span>
                        </label>

                        <input type="text" name="email" value="{{ old('email') }}" id="email" class="form-control">

                        @error('email')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>
                    
                    <!-- New Field -->
                    <div class="form-group">
                        <label for="mobile_number">
                            {{ trans('user::auth.phone') }}<span>*</span>
                        </label>

                        <input type="text" name="mobile_number" value="{{ old('mobile_number') }}" id="mobile_number" class="form-control">

                        @error('mobile_number')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- New Field -->
                    <div class="form-group">
                        <label for="nid">
                            {{ trans('user::auth.national_id') }}<span>*</span>
                        </label>

                        <input type="text" name="national_id" value="{{ old('national_id') }}" id="national_id" class="form-control">

                        @error('national_id')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="password">
                            {{ trans('user::auth.password') }}<span>*</span>
                        </label>

                        <input type="password" name="password" id="password" class="form-control">

                        @error('password')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>
                    

                    <div class="form-group">
                        <label for="confirm-password">
                            {{ trans('user::auth.confirm_password') }}<span>*</span>
                        </label>

                        <input type="password" name="password_confirmation" id="confirm-password" class="form-control">

                        @error('password_confirmation')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>
                    
                    <!-- New Field -->
                    <div class="form-group">
                        <label for="code">
                            {{ trans('user::auth.code') }}<span>*</span>
                        </label>

                        <input type="text" name="code" value="<?= ( (isset($_GET['code']) )? $_GET['code'] : $default_code )  ?>"  id="code" class="form-control">

                        @error('code')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="tab" style="display: none;">
                    <h5 style="padding-bottom: 20px;">To Protecting Your Money During The Withdrawal Process You Answer The Question and enter The Pin</h5>
                    
                    
                    <!-- New Field -->
                    <div class="form-group">
                        <label for="pin">
                            {{ trans('user::auth.pin') }}<span>*</span>
                        </label>

                        <input type="text" name="pin" value="{{ old('pin') }}" id="pin" class="form-control">

                        @error('pin')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>
                    
                    <!-- New Field -->
                    <div class="form-group">
                        <label for="question">
                            {{ trans('user::auth.question') }}<span>*</span>
                        </label>

                        <input type="text" name="question" value="{{ old('question') }}" id="question" class="form-control">

                        @error('question')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>
                    
                    <!-- New Field -->
                    <div class="form-group">
                        <label for="answer">
                            {{ trans('user::auth.answer') }}<span>*</span>
                        </label>

                        <input type="text" name="answer" value="{{ old('answer') }}" id="answer" class="form-control">

                        @error('answer')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="tab" style="display: none;">
                    <h5 style="padding-bottom: 20px;">Select The Amount of Your Annual Subscription In order To Recieve The Commision Money</h5>
                    
                     <div class="form-group">
                        <label for="answer">
                            Choose Your Currency<span>*</span>
                        </label>
                    <!-- New Field -->
                        <select name="subscription" id="subscription" class="form-control arrow-black">
                            @foreach($plans as $currencie)
                                <option value="{{ $currencie->id }}">{{ $currencie->currency }}</option>
                            @endforeach 
                        </select>
                        @error('subscription')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>
                    
                    <!-- <h5 style="padding-bottom: 20px;">Select method you prefer to withdraw your money</h5> -->
                        
                    <!-- New Field -->
                    <!-- <div class="form-group">
                        <label for="answer">
                            Select Method<span>*</span>
                        </label>

                        <select name="withdraw_method" id="withdraw_method" class="form-control arrow-black">
                            @foreach($withdraws_methods as $withdraws_method)
                                <option value="{{ $withdraws_method->id }}">{{ $withdraws_method->name}}</option>
                            @endforeach 
                        </select>

                        @error('withdraw_method')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div> -->
                    
                    <!-- <div class="form-group">
                        <label for="answer">
                            Withdraw Field<span>*</span>
                        </label>

                        <input type="text" name="withdraw_main_field_value" value="{{ old('withdraw_main_field_value') }}" id="withdraw_main_field_value" class="form-control">

                        @error('withdraw_main_field_value')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div> -->
                    
                    <!-- <div class="form-group">
                        <label for="answer">
                            Withdraw Description<span>*</span>
                        </label>

                        <textarea class="form-control" name="withdraw_description">{{ old('withdraw_description') }}</textarea>
                        @error('withdraw_description')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div> -->
                    <div class="form-check terms-and-conditions">
                        <input type="hidden" name="privacy_policy" value="0">
                        <input type="checkbox" name="privacy_policy" value="1" id="terms" {{ old('privacy_policy', false) ? 'checked' : '' }}>

                        <label for="terms" class="form-check-label">
                            {{ trans('user::auth.i_agree_to_the') }} <a href="{{ $privacyPageUrl }}">{{ trans('user::auth.privacy_policy') }}</a>
                        </label>

                        @error('privacy_policy')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                    
 

                    <!--<div class="form-group p-t-5">-->
                    <!--    @captcha-->
                    <!--    <input type="text" name="captcha" id="captcha" class="captcha-input" placeholder="{{ trans('storefront::layout.enter_captcha_code') }}">-->

                    <!--    @error('captcha')-->
                    <!--        <span class="error-message">{{ $message }}</span>-->
                    <!--    @enderror-->
                    <!--</div>-->

              

                    <div style="overflow:auto;">
                        <div style="float:right;    display: -webkit-inline-box;">
                            <button type="button" id="prevBtn" style="margin-left:15px;background-color:#0055B8;color:white" class="btn  btn-create-account" onclick="nextPrev(-1)">{{ trans('user::auth.previous') }}</button>
                            <button type="button" id="nextBtn" style="margin-left:15px;background-color:#0055B8;color:white" class="btn  btn-create-account" onclick="nextPrev(1)"> {{ trans('user::auth.pext') }} </button>
                            <button type="submit"  id="submitbtn" style="margin-left:15px;background-color:#0055B8;color:white;display:none" class="btn  btn-create-account" > {{ trans('user::auth.submit') }} </button>
                        </div>
                    </div>

<!-- Circles which indicates the steps of the form: -->
                <div style="text-align:center;margin-top:40px;">
                <span class="step"></span>
                <span class="step"></span>
                <span class="step"></span>
                </div>
        </form>

                @include('public.auth.partials.social_login')

                <span class="have-an-account">
                    {{ trans('user::auth.already_have_an_account') }}
                </span>

                <a href="{{ route('login') }}" class="btn btn-default btn-sign-in">
                    {{ trans('user::auth.sign_in') }}
                </a>
            </div>
        </div>
        <input type="hidden" name=""  id="testscript" value="asasd">
    </section>
   
   
    <script>
var currentTab = 0; // Current tab is set to be the first tab (0)
showTab(currentTab); // Display the current tab

function showTab(n) {
  // This function will display the specified tab of the form ...
  var x = document.getElementsByClassName("tab");
  x[n].style.display = "block";
  // ... and fix the Previous/Next buttons:
  if (n == 0) {
    document.getElementById("prevBtn").style.display = "none";
  } else {
    document.getElementById("prevBtn").style.display = "inline";
  }

  if (n == (x.length - 1)) {
    document.getElementById("nextBtn").style.display = "none";
    document.getElementById("submitbtn").style.display = "block";
  } else {
    document.getElementById("nextBtn").style.display = "block";
    document.getElementById("submitbtn").style.display = "none";
    document.getElementById("nextBtn").innerHTML = "Next";
  }
  // ... and run a function that displays the correct step indicator:
  fixStepIndicator(n)
}

function nextPrev(n) {
  // This function will figure out which tab to display
  var x = document.getElementsByClassName("tab");
  // Exit the function if any field in the current tab is invalid:
  if (n == 1 && !validateForm()) return false;
  // Hide the current tab:
  x[currentTab].style.display = "none";
  // Increase or decrease the current tab by 1:
  currentTab = currentTab + n;
  // if you have reached the end of the form... :
  if (currentTab >= x.length) {
    //...the form gets submitted:
    document.getElementById("regForm").submit();
    return false;
  }
  // Otherwise, display the correct tab:
  showTab(currentTab);
}

function validateForm() {
  // This function deals with validation of the form fields
  var x, y, i, valid = true;
  x = document.getElementsByClassName("tab");
  y = x[currentTab].getElementsByTagName("input");
  // A loop that checks every input field in the current tab:
  for (i = 0; i < y.length; i++) {
    // If a field is empty...
    if (y[i].value == "") {
      // add an "invalid" class to the field:
      y[i].className += " invalid";
      // and set the current valid status to false:
      valid = false;
    }
  }
  // If the valid status is true, mark the step as finished and valid:
  if (valid) {
    document.getElementsByClassName("step")[currentTab].className += " finish";
  }
  return valid; // return the valid status
}

function fixStepIndicator(n) {
  // This function removes the "active" class of all steps...
  var i, x = document.getElementsByClassName("step");
  for (i = 0; i < x.length; i++) {
    x[i].className = x[i].className.replace(" active", "");
  }
  //... and adds the "active" class to the current step:
  x[n].className += " active";
}
</script>

@endsection
