<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BINA | Complete Your Profile</title>

    {{-- Custom Favicon --}}
    <link rel="icon" href="{{ asset('favicon-client.png') }}" type="image/png">
    <link rel="shortcut icon" href="{{ asset('favicon-client.png') }}" type="image/png">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body>

<style>
body {
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(rgba(0,0,0,0.7), rgba(0,0,0,0.7)), url('{{ asset('images/hero-section.png') }}') no-repeat center center;
    background-size: cover;
    background-attachment: fixed;
    margin: 0;
    padding: 15px;
}

.profile-card {
    width: 100%;
    max-width: 800px;
    padding: 2rem;
    border-radius: 12px;
    box-shadow: 0 8px 32px rgba(0,0,0,0.2);
    background-color: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.2);
    margin: 2rem auto;
}

.header {
    text-align: center;
    margin-bottom: 2rem;
}

.header h4 {
    color: #1e293b;
    font-size: 1.5rem;
    margin: 0;
    text-transform: uppercase;
    letter-spacing: 1px;
}

.header p {
    color: #64748b;
    margin-top: 0.5rem;
}

.form-group {
    margin-bottom: 1.5rem;
}

.form-group label {
    font-weight: 500;
    margin-bottom: 0.5rem;
    display: block;
    color: #1e293b;
}

.form-control {
    padding: 0.75rem 1rem;
    border-radius: 8px;
    border: 1px solid #e2e8f0;
    background-color: rgba(255, 255, 255, 0.9);
    transition: all 0.3s ease;
}

.form-control:focus {
    box-shadow: 0 0 0 2px rgba(13, 110, 253, 0.25);
    border-color: #0d6efd;
    background-color: #fff;
}

.btn-submit {
    padding: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    background-color: #0d6efd;
    border: none;
    border-radius: 8px;
    transition: all 0.3s ease;
    color: white;
    width: 100%;
}

.btn-submit:hover {
    background-color: #0b5ed7;
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(13, 110, 253, 0.3);
}

.skip-link {
    text-align: center;
    margin-top: 1rem;
}

.skip-link a {
    color: #64748b;
    text-decoration: none;
    font-size: 0.875rem;
}

.skip-link a:hover {
    color: #0d6efd;
    text-decoration: underline;
}

.form-section {
    display: none;
}

.form-section.active {
    display: block;
}

.form-text {
    font-size: 0.875rem;
    color: #64748b;
}

.category-select {
    margin-bottom: 2rem;
    padding: 1rem;
    border: 1px solid #e2e8f0;
    border-radius: 8px;
    background-color: #f8fafc;
}

.category-select .form-check {
    margin-bottom: 0.5rem;
}

.category-select .form-check-input:checked {
    background-color: #0d6efd;
    border-color: #0d6efd;
}

.form-floating {
    margin-bottom: 1rem;
}

.social-links {
    background-color: #f8fafc;
    padding: 1rem;
    border-radius: 8px;
    margin-top: 1rem;
}

.social-links h5 {
    color: #1e293b;
    margin-bottom: 1rem;
    font-size: 1rem;
}

@media (max-width: 768px) {
    .profile-card {
        padding: 1.5rem;
        margin: 1rem;
    }
}

/* Modal Styles */
.modal-content {
    border: none;
    border-radius: 15px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
}

.modal-header {
    padding: 1.5rem 1.5rem 0.5rem;
}

.modal-body {
    padding: 2rem;
}

.btn-close {
    opacity: 0.5;
    transition: opacity 0.2s;
}

.btn-close:hover {
    opacity: 1;
}

.success-icon {
    color: #198754;
    font-size: 4rem;
    margin-bottom: 1rem;
}

.error-icon {
    color: #dc3545;
    font-size: 4rem;
    margin-bottom: 1rem;
}

#responseButton {
    padding: 0.75rem 2.5rem;
    font-weight: 600;
    border-radius: 8px;
    min-width: 160px;
}

#responseTitle {
    color: #1e293b;
    font-weight: 600;
}

#responseMessage {
    color: #64748b;
    font-size: 1rem;
    white-space: pre-line;
}
</style>

<div class="profile-card">
    <div class="header">
        <h4>Complete Your Profile</h4>
        <p>Please provide your details to complete your registration</p>
    </div>

    @if ($errors->any())
    <div class="alert alert-danger">
        <h5>Please fix the following errors:</h5>
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    @if (session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
    @endif

    @if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    <form id="userDetailsForm" method="POST" action="{{ route('client.user.details.update') }}">
        @csrf
        
        <div class="category-select">
            <label class="form-label fw-bold mb-3">Select your category:</label>
            <div class="form-check">
                <input class="form-check-input @error('category') is-invalid @enderror" 
                       type="radio" 
                       name="category" 
                       id="category-individual" 
                       value="individual" 
                       {{ old('category', 'individual') == 'individual' ? 'checked' : '' }}>
                <label class="form-check-label" for="category-individual">
                    Individual
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input @error('category') is-invalid @enderror" 
                       type="radio" 
                       name="category" 
                       id="category-academic" 
                       value="academic"
                       {{ old('category') == 'academic' ? 'checked' : '' }}>
                <label class="form-check-label" for="category-academic">
                    Academician
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input @error('category') is-invalid @enderror" 
                       type="radio" 
                       name="category" 
                       id="category-org" 
                       value="organization"
                       {{ old('category') == 'organization' ? 'checked' : '' }}>
                <label class="form-check-label" for="category-org">
                    Organization
                </label>
            </div>
            @error('category')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Individual Professional Fields -->
        <div id="individual-fields" class="form-section active">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="mobile_number">Mobile Number</label>
                        <input type="tel" 
                               class="form-control" 
                               name="mobile_number" 
                               id="mobile_number"
                               pattern="[0-9]*"
                               inputmode="numeric"
                               oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                               maxlength="15"
                               placeholder="e.g. 0123456789">
                    </div>
                </div>
            </div>
        </div>

        <!-- Academic Fields -->
        <div id="academic-fields" class="form-section">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="student_id">Student ID (optional)</label>
                        <input type="text" class="form-control" name="student_id" id="student_id">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="academic_institution">Academic Institution</label>
                        <input type="text" class="form-control" name="academic_institution" id="academic_institution">
                    </div>
                </div>
            </div>
        </div>

        <!-- Organization Fields -->
        <div id="organization-fields" class="form-section">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="job_title">Job Title</label>
                        <input type="text" class="form-control" name="job_title" id="job_title">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="organization">Organization</label>
                        <input type="text" class="form-control" name="organization" id="organization">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="green_card">Green Card Number (optional)</label>
                        <input type="text" class="form-control" name="green_card" id="green_card">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="impact_number">IMPACT Certified Number (optional)</label>
                        <input type="text" class="form-control" name="impact_number" id="impact_number">
                    </div>
                </div>
            </div>
        </div>

        <!-- Common Fields -->
        <div class="common-fields">
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="title">Title</label>
                        <select class="form-control" name="title" id="title">
                            <option value="">Select Title</option>
                            <option value="Mr">Mr.</option>
                            <option value="Mrs">Mrs.</option>
                            <option value="Ms">Ms.</option>
                            <option value="Dr">Dr.</option>
                            <option value="Prof">Prof.</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="first_name">First Name</label>
                        <input type="text" class="form-control" name="first_name" id="first_name">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="last_name">Last Name</label>
                        <input type="text" class="form-control" name="last_name" id="last_name">
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="about_me">About Me</label>
                <textarea class="form-control" name="about_me" id="about_me" rows="3"></textarea>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="address">Address</label>
                        <input type="text" class="form-control" name="address" id="address">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="city">City</label>
                        <input type="text" class="form-control" name="city" id="city">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="state">State</label>
                        <input type="text" class="form-control" name="state" id="state">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="postal_code">Postal Code</label>
                        <input type="text" 
                               class="form-control" 
                               name="postal_code" 
                               id="postal_code"
                               pattern="[0-9]*"
                               inputmode="numeric"
                               oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                               maxlength="10"
                               placeholder="e.g. 50450"
                               required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="country">Country</label>
                        <select class="form-control" name="country" id="country">
                            <option value="">Select Country</option>
                            <!-- Add country options dynamically -->
                        </select>
                    </div>
                </div>
            </div>

            <div class="social-links">
                <h5>Social Media & Website Links</h5>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="website">Website (optional)</label>
                            <input type="text" class="form-control" name="website" id="website" placeholder="https://company.com">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="linkedin">LinkedIn (optional)</label>
                            <input type="text" class="form-control" name="linkedin" id="linkedin" placeholder="LinkedIn Profile or Name">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="facebook">Facebook (optional)</label>
                            <input type="text" class="form-control" name="facebook" id="facebook" placeholder="Facebook Name or Username">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="twitter">Twitter (optional)</label>
                            <input type="text" class="form-control" name="twitter" id="twitter" placeholder="Twitter Handle">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="instagram">Instagram (optional)</label>
                            <input type="text" class="form-control" name="instagram" id="instagram" placeholder="Instagram Username">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <button type="submit" class="btn btn-submit mt-4">Save Profile</button>
    </form>

    <div class="skip-link">
        <a href="{{ route('client.login') }}">Skip for now</a>
    </div>
</div>

<!-- Response Modal -->
<div class="modal fade" id="responseModal" tabindex="-1" aria-labelledby="responseModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body text-center py-5">
                <div id="responseIcon" class="mb-4">
                    <!-- Icon will be inserted here by JS -->
                </div>
                <h4 id="responseTitle" class="mb-3"><!-- Title will be inserted here by JS --></h4>
                <p id="responseMessage" class="text-muted mb-4"><!-- Message will be inserted here by JS --></p>
                <button type="button" id="responseButton" class="btn btn-primary px-5">Continue</button>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    $(document).ready(function() {
        // Handle category selection
        $('input[name="category"]').change(function() {
            $('.form-section').removeClass('active');
            $('#' + $(this).val() + '-fields').addClass('active');
        });

        // Populate countries dropdown
        $.get('https://restcountries.com/v3.1/all', function(data) {
            const countries = data.sort((a, b) => a.name.common.localeCompare(b.name.common));
            const select = $('#country');
            countries.forEach(country => {
                select.append($('<option>', {
                    value: country.name.common,
                    text: country.name.common
                }));
            });
        });

        // Function to format error messages
        function formatErrorMessages(errors) {
            let formattedMessage = '';
            for (let field in errors) {
                if (Array.isArray(errors[field])) {
                    errors[field].forEach(error => {
                        formattedMessage += `• ${error}\n`;
                    });
                }
            }
            return formattedMessage;
        }

        // Function to show response modal
        function showResponseModal(success, title, message, redirectUrl = null) {
            const modal = $('#responseModal');
            const iconDiv = $('#responseIcon');
            const titleEl = $('#responseTitle');
            const messageEl = $('#responseMessage');
            const button = $('#responseButton');

            // Set modal content
            iconDiv.html(success ? 
                '<i class="bi bi-check-circle text-success" style="font-size: 3rem;"></i>' : 
                '<i class="bi bi-x-circle text-danger" style="font-size: 3rem;"></i>'
            );
            titleEl.text(title);
            messageEl.text(message);
            button.text(success ? 'Continue' : 'Try Again');
            button.removeClass('btn-primary btn-danger').addClass(success ? 'btn-primary' : 'btn-danger');

            // Handle button click
            button.off('click').on('click', function() {
                if (success && redirectUrl) {
                    window.location.href = redirectUrl;
                } else {
                    modal.modal('hide');
                }
            });

            // Show modal
            modal.modal('show');
        }

        // Handle form submission
        $('#userDetailsForm').on('submit', function(e) {
            e.preventDefault();
            
            $.ajax({
                url: $(this).attr('action'),
                method: 'POST',
                data: $(this).serialize(),
                success: function(response) {
                    if (response.success) {
                        showResponseModal(
                            true,
                            'Success!',
                            response.message,
                            response.redirect
                        );
                    }
                },
                error: function(xhr) {
                    const response = xhr.responseJSON;
                    if (response && response.errors) {
                        showResponseModal(
                            false,
                            response.message || 'Please Complete Required Fields',
                            formatErrorMessages(response.errors)
                        );
                    } else {
                        showResponseModal(
                            false,
                            'Error',
                            'An error occurred while updating your profile.\nPlease try again.'
                        );
                    }
                }
            });
        });
    });
</script>
</body>
</html> 