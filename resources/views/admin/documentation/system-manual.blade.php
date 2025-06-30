<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>BINA System Documentation</title>
    <style>
        /* PDF-friendly styles */
        @page {
            margin: 30px;
            size: A4;
        }

        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            margin: 20px;
        }
        
        .page-header {
            text-align: center;
            margin-bottom: 20px;
        }
        
        .page-title {
            font-size: 28px;
            font-weight: bold;
            margin-bottom: 15px;
            color: #2c3e50;
        }
        
        .manual-intro {
            background-color: #f8f9fa;
            padding: 12px;
            margin-bottom: 20px;
            border: 1px solid #dee2e6;
            border-radius: 5px;
        }
        
        .section {
            margin-bottom: 20px;
        }
        
        .section-title {
            font-size: 24px;
            color: #2c3e50;
            border-bottom: 2px solid #3498db;
            padding-bottom: 8px;
            margin-bottom: 15px;
        }
        
        .subsection {
            margin-bottom: 20px;
            margin-left: 20px;
        }
        
        .subsection-title {
            font-size: 20px;
            color: #34495e;
            margin-bottom: 12px;
        }
        
        .content-block {
            margin-bottom: 15px;
            margin-left: 20px;
        }
        
        .block-title {
            font-weight: bold;
            color: #2c3e50;
            margin-bottom: 8px;
        }
        
        .info-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }
        
        .info-table th, .info-table td {
            border: 1px solid #dee2e6;
            padding: 6px 10px;
            text-align: left;
        }
        
        .info-table th {
            background-color: #f8f9fa;
            font-weight: bold;
        }
        
        .info-list {
            list-style-type: none;
            padding-left: 20px;
            margin-bottom: 12px;
        }
        
        .info-list li {
            margin-bottom: 6px;
            position: relative;
        }
        
        .info-list li:before {
            content: "•";
            position: absolute;
            left: -15px;
            color: #3498db;
        }
        
        .note-box {
            background-color: #fff3cd;
            border: 1px solid #ffeeba;
            padding: 12px;
            margin: 15px 0;
            border-radius: 5px;
        }
        
        .note-title {
            font-weight: bold;
            color: #856404;
            margin-bottom: 8px;
        }
        
        .page-break {
            page-break-before: always;
        }
    </style>
</head>
<body>
    <div class="page-header">
        <h1 class="page-title">BINA System Documentation</h1>
        <div class="manual-intro">
            <p>This comprehensive documentation provides detailed information about BINA's system architecture, design patterns, and technical specifications. It serves as a reference for developers and system maintainers to understand the system's structure and functionality.</p>
        </div>
    </div>

    <div class="section">
        <h2 class="section-title">1. System Architecture</h2>
        
        <div class="subsection">
            <h3 class="subsection-title">1.1 Core Technologies</h3>
            <div class="content-block">
                <div class="block-title">Framework and Libraries:</div>
                <ul class="info-list">
                    <li>Backend:
                        <ul>
                            <li>Laravel (PHP) - Main framework</li>
                            <li>Laravel Sanctum - Authentication</li>
                            <li>DomPDF - PDF generation</li>
                            <li>chillerlan/php-qrcode - QR code generation</li>
                        </ul>
                    </li>
                    <li>Frontend:
                        <ul>
                            <li>Blade Templates - View rendering</li>
                            <li>Bootstrap 5 - UI framework</li>
                            <li>JavaScript/jQuery - Client-side interactions</li>
                        </ul>
                    </li>
                    <li>Database:
                        <ul>
                            <li>MySQL - Primary database</li>
                            <li>Laravel Migrations - Schema management</li>
                            <li>Eloquent ORM - Database interactions</li>
                        </ul>
                    </li>
                    <li>External Services:
                        <ul>
                            <li>Stripe API - International payments</li>
                            <li>ToyyibPay - Malaysian FPX payments</li>
                            <li>Google OAuth2 - Social authentication</li>
                        </ul>
                    </li>
                </ul>

                <div class="note-box">
                    <div class="note-title">System Requirements</div>
                    <ul class="info-list">
                        <li>Server Requirements:
                            <ul>
                                <li>PHP >= 8.1</li>
                                <li>MySQL >= 5.7</li>
                                <li>SSL certificate (for secure transactions)</li>
                                <li>Composer (dependency management)</li>
                                <li>Node.js and NPM (asset compilation)</li>
                            </ul>
                        </li>
                        <li>PHP Extensions:
                            <ul>
                                <li>OpenSSL</li>
                                <li>PDO</li>
                                <li>Mbstring</li>
                                <li>Tokenizer</li>
                                <li>XML</li>
                                <li>Ctype</li>
                                <li>JSON</li>
                                <li>GD (for image processing)</li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="page-break"></div>

        <div class="subsection">
            <h3 class="subsection-title">1.2 Directory Structure</h3>
            <div class="content-block">
                <div class="block-title">Application Organization:</div>
                <ul class="info-list">
                    <li>app/
                        <ul>
                            <li>Http/Controllers/
                                <ul>
                                    <li>Admin/ - Administrative controllers</li>
                                    <li>Client/ - Client-facing controllers</li>
                                </ul>
                            </li>
                            <li>Models/ - Eloquent models</li>
                            <li>Helpers/ - Utility classes</li>
                            <li>Providers/ - Service providers</li>
                            <li>Middleware/ - Request filters</li>
                        </ul>
                    </li>
                    <li>resources/
                        <ul>
                            <li>views/ - Blade templates
                                <ul>
                                    <li>admin/ - Admin panel views</li>
                                    <li>client/ - Client-facing views</li>
                                    <li>emails/ - Email templates</li>
                                </ul>
                            </li>
                            <li>css/ - SCSS/CSS files</li>
                            <li>js/ - JavaScript files</li>
                        </ul>
                    </li>
                    <li>storage/
                        <ul>
                            <li>app/ - Application files</li>
                            <li>logs/ - System logs
                                <ul>
                                    <li>payments/ - Payment transaction logs</li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                    <li>public/
                        <ul>
                            <li>images/ - Uploaded and static images</li>
                            <li>css/ - Compiled CSS</li>
                            <li>js/ - Compiled JavaScript</li>
                            <li>files/ - Public downloadable files</li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>

        <div class="page-break"></div>

        <div class="subsection">
            <h3 class="subsection-title">1.3 Payment System</h3>
            <div class="content-block">
                <div class="block-title">Components and Flow:</div>
                <ul class="info-list">
                    <li>Core Components:
                        <ul>
                            <li>CheckoutController - Payment processing</li>
                            <li>PaymentLogger - Transaction logging</li>
                            <li>PDF Generator - Order documents</li>
                            <li>Email Service - Notifications</li>
                        </ul>
                    </li>
                    <li>Payment Methods:
                        <ul>
                            <li>ToyyibPay (FPX):
                                <ul>
                                    <li>Personal and corporate banking</li>
                                    <li>B2B transaction support</li>
                                    <li>Malaysian banks only</li>
                                </ul>
                            </li>
                            <li>Stripe:
                                <ul>
                                    <li>International cards</li>
                                    <li>Dynamic currency conversion</li>
                                    <li>Automatic fee calculation</li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                    <li>Transaction Process:
                        <ul>
                            <li>Input validation</li>
                            <li>Cart verification</li>
                            <li>Payment processing</li>
                            <li>Order creation</li>
                            <li>Stock update</li>
                            <li>Document generation</li>
                            <li>Email notification</li>
                        </ul>
                    </li>
                </ul>

                <div class="note-box">
                    <div class="note-title">Technical Specifications</div>
                    <ul class="info-list">
                        <li>Monetary values stored in smallest currency unit</li>
                        <li>Automatic phone number formatting</li>
                        <li>Name length restrictions for payment gateways</li>
                        <li>Transaction logging in storage/logs/payments/</li>
                        <li>PDF generation with DomPDF library</li>
                        <li>QR code generation for tickets</li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="page-break"></div>

        <div class="subsection">
            <h3 class="subsection-title">1.4 QR Code System</h3>
            <div class="content-block">
                <div class="block-title">QR Code Generation:</div>
                <ul class="info-list">
                    <li>Library: chillerlan/php-qrcode v5.0
                        <ul>
                            <li>High error correction level (EccLevel::H)</li>
                            <li>SVG output format</li>
                            <li>Automatic version selection</li>
                            <li>Custom styling capabilities</li>
                        </ul>
                    </li>
                    <li>Configuration Options:
                        <ul>
                            <li>Scale factor: 10x</li>
                            <li>Quiet zone size: 2 units</li>
                            <li>Circular modules with 0.45 radius</li>
                            <li>Custom color scheme (black and white)</li>
                        </ul>
                    </li>
                    <li>Data Structure:
                        <ul>
                            <li>JSON encoded data:
                                <ul>
                                    <li>Reference number (ref)</li>
                                    <li>Ticket name (tkt)</li>
                                </ul>
                            </li>
                            <li>Unique per ticket instance</li>
                            <li>Compact data format for optimal scanning</li>
                        </ul>
                    </li>
                    <li>Storage and Naming:
                        <ul>
                            <li>Storage location: public/storage/qrcodes/</li>
                            <li>Filename format: reference_number_ticket_name_number.svg</li>
                            <li>Special character handling in filenames</li>
                            <li>Public accessibility for email embedding</li>
                        </ul>
                    </li>
                </ul>

                <div class="block-title">Implementation Details:</div>
                <ul class="info-list">
                    <li>Generation Process:
                        <ul>
                            <li>Triggered after successful order creation</li>
                            <li>Generated per individual ticket (not per order)</li>
                            <li>Sequential numbering for multiple quantities</li>
                            <li>Error handling with logging</li>
                        </ul>
                    </li>
                    <li>Output Handling:
                        <ul>
                            <li>SVG format for high quality scaling</li>
                            <li>Direct storage disk writing</li>
                            <li>URL generation for email embedding</li>
                            <li>Metadata tracking for each QR code</li>
                        </ul>
                    </li>
                </ul>

                <div class="note-box">
                    <div class="note-title">Important Considerations</div>
                    <ul class="info-list">
                        <li>High error correction level ensures reliable scanning</li>
                        <li>SVG format maintains quality at any size</li>
                        <li>Circular modules improve aesthetic appearance</li>
                        <li>Each QR code contains minimal but sufficient data</li>
                        <li>Filenames are sanitized for cross-platform compatibility</li>
                        <li>Debug logging enabled for troubleshooting</li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="page-break"></div>

        <div class="subsection">
            <h3 class="subsection-title">1.5 Security Implementation</h3>
            <div class="content-block">
                <div class="block-title">Security Measures:</div>
                <ul class="info-list">
                    <li>Authentication:
                        <ul>
                            <li>Laravel Sanctum for API tokens</li>
                            <li>Session-based authentication</li>
                            <li>Google OAuth2 integration</li>
                            <li>Role-based access control</li>
                        </ul>
                    </li>
                    <li>Data Protection:
                        <ul>
                            <li>HTTPS enforcement</li>
                            <li>CSRF protection</li>
                            <li>SQL injection prevention</li>
                            <li>XSS protection</li>
                        </ul>
                    </li>
                    <li>Payment Security:
                        <ul>
                            <li>PCI compliance via Stripe</li>
                            <li>Secure webhook handling</li>
                            <li>Transaction logging</li>
                            <li>Data encryption</li>
                        </ul>
                    </li>
                </ul>

                <div class="note-box">
                    <div class="note-title">Best Practices</div>
                    <ul class="info-list">
                        <li>Regular security updates</li>
                        <li>Secure password policies</li>
                        <li>Input validation and sanitization</li>
                        <li>Error logging and monitoring</li>
                        <li>Backup and recovery procedures</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="page-break"></div>

    <div class="section">
        <h2 class="section-title">2. System Maintenance</h2>
        
        <div class="subsection">
            <h3 class="subsection-title">2.1 Payment System Architecture</h3>
            <div class="content-block">
                <div class="block-title">Payment Processing Flow:</div>
                <ul class="info-list">
                    <li>Components:
                        <ul>
                            <li>CheckoutController - Main payment processing logic</li>
                            <li>PaymentLogger - Transaction logging system</li>
                            <li>PDF Generator - Order confirmation documents</li>
                            <li>Email Service - Order notifications</li>
                        </ul>
                    </li>
                    <li>Payment Methods:
                        <ul>
                            <li>ToyyibPay (FPX):
                                <ul>
                                    <li>Personal and corporate banking</li>
                                    <li>Automatic B2B detection for organizations</li>
                                    <li>Direct bank integration</li>
                                </ul>
                            </li>
                            <li>Stripe:
                                <ul>
                                    <li>International credit/debit cards</li>
                                    <li>Dynamic currency conversion</li>
                                    <li>Automatic fee calculation</li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                    <li>Database Schema:
                        <ul>
                            <li>orders:
                                <ul>
                                    <li>Reference number (ORDER-xxx or STR-xxx format)</li>
                                    <li>Payment method and status</li>
                                    <li>Total amount and processing fees</li>
                                    <li>Cart items (JSON structure)</li>
                                </ul>
                            </li>
                            <li>billing_details:
                                <ul>
                                    <li>Customer information</li>
                                    <li>Category-specific fields (individual/organization/academician)</li>
                                    <li>Address and contact details</li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                </ul>

                <div class="block-title">Transaction Logging:</div>
                <ul class="info-list">
                    <li>Log Files:
                        <ul>
                            <li>payment_success.log - Successful transactions</li>
                            <li>payment_failures.log - Failed transactions</li>
                        </ul>
                    </li>
                    <li>Log Entry Format:
                        <ul>
                            <li>Timestamp</li>
                            <li>Payment method</li>
                            <li>Status and reason</li>
                            <li>Transaction details</li>
                            <li>Additional data (reference number, amount)</li>
                        </ul>
                    </li>
                    <li>Storage Location: storage/logs/payments/</li>
                </ul>

                <div class="block-title">Order Processing:</div>
                <ul class="info-list">
                    <li>Validation:
                        <ul>
                            <li>Input validation with specific length limits</li>
                            <li>Category-specific field validation</li>
                            <li>Phone number formatting for payment gateways</li>
                        </ul>
                    </li>
                    <li>Transaction Steps:
                        <ul>
                            <li>Cart validation and total calculation</li>
                            <li>Billing information processing</li>
                            <li>Payment gateway integration</li>
                            <li>Order creation and stock update</li>
                            <li>QR code generation</li>
                            <li>PDF generation and email notification</li>
                        </ul>
                    </li>
                    <li>Error Handling:
                        <ul>
                            <li>Transaction rollback on failure</li>
                            <li>Detailed error logging</li>
                            <li>User-friendly error messages</li>
                            <li>Payment gateway error handling</li>
                        </ul>
                    </li>
                </ul>

                <div class="note-box">
                    <div class="note-title">Important Considerations</div>
                    <ul class="info-list">
                        <li>All monetary values are stored and processed in cents/smallest currency unit</li>
                        <li>Phone numbers are automatically formatted for payment gateway requirements</li>
                        <li>Name lengths are restricted to match payment gateway limits</li>
                        <li>B2B transactions have additional validation and processing rules</li>
                        <li>All transactions are logged for audit purposes</li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="subsection">
            <h3 class="subsection-title">2.2 PDF Generation System</h3>
            <div class="content-block">
                <div class="block-title">Components:</div>
                <ul class="info-list">
                    <li>PDF Templates:
                        <ul>
                            <li>Order confirmation template</li>
                            <li>QR code pages template</li>
                        </ul>
                    </li>
                    <li>Generation Process:
                        <ul>
                            <li>Dynamic content compilation</li>
                            <li>QR code generation and embedding</li>
                            <li>Multi-page document handling</li>
                            <li>Automatic page breaks</li>
                        </ul>
                    </li>
                    <li>Content Structure:
                        <ul>
                            <li>Order details page:
                                <ul>
                                    <li>Customer information</li>
                                    <li>Order summary</li>
                                    <li>Price breakdown</li>
                                </ul>
                            </li>
                            <li>QR code pages:
                                <ul>
                                    <li>4 QR codes per page maximum</li>
                                    <li>Individual ticket information</li>
                                    <li>Ticket numbering system</li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                </ul>

                <div class="note-box">
                    <div class="note-title">PDF Settings</div>
                    <ul class="info-list">
                        <li>A4 page size with optimized margins</li>
                        <li>Embedded fonts for consistent rendering</li>
                        <li>High-quality QR code resolution</li>
                        <li>Printer-friendly layout</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="page-break"></div>

    <div class="section">
        <h2 class="section-title">3. Database Design</h2>
        
        <div class="subsection">
            <h3 class="subsection-title">2.1 Core Tables</h3>
            <div class="content-block">
                <div class="block-title">Database Configuration:</div>
                <ul class="info-list">
                    <li>Engine: InnoDB</li>
                    <li>Character Set: UTF8MB4</li>
                    <li>Collation: utf8mb4_unicode_ci</li>
                    <li>Foreign Key Constraints: Enabled</li>
                </ul>

                <div class="block-title">Main Database Tables:</div>
                <table class="info-table">
                    <tr>
                        <th>Table Name</th>
                        <th>Description</th>
                        <th>Key Fields</th>
                        <th>Relationships</th>
                    </tr>
                    <tr>
                        <td>users</td>
                        <td>User accounts and authentication</td>
                        <td>
                            <ul>
                                <li>id (PK)</li>
                                <li>name</li>
                                <li>email (unique)</li>
                                <li>password (hashed)</li>
                                <li>role</li>
                                <li>google_id</li>
                                <li>avatar</li>
                                <li>email_verified_at</li>
                                <li>remember_token</li>
                            </ul>
                        </td>
                        <td>
                            <ul>
                                <li>Has one UserProfile</li>
                                <li>Has many ConnectionRequests (as sender/receiver)</li>
                                <li>Has many Messages (as sender/receiver)</li>
                            </ul>
                        </td>
                    </tr>
                    <tr>
                        <td>user_profiles</td>
                        <td>Extended user information and preferences</td>
                        <td>
                            <ul>
                                <li>id (PK)</li>
                                <li>user_id (FK)</li>
                                <li>category</li>
                                <li>mobile_number</li>
                                <li>student_id</li>
                                <li>academic_institution</li>
                                <li>job_title</li>
                                <li>organization</li>
                                <li>green_card</li>
                                <li>impact_number</li>
                                <li>title</li>
                                <li>first_name</li>
                                <li>last_name</li>
                                <li>about_me</li>
                                <li>address</li>
                                <li>city</li>
                                <li>state</li>
                                <li>postal_code</li>
                                <li>country</li>
                                <li>website</li>
                                <li>social media links</li>
                                <li>nature_of_business</li>
                            </ul>
                        </td>
                        <td>
                            <ul>
                                <li>Belongs to User</li>
                            </ul>
                        </td>
                    </tr>
                    <tr>
                        <td>events</td>
                        <td>Event management and scheduling</td>
                        <td>
                            <ul>
                                <li>id (PK)</li>
                                <li>title (uppercase)</li>
                                <li>description</li>
                                <li>location</li>
                                <li>start_date</li>
                                <li>end_date</li>
                                <li>image</li>
                                <li>organizer</li>
                                <li>slug</li>
                                <li>is_featured</li>
                                <li>is_published</li>
                            </ul>
                        </td>
                        <td>
                            <ul>
                                <li>Has many Schedules</li>
                            </ul>
                        </td>
                    </tr>
                    <tr>
                        <td>schedules</td>
                        <td>Event schedule and session management</td>
                        <td>
                            <ul>
                                <li>id (PK)</li>
                                <li>title</li>
                                <li>description (nullable)</li>
                                <li>start_time</li>
                                <li>end_time (nullable)</li>
                                <li>session</li>
                                <li>event_type</li>
                            </ul>
                        </td>
                        <td>
                            <ul>
                                <li>Belongs to Event</li>
                            </ul>
                        </td>
                    </tr>
                    <tr>
                        <td>podcasts</td>
                        <td>Podcast episode management for BINA and FM podcasts</td>
                        <td>
                            <ul>
                                <li>id (PK)</li>
                                <li>type (bina/fm)</li>
                                <li>episode_number</li>
                                <li>title</li>
                                <li>description (nullable)</li>
                                <li>image (nullable)</li>
                                <li>youtube_url (nullable)</li>
                                <li>panelists (JSON, nullable)</li>
                                <li>is_live_streaming (boolean)</li>
                                <li>live_streaming_event (nullable)</li>
                                <li>is_coming_soon (boolean)</li>
                                <li>display_order (integer)</li>
                                <li>is_active (boolean)</li>
                                <li>is_special (boolean)</li>
                                <li>special_position (above/below, nullable)</li>
                                <li>created_at</li>
                                <li>updated_at</li>
                            </ul>
                        </td>
                        <td>
                            <ul>
                                <li>Self-referential for special episodes</li>
                                <li>Special episodes are linked to regular episodes by episode_number</li>
                            </ul>
                        </td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="page-break"></div>

        <div class="subsection">
            <h3 class="subsection-title">2.2 E-commerce Tables</h3>
            <div class="content-block">
                <table class="info-table">
                    <tr>
                        <th>Table Name</th>
                        <th>Description</th>
                        <th>Key Fields</th>
                        <th>Relationships</th>
                    </tr>
                    <tr>
                        <td>tickets</td>
                        <td>Ticket inventory and pricing management</td>
                        <td>
                            <ul>
                                <li>id (PK)</li>
                                <li>name</li>
                                <li>price</li>
                                <li>sku</li>
                                <li>categories (JSON)</li>
                                <li>quantity_discounts (JSON)</li>
                                <li>can_select_quantity</li>
                                <li>image</li>
                                <li>description</li>
                                <li>additional_info</li>
                                <li>stock</li>
                            </ul>
                        </td>
                        <td>
                            <ul>
                                <li>Has many CartItems</li>
                            </ul>
                        </td>
                    </tr>
                    <tr>
                        <td>cart_items</td>
                        <td>Shopping cart management</td>
                        <td>
                            <ul>
                                <li>id (PK)</li>
                                <li>session_id (index)</li>
                                <li>user_id (FK, nullable)</li>
                                <li>ticket_id (FK)</li>
                                <li>quantity</li>
                            </ul>
                        </td>
                        <td>
                            <ul>
                                <li>Belongs to User</li>
                                <li>Belongs to Ticket</li>
                            </ul>
                        </td>
                    </tr>
                    <tr>
                        <td>billing_details</td>
                        <td>Customer billing information</td>
                        <td>
                            <ul>
                                <li>id (PK)</li>
                                <li>session_id</li>
                                <li>user_id (FK)</li>
                                <li>first_name</li>
                                <li>last_name</li>
                                <li>gender</li>
                                <li>category</li>
                                <li>country</li>
                                <li>address1</li>
                                <li>address2</li>
                                <li>city</li>
                                <li>state</li>
                                <li>postcode</li>
                                <li>phone</li>
                                <li>email</li>
                                <li>company_name</li>
                                <li>business_registration_number</li>
                                <li>tax_number</li>
                                <li>student_id</li>
                                <li>academic_institution</li>
                            </ul>
                        </td>
                        <td>
                            <ul>
                                <li>Has many Orders</li>
                                <li>Belongs to User</li>
                            </ul>
                        </td>
                    </tr>
                    <tr>
                        <td>orders</td>
                        <td>Order processing and tracking</td>
                        <td>
                            <ul>
                                <li>id (PK)</li>
                                <li>billing_detail_id (FK)</li>
                                <li>reference_number</li>
                                <li>total_amount</li>
                                <li>status</li>
                                <li>cart_items (JSON)</li>
                                <li>payment_id</li>
                                <li>payment_method</li>
                                <li>payment_country</li>
                                <li>processing_fee</li>
                            </ul>
                        </td>
                        <td>
                            <ul>
                                <li>Belongs to BillingDetail</li>
                            </ul>
                        </td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="page-break"></div>

        <div class="subsection">
            <h3 class="subsection-title">2.3 Community Tables</h3>
            <div class="content-block">
                <table class="info-table">
                    <tr>
                        <th>Table Name</th>
                        <th>Description</th>
                        <th>Key Fields</th>
                        <th>Relationships</th>
                    </tr>
                    <tr>
                        <td>connection_requests</td>
                        <td>User connection management</td>
                        <td>
                            <ul>
                                <li>id (PK)</li>
                                <li>sender_id (FK)</li>
                                <li>receiver_id (FK)</li>
                                <li>status</li>
                            </ul>
                        </td>
                        <td>
                            <ul>
                                <li>Belongs to User (sender)</li>
                                <li>Belongs to User (receiver)</li>
                            </ul>
                        </td>
                    </tr>
                    <tr>
                        <td>messages</td>
                        <td>User messaging system</td>
                        <td>
                            <ul>
                                <li>id (PK)</li>
                                <li>sender_id (FK)</li>
                                <li>receiver_id (FK)</li>
                                <li>content</li>
                                <li>is_read</li>
                            </ul>
                        </td>
                        <td>
                            <ul>
                                <li>Belongs to User (sender)</li>
                                <li>Belongs to User (receiver)</li>
                            </ul>
                        </td>
                    </tr>
                </table>

                <div class="note-box">
                    <div class="note-title">Database Features</div>
                    <ul class="info-list">
                        <li>Foreign Key Constraints:
                            <ul>
                                <li>Cascading deletes for user-related data</li>
                                <li>Referential integrity enforcement</li>
                            </ul>
                        </li>
                        <li>Indexing:
                            <ul>
                                <li>Primary keys (auto-incrementing)</li>
                                <li>Foreign key columns</li>
                                <li>Frequently searched columns</li>
                            </ul>
                        </li>
                        <li>Data Types:
                            <ul>
                                <li>Appropriate use of VARCHAR, TEXT, JSON</li>
                                <li>DECIMAL for monetary values</li>
                                <li>DATETIME with timezone awareness</li>
                            </ul>
                        </li>
                        <li>Soft Deletes:
                            <ul>
                                <li>Available but not implemented</li>
                                <li>Can be added per business needs</li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="page-break"></div>

    <div class="section">
        <h2 class="section-title">4. Authentication & Authorization</h2>
        
        <div class="subsection">
            <h3 class="subsection-title">4.1 Authentication Methods</h3>
            <div class="content-block">
                <div class="block-title">Available Authentication Methods:</div>
                <ul class="info-list">
                    <li>Traditional Email/Password
                        <ul>
                            <li>Secure password hashing with Bcrypt</li>
                            <li>Remember me functionality</li>
                            <li>Password reset via email</li>
                        </ul>
                    </li>
                    <li>Google OAuth2 Integration
                        <ul>
                            <li>Single sign-on capability</li>
                            <li>Automatic profile creation</li>
                            <li>Avatar synchronization</li>
                            <li>Email verification bypass</li>
                        </ul>
                    </li>
                    <li>Session Management
                        <ul>
                            <li>Secure session handling</li>
                            <li>CSRF protection</li>
                            <li>Session regeneration on login</li>
                        </ul>
                    </li>
                </ul>

                <div class="note-box">
                    <div class="note-title">Security Features</div>
                    <ul class="info-list">
                        <li>HTTPS enforcement</li>
                        <li>Rate limiting on login attempts</li>
                        <li>Session timeout settings</li>
                        <li>Secure cookie handling</li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="page-break"></div>

        <div class="subsection">
            <h3 class="subsection-title">4.2 User Roles and Permissions</h3>
            <div class="content-block">
                <div class="block-title">Role Hierarchy:</div>
                <ul class="info-list">
                    <li>Superadmin
                        <ul>
                            <li>Full system access</li>
                            <li>Manage admin users</li>
                            <li>System configuration</li>
                            <li>Access all reports</li>
                        </ul>
                    </li>
                    <li>Admin
                        <ul>
                            <li>Manage events and tickets</li>
                            <li>View and process orders</li>
                            <li>Generate reports</li>
                            <li>Manage regular users</li>
                        </ul>
                    </li>
                    <li>Client
                        <ul>
                            <li>Purchase tickets</li>
                            <li>View events and schedules</li>
                            <li>Manage own profile</li>
                            <li>Participate in community</li>
                        </ul>
                    </li>
                </ul>

                <div class="block-title">Access Control Implementation:</div>
                <ul class="info-list">
                    <li>Route Protection
                        <ul>
                            <li>Middleware-based access control</li>
                            <li>Role-specific route groups</li>
                            <li>Custom authentication checks</li>
                        </ul>
                    </li>
                    <li>View-Level Authorization
                        <ul>
                            <li>Blade directive checks</li>
                            <li>Component-based access control</li>
                            <li>Dynamic UI adaptation</li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <div class="page-break"></div>

    <div class="section">
        <h2 class="section-title">5. Payment Integration</h2>
        
        <div class="subsection">
            <h3 class="subsection-title">5.1 Payment Gateways</h3>
            <div class="content-block">
                <div class="block-title">Supported Payment Methods:</div>
                <ul class="info-list">
                    <li>Stripe Integration
                        <ul>
                            <li>Credit/Debit card processing</li>
                            <li>International payments support</li>
                            <li>Dynamic fee calculation:
                                <ul>
                                    <li>Malaysian cards: 3% + RM1.00</li>
                                    <li>International cards: 4% + RM1.00</li>
                                    <li>Currency conversion: +2%</li>
                                </ul>
                            </li>
                            <li>Secure payment element</li>
                            <li>Real-time validation</li>
                            <li>Error handling and logging</li>
                        </ul>
                    </li>
                    <li>ToyyibPay Integration
                        <ul>
                            <li>FPX online banking (Malaysia)</li>
                            <li>Corporate banking support</li>
                            <li>No processing fees</li>
                            <li>Instant payment confirmation</li>
                            <li>Automatic status updates</li>
                        </ul>
                    </li>
                </ul>

                <div class="block-title">Payment Processing Flow:</div>
                <ul class="info-list">
                    <li>Pre-payment
                        <ul>
                            <li>Cart validation</li>
                            <li>Stock availability check</li>
                            <li>Billing information validation</li>
                            <li>Payment method selection</li>
                        </ul>
                    </li>
                    <li>During Payment
                        <ul>
                            <li>Real-time processing</li>
                            <li>Secure gateway redirect</li>
                            <li>Transaction monitoring</li>
                        </ul>
                    </li>
                    <li>Post-payment
                        <ul>
                            <li>Order creation</li>
                            <li>Stock reduction</li>
                            <li>Email notifications</li>
                            <li>Cart clearing</li>
                        </ul>
                    </li>
                </ul>

                <div class="note-box">
                    <div class="note-title">Security Measures</div>
                    <ul class="info-list">
                        <li>PCI DSS compliance via Stripe</li>
                        <li>Secure webhook handling</li>
                        <li>Transaction logging</li>
                        <li>Error monitoring and alerts</li>
                        <li>Automatic retry mechanisms</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</body>
</html> 