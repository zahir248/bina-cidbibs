<footer class="footer mt-5">
    <div class="container">
        <div class="row align-items-start">
            <!-- BINA Logo and Info -->
            <div class="col-md-4">
                <img src="{{ asset('images/bina-logo.png') }}" alt="BINA Logo" class="footer-logo mb-3">
                <h5 class="text-white">Beyond Limit, Build Tomorrow</h5>
                <div class="company-info">
                    <p class="mb-1">CIDB IBS SDN. BHD.</p>
                    <p class="mb-3">Lot 8, Jalan Chan Sow, Cheras Batu 2 1/2,<br>55200 Kuala Lumpur, Federal Territory of Kuala Lumpur</p>
                </div>
                <div class="social-links">
                    <a href="https://www.facebook.com/cidbibsofficial/?locale=ms_MY" class="social-link" target="_blank" rel="noopener"><i class="fab fa-facebook-f"></i></a>
                    <a href="https://www.linkedin.com/company/cidbibsofficial/posts/?feedView=all" class="social-link" target="_blank" rel="noopener"><i class="fab fa-linkedin-in"></i></a>
                </div>
            </div>

            <!-- Contact Information -->
            <div class="col-md-4">
                <h5 class="text-white mb-4">CONTACT US</h5>
                <div class="contact-info">
                    <div class="d-flex align-items-center mb-3">
                        <i class="fas fa-envelope text-orange me-2"></i>
                        <div>
                            <p class="mb-0">Our Email</p>
                            <a href="mailto:bina@cidbibs.com.my" class="text-white">bina@cidbibs.com.my</a>
                        </div>
                    </div>
                    <div class="d-flex align-items-center">
                        <i class="fas fa-phone text-orange me-2"></i>
                        <div>
                            <p class="mb-0">Our Phone</p>
                            <p class="mb-1">+603-92242280</p>
                            <p class="mb-0">+6012-6909457</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Newsletter and Logos -->
            <div class="col-md-4">
                <h5 class="text-white mb-4">SUBSCRIBE OUR NEWSLETTER</h5>
                <form class="newsletter-form mb-4" id="newsletterForm" action="{{ route('newsletter.subscribe') }}" method="POST">
                    @csrf
                    <div class="input-group">
                        <input type="email" class="form-control" placeholder="Your Email Address" name="email" required>
                        <button class="btn btn-orange" type="submit">SIGN UP</button>
                    </div>
                </form>
                <div class="partner-logos">
                    <img src="{{ asset('images/logo-footer.png') }}" alt="CIDB IBS Logo" class="partner-logo me-3">
                </div>
            </div>
        </div>
    </div>
    <div class="footer-bottom mt-4">
        <div class="container">
            <p class="text-center mb-0">&copy; 2025 BINA CIDB IBS All rights Reserved</p>
        </div>
    </div>
</footer>

<!-- Newsletter Modal -->
<div class="modal fade" id="newsletterModal" tabindex="-1" aria-labelledby="newsletterModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0">
            <div class="modal-body p-4 text-center">
                <div class="newsletter-modal-icon mb-3">
                    <i class="fas fa-check-circle text-success success-icon" style="display: none;"></i>
                    <i class="fas fa-exclamation-circle text-warning error-icon" style="display: none;"></i>
                </div>
                <h4 class="modal-title mb-3" id="newsletterModalLabel"></h4>
                <p class="newsletter-modal-message mb-4"></p>
                <button type="button" class="btn btn-primary px-4 py-2" data-bs-dismiss="modal" style="background-color: #FF9900; border: none;">Close</button>
            </div>
        </div>
    </div>
</div>

<style>
/* Newsletter Modal Styles */
.newsletter-modal-icon {
    font-size: 4rem;
    line-height: 1;
}

.newsletter-modal-icon i {
    animation: scaleIn 0.3s ease-in-out;
}

@keyframes scaleIn {
    0% {
        transform: scale(0);
        opacity: 0;
    }
    100% {
        transform: scale(1);
        opacity: 1;
    }
}

.modal-content {
    border-radius: 1rem;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
}

.modal-body {
    padding: 2.5rem !important;
}

.newsletter-modal-message {
    color: #666;
    font-size: 1.1rem;
}

#newsletterModal .btn-primary:hover {
    background-color: #e67e00 !important;
}

/* Fade animation for modal */
.modal.fade .modal-dialog {
    transform: scale(0.8);
    transition: transform 0.3s ease-in-out;
}

.modal.show .modal-dialog {
    transform: scale(1);
}
</style>

<script>
document.getElementById('newsletterForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const form = this;
    const submitBtn = form.querySelector('button[type="submit"]');
    const originalBtnText = submitBtn.innerHTML;
    const modal = new bootstrap.Modal(document.getElementById('newsletterModal'));
    
    // Disable submit button and show loading state
    submitBtn.disabled = true;
    submitBtn.innerHTML = 'Signing up...';
    
    fetch(form.action, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({
            email: form.email.value
        })
    })
    .then(response => response.json())
    .then(data => {
        // Set modal content based on response
        const modalTitle = document.getElementById('newsletterModalLabel');
        const modalMessage = document.querySelector('.newsletter-modal-message');
        const successIcon = document.querySelector('.success-icon');
        const errorIcon = document.querySelector('.error-icon');
        
        if (data.status === 'success') {
            modalTitle.textContent = 'Thank You!';
            modalMessage.textContent = data.message;
            successIcon.style.display = 'inline-block';
            errorIcon.style.display = 'none';
            form.reset();
        } else {
            modalTitle.textContent = 'Oops!';
            modalMessage.textContent = data.message;
            successIcon.style.display = 'none';
            errorIcon.style.display = 'inline-block';
        }
        
        // Show the modal
        modal.show();
    })
    .catch(error => {
        const modalTitle = document.getElementById('newsletterModalLabel');
        const modalMessage = document.querySelector('.newsletter-modal-message');
        const successIcon = document.querySelector('.success-icon');
        const errorIcon = document.querySelector('.error-icon');
        
        modalTitle.textContent = 'Oops!';
        modalMessage.textContent = 'An error occurred. Please try again later.';
        successIcon.style.display = 'none';
        errorIcon.style.display = 'inline-block';
        
        modal.show();
    })
    .finally(() => {
        // Re-enable submit button and restore original text
        submitBtn.disabled = false;
        submitBtn.innerHTML = originalBtnText;
    });
});
</script> 