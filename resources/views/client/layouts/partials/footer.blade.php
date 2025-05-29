<footer class="footer-section py-5">
    <div class="container">
        <div class="row">
            <!-- Left Column: Logo, Tagline, Address, Social -->
            <div class="col-lg-4 col-md-6 mb-4 mb-lg-0">
                <div class="footer-logo-container mb-3">
                    <a href="{{ route('client.home') }}">
                         <img src="{{ asset('images/bina-logo.png') }}" alt="BINA 2025 Logo" class="footer-logo">
                    </a>
                </div>
                <p class="footer-tagline mb-3">Beyond Limit, Build Tomorrow</p>
                <div class="footer-address mb-4">
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
            <div class="col-lg-3 col-md-6 mb-4 mb-lg-0">
                <h5 class="footer-heading mb-4">CONTACT US</h5>
                <div class="contact-info mb-3">
                    <div class="contact-item mb-2">
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
                <h5 class="footer-heading mb-4">SUBSCRIBE OUR NEWSLETTER</h5>
                <form class="newsletter-form mb-4" action="#" method="POST">
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

        <hr class="footer-divider my-4">

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
    font-size: 1rem;
}

.footer-logo-container img {
    height: 80px; /* Adjust based on logo size */
    width: auto;
}

.footer-tagline {
    font-size: 1.1rem;
    font-weight: 500;
    color: white; /* White tagline */
}

.footer-address p {
    margin-bottom: 0.2rem;
    line-height: 1.5;
}

.footer-social a {
    color: #ff9800; /* Orange social icons */
    font-size: 1.2rem;
    margin-right: 1rem;
    transition: color 0.3s ease;
    text-decoration: none; /* Prevent underline */
}

.footer-social a:hover {
    color: white; /* White on hover */
    text-decoration: none; /* Ensure no underline on hover */
}

.footer-heading {
    font-size: 1.2rem;
    font-weight: 700;
    color: white; /* White heading */
    margin-bottom: 1.5rem;
}

.contact-item {
    display: flex;
    align-items: flex-start; /* Align icon to the top */
    gap: 1rem;
    margin-bottom: 1.5rem;
}

.contact-icon {
    width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
    background-color: #161b22; /* Dark background for icon circle */
    border-radius: 50%;
    font-size: 1.1rem;
    flex-shrink: 0;
}

.contact-icon i {
    color: #ff9800; /* Orange icon */
}

.contact-details {
    flex: 1;
}

.contact-label {
    font-size: 0.9rem;
    font-weight: 600;
    color: white; /* White label */
    margin-bottom: 0.2rem;
}

.contact-link, .contact-details p {
    font-size: 1rem;
    color: #c9d1d9; /* Light text color */
    text-decoration: none;
    line-height: 1.5;
}

.contact-link:hover {
    color: white; /* White on hover */
}

.newsletter-form .input-group {
    border-radius: 0.5rem;
    overflow: hidden;
    background-color: #161b22; /* Dark input background */
    border: 1px solid #30363d; /* Dark border */
}

.newsletter-input {
    background-color: transparent !important;
    border: none !important;
    color: white !important;
    font-size: 1rem;
    padding: 0.75rem 1rem;
    box-shadow: none !important;
}

.newsletter-input::placeholder {
    color: #8b949e; /* Lighter placeholder text */
}

.btn-newsletter {
    background: linear-gradient(135deg, #ff9800 0%, #f57c00 100%); /* Orange gradient button */
    color: white !important;
    border: none;
    padding: 0.75rem 1.5rem;
    font-size: 1rem;
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
    height: auto; /* Allow height to adjust */
    width: 100%; /* Make the logo take the full width of its container */
    max-width: 100%; /* Ensure it doesn't exceed container width */
    filter: brightness(0) invert(1); /* Make logos white */
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
    font-size: 0.9rem;
    color: #8b949e; /* Lighter copyright text */
}

/* Responsive adjustments */
@media (max-width: 767.98px) {
    .footer-social {
        text-align: left; /* Align social icons left */
    }

    .social-icon {
        margin-right: 1rem; /* Maintain space between icons */
        margin-left: 0; /* Remove left margin if any */
    }

    .contact-item {
        justify-content: flex-start; /* Align contact items left */
        text-align: left;
    }

    .contact-details {
         text-align: left;
    }

    .partner-logos {
        justify-content: flex-start; /* Align partner logos left */
        text-align: left; /* Ensure container text align is left */
    }
    
    .footer-logo-container, .footer-tagline, .footer-address {
        text-align: left; /* Align these left */
    }

     .footer-heading {
        text-align: left; /* Align headings left */
     }

     .newsletter-form .input-group {
         flex-direction: column; /* Stack input and button */
         align-items: stretch; /* Stretch items to full width */
     }

     .newsletter-input,
     .btn-newsletter {
         width: 100% !important; /* Make input and button full width */
         margin-bottom: 0.5rem; /* Add space between stacked items */
     }

     .input-group > .form-control:not(:last-child),
     .input-group > .btn:not(:last-child) {
         border-top-right-radius: 0.5rem;
         border-bottom-right-radius: 0;
     }

      .input-group > .form-control:not(:first-child),
      .input-group > .btn:not(:first-child) {
         border-top-left-radius: 0;
         border-bottom-left-radius: 0.5rem;
     }

     .input-group > .btn:last-child {
          margin-bottom: 0; /* Remove bottom margin for the last item */
     }

     /* Mobile adjustments for the single logo-footer image */
     .partner-logo {
         width: auto; /* Revert width to auto */
         max-width: 150px; /* Set a reasonable max width */
         height: auto; /* Maintain aspect ratio */
         filter: brightness(0) invert(1); /* Keep it white */
         opacity: 1; /* Ensure full opacity */
     }
     
     .partner-logos {
         display: flex; /* Use flexbox again for alignment */
         justify-content: flex-start; /* Align logos to the left */
         align-items: center;
         gap: 1rem;
         flex-wrap: wrap;
     }

     .partner-logo-item {
        padding: 0; /* Remove padding if present */
        background-color: transparent; /* Remove background */
        box-shadow: none; /* Remove shadow */
     }
}

@media (max-width: 575.98px) {
    .footer-section {
        padding: 2rem 1rem; /* Adjust padding */
    }
    
    .footer-heading {
         margin-bottom: 1rem;
    }

     .contact-item {
        flex-direction: row; /* Revert to row for contact items */
        align-items: flex-start; /* Align icon to top */
        text-align: left;
        gap: 1rem; /* Restore gap */
        margin-bottom: 1rem; /* Adjust margin */
     }

     .contact-details {
         text-align: left;
     }

    .contact-label {
        margin-bottom: 0.2rem; /* Restore margin */
    }

    .newsletter-form {
        margin-bottom: 1.5rem; /* Adjust margin */
    }
    
    /* Adjust partner logo size for very small screens */
    .partner-logo {
        max-width: 120px; 
    }

     .partner-logos {
         gap: 0.5rem; /* Adjust gap for smaller screen */
     }
}
</style>