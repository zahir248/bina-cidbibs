<footer class="footer-section py-2">
    <div class="container">
        <div class="row">
            <!-- Left Column: Logo, Tagline, Address, Social -->
            <div class="col-lg-4 col-md-6 mb-3 mb-lg-0">
                <div class="footer-logo-container mb-2">
                    <a href="{{ route('client.home') }}">
                         <img src="{{ asset('images/bina-logo.png') }}" alt="BINA 2025 Logo" class="footer-logo">
                    </a>
                </div>
                <p class="footer-tagline mb-2">Beyond Limit, Build Tomorrow</p>
                <div class="footer-address mb-2">
                    <p>CIDB IBS SDN. BHD.</p>
                    <p>Lot 8, Jalan Chan Sow, Cheras Batu 2 1/2,</p>
                    <p>55200 Kuala Lumpur, Federal Territory of Kuala Lumpur</p>
                </div>
                <div class="footer-social">
                    <a href="https://www.facebook.com/cidbibsofficial/?locale=ms_MY" class="social-icon" target="_blank" rel="noopener"><i class="fab fa-facebook-f"></i></a>
                    <a href="https://www.linkedin.com/company/cidbibsofficial/posts/?feedView=all" class="social-icon" target="_blank" rel="noopener"><i class="fab fa-linkedin-in"></i></a>
                </div>
            </div>

            <!-- Middle Column: Contact Info -->
            <div class="col-lg-3 col-md-6 mb-3 mb-lg-0">
                <h5 class="footer-heading mb-2">CONTACT US</h5>
                <div class="contact-info mb-2">
                    <div class="contact-item mb-1">
                        <div class="contact-icon"><i class="fas fa-envelope"></i></div>
                        <div class="contact-details">
                            <div class="contact-label">Our Email</div>
                            <a href="mailto:bina@cidbibs.com.my" class="contact-link">bina@cidbibs.com.my</a>
                        </div>
                    </div>
                     <div class="contact-item">
                        <div class="contact-icon"><i class="fas fa-phone-alt"></i></div>
                        <div class="contact-details">
                            <div class="contact-label">Our Phone</div>
                            <p>+603-92242280</p>
                            <p>+6012-6909457</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column: Newsletter & Partners -->
            <div class="col-lg-5">
                <h5 class="footer-heading mb-2">SUBSCRIBE OUR NEWSLETTER</h5>
                <form class="newsletter-form mb-2" id="newsletterForm" action="{{ route('newsletter.subscribe') }}" method="POST">
                     @csrf
                    <div class="input-group">
                        <input type="email" class="form-control newsletter-input" placeholder="Your Email Address" name="email" required style="background:rgba(255, 255, 255, 0.2) !important;border-radius:0.5rem 0 0 0.5rem !important;color:white !important;border:none;padding:0.75rem 1.25rem;">
                        <button type="submit" class="btn btn-newsletter" style="background:white !important;color:#FF9900 !important;border-radius:0 0.5rem 0.5rem 0 !important;padding:0.75rem 1.5rem;font-weight:600;border:none;">SIGN UP</button>
                    </div>
                </form>

                <div class="quick-links mb-2">
                    <h6 class="footer-subheading mb-1">Quick Links</h6>
                    <div class="quick-links-list">
                        <a href="{{ route('client.order-lookup') }}" class="quick-link">Order Lookup</a>
                        <a href="{{ route('client.store') }}" class="quick-link">Buy Tickets</a>
                        <a href="{{ route('client.about') }}" class="quick-link">About Us</a>
                    </div>
                </div>

                <!-- Newsletter Modal -->
                <div class="modal fade" id="newsletterModal" tabindex="-1" aria-labelledby="newsletterModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content border-0">
                            <div class="modal-body p-4 text-center">
                                <div class="newsletter-modal-icon mb-4">
                                    <i class="fas fa-check-circle text-success" style="font-size: 48px;"></i>
                                </div>
                                <p class="newsletter-modal-message mb-4" style="font-size: 18px; color: #333;"></p>
                                <button type="button" class="btn btn-orange px-4 py-2" data-bs-dismiss="modal" style="background-color: #FF9900; border: none; color: white;">Close</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="partner-logos">
                     <img src="{{ asset('images/logo-footer.png') }}" alt="CIDB IBS Logo" class="partner-logo me-3">
                </div>
            </div>
        </div>

        <hr class="footer-divider my-2">

        <!-- Bottom Row: Copyright -->
        <div class="row">
            <div class="col-12 text-center">
                <p class="footer-copyright mb-0">&copy; 2025 BINA CIDB IBS All rights Reserved</p>
            </div>
        </div>
    </div>
</footer>

<style>
/* Footer Styles */
.footer-section {
    background: #e67e00;
    color: #ffffff;
    font-size: 0.9rem;
}

.footer-logo-container img {
    height: 60px;
    width: auto;
}

.footer-subheading {
    color: #ffffff;
    font-weight: 600;
    font-size: 0.9rem;
    margin-bottom: 8px;
}

.quick-links-list {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
}

.quick-link {
    color: #ffffff;
    text-decoration: none;
    font-size: 0.8rem;
    padding: 4px 8px;
    border-radius: 4px;
    background: rgba(255, 255, 255, 0.1);
    transition: all 0.3s ease;
}

.quick-link:hover {
    background: rgba(255, 255, 255, 0.2);
    color: #ffffff;
    text-decoration: none;
}

.footer-tagline {
    font-size: 1rem;
    font-weight: 500;
    color: white;
}

.footer-address p {
    margin-bottom: 0.1rem;
    line-height: 1.4;
    color: white;
}

.footer-social a {
    color: white;
    font-size: 1.1rem;
    margin-right: 0.8rem;
    transition: color 0.3s ease;
    text-decoration: none;
}

.footer-social a:hover {
    color: #181b2c;
    text-decoration: none;
}

.footer-heading {
    font-size: 1.1rem;
    font-weight: 700;
    color: white;
    margin-bottom: 1rem;
}

.contact-item {
    display: flex;
    align-items: flex-start;
    gap: 0.8rem;
    margin-bottom: 1rem;
}

.contact-icon {
    width: 32px;
    height: 32px;
    display: flex;
    align-items: center;
    justify-content: center;
    background-color: white;
    border-radius: 50%;
    font-size: 1rem;
    flex-shrink: 0;
}

.contact-icon i {
    color: #FF9900;
}

.contact-details {
    flex: 1;
}

.contact-label {
    font-size: 0.85rem;
    font-weight: 600;
    color: white;
    margin-bottom: 0.1rem;
}

.contact-link, .contact-details p {
    font-size: 0.9rem;
    color: white;
    text-decoration: none;
    line-height: 1.4;
    margin-bottom: 0.1rem;
}

.contact-link:hover {
    color: #181b2c;
}

.newsletter-form {
    max-width: 100%;
    margin-bottom: 2rem;
}

.newsletter-form .input-group {
    border-radius: 0.5rem;
    overflow: hidden;
    background: transparent;
    border: none;
    width: 100%;
}

.newsletter-input {
    background: rgba(255, 255, 255, 0.2) !important;
    border: none !important;
    color: white !important;
    font-size: 0.9rem;
    padding: 0.75rem 1.25rem;
    box-shadow: none !important;
}

.newsletter-input::placeholder {
    color: rgba(255, 255, 255, 0.8);
}

.btn-newsletter {
    background: white !important;
    color: #FF9900 !important;
    border: none;
    padding: 0.75rem 1.5rem;
    font-size: 0.9rem;
    font-weight: 600;
    transition: all 0.3s ease;
}

.btn-newsletter:hover {
    background: #f8f9fa !important;
    color: #FF9900 !important;
}

.partner-logos {
    display: block;
    width: 100%;
    text-align: left;
}

.partner-logo {
    height: auto;
    width: 100%;
    max-width: 100%;
    filter: brightness(0) invert(1);
    opacity: 1;
    transition: opacity 0.3s ease;
}

.partner-logo:hover {
    opacity: 0.9;
}

.footer-divider {
    border-top: 1px solid rgb(255, 255, 255);
}

.footer-copyright {
    font-size: 0.85rem;
    color: white;
}

/* Responsive adjustments */
@media (max-width: 767.98px) {
    .footer-section {
        padding: 1.5rem 1rem;
    }
    
    .footer-heading {
        margin-bottom: 0.8rem;
    }

    .contact-item {
        margin-bottom: 0.8rem;
    }

    .newsletter-form {
        margin-bottom: 1.5rem;
    }
    
    .partner-logo {
        width: 100%;
        max-width: 100%;
    }
}

@media (max-width: 575.98px) {
    .footer-section {
        padding: 1rem 0.8rem;
    }
    
    .footer-heading {
        margin-bottom: 0.8rem;
    }

    .contact-item {
        margin-bottom: 0.8rem;
    }

    .newsletter-form {
        margin-bottom: 1rem;
    }
    
    .partner-logo {
        width: 100%;
        max-width: 100%;
    }
}

.footer-section .container {
    padding-top: 1rem;
}

/* Updated Newsletter Modal Styles */
.modal-content {
    border-radius: 15px;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
}

.modal-body {
    padding: 2rem !important;
}

.newsletter-modal-icon {
    color: #28a745;
}

.btn-orange {
    transition: background-color 0.3s ease;
}

.btn-orange:hover {
    background-color: #e67e00 !important;
}

/* Fade animation for modal */
.modal.fade .modal-dialog {
    transform: translateY(-20px);
    transition: transform 0.3s ease-out;
}

.modal.show .modal-dialog {
    transform: translateY(0);
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
        const modalMessage = document.querySelector('.newsletter-modal-message');
        
        if (data.status === 'success') {
            modalMessage.textContent = 'Thank you for subscribing to our newsletter!';
            form.reset();
        } else {
            modalMessage.textContent = data.message || 'An error occurred. Please try again later.';
        }
        
        // Show the modal
        modal.show();
    })
    .catch(error => {
        const modalMessage = document.querySelector('.newsletter-modal-message');
        modalMessage.textContent = 'An error occurred. Please try again later.';
        modal.show();
    })
    .finally(() => {
        // Re-enable submit button and restore original text
        submitBtn.disabled = false;
        submitBtn.innerHTML = originalBtnText;
    });
});
</script>