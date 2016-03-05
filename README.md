# MailChimp Signup Form w/ Cookies

Shows MailChimp Signup Form for non-members. Uses cookies to store data. If cookie is found, no signup form appears. If no cookie is found, then signup form appears. Contains subscribe form and a form to check the user's susbcription if the user is already subscribed.

### Installation:
- At the very bottom of index.php, you will I included the signup form script:
  <pre><?php include('mc-signup-form.php'); ?></pre>
- This is can be added to any other page by putting the above code in the footer.

### The PHP script itself:
- The file <code>mc-signup-form.php</code> is where the main source code of the script lives.
- This file begins with inline CSS (kept this inline to keep requests as few as possible)
- Next, we have the markup: <pre>&lt;div id="mc_embed_signup"&gt;...&lt;/div&gt;</pre>
- Lastly, the javascript.

### The JavaScript:
- I'm using [JS Cookie](https://github.com/js-cookie/js-cookie) for cookie management for easiest readability. 
- Again all my js is inline to keep requests to a minimum. 
- On window load, JS checks if user is a member by looking for a browser cookie: <code>PERIMITER_MC_SUBSCRIPTION_STATUS</code>
- If cookie isn't found, then the signup form modal fades in.
- If cookie is found, then no signup form appears. Easy enough?
- I went ahead and added in a link for "Already subscribed?" for best UX. This allows users to enter their email to check their subscription status if they are browsing on a different device. 
- Cookie is set to expire in 10 years (setting no expiration is not possible, and anything longer than 10 years [is potentially problematic](http://stackoverflow.com/questions/3290424/set-a-cookie-to-never-expire))
- All form processing is done via AJAX. 
- Responses are printed on based on conditions of the AJAX requests. 

#### The AJAX requests:
- Here's where the actual PHP comes in.
- There are 2 ajax processing requests, which are written in PHP:
(1) subscribe user:  <code>/ajax/mc-subscripe.php</code>
(2) check subscription status:  <code>/ajax/mc-subscripe.php</code>
- I've included [PHP Console](https://github.com/barbushin/php-console), used for debugging. Turned off for production.
- All lines starting with <code>PC::</code> are used for debugging. Commented these out for production.
- MailChimp API key and List ID are located at the very top. These can be grabbed from MailChimp's account settings. These are required; the script will not work without them. 
<pre>// MailChimp API keys and List ID
$apiKey = '{your-mailchimp-api-key}';
$listId = '{your-mailchimp-list-id}';</pre>
- These scripts use the MailChimp API v3.0. [Full docs here](http://developer.mailchimp.com/documentation/mailchimp/guides/get-started-with-mailchimp-api-3/).
- These functions simply ping MailChimp using an HTTP request via curl. They return two items: (1) a result and (2) an HTTP code, either 404 (fail) or 200 (success).
- After returning the response from MailChimp, the ajax scripts then echos the output back to the JavaScript in <code>mc-signup-form.php.</code>

### Version History

**1.1**
* Fixed overflow scroll bug
* Added cancelSignUpForm function that checks for referring URL
* Added close button for easier UX

**1.0**
* Initial Release

And that's it! Enjoy!
