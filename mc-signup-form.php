<?php
/*
Script:        MailChimp Signup Form w/ Cookies
Description:   Shows MailChimp Signup Form for non-members. Uses cookies to
               store data. If cookie is found, no signup form appears. If no
               cookie is found, then signup form appears. Contains subscribe
               form and a form to check the user's susbcription if the user is
               already subscribed.
Script URI:    https://github.com/bfa/mc-signup-form
Author:        Brent Alexander
Author URI:    http://www.bfa.me
Author Email:  brent@bfa.me
Last Updated:  3/5/2016
Version:       1.0
*/
?>
<!-- Begin MailChimp Signup Form -->
<style type="text/css">
   .blur {
      filter: blur(10px);/
      -webkit-filter: blur(10px);
      -moz-filter: blur(10px);
      -o-filter: blur(10px);
      -ms-filter: blur(10px);
      filter: progid:DXImageTransform.Microsoft.Blur(PixelRadius='10');
      -webkit-transition: all 100ms ease;
      -moz-transition: all 100ms ease;
      -o-transition: all 100ms ease;
      transition: all 100ms ease;
   }
   #mc_embed_signup{
      display: none;
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      font-family: 'proxima-nova',sans-serif;
      letter-spacing: 0;
   }
   #mc_embed_signup .mc-modal-bg {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: #000;
      opacity: 0.8;
      z-index: -1;
   }
   #mc_embed_signup .mc-modal {
      position: absolute;
      top: 10%;
      left: 50%;
      margin-left: -160px;
      padding: 1em;
      background: rgb(248, 248, 248);
      width: 320px;
      max-height: 80%;
      overflow: scroll;
   }
   .mc-modal h1 {
      margin: 0;
      font-family: "minion-pro",serif;
      text-transform: none;
      font-size: 34px;
      font-weight: 400;
      letter-spacing: 0px;
      font-style: italic;
   }
   #mc_embed_signup label {
      display: block;
      margin-top: 0.25em;
      text-align: left;
      font-size: 0.75em;
      font-weight: bold;
      text-transform: uppercase;
      color: rgba(0,0,0,.25);
   }
   #mc_embed_signup .asterisk {
      color: #dbe11f;
      font-weight: bold;
      font-size: 2em;
      position: relative;
      top: 0.375em;
   }
   #mc_embed_signup input[type=text],
   #mc_embed_signup input[type=email] {
      background: rgba(0,0,0,.1);
      margin-top: 0.125em;
      padding: 0.5em;
      width: 100%;
      font-size: 1.25em;
      font-weight: 200;
      box-sizing: border-box;
      border: 0;
   }
   #mc_embed_signup input[type=text]:focus,
   #mc_embed_signup input[type=email]:focus,
   #mc_embed_signup input[type=text]:active,
   #mc_embed_signup input[type=email]:active {
      outline: none;
      background: rgba(0,0,0,.2);
   }
   #mc_embed_signup .phonearea input {
      float: left;
      margin-right: 2.5%;
      width: 25%;
   }
   #mc_embed_signup .phonedetail1 input {
      float: left;
      margin-right: 2.5%;
      width: 25%;
   }
   #mc_embed_signup .phonedetail2 input {
      float: left;
      width: 45%;
   }
   #mc_embed_signup input[type=button],
   #mc_embed_signup input[type=submit],
   #mc_embed_signup a.button {
      margin-top: 2em;
      margin-right: 1em;
      display: inline-block;
      background: #dbe11f;
      line-height: 1;
      padding: 1em 0.6em 1em 0.8em;
      color: #111;
      text-transform: uppercase;
      position: relative;
      text-decoration: none;
      border: 1px solid #dbe11f;
      font-family: "proxima-nova",sans-serif;
      font-weight: 700;
      font-size: 0.825rem;
      letter-spacing: 4px;
      -webkit-transition: all 200ms ease;
      -moz-transition: all 200ms ease;
      -o-transition: all 200ms ease;
      transition: all 200ms ease;
      max-width: 50%;
      box-sizing: border-box;
      font-style: normal;
      opacity: 1;
   }
   #mc_embed_signup input[type=button]:hover,
   #mc_embed_signup input[type=submit]:hover,
   #mc_embed_signup a.button:hover {
      background: transparent;
      border-color: #dbe11f;
   }
   #mc_embed_signup input[type=button]:focus,
   #mc_embed_signup input[type=submit]:focus,
   #mc_embed_signup a.button:focus,
   #mc_embed_signup input[type=button]:active,
   #mc_embed_signup input[type=submit]:active,
   #mc_embed_signup a.button:active {
      outline: none;
      background: #cbd10f;
      color: #fff;
   }
   #mc_embed_signup input[type=button]:last-child,
   #mc_embed_signup input[type=submit]:last-child,
   #mc_embed_signup a.button:last-child {
      margin-right: 0;
   }
   #mc_embed_signup input[type=button] {
      background: transparent;
      color: #aaa;
      border-color: #ddd;
   }
   #mc_embed_signup #mc-check-status {
      display: none;
   }
   #mc_embed_signup #already-subscribed {
      display: block;
      margin-top: 1em;
      margin-bottom: 1em;
      font-size: 0.75em;
      color: #aaa;
      -webkit-transition: all 200ms ease;
      -moz-transition: all 200ms ease;
      -o-transition: all 200ms ease;
      transition: all 200ms ease;
   }
   #mc_embed_signup #already-subscribed:hover {
      color: #333;
   }
   #mc_embed_signup #mc-responses,
   #mc_embed_signup #mc-cs-responses {
      margin-top: 1em;
      font-style: italic;
   }
   #mc_embed_signup .error {
      color: #C73C3C;
      font-weight: bold;
   }
   #mc_embed_signup label.error {
      padding-top: 0.25em;
      clear: both;
   }
   #mc_embed_signup .phonearea label.error ,
   #mc_embed_signup .phonedetail1 label.error {
      display: none !important;
   }
   #mc_embed_signup p a {
      opacity: 0.5;
      text-decoration: underline;
      -webkit-transition: all 200ms ease;
      -moz-transition: all 200ms ease;
      -o-transition: all 200ms ease;
      transition: all 200ms ease;
   }
   #mc_embed_signup p a:hover {
      opacity: 0.75;
   }
</style>
<div id="mc_embed_signup">
   <div class="mc-modal-bg"></div>
   <div class="mc-modal">
      <h1>Sign Up To Browse Our Floorplans</h1>
      <form action="" method="post" id="mc-subscribe-form"
         name="mc-subscribe-form">
         <div id="mc_embed_signup_scroll">
            <div class="mc-field-group">
               <label for="mce-FNAME">
                  First Name <span class="asterisk">*</span>
               </label>
               <input type="text" value="" name="FNAME" class="required"
               id="mce-FNAME">
            </div>
            <div class="mc-field-group">
               <label for="mce-LNAME">
                  Last Name <span class="asterisk">*</span>
               </label>
               <input type="text" value="" name="LNAME" class="required"
               id="mce-LNAME">
            </div>
            <div class="mc-field-group">
               <label for="mce-EMAIL">
                  Email Address <span class="asterisk">*</span>
               </label>
               <input type="email" value="" name="EMAIL"
               class="required email" id="mce-EMAIL">
            </div>
            <div class="mc-field-group size1of2">
               <label for="mce-PHONE">
                  Phone Number <span class="asterisk">*</span>
               </label>
               <div class="phonefield phonefield-us">
                  <span class="phonearea">
                     <input class="phonepart required" pattern="[0-9]*"
                     id="mce-PHONE-area" name="PHONE[area]"
                     maxlength="3" size="3" value="" type="text">
                  </span>
                  <span class="phonedetail1">
                     <input class="phonepart required" pattern="[0-9]*"
                     id="mce-PHONE-detail1" name="PHONE[detail1]"
                     maxlength="3" size="3" value="" type="text">
                  </span>
                  <span class="phonedetail2">
                     <input class="phonepart required" pattern="[0-9]*"
                     id="mce-PHONE-detail2" name="PHONE[detail2]"
                     maxlength="4" size="4" value="" type="text">
                  </span>
               </div>
            </div>
            <!-- real people should not fill this in and expect good things
               - do not remove this or risk form bot signups -->
            <div style="position:absolute;left:-5000px;" aria-hidden="true">
               <input type="text" name="4ccd4e352a86a182272815b3b"
                  tabindex="-1" value=""></div>
            <div>
               <input type="button" value="No Thanks"
               name="no-thanks" id="mc-no-thanks-btn" class="button">
               <input type="submit" value="Subscribe" name="subscribe"
               id="mc-subscribe-btn" class="button">
            </div>
         </div>
         <div id="mc-responses"></div>
      </form>
      <div id="mc-check-status-wrapper">
         <a href="#" id="already-subscribed">Already subscribed?</a>
         <div id="mc-check-status">
            <form action="" method="post" id="mc-check-status-form"
               name="mc-check-status-form">
               <p> Great to see you again. Looks like you might be using a
               different device this time or just have cookies turned
               off. Just enter your email address and we'll handle the
               rest. </p>
               <div class="mc-field-group">
                  <label for="mc-cs-EMAIL">
                     Email Address <span class="asterisk">*</span>
                  </label>
                  <input type="email" value="" name="EMAIL"
                  class="required email" id="mc-cs-EMAIL"/>
               </div>
               <div>
                  <input type="submit" style="display:block; width:100%;
                  max-width:100%;" value="Check Subscription"
                  name="check-subscription" id="mc-check-subscription"
                  class="button">
               </div>
            </form>
         </div>
      </div>
      <div id="mc-cs-responses"></div>
   </div>
</div>
<script src="js/js.cookie.js"></script>
<script>
jQuery(function($) {

   // on load
   $(window).load(function(){
      // declare vars
      var member = false;
      // get subscription status cookie
      member = Cookies.get('PERIMITER_MC_SUBSCRIPTION_STATUS');
      // if not already a member, then show the lightbox
      if (!member) {
         // fade in signup form on 200ms delay
         setTimeout(function() { fadeInSignUpForm(); }, 200);
         // bind click events
         $('#already-subscribed').click(function (e){
            e.preventDefault();
            alreadySubscribed(); // show check status form
         });
         $('#mc-no-thanks-btn').click(function (e){
            e.preventDefault();
            parent.history.back(); // go back to whence you came
      });
      } else {
         // you may pass :)
      }
   });

   // function: fade in signup form
   function fadeInSignUpForm() { // console.log('mc modal active');
      $('#mc_embed_signup').fadeIn();
      $('.container').addClass('blur');
   }

   // function: fade out signup form
   function fadeOutSignUpForm() { // console.log('mc modal inactive');
      $('#mc_embed_signup').fadeOut();
      $('.container').removeClass('blur');
   }

   // function: if user is already subscribed
   function alreadySubscribed() { // console.log('already subscribed');
      // toggle #already-subscribed link
      if ( $('#mc_embed_signup_scroll').is(':visible') )
         $('#already-subscribed').text('← Back to Subscription Form');
      else
         $('#already-subscribed').text('Already subscribed?');
      // toggle the forms and response divs
      $('#mc_embed_signup_scroll').slideToggle('fast');
      $('#mc-check-status').slideToggle('fast');
      $('#mc-responses').slideToggle('fast');
      $('#mc-cs-responses').slideToggle('fast');
   }

   // function: set cookie for 10 years
   function setSignUpFormCookie() { // console.log('setting cookie');
      Cookies.set(
         'PERIMITER_MC_SUBSCRIPTION_STATUS',     // name
         'true',                                 // value
         { expires: 3650 }                       // exp in days
      );
   }

   // processing for subscriber form
   if ($('#mc-subscribe-form').length) {
      // config validator
      $.validator.addMethod('defaultInvalid', function(value, element) {
         switch (element.value) {
            case '':
               if (element.name == 'FNAME') return false;
               if (element.name == 'LNAME') return false;
               if (element.name == 'EMAIL') return false;
               if (element.name == 'PHONE[area]') return false;
               if (element.name == 'PHONE[detail1]') return false;
               if (element.name == 'PHONE[detail2]') return false;
               break;
            default: return true;
               break;
         }
      },$.validator.messages.required);
      // validate form
      $('#mc-subscribe-form').validate({
         debug: false,
         rules: {
            FNAME: {
               defaultInvalid: true,
               required:true
            },
            LNAME: {
               defaultInvalid: true,
               required:true
            },
            EMAIL: {
               defaultInvalid: true,
               required:true,
               email:true
            },
            PHONE: {
               defaultInvalid: true,
               required:true
            }
         },
         // submit for ajax processing
         submitHandler: function(form) {
            $.post(
               'ajax/mc-subscribe.php', // url
               $('#mc-subscribe-form').serialize(), // data
               function(data) { // function
                  // console.log(data);
                  // set error response by default
                  var response = '<p class="error">'+
                                 'There was an error, please try again.'+
                                 '</p>';
                  // on success
                  if (data == 'true') {
                     // success response
                     response =  '<p class="success">Almost done! We '+
                                 'just sent you an email to confirm '+
                                 'your email address.<br><br>'+
                                 '<a style="display:block; width:100%;'+
                                 'max-width:100%;" href="#"'+
                                 'id="close-window"'+
                                 'class="button reverse">'+
                                 'Browse Floorplans</a></p>';
                     // slide up forms
                     $('#mc_embed_signup_scroll').slideUp('fast');
                     $('#mc-check-status-wrapper').slideUp('fast');
                     $('#mc-cs-responses').slideUp('fast');
                     // set site-wide cookie that expires in 10 years
                     setSignUpFormCookie();
                  }
                  // output response
                  $('#mc-responses').html(response).fadeIn(200);
                  // bind click event to close window buttoon
                  $('#close-window').click(function (e){
                     e.preventDefault();
                     fadeOutSignUpForm();
                  });
               } // end function
            ); // end ajax request
         } // end submitHandler
      }); // end validator
   } // end processing for subscriber form

   // processing for check status form
   if ($('#mc-check-status-form').length) {
      // config validator
      $.validator.addMethod('defaultInvalid', function(value, element) {
         switch (element.value) {
            case '':
               if (element.name == 'EMAIL') return false;
               break;
            default: return true;
               break;
         }
      },$.validator.messages.required);
      // validate form
      $('#mc-check-status-form').validate({
         debug: false,
         rules: {
            EMAIL: {
               defaultInvalid: true,
               required:true,
               email:true
            }
         },
         // submit for ajax processing
         submitHandler: function(form) {
            $.post(
               'ajax/mc-check-status.php', // url
               $('#mc-check-status-form').serialize(), // data
               function(data) { // function
                  // console.log(data);
                  // set error response by default
                  var response = '<p class="error">Sorry, that email '+
                                 'is not on the list. '+
                                 'Please <a href="#"'+
                                 'id="back-to-signup">'+
                                 'subscribe to the list</a>.</p>';
                  // if member is subscribed
                  if (data == 'subscribed') {
                     // response for subscribers
                     response =  '<p class="success">'+
                                 'Looks like you are on the list! '+
                                 'You may proceed.<br><br>'+
                                 '<a style="display:block;width:100%;'+
                                 'max-width:100%;" href="#"'+
                                 'id="close-window"'+
                                 'class="button reverse">'+
                                 'Browse Floorplans</a></p>';
                     // slide up forms
                     $('#mc_embed_signup_scroll').slideUp('fast');
                     $('#mc-check-status-wrapper').slideUp('fast');
                     // set site-wide cookie that expires in 10 years
                     setSignUpFormCookie();
                     // auto proceed in 3, 2, 1...
                     setTimeout(function() {
                        fadeOutSignUpForm();
                     }, 3000);
                  }
                  // if member is pending
                  else if (data == 'pending') {
                     // response for pending subscribers
                     response =  '<p class="success">'+
                                 'Looks like you have signed up, but '+
                                 'have not confirmed your email '+
                                 'address yet. Please check your email '+
                                 'or <a href="#" id="back-to-signup">'+
                                 'sign up again</a>.</p>';
                  }
                  // print response
                  $('#mc-cs-responses').html(response).fadeIn(200);
                  // bind click event to back to signup buttoon
                  $('#back-to-signup').click(function (e){
                     e.preventDefault();
                     alreadySubscribed();
                  });
                  // bind click event to close window buttoon
                  $('#close-window').click(function (e){
                     e.preventDefault();
                     fadeOutSignUpForm();
                  });
               } // end function
            ); // end ajax request
         } // end submitHandler
      }); // end validator
   } // end processing for check status form

}); // end jquery
</script>
<!--End mc_embed_signup-->
