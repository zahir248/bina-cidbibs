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
            <h3 class="subsection-title">1.1 Overview</h3>
            <div class="content-block">
                <div class="block-title">Core Technologies:</div>
                <ul class="info-list">
                    <li>Framework: Laravel (PHP)</li>
                    <li>Frontend: Blade Templates with Bootstrap 5</li>
                    <li>Database: MySQL</li>
                    <li>Authentication: Laravel Sanctum</li>
                    <li>Social Authentication: Google OAuth2</li>
                    <li>Payment Integration:
                        <ul>
                            <li>Stripe API for international payments</li>
                            <li>ToyyibPay for Malaysian FPX</li>
                        </ul>
                    </li>
                </ul>

                <div class="note-box">
                    <div class="note-title">System Requirements</div>
                    <ul class="info-list">
                        <li>PHP >= 8.1</li>
                        <li>MySQL >= 5.7</li>
                        <li>Composer for dependency management</li>
                        <li>Node.js and NPM for asset compilation</li>
                        <li>SSL certificate for secure transactions</li>
                        <li>Appropriate PHP extensions:
                            <ul>
                                <li>OpenSSL PHP Extension</li>
                                <li>PDO PHP Extension</li>
                                <li>Mbstring PHP Extension</li>
                                <li>Tokenizer PHP Extension</li>
                                <li>XML PHP Extension</li>
                                <li>Ctype PHP Extension</li>
                                <li>JSON PHP Extension</li>
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
                <div class="block-title">Key Directories:</div>
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
                            <li>Providers/ - Service providers</li>
                            <li>Middleware/ - Custom middleware</li>
                        </ul>
                    </li>
                    <li>resources/
                        <ul>
                            <li>views/
                                <ul>
                                    <li>admin/ - Admin panel views</li>
                                    <li>client/ - Client-facing views</li>
                                    <li>emails/ - Email templates</li>
                                </ul>
                            </li>
                            <li>css/ - Custom stylesheets</li>
                            <li>js/ - JavaScript files</li>
                        </ul>
                    </li>
                    <li>database/
                        <ul>
                            <li>migrations/ - Database structure</li>
                            <li>seeders/ - Sample data</li>
                            <li>factories/ - Model factories for testing</li>
                        </ul>
                    </li>
                    <li>public/ - Web accessible files
                        <ul>
                            <li>images/ - Uploaded and static images</li>
                            <li>css/ - Compiled CSS</li>
                            <li>js/ - Compiled JavaScript</li>
                        </ul>
                    </li>
                    <li>routes/ - Application routes
                        <ul>
                            <li>web.php - Web routes</li>
                            <li>console.php - Console commands</li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <div class="page-break"></div>

    <div class="section">
        <h2 class="section-title">2. Database Design</h2>
        
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
        <h2 class="section-title">3. Authentication & Authorization</h2>
        
        <div class="subsection">
            <h3 class="subsection-title">3.1 Authentication Methods</h3>
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
            <h3 class="subsection-title">3.2 User Roles and Permissions</h3>
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
        <h2 class="section-title">4. Payment Integration</h2>
        
        <div class="subsection">
            <h3 class="subsection-title">4.1 Payment Gateways</h3>
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