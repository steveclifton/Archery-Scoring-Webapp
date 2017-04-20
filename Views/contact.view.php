<link rel="stylesheet" href="Views/css/contact.css">
<div class="container">
    <form id="contact" action="#" method="post" onsubmit="return submitContactForm()">
        <h4>Contact Archery OSA</h4>
        <fieldset>
            <input id="name" name="name" placeholder="Your name" type="text" tabindex="1" required autofocus>
        </fieldset>
        <fieldset>
            <input id="email" name="email" placeholder="Your Email Address" type="email" tabindex="2" required>
        </fieldset>
        <fieldset>
            <textarea id="message" name="message" placeholder="Type your message here...." tabindex="5" required></textarea>
        </fieldset>
        <fieldset>
            <i class="fa fa-spinner fa-spin" style="font-size:40px; align-content: center" id="spinning"></i>
            <button name="submit" type="submit" id="contact-submit">Submit</button>
        </fieldset>
    </form>
</div>