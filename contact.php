<!-- HTML code for the form -->
<section class="contact" id="contact">

    <div class="image">
        <img src="image/contact_img.png" alt="">
    </div>

    <form action="" method="post" onsubmit="submitForm(event)">
        <h3>contact us</h3>
        <input type="text" placeholder="your name" name="name" class="box">
        <input type="email" placeholder="your email" name="email" class="box">
        <input type="tel" placeholder="your number" name="phone" class="box">
        <textarea name="message" placeholder="your message" id="" cols="30" rows="10"></textarea>
        <input type="submit" value="send message" class="btn">
    </form>

</section>

<!-- JavaScript code for the AJAX request -->
<script>
    function submitForm(event) {
        event.preventDefault(); // Prevent the default form submission

        // Get the form data
        var formData = new FormData(event.target);

        // Send the form data using AJAX
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "submit_enquiry.php");
        xhr.onload = function () {
            if (xhr.status === 200) {
                // Show a popup message and redirect the user
                var popup = document.createElement("div");
                popup.innerHTML = "Thank you for contacting us!";
                popup.style.position = "fixed";
                popup.style.backgroundColor = "Blue";
                popup.style.color = "White";
                popup.style.padding = "10px";
                popup.style.borderRadius = "10px";
                popup.style.top = "100px";
                popup.style.right = "15px";
                document.body.appendChild(popup);
                setTimeout(function () {
                    popup.style.display = "none";
                }, 3000);
            } else {
                console.error(xhr.statusText);
            }
        };
        xhr.onerror = function () {
            console.error(xhr.statusText);
        };
        xhr.send(formData);
        // event.target.reset();
    }
</script>