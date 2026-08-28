    <section id="contact" class="contact_area ">
        <div class="container">
            <div class="row">
                <div class="col-lg-6" data-aos="fade-right">
                    <div class="contact_form pt-105 pb-120">
                        <div class="section_title pb-25">
                            <span class="line"></span>
                            <h3 class="title">GIVE US FEEDBACK</h3>
                        </div>
                        <form action="{{ route('feedback.submit') }}" method="POST">
                            @csrf
                            <div class="single_form">
                                <input type="text" name="name" id="name" placeholder="Name" required>
                                <div id="name-error"
                                    style="color: #dc3545; font-size: 12px; margin-top: 5px; display: none;"></div>
                            </div>
                            <div class="single_form">
                                <input type="text" name="email" placeholder="example@email.com" required>
                            </div>
                            <div class="single_form">
                                <input type="text" name="subject" placeholder="Subject" required>
                            </div>
                            <div class="single_form">
                                <label for="rating"
                                    style="color: #333; font-weight: 500; margin-bottom: 8px; display: block;">Rate
                                    your
                                    experience (1-5 stars):</label>
                                <div class="star-rating" style="display: flex; gap: 8px; margin-bottom: 10px;">
                                    <div id="rating-display" style="margin-left: 10px; font-weight: bold; color: #333;">
                                    </div>
                                    <input type="radio" name="rating" value="1" id="star1"
                                        style="display: none;">
                                    <label for="star1" class="star"
                                        style="font-size: 24px; color: #ddd; cursor: pointer; transition: color 0.2s;">★</label>

                                    <input type="radio" name="rating" value="2" id="star2"
                                        style="display: none;">
                                    <label for="star2" class="star"
                                        style="font-size: 24px; color: #ddd; cursor: pointer; transition: color 0.2s;">★</label>

                                    <input type="radio" name="rating" value="3" id="star3"
                                        style="display: none;">
                                    <label for="star3" class="star"
                                        style="font-size: 24px; color: #ddd; cursor: pointer; transition: color 0.2s;">★</label>

                                    <input type="radio" name="rating" value="4" id="star4"
                                        style="display: none;">
                                    <label for="star4" class="star"
                                        style="font-size: 24px; color: #ddd; cursor: pointer; transition: color 0.2s;">★</label>

                                    <input type="radio" name="rating" value="5" id="star5"
                                        style="display: none;">
                                    <label for="star5" class="star"
                                        style="font-size: 24px; color: #ddd; cursor: pointer; transition: color 0.2s;">★</label>
                                </div>
                                <small style="color: #666; font-size: 12px;">Click on a star to rate your
                                    experience</small>
                            </div>
                            <div class="single_form">
                                <textarea name="message" placeholder="Message" required></textarea>
                            </div>
                            <p class="form-message"></p>
                            <div class="single_form">
                                <button class="main-btn" type="submit" onclick="return validateForm()">SUBMIT</button>
                            </div>

                            @if (session('success'))
                                <div class="custom-alert-success">
                                    {{ session('success') }}
                                </div>
                            @endif

                            <script>
                                document.addEventListener("DOMContentLoaded", function() {
                                    // Star rating functionality
                                    const stars = document.querySelectorAll('.star');
                                    const radioInputs = document.querySelectorAll('input[name="rating"]');

                                    stars.forEach((star, index) => {
                                        star.addEventListener('click', () => {
                                            // Reset all stars
                                            stars.forEach(s => s.style.color = '#ddd');

                                            // Color stars up to clicked star
                                            for (let i = 0; i <= index; i++) {
                                                stars[i].style.color = '#ffd700';
                                            }

                                            // Check the corresponding radio input
                                            radioInputs[index].checked = true;

                                            // Debug: Log the selected rating
                                            console.log('Selected rating:', radioInputs[index].value);

                                            // Update the rating display
                                            document.getElementById('rating-display').textContent = radioInputs[index]
                                                .value + '/5';
                                        });

                                        // Hover effects
                                        star.addEventListener('mouseenter', () => {
                                            // Color stars up to hovered star
                                            for (let i = 0; i <= index; i++) {
                                                stars[i].style.color = '#ffd700';
                                            }
                                        });

                                        star.addEventListener('mouseleave', () => {
                                            // Reset to selected state
                                            const checkedInput = document.querySelector('input[name="rating"]:checked');
                                            if (checkedInput) {
                                                const checkedIndex = Array.from(radioInputs).indexOf(checkedInput);
                                                stars.forEach((s, i) => {
                                                    s.style.color = i <= checkedIndex ? '#ffd700' : '#ddd';
                                                });
                                            } else {
                                                stars.forEach(s => s.style.color = '#ddd');
                                            }
                                        });
                                    });

                                    // Auto-hide success message
                                    setTimeout(function() {
                                        const alert = document.querySelector('.custom-alert-success');
                                        if (alert) {
                                            alert.classList.add('fade-out');
                                        }
                                    }, 3000); // 3000ms = 3 seconds
                                });

                                // Name validation function
                                function validateName(name) {
                                    // Allow only letters, spaces, and dots
                                    const nameRegex = /^[a-zA-Z\s.]+$/;
                                    return nameRegex.test(name);
                                }

                                // Add real-time validation for name field
                                document.getElementById('name').addEventListener('input', function() {
                                    const nameValue = this.value;
                                    const errorDiv = document.getElementById('name-error');

                                    if (nameValue && !validateName(nameValue)) {
                                        errorDiv.textContent = 'Name can only contain letters, spaces, and dots.';
                                        errorDiv.style.display = 'block';
                                        this.style.borderColor = '#dc3545';
                                    } else {
                                        errorDiv.style.display = 'none';
                                        this.style.borderColor = '';
                                    }
                                });

                                // Form validation function
                                function validateForm() {
                                    const nameField = document.getElementById('name');
                                    const nameValue = nameField.value;
                                    const selectedRating = document.querySelector('input[name="rating"]:checked');

                                    // Validate name field
                                    if (!nameValue) {
                                        alert('Please enter your name.');
                                        nameField.focus();
                                        return false;
                                    }

                                    if (!validateName(nameValue)) {
                                        alert('Name can only contain letters, spaces, and dots.');
                                        nameField.focus();
                                        return false;
                                    }

                                    if (!selectedRating) {
                                        alert('Please select a rating before submitting.');
                                        return false;
                                    }

                                    console.log('Submitting form with rating:', selectedRating.value);
                                    return true;
                                }
                            </script>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="contact_map" data-aos="fade-left" data-aos-delay="200">
            <div class="googlemap_limitless">
                <img src={{ asset('assets/images/maps.png') }} alt="">
            </div>
        </div>
    </section>
