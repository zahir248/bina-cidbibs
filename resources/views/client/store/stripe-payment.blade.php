<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BINA | Secure Payment</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #ff9900;
            --primary-dark: #f57c00;
            --text-color: #1a1f36;
            --text-secondary: #697386;
            --background-color: #f7fafc;
            --border-color: #e3e8ee;
            --success-color: #0a2540;
            --error-color: #df1b41;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background-color: var(--background-color);
            color: var(--text-color);
            line-height: 1.6;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .header {
            background: white;
            padding: 0.75rem 0;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04);
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 100;
        }

        .header-content {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            height: 40px;
        }

        .security-badge {
            display: flex;
            align-items: center;
            color: var(--text-secondary);
            font-size: 0.9rem;
            gap: 0.5rem;
        }

        .security-badge i {
            color: var(--success-color);
        }

        .main-content {
            max-width: 1200px;
            margin: 80px auto 1rem;
            padding: 1.5rem;
            flex: 1;
        }

        .content-wrapper {
            display: flex;
            gap: 3rem;
            align-items: flex-start;
        }

        .section-title {
            font-size: 1.75rem;
            font-weight: 600;
            margin-bottom: 1.5rem;
            color: var(--success-color);
            text-align: center;
        }

        .payment-section {
            flex: 1;
            max-width: 600px;
        }

        .payment-card {
            background: white;
            border-radius: 12px;
            padding: 1.5rem;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            margin-bottom: 1rem;
        }

        #payment-element {
            margin: 0.5rem 0;
        }

        .payment-button {
            background: var(--primary-color);
            color: white;
            border: none;
            padding: 1rem;
            border-radius: 8px;
            font-weight: 600;
            font-size: 1rem;
            width: 100%;
            cursor: pointer;
            transition: all 0.2s ease;
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 0.75rem;
        }

        .payment-button:hover {
            background: var(--primary-dark);
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(255, 153, 0, 0.2);
        }

        .payment-button:disabled {
            background: #e2e8f0;
            cursor: not-allowed;
            transform: none;
            box-shadow: none;
        }

        #payment-message {
            color: var(--error-color);
            font-size: 0.875rem;
            line-height: 1.5;
            padding-top: 0.75rem;
            text-align: center;
        }

        .order-summary {
            width: 380px;
            background: white;
            border-radius: 12px;
            padding: 1.5rem;
            height: fit-content;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        }

        .order-summary-title {
            font-size: 1.25rem;
            font-weight: 600;
            margin-bottom: 1rem;
            color: var(--text-color);
        }

        .order-details {
            border-bottom: 1px solid var(--border-color);
            padding-bottom: 1rem;
            margin-bottom: 1rem;
        }

        .order-item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 1.25rem;
            color: var(--text-secondary);
            font-size: 0.9375rem;
            line-height: 1.5;
        }

        .order-item:last-child {
            margin-bottom: 0;
        }

        .order-item-name {
            flex: 1;
            padding-right: 1rem;
        }

        .order-item-price {
            text-align: right;
            white-space: nowrap;
        }

        .order-total {
            display: flex;
            justify-content: space-between;
            font-weight: 600;
            color: var(--text-color);
            font-size: 1.125rem;
            padding-top: 1.25rem;
        }

        .secure-badges {
            margin-top: 1rem;
            display: flex;
            justify-content: center;
            gap: 1.5rem;
            color: var(--text-secondary);
            font-size: 0.8125rem;
        }

        .secure-badge {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem 1rem;
            background: rgba(10, 37, 64, 0.02);
            border-radius: 6px;
        }

        .secure-badge i {
            font-size: 1rem;
            color: var(--success-color);
        }

        .country-selector {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            font-size: 1rem;
            color: #32325d;
            background-color: #f8f9fa;
            appearance: none;
            background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%2332325d' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3e%3cpolyline points='6 9 12 15 18 9'%3e%3c/polyline%3e%3c/svg%3e");
            background-repeat: no-repeat;
            background-position: right 1rem center;
            background-size: 1em;
            padding-right: 2.5rem;
            height: 45px;
            margin-top: 4px;
        }

        .country-selector:focus {
            outline: none;
            border-color: #32325d;
            box-shadow: 0 1px 3px 0 #e6ebf1;
            background-color: white;
        }

        .country-selector option {
            background-color: white;
            color: #32325d;
        }

        .country-label {
            display: block;
            color: #32325d;
            font-size: 0.9375rem;
            font-weight: 1;
        }

        .country-field-container {
            margin-bottom: 1.5rem;
            background: white;
            border-radius: 8px;
        }

        .fees-info {
            font-size: 0.875rem;
            color: var(--text-secondary);
            margin-top: 0.5rem;
            padding: 0.5rem;
            background: rgba(10, 37, 64, 0.02);
            border-radius: 6px;
        }

        @media (max-width: 1024px) {
            .main-content {
                flex-direction: column;
                gap: 2rem;
                margin-top: 80px;
                padding: 1.5rem;
            }

            .payment-section {
                max-width: 100%;
            }

            .order-summary {
                width: 100%;
            }
        }

        /* Loading spinner */
        .spinner {
            display: none;
            width: 20px;
            height: 20px;
            border: 2px solid #ffffff;
            border-bottom-color: transparent;
            border-radius: 50%;
            animation: spinner 0.75s linear infinite;
        }

        @keyframes spinner {
            to {
                transform: rotate(360deg);
            }
        }

        .divider {
            border-top: 1px solid var(--border-color);
            margin: 1rem 0;
        }
        
        /* Update order-item margin for better spacing with divider */
        .order-item {
            margin-bottom: 1rem;
        }
        .order-item:last-child {
            margin-bottom: 0;
        }
    </style>
</head>
<body>
    <header class="header">
        <div class="header-content">
            <img src="{{ asset('images/bina-logo.png') }}" alt="BINA Logo" class="logo">
            <div class="security-badge">
                <i class="fas fa-shield-alt"></i>
                <span>Secure Checkout</span>
            </div>
        </div>
    </header>

    <main class="main-content">
        <h1 class="section-title">Complete your payment</h1>
        <div class="content-wrapper">
            <div class="payment-section">
                <div class="payment-card">
                    <div class="country-field-container">
                        <label for="country-select" class="country-label">Country</label>
                        <select id="country-select" class="country-selector" required>
                            <option value="" disabled selected>Select Country</option>
                            <option value="Afghanistan">Afghanistan</option>
                            <option value="Albania">Albania</option>
                            <option value="Algeria">Algeria</option>
                            <option value="Andorra">Andorra</option>
                            <option value="Angola">Angola</option>
                            <option value="Argentina">Argentina</option>
                            <option value="Armenia">Armenia</option>
                            <option value="Australia">Australia</option>
                            <option value="Austria">Austria</option>
                            <option value="Azerbaijan">Azerbaijan</option>
                            <option value="Bahamas">Bahamas</option>
                            <option value="Bahrain">Bahrain</option>
                            <option value="Bangladesh">Bangladesh</option>
                            <option value="Barbados">Barbados</option>
                            <option value="Belarus">Belarus</option>
                            <option value="Belgium">Belgium</option>
                            <option value="Belize">Belize</option>
                            <option value="Benin">Benin</option>
                            <option value="Bhutan">Bhutan</option>
                            <option value="Bolivia">Bolivia</option>
                            <option value="Bosnia and Herzegovina">Bosnia and Herzegovina</option>
                            <option value="Botswana">Botswana</option>
                            <option value="Brazil">Brazil</option>
                            <option value="Brunei">Brunei</option>
                            <option value="Bulgaria">Bulgaria</option>
                            <option value="Burkina Faso">Burkina Faso</option>
                            <option value="Burundi">Burundi</option>
                            <option value="Cambodia">Cambodia</option>
                            <option value="Cameroon">Cameroon</option>
                            <option value="Canada">Canada</option>
                            <option value="China">China</option>
                            <option value="Colombia">Colombia</option>
                            <option value="Denmark">Denmark</option>
                            <option value="Egypt">Egypt</option>
                            <option value="Finland">Finland</option>
                            <option value="France">France</option>
                            <option value="Germany">Germany</option>
                            <option value="Greece">Greece</option>
                            <option value="Hong Kong">Hong Kong</option>
                            <option value="Hungary">Hungary</option>
                            <option value="Iceland">Iceland</option>
                            <option value="India">India</option>
                            <option value="Indonesia">Indonesia</option>
                            <option value="Iran">Iran</option>
                            <option value="Iraq">Iraq</option>
                            <option value="Ireland">Ireland</option>
                            <option value="Israel">Israel</option>
                            <option value="Italy">Italy</option>
                            <option value="Jamaica">Jamaica</option>
                            <option value="Japan">Japan</option>
                            <option value="Jordan">Jordan</option>
                            <option value="Kazakhstan">Kazakhstan</option>
                            <option value="Kenya">Kenya</option>
                            <option value="Kuwait">Kuwait</option>
                            <option value="Malaysia">Malaysia</option>
                            <option value="Maldives">Maldives</option>
                            <option value="Mexico">Mexico</option>
                            <option value="Morocco">Morocco</option>
                            <option value="Myanmar">Myanmar</option>
                            <option value="Nepal">Nepal</option>
                            <option value="Netherlands">Netherlands</option>
                            <option value="New Zealand">New Zealand</option>
                            <option value="Nigeria">Nigeria</option>
                            <option value="Norway">Norway</option>
                            <option value="Oman">Oman</option>
                            <option value="Pakistan">Pakistan</option>
                            <option value="Philippines">Philippines</option>
                            <option value="Poland">Poland</option>
                            <option value="Portugal">Portugal</option>
                            <option value="Qatar">Qatar</option>
                            <option value="Romania">Romania</option>
                            <option value="Russia">Russia</option>
                            <option value="Saudi Arabia">Saudi Arabia</option>
                            <option value="Singapore">Singapore</option>
                            <option value="South Africa">South Africa</option>
                            <option value="South Korea">South Korea</option>
                            <option value="Spain">Spain</option>
                            <option value="Sri Lanka">Sri Lanka</option>
                            <option value="Sweden">Sweden</option>
                            <option value="Switzerland">Switzerland</option>
                            <option value="Taiwan">Taiwan</option>
                            <option value="Thailand">Thailand</option>
                            <option value="Turkey">Turkey</option>
                            <option value="Ukraine">Ukraine</option>
                            <option value="United Arab Emirates">United Arab Emirates</option>
                            <option value="United Kingdom">United Kingdom</option>
                            <option value="United States">United States</option>
                            <option value="Vietnam">Vietnam</option>
                            <option value="Yemen">Yemen</option>
                        </select>
                    </div>
                    <form id="payment-form">
                        <div id="payment-element"></div>
                        <button id="submit" class="payment-button">
                            <div class="spinner" id="spinner"></div>
                            <i class="fas fa-lock" id="button-icon"></i>
                            <span id="button-text">Pay RM {{ number_format(session('pending_cart_total', 0), 2) }}</span>
                        </button>
                        <div id="payment-message"></div>
                    </form>
                </div>

                <div class="secure-badges">
                    <div class="secure-badge">
                        <i class="fas fa-lock"></i>
                        <span>SSL Encrypted</span>
                    </div>
                    <div class="secure-badge">
                        <i class="fas fa-shield-alt"></i>
                        <span>Secure Payment</span>
                    </div>
                    <div class="secure-badge">
                        <i class="fas fa-check-circle"></i>
                        <span>Guaranteed Safe</span>
                    </div>
                </div>
            </div>
            
            <div class="order-summary">
                <h2 class="order-summary-title">Order Summary</h2>
                <div class="order-details">
                    @php
                        $cartItems = session('pending_cart', []);
                        $cartTotal = session('pending_cart_total', 0);
                        $originalTotal = 0;
                    @endphp
                    
                    @foreach($cartItems as $item)
                        @php
                            $originalTotal += $item['quantity'] * $item['ticket']['price'];
                        @endphp
                        <div class="order-item">
                            <div class="order-item-name">
                                {{ $item['ticket']['name'] }} × {{ $item['quantity'] }}
                            </div>
                            <div class="order-item-price">
                                RM {{ number_format($item['quantity'] * $item['ticket']['price'], 2) }}
                            </div>
                        </div>
                    @endforeach
                    
                    @if($originalTotal > $cartTotal)
                        <div class="order-item">
                            <div class="order-item-name">Discount</div>
                            <div class="order-item-price">
                                -RM {{ number_format($originalTotal - $cartTotal, 2) }}
                            </div>
                        </div>
                    @endif

                    <div class="divider"></div>

                    <div class="order-item" id="processing-fee">
                        <div class="order-item-name">Total Processing Fee</div>
                        <div class="order-item-price">RM 0.00</div>
                    </div>
                </div>
                <div class="order-total">
                    <span>Total</span>
                    <span id="final-total">RM {{ number_format($cartTotal, 2) }}</span>
                </div>
                <div class="fees-info" id="fees-info">
                    Processing fee: 3% + RM1.00
                </div>
            </div>
        </div>
    </main>

    <script src="https://js.stripe.com/v3/"></script>
    <script>
        const stripe = Stripe('{{ $publicKey }}');
        const options = {
            clientSecret: '{{ $clientSecret }}',
            appearance: {
                theme: 'stripe',
                variables: {
                    colorPrimary: '#ff9900',
                },
            },
        };

        const elements = stripe.elements(options);
        const paymentElement = elements.create('payment', {
            defaultValues: {
                billingDetails: {
                    address: {
                        country: ''
                    }
                }
            },
            fields: {
                billingDetails: {
                    address: {
                        country: 'never',
                        line1: 'auto',
                        line2: 'auto',
                        city: 'auto',
                        state: 'auto',
                        postalCode: 'auto'
                    }
                }
            },
            wallets: {
                applePay: 'never',
                googlePay: 'never'
            }
        });
        paymentElement.mount('#payment-element');

        const form = document.getElementById('payment-form');
        const paymentMessage = document.getElementById('payment-message');
        const countrySelect = document.getElementById('country-select');
        const processingFee = document.getElementById('processing-fee');
        const finalTotal = document.getElementById('final-total');
        const feesInfo = document.getElementById('fees-info');
        const buttonText = document.getElementById('button-text');
        const submitButton = document.getElementById('submit');
        let currentTotal = 0; // Track the current total with fees

        function calculateFees(subtotal, country) {
            let fee = 0;
            let feeDescription = '';
            
            // Convert subtotal to number to ensure proper calculation
            subtotal = parseFloat(subtotal);

            if (!country) {
                feeDescription = 'Please select your card\'s registered country';
                return { fee: 0, total: subtotal, description: feeDescription };
            }

            if (country === 'Malaysia') {
                // For Malaysian transactions:
                // Stripe fee is 3% + RM1.00
                // To get exact base amount (b) as payout:
                // x - (0.03x + 1) = b
                // x - 0.03x = b + 1
                // 0.97x = b + 1
                // x = (b + 1) / 0.97
                
                const totalNeeded = Math.ceil((subtotal + 1) / 0.97 * 100) / 100;
                fee = totalNeeded - subtotal;
                
                // Calculate the actual Stripe fee for display
                const percentageFee = totalNeeded * 0.03;
                const fixedFee = 1.00;
                const totalStripeFee = percentageFee + fixedFee;
                
                feeDescription = `Processing fees breakdown:<br><br>` +
                    `Stripe fee (3% + RM1.00): RM${totalStripeFee.toFixed(2)}`;
            } else {
                // For international payments:
                // Base Stripe fee: 3% + RM1.00
                // International fee: 1%
                // Currency conversion: 2%
                // Total fee percentage: 6%
                // x - (0.06x + 1) = b
                // 0.94x = b + 1
                // x = (b + 1) / 0.94
                
                const totalNeeded = Math.ceil((subtotal + 1) / 0.94 * 100) / 100;
                fee = totalNeeded - subtotal;
                
                // Calculate fee components for display
                const stripeFee = (totalNeeded * 0.03) + 1;
                const internationalFee = totalNeeded * 0.01;
                const conversionFee = totalNeeded * 0.02;
                const totalFee = stripeFee + internationalFee + conversionFee;
                
                                    feeDescription = `Processing fees breakdown:<br><br>` +
                        `Stripe fee (3% + RM1.00): RM${stripeFee.toFixed(2)}<br>` +
                        `International fee (1%): RM${internationalFee.toFixed(2)}<br>` +
                        `Currency conversion (2%): RM${conversionFee.toFixed(2)}`;
            }

            const total = subtotal + fee;
            return {
                fee: fee,
                total: total,
                description: feeDescription
            };
        }

        function updateTotals() {
            try {
                const subtotal = {{ session('pending_cart_total', 0) }};
                if (!validatePaymentAmount(subtotal)) {
                    throw new Error('Invalid cart total');
                }

                const country = countrySelect.value;
                const { fee, total, description } = calculateFees(subtotal, country);
                
                if (!validatePaymentAmount(total)) {
                    throw new Error('Invalid total after fees');
                }

                currentTotal = total;

                // Update processing fee display
                processingFee.querySelector('.order-item-price').textContent = 
                    `RM ${fee.toFixed(2)}`;

                // Update total amount
                finalTotal.textContent = `RM ${total.toFixed(2)}`;
                buttonText.textContent = `Pay RM ${total.toFixed(2)}`;

                // Update fees description with HTML
                feesInfo.innerHTML = description;

                // Enable/disable submit button
                submitButton.disabled = !country;

                // Update Stripe's payment element country
                if (country && paymentElement) {
                    const countryCode = getCountryCode(country);
                    if (countryCode) {
                        paymentElement.update({
                            defaultValues: {
                                billingDetails: {
                                    address: {
                                        country: countryCode
                                    }
                                }
                            }
                        });
                    }
                }

                // Log for debugging
                console.log('Updated totals:', {
                    country: country,
                    subtotal: subtotal,
                    fee: fee,
                    total: total
                });
            } catch (e) {
                console.error('Error in updateTotals:', e);
                paymentMessage.textContent = 'There was an error calculating the total. Please refresh the page.';
                submitButton.disabled = true;
            }
        }

        // Function to convert country names to ISO codes
        function getCountryCode(country) {
            const countryMapping = {
                'Malaysia': 'MY',
                'United States': 'US',
                'United Kingdom': 'GB',
                'Indonesia': 'ID',
                'Singapore': 'SG',
                'Thailand': 'TH',
                'Vietnam': 'VN',
                'Philippines': 'PH',
                'China': 'CN',
                'Japan': 'JP',
                'South Korea': 'KR',
                'India': 'IN',
                'Australia': 'AU',
                'New Zealand': 'NZ',
                'Canada': 'CA',
                'Germany': 'DE',
                'France': 'FR',
                'Italy': 'IT',
                'Spain': 'ES',
                'Netherlands': 'NL',
                'Belgium': 'BE',
                'Switzerland': 'CH',
                'Austria': 'AT',
                'Sweden': 'SE',
                'Norway': 'NO',
                'Denmark': 'DK',
                'Finland': 'FI',
                'Russia': 'RU',
                'Brazil': 'BR',
                'Mexico': 'MX',
                'Argentina': 'AR',
                'South Africa': 'ZA',
                'United Arab Emirates': 'AE',
                'Saudi Arabia': 'SA',
                'Turkey': 'TR',
                'Israel': 'IL',
                'Egypt': 'EG',
                'Afghanistan': 'AF',
                'Albania': 'AL',
                'Algeria': 'DZ',
                'Andorra': 'AD',
                'Angola': 'AO',
                'Armenia': 'AM',
                'Azerbaijan': 'AZ',
                'Bahamas': 'BS',
                'Bahrain': 'BH',
                'Bangladesh': 'BD',
                'Barbados': 'BB',
                'Belarus': 'BY',
                'Belize': 'BZ',
                'Benin': 'BJ',
                'Bhutan': 'BT',
                'Bolivia': 'BO',
                'Bosnia and Herzegovina': 'BA',
                'Botswana': 'BW',
                'Brunei': 'BN',
                'Bulgaria': 'BG',
                'Burkina Faso': 'BF',
                'Burundi': 'BI',
                'Cambodia': 'KH',
                'Cameroon': 'CM',
                'Colombia': 'CO',
                'Greece': 'GR',
                'Hong Kong': 'HK',
                'Hungary': 'HU',
                'Iceland': 'IS',
                'Iran': 'IR',
                'Iraq': 'IQ',
                'Ireland': 'IE',
                'Jamaica': 'JM',
                'Jordan': 'JO',
                'Kazakhstan': 'KZ',
                'Kenya': 'KE',
                'Kuwait': 'KW',
                'Maldives': 'MV',
                'Morocco': 'MA',
                'Myanmar': 'MM',
                'Nepal': 'NP',
                'Nigeria': 'NG',
                'Oman': 'OM',
                'Pakistan': 'PK',
                'Poland': 'PL',
                'Portugal': 'PT',
                'Qatar': 'QA',
                'Romania': 'RO',
                'Sri Lanka': 'LK',
                'Taiwan': 'TW',
                'Ukraine': 'UA',
                'Yemen': 'YE'
            };
            return countryMapping[country] || '';
        }

        // Add event listener for country select change
        if (countrySelect) {
            countrySelect.addEventListener('change', async function() {
                try {
                    const subtotal = {{ session('pending_cart_total', 0) }};
                    const { total } = calculateFees(subtotal, this.value);
                    
                    // Update PaymentIntent amount on the server
                    const response = await fetch('{{ route('update.payment.amount') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            country: this.value,
                            amount: total
                        })
                    });

                    if (!response.ok) {
                        throw new Error('Failed to update payment amount');
                    }

                    // Update UI
                    updateTotals();
                } catch (error) {
                    console.error('Error updating payment amount:', error);
                    paymentMessage.textContent = 'Error updating payment amount. Please refresh the page and try again.';
                }
            });
        }

        // Initial calculation when page loads
        document.addEventListener('DOMContentLoaded', function() {
            updateTotals();
        });

        form.addEventListener('submit', async (e) => {
            e.preventDefault();

            if (!countrySelect.value) {
                paymentMessage.textContent = 'Please select a country before proceeding with payment.';
                return;
            }

            setLoading(true);
            paymentMessage.textContent = '';

            try {
                // Calculate final amount with fees
                const subtotal = {{ session('pending_cart_total', 0) }};
                const { total } = calculateFees(subtotal, countrySelect.value);

                const {error} = await stripe.confirmPayment({
                    elements,
                    confirmParams: {
                        return_url: '{{ url('/payment/stripe/callback') }}?' + new URLSearchParams({
                            country: countrySelect.value,
                            calculated_total: total.toFixed(2)
                        }).toString(),
                        payment_method_data: {
                            billing_details: {
                                address: {
                                    country: getCountryCode(countrySelect.value)
                                }
                            }
                        }
                    }
                });

                if (error) {
                    if (error.type === 'card_error' || error.type === 'validation_error') {
                        paymentMessage.textContent = error.message;
                    } else {
                        paymentMessage.textContent = 'Please try again.';
                    }
                    console.error('Stripe error:', error);
                    setLoading(false);
                }
            } catch (e) {
                console.error('Payment error:', e);
                paymentMessage.textContent = e.message || "An unexpected error occurred. Please check your payment details and try again.";
                setLoading(false);
            }
        });

        // Update the setLoading function to handle errors better
        function setLoading(isLoading) {
            const spinner = document.querySelector("#spinner");
            const buttonIcon = document.querySelector("#button-icon");

            try {
                if (isLoading) {
                    submitButton.disabled = true;
                    spinner.style.display = "inline-block";
                    buttonIcon.style.display = "none";
                    buttonText.textContent = "Processing...";
                } else {
                    submitButton.disabled = !countrySelect.value;
                    spinner.style.display = "none";
                    buttonIcon.style.display = "inline-block";
                    updateTotals();
                }
            } catch (e) {
                console.error('Error in setLoading:', e);
                // Ensure button is enabled if there's an error
                if (submitButton) submitButton.disabled = false;
            }
        }

        // Add validation for the total amount
        function validatePaymentAmount(amount) {
            return !isNaN(amount) && amount > 0 && amount <= 999999999; // Add reasonable maximum
        }

        // Add error handling for payment element
        paymentElement.on('change', (event) => {
            if (event.error) {
                paymentMessage.textContent = event.error.message;
            } else {
                paymentMessage.textContent = '';
            }
        });
    </script>
</body>
</html> 