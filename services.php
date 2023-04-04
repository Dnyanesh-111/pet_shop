<!-- Shop Section Ends here-->
<section class="services" id="services">

    <h1 class="heading"> our <span>services</span> </h1>

    <div class="box-container">

        <div class="box">
            <i class="fas fa-dog"></i>
            <h3>dog boarding</h3>
            <a aria-current="page" href="./?p=petservices/dogBoarding" class="btn">read more</a>
        </div>

        <div class="box">
            <i class="fas fa-cat"></i>
            <h3>cat boarding</h3>
            <a aria-current="page" href="./?p=petservices/catBoarding" class="btn">read more</a>
        </div>

        <div class="box">
            <i class="fas fa-bath"></i>
            <h3>spa & grooming</h3>
            <a aria-current="page" href="./?p=petservices/spaGrooming" class="btn">read more</a>
        </div>

        <div class="box">
            <i class="fas fa-drumstick-bite"></i>
            <h3>healthy meal</h3>
            <a aria-current="page" href="./?p=petservices/healthyMeal" class="btn">read more</a>
        </div>

        <div class="box">
            <i class="fas fa-baseball-ball"></i>
            <h3>activity exercise</h3>
            <a aria-current="page" href="./?p=petservices/activityExercise" class="btn">read more</a>
        </div>

        <div class="box">
            <i class="fas fa-heartbeat"></i>
            <h3>health care</h3>
            <a aria-current="page" href="./?p=petservices/helthCare" class="btn">read more</a>
        </div>

    </div>

</section>

<!-- services section ends -->
<!-- plan section starts  -->

<section class="plan" id="plan">

    <h1 class="heading"> choose a <span>plan</span> </h1>

    <div class="box-container">

        <div class="box">
            <h3 class="title">pet care</h3>
            <h3 class="day"> 1 day </h3>
            <i class="fas fa-bicycle icon"></i>
            <div class="list">
                <p> pet room <span class="fas fa-check"></span> </p>
                <p> pet grooming <span class="fas fa-check"></span> </p>
                <p> pet exercise <span class="fas fa-check"></span> </p>
                <p> pet meals <span class="fas fa-check"></span> </p>
            </div>
            <div class="amount"><span>₹</span>50</div>
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#bookModal"
                data-whatever="1 Day,50">
                Choose Plan
            </button>
        </div>

        <div class="box">
            <h3 class="title">pet care</h3>
            <h3 class="day"> 10 days </h3>
            <i class="fas fa-motorcycle icon"></i>
            <div class="list">
                <p> pet room <span class="fas fa-check"></span> </p>
                <p> pet grooming <span class="fas fa-check"></span> </p>
                <p> pet exercise <span class="fas fa-check"></span> </p>
                <p> pet meals <span class="fas fa-check"></span> </p>
            </div>
            <div class="amount"><span>₹</span>350</div>
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#bookModal"
                data-whatever="10 Days,350">
                Choose Plan
            </button>
        </div>

        <div class="box">
            <h3 class="title">pet care</h3>
            <h3 class="day"> 30 days </h3>
            <i class="fas fa-car-side icon"></i>
            <div class="list">
                <p> pet room <span class="fas fa-check"></span> </p>
                <p> pet grooming <span class="fas fa-check"></span> </p>
                <p> pet exercise <span class="fas fa-check"></span> </p>
                <p> pet meals <span class="fas fa-check"></span> </p>
            </div>
            <div class="amount"><span>₹</span>650</div>
            <!-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#bookModal">
                Choose Plan
            </button> -->
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#bookModal"
                data-whatever="30 Days,650">
                Choose Plan
            </button>

        </div>

    </div>

</section>

<!-- plan section ends -->
<!-- The modal -->
<div class="modal fade" id="bookModal" tabindex="-1" role="dialog" aria-labelledby="bookModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="bookModalLabel">Book Service</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="./?p=petservices/book" method="post">
                    <div class="form-group">
                        <label for="cname">Your Name:</label>
                        <input type="text" class="form-control" id="cname" name="cname" required>
                    </div>
                    <div class="form-group">
                        <label for="cemail">Email Address:</label>
                        <input type="email" class="form-control" id="cemail" name="cemail" required>
                    </div>
                    <div class="form-group">
                        <label for="cnumber">Mobile Number:</label>
                        <input type="phone" class="form-control" id="cnumber" name="cnumber" required>
                    </div>
                    <div class="form-group">
                        <label for="plan">Plan:</label>
                        <input type="text" class="form-control" id="plan" name="plan" readonly>
                    </div>
                    <div class="form-group">
                        <label for="charges">Charges:</label>
                        <input type="text" class="form-control" id="charges" name="charges" readonly>
                    </div>
                    <div class="text-right mt-2">
                        <button type="button" class="btn btn-primary" data-dismiss="modal" aria-label="Close">
                            Cancel
                        </button>
                        <button type="submit" class="btn btn-primary">Book</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    $('#bookModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget) // Button that triggered the modal
        var values = button.data('whatever').split(",") // Extract the values from data-whatever attribute
        var modal = $(this)
        modal.find('#plan').val(values[0]) // Set the first value to input1
        modal.find('#charges').val(values[1]) // Set the second value to input2
    })
</script>