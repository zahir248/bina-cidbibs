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
                    <p>Lot 8, Jalan Chan So,</p>
                    <p>55200 Kuala Lumpur</p>
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
                <form class="newsletter-form mb-2" action="#" method="POST">
                     @csrf
                    <div class="input-group">
                        <input type="email" class="form-control newsletter-input" placeholder="Your Email Address" name="email" required>
                        <button type="submit" class="btn btn-newsletter">SIGN UP</button>
                    </div>
                </form>

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
    color: #c9d1d9; /* Light text color */
    font-size: 0.9rem;
}

.footer-logo-container img {
    height: 60px; /* Reduced logo size */
    width: auto;
}

.footer-tagline {
    font-size: 1rem;
    font-weight: 500;
    color: white;
}

.footer-address p {
    margin-bottom: 0.1rem;
    line-height: 1.4;
}

.footer-social a {
    color: #ff9800;
    font-size: 1.1rem;
    margin-right: 0.8rem;
    transition: color 0.3s ease;
    text-decoration: none;
}

.footer-social a:hover {
    color: white; /* White on hover */
    text-decoration: none; /* Ensure no underline on hover */
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
    background-color: #161b22;
    border-radius: 50%;
    font-size: 1rem;
    flex-shrink: 0;
}

.contact-icon i {
    color: #ff9800; /* Orange icon */
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
    color: #c9d1d9;
    text-decoration: none;
    line-height: 1.4;
    margin-bottom: 0.1rem;
}

.contact-link:hover {
    color: white; /* White on hover */
}

.newsletter-form .input-group {
    border-radius: 0.4rem;
    overflow: hidden;
    background-color: #161b22;
    border: 1px solid #30363d;
}

.newsletter-input {
    background-color: transparent !important;
    border: none !important;
    color: white !important;
    font-size: 0.9rem;
    padding: 0.5rem 0.8rem;
    box-shadow: none !important;
}

.newsletter-input::placeholder {
    color: #8b949e; /* Lighter placeholder text */
}

.btn-newsletter {
    background: linear-gradient(135deg, #ff9800 0%, #f57c00 100%);
    color: white !important;
    border: none;
    padding: 0.5rem 1rem;
    font-size: 0.9rem;
    font-weight: 600;
    transition: all 0.3s ease;
}

.btn-newsletter:hover {
    background: linear-gradient(135deg, #f57c00 0%, #ef6c00 100%);
}

.partner-logos {
    display: block; /* Change display to block */
    align-items: center;
    gap: 1rem; /* Space between logos */
    flex-wrap: wrap; /* Allow wrapping on smaller screens */
    width: 100%; /* Make the container take the full width of its parent column */
    text-align: left; /* Align content to the left */
}

.partner-logo {
    height: auto;
    width: 100%;
    max-width: 100%;
    filter: brightness(0) invert(1);
    opacity: 0.8;
    transition: opacity 0.3s ease;
}

.partner-logo:hover {
     opacity: 1;
}

.footer-divider {
    border-top: 1px solid #30363d; /* Dark divider */
}

.footer-copyright {
    font-size: 0.85rem;
    color: #8b949e;
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
        margin-bottom: 1rem;
    }
    
    .partner-logo {
        max-width: 120px;
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
        max-width: 100px;
    }
}

.footer-section .container {
    padding-top: 1rem;
}
</style>