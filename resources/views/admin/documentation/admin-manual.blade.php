<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>BINA Administrator Manual</title>
    <style>
        /* PDF-friendly styles */
        @page {
            margin: 30px; /* Reduced from 50px */
            size: A4;
        }

        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            margin: 20px; /* Reduced from 40px */
        }
        
        .page-header {
            text-align: center;
            margin-bottom: 20px; /* Reduced from 40px */
        }
        
        .page-title {
            font-size: 28px;
            font-weight: bold;
            margin-bottom: 15px; /* Reduced from 20px */
            color: #2c3e50;
        }
        
        .manual-intro {
            background-color: #f8f9fa;
            padding: 12px; /* Reduced from 15px */
            margin-bottom: 20px; /* Reduced from 30px */
            border: 1px solid #dee2e6;
            border-radius: 5px;
        }
        
        .section {
            margin-bottom: 20px; /* Reduced from 30px */
        }
        
        .section-title {
            font-size: 24px;
            color: #2c3e50;
            border-bottom: 2px solid #3498db;
            padding-bottom: 8px; /* Reduced from 10px */
            margin-bottom: 15px; /* Reduced from 20px */
        }
        
        .subsection {
            margin-bottom: 20px; /* Reduced from 25px */
            margin-left: 20px;
        }
        
        .subsection-title {
            font-size: 20px;
            color: #34495e;
            margin-bottom: 12px; /* Reduced from 15px */
        }
        
        .content-block {
            margin-bottom: 15px; /* Reduced from 20px */
            margin-left: 20px;
        }
        
        .block-title {
            font-weight: bold;
            color: #2c3e50;
            margin-bottom: 8px; /* Reduced from 10px */
        }
        
        .info-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px; /* Reduced from 20px */
        }
        
        .info-table th, .info-table td {
            border: 1px solid #dee2e6;
            padding: 6px 10px; /* Reduced from 8px 12px */
            text-align: left;
        }
        
        .info-table th {
            background-color: #f8f9fa;
            font-weight: bold;
        }
        
        .info-list {
            list-style-type: none;
            padding-left: 20px;
            margin-bottom: 12px; /* Reduced from 15px */
        }
        
        .info-list li {
            margin-bottom: 6px; /* Reduced from 8px */
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
            padding: 12px; /* Reduced from 15px */
            margin: 15px 0; /* Reduced from 20px */
            border-radius: 5px;
        }
        
        .note-title {
            font-weight: bold;
            color: #856404;
            margin-bottom: 8px; /* Reduced from 10px */
        }
        
        .page-break {
            page-break-before: always;
        }
    </style>
</head>
<body>
    <div class="page-header">
        <h1 class="page-title">BINA Administrator Manual</h1>
        <div class="manual-intro">
            <p>This comprehensive guide provides detailed instructions for managing the BINA platform. Each section contains step-by-step procedures and practical examples based on the actual system functionality.</p>
        </div>
    </div>

    <div class="section">
        <h2 class="section-title">1. Dashboard Overview</h2>
        
        <div class="subsection">
            <h3 class="subsection-title">1.1 Accessing Dashboard</h3>
            <div class="content-block">
                <div class="block-title">Steps to Access Dashboard:</div>
                <ul class="info-list">
                    <li>Navigate to the admin login page</li>
                    <li>Enter your admin credentials:
                        <ul>
                            <li>Email (required)</li>
                            <li>Password (required)</li>
                            <li>Optional: Check "Remember me" for persistent login</li>
                        </ul>
                    </li>
                    <li>Click "Login" to access the dashboard</li>
                </ul>

                <div class="note-box">
                    <div class="note-title">Important Notes</div>
                    <ul class="info-list">
                        <li>Only users with 'admin' or 'superadmin' roles can access the admin area</li>
                        <li>Invalid credentials or insufficient permissions will result in access denial</li>
                        <li>For security, use the logout button when finished</li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="subsection">
            <h3 class="subsection-title">1.2 Dashboard Statistics</h3>
            <div class="content-block">
                <div class="block-title">Available Statistics:</div>
                <ul class="info-list">
                    <li>User Statistics:
                        <ul>
                            <li>Total Users (excluding superadmin)</li>
                            <li>Gender Demographics</li>
                            <li>Category Distribution</li>
                            <li>Location Statistics (Countries and Cities)</li>
                        </ul>
                    </li>
                    <li>Order Statistics:
                        <ul>
                            <li>Total Orders</li>
                            <li>Total Revenue (excluding processing fees)</li>
                            <li>Success Rate (percentage of paid orders)</li>
                            <li>Today's Revenue</li>
                            <li>Monthly Revenue</li>
                        </ul>
                    </li>
                    <li>Ticket Statistics:
                        <ul>
                            <li>Total Tickets</li>
                            <li>Low Stock Alerts (less than 10)</li>
                            <li>Sales Performance by Ticket</li>
                            <li>Revenue by Ticket Type</li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <div class="page-break"></div>

    <div class="section">
        <h2 class="section-title">2. Event Management</h2>
        
        <div class="subsection">
            <h3 class="subsection-title">2.1 Creating Events</h3>
            <div class="content-block">
                <div class="block-title">Steps to Create an Event:</div>
                <ul class="info-list">
                    <li>Navigate to Events section in the sidebar</li>
                    <li>Click "Create Event" button</li>
                    <li>Fill in the required details:
                        <ul>
                            <li>Title (required, will be converted to uppercase)</li>
                            <li>Description (optional)</li>
                            <li>Location (optional, max 255 characters)</li>
                            <li>Start Date (optional)</li>
                            <li>End Date (optional, must be after start date)</li>
                            <li>Organizer (optional, max 255 characters)</li>
                            <li>Event Type (required, choose modular-asia or facility-management)</li>
                            <li>Image (optional, max 2MB, formats: jpeg/png/jpg/gif)</li>
                        </ul>
                    </li>
                    <li>Set event visibility:
                        <ul>
                            <li>Featured Status (checkbox)</li>
                            <li>Published Status (checkbox)</li>
                        </ul>
                    </li>
                    <li>Click "Save" to create the event</li>
                </ul>

                <div class="note-box">
                    <div class="note-title">Important Notes</div>
                    <ul class="info-list">
                        <li>Event titles are automatically converted to uppercase</li>
                        <li>Images are stored in the public/images/events directory</li>
                        <li>End date must be after the start date if provided</li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="page-break"></div>

        <div class="subsection">
            <h3 class="subsection-title">2.2 Editing Events</h3>
            <div class="content-block">
                <div class="block-title">Steps to Edit an Event:</div>
                <ul class="info-list">
                    <li>Find the event in the events list</li>
                    <li>Click the "Edit" button</li>
                    <li>Modify any of the event details:
                        <ul>
                            <li>All fields from the creation form are editable</li>
                            <li>Only changed fields will be updated</li>
                            <li>New image will replace the existing one</li>
                        </ul>
                    </li>
                    <li>Update visibility settings if needed</li>
                    <li>Click "Save" to update the event</li>
                </ul>
            </div>
        </div>

        <div class="page-break"></div>

        <div class="subsection">
            <h3 class="subsection-title">2.3 Deleting Events</h3>
            <div class="content-block">
                <div class="block-title">Steps to Delete an Event:</div>
                <ul class="info-list">
                    <li>Locate the event in the events list</li>
                    <li>Click the "Delete" button</li>
                    <li>Confirm deletion in the popup dialog</li>
                </ul>

                <div class="note-box">
                    <div class="note-title">Warning</div>
                    <ul class="info-list">
                        <li>Event deletion is permanent and cannot be undone</li>
                        <li>Associated event image will be deleted from the server</li>
                        <li>Consider unpublishing instead of deleting if temporary removal is needed</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="page-break"></div>

    <div class="section">
        <h2 class="section-title">3. Ticket Management</h2>
        
        <div class="subsection">
            <h3 class="subsection-title">3.1 Creating Tickets</h3>
            <div class="content-block">
                <div class="block-title">Steps to Create a Ticket:</div>
                <ul class="info-list">
                    <li>Navigate to Tickets section</li>
                    <li>Click "Add New Ticket" button</li>
                    <li>Fill in ticket details:
                        <ul>
                            <li>Name (required, max 255 characters)</li>
                            <li>SKU (required, unique identifier, max 50 characters)</li>
                            <li>Price (required, minimum 0)</li>
                            <li>Stock Quantity (required, minimum 0)</li>
                            <li>Description (required)</li>
                            <li>Categories (optional, multiple selection allowed)</li>
                            <li>Quantity Selection Toggle (optional)</li>
                            <li>Quantity Discounts (optional, for bulk pricing)</li>
                            <li>Additional Information (optional)</li>
                            <li>Image (optional, max 2MB, formats: jpeg/png/jpg/gif)</li>
                        </ul>
                    </li>
                    <li>Click "Save" to create the ticket</li>
                </ul>

                <div class="note-box">
                    <div class="note-title">Important Notes</div>
                    <ul class="info-list">
                        <li>SKU must be unique across all tickets</li>
                        <li>Enable quantity selection for bulk purchases</li>
                        <li>Set up quantity discounts with min/max quantities and discounted prices</li>
                        <li>Images are stored in the public/images directory</li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="page-break"></div>

        <div class="subsection">
            <h3 class="subsection-title">3.2 Editing Tickets</h3>
            <div class="content-block">
                <div class="block-title">Steps to Edit a Ticket:</div>
                <ul class="info-list">
                    <li>Find the ticket in the tickets list</li>
                    <li>Click the "Edit" button</li>
                    <li>Modify ticket details:
                        <ul>
                            <li>All fields from creation form are editable</li>
                            <li>SKU must remain unique</li>
                            <li>New image will replace existing one</li>
                            <li>Existing categories will be preserved if not modified</li>
                        </ul>
                    </li>
                    <li>Click "Save" to update the ticket</li>
                </ul>
            </div>
        </div>

        <div class="page-break"></div>

        <div class="subsection">
            <h3 class="subsection-title">3.3 Deleting Tickets</h3>
            <div class="content-block">
                <div class="block-title">Steps to Delete a Ticket:</div>
                <ul class="info-list">
                    <li>Locate the ticket in the list</li>
                    <li>Click the "Delete" button</li>
                    <li>Confirm deletion in the confirmation dialog</li>
                </ul>

                <div class="note-box">
                    <div class="note-title">Warning</div>
                    <ul class="info-list">
                        <li>Ticket deletion is permanent</li>
                        <li>Associated ticket image will be deleted</li>
                        <li>Consider setting stock to 0 instead of deleting if temporary unavailability is needed</li>
                        <li>Check for any active orders before deletion</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="page-break"></div>

    <div class="section">
        <h2 class="section-title">4. Reports Management</h2>
        
        <div class="subsection">
            <h3 class="subsection-title">4.1 Available Reports</h3>
            <div class="content-block">
                <div class="block-title">Report Types:</div>
                <ul class="info-list">
                    <li>All Reports:
                        <ul>
                            <li>Total stock and sold quantities</li>
                            <li>Monthly sales data</li>
                            <li>Ticket type statistics</li>
                            <li>Total revenue (excluding processing fees)</li>
                        </ul>
                    </li>
                    <li>Ticket Reports:
                        <ul>
                            <li>Total stock levels</li>
                            <li>Total tickets sold</li>
                            <li>Detailed ticket type statistics</li>
                        </ul>
                    </li>
                    <li>Sales Reports:
                        <ul>
                            <li>Monthly sales breakdown</li>
                            <li>Daily sales quantities</li>
                            <li>Revenue calculations (excluding fees)</li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>

        <div class="subsection">
            <h3 class="subsection-title">4.2 Generating Reports</h3>
            <div class="content-block">
                <div class="block-title">Steps to Generate Reports:</div>
                <ul class="info-list">
                    <li>Navigate to Reports section</li>
                    <li>Select report parameters:
                        <ul>
                            <li>Report Type (All/Tickets/Sales)</li>
                            <li>Month (optional)</li>
                            <li>Year (optional)</li>
                        </ul>
                    </li>
                    <li>Click "Download Report" button</li>
                    <li>PDF will be generated with:
                        <ul>
                            <li>Selected report type data</li>
                            <li>Generation timestamp</li>
                            <li>Filtered by selected month/year if specified</li>
                        </ul>
                    </li>
                </ul>

                <div class="note-box">
                    <div class="note-title">Important Notes</div>
                    <ul class="info-list">
                        <li>Reports use real-time data</li>
                        <li>Revenue calculations exclude processing fees</li>
                        <li>Monthly filters apply only to sales reports</li>
                        <li>PDF format ensures consistent viewing</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="page-break"></div>

    <div class="section">
        <h2 class="section-title">5. Order Management</h2>
        
        <div class="subsection">
            <h3 class="subsection-title">5.1 Viewing Orders</h3>
            <div class="content-block">
                <div class="block-title">Steps to View Orders:</div>
                <ul class="info-list">
                    <li>Navigate to Orders section</li>
                    <li>View order list with:
                        <ul>
                            <li>Reference number</li>
                            <li>Customer details</li>
                            <li>Order status</li>
                            <li>Total amount</li>
                            <li>Number of items</li>
                        </ul>
                    </li>
                    <li>Access detailed information:
                        <ul>
                            <li>Click "View Billing Details" for customer information</li>
                            <li>Click "View Items" for order contents</li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>

        <div class="subsection">
            <h3 class="subsection-title">5.2 Generating Order Documents</h3>
            <div class="content-block">
                <div class="block-title">Steps to Generate Order PDF:</div>
                <ul class="info-list">
                    <li>Find the order in the list</li>
                    <li>Click "Download PDF" button</li>
                    <li>PDF will include:
                        <ul>
                            <li>Order reference number</li>
                            <li>Complete billing information</li>
                            <li>Itemized list with original prices</li>
                            <li>Quantity discounts applied</li>
                            <li>Final total amount</li>
                        </ul>
                    </li>
                </ul>

                <div class="block-title">Steps to Generate Attendance Form:</div>
                <ul class="info-list">
                    <li>Locate the order</li>
                    <li>Click "Generate Attendance Form"</li>
                    <li>Form will contain:
                        <ul>
                            <li>Order reference</li>
                            <li>Ticket details</li>
                            <li>Rows for each attendee</li>
                            <li>Fields for name, email, phone</li>
                            <li>Signature spaces</li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <div class="page-break"></div>

    <div class="section">
        <h2 class="section-title">6. User Management</h2>
        
        <div class="subsection">
            <h3 class="subsection-title">6.1 Managing Users</h3>
            <div class="content-block">
                <div class="block-title">User Types:</div>
                <ul class="info-list">
                    <li>Admin Users:
                        <ul>
                            <li>Full access to admin dashboard</li>
                            <li>Can manage other admin users</li>
                            <li>Can manage all system features</li>
                        </ul>
                    </li>
                    <li>Client Users:
                        <ul>
                            <li>Regular website users</li>
                            <li>Have associated profiles</li>
                            <li>Register through public website</li>
                        </ul>
                    </li>
                </ul>

                <div class="block-title">Steps to View Users:</div>
                <ul class="info-list">
                    <li>Navigate to Users section</li>
                    <li>View separate tables for:
                        <ul>
                            <li>Admin Users (name, email, creation date)</li>
                            <li>Client Users (name, email, category, organization)</li>
                        </ul>
                    </li>
                    <li>Use search function to filter by:
                        <ul>
                            <li>Name</li>
                            <li>Email</li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>

        <div class="subsection">
            <h3 class="subsection-title">6.2 Creating Admin Users</h3>
            <div class="content-block">
                <div class="block-title">Steps to Create Admin User:</div>
                <ul class="info-list">
                    <li>Click "Add New Admin" button</li>
                    <li>Fill in required details:
                        <ul>
                            <li>Name (required, max 255 characters)</li>
                            <li>Email (required, must be unique)</li>
                            <li>Password (required, minimum 8 characters)</li>
                            <li>Password confirmation</li>
                        </ul>
                    </li>
                    <li>Click "Create Admin" to save</li>
                </ul>

                <div class="note-box">
                    <div class="note-title">Important Notes</div>
                    <ul class="info-list">
                        <li>Only admin users can be created through this interface</li>
                        <li>Client users must register through the public website</li>
                        <li>Passwords are automatically hashed for security</li>
                        <li>Email must be unique in the system</li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="subsection">
            <h3 class="subsection-title">6.3 Editing Users</h3>
            <div class="content-block">
                <div class="block-title">Steps to Edit Admin User:</div>
                <ul class="info-list">
                    <li>Find the admin user in the list</li>
                    <li>Click "Edit" button</li>
                    <li>Modify available fields:
                        <ul>
                            <li>Name (max 255 characters)</li>
                            <li>Email (must remain unique)</li>
                        </ul>
                    </li>
                    <li>Click "Save" to update</li>
                </ul>
            </div>
        </div>

        <div class="subsection">
            <h3 class="subsection-title">6.4 Deleting Users</h3>
            <div class="content-block">
                <div class="block-title">Steps to Delete Admin User:</div>
                <ul class="info-list">
                    <li>Locate the admin user</li>
                    <li>Click "Delete" button</li>
                    <li>Confirm deletion in the dialog</li>
                </ul>

                <div class="note-box">
                    <div class="note-title">Warning</div>
                    <ul class="info-list">
                        <li>Only admin users can be deleted through this interface</li>
                        <li>Deletion is permanent and cannot be undone</li>
                        <li>Ensure user has no active responsibilities before deletion</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="page-break"></div>

    <div class="section">
        <h2 class="section-title">7. Schedule Management</h2>
        
        <div class="subsection">
            <h3 class="subsection-title">7.1 Creating Schedules</h3>
            <div class="content-block">
                <div class="block-title">Steps to Create a Schedule:</div>
                <ul class="info-list">
                    <li>Navigate to Schedules section</li>
                    <li>Click "Create Schedule" button</li>
                    <li>Fill in required details:
                        <ul>
                            <li>Title (required, max 255 characters)</li>
                            <li>Description (optional)</li>
                            <li>Start Time (required, 24-hour format)</li>
                            <li>End Time (optional, must be after start time)</li>
                            <li>Session (optional, for grouping)</li>
                            <li>Event Type (required, choose facility_management or modular_asia)</li>
                        </ul>
                    </li>
                    <li>Click "Save" to create</li>
                </ul>

                <div class="note-box">
                    <div class="note-title">Important Notes</div>
                    <ul class="info-list">
                        <li>Times must be in 24-hour format (HH:mm)</li>
                        <li>End time must be after start time if provided</li>
                        <li>Session field can be used to group related schedules</li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="subsection">
            <h3 class="subsection-title">7.2 Editing Schedules</h3>
            <div class="content-block">
                <div class="block-title">Steps to Edit a Schedule:</div>
                <ul class="info-list">
                    <li>Find the schedule in the list</li>
                    <li>Click "Edit" button</li>
                    <li>Modify schedule details:
                        <ul>
                            <li>All fields from creation form are editable</li>
                            <li>Time format requirements remain the same</li>
                            <li>Event type must be valid</li>
                        </ul>
                    </li>
                    <li>Click "Save" to update</li>
                </ul>
            </div>
        </div>

        <div class="subsection">
            <h3 class="subsection-title">7.3 Deleting Schedules</h3>
            <div class="content-block">
                <div class="block-title">Steps to Delete a Schedule:</div>
                <ul class="info-list">
                    <li>Locate the schedule in the list</li>
                    <li>Click "Delete" button</li>
                    <li>Confirm deletion in the popup</li>
                </ul>

                <div class="note-box">
                    <div class="note-title">Warning</div>
                    <ul class="info-list">
                        <li>Schedule deletion is permanent</li>
                        <li>Consider impact on event planning</li>
                        <li>Check for related sessions before deleting</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="page-break"></div>

    <div class="section">
        <h2 class="section-title">8. Podcast Management</h2>
        
        <div class="subsection">
            <h3 class="subsection-title">8.1 Creating Podcasts</h3>
            <div class="content-block">
                <div class="block-title">Steps to Create a Podcast:</div>
                <ul class="info-list">
                    <li>Navigate to Podcasts section</li>
                    <li>Click "Create Podcast" button</li>
                    <li>Fill in podcast details:
                        <ul>
                            <li>Type (required, choose bina or fm)</li>
                            <li>Episode Number (required)</li>
                            <li>Title (required, max 255 characters)</li>
                            <li>Description (optional)</li>
                            <li>YouTube URL (optional)</li>
                            <li>Panelists (optional, one per line)</li>
                            <li>Live Streaming Options:
                                <ul>
                                    <li>Is Live Streaming (checkbox)</li>
                                    <li>Live Streaming Event (if applicable)</li>
                                </ul>
                            </li>
                            <li>Special Episode Options:
                                <ul>
                                    <li>Is Special Episode (checkbox)</li>
                                    <li>Special Position (above/below, if special)</li>
                                </ul>
                            </li>
                            <li>Display Order (integer)</li>
                            <li>Image URL (optional)</li>
                        </ul>
                    </li>
                    <li>Click "Save" to create</li>
                </ul>

                <div class="note-box">
                    <div class="note-title">Important Notes</div>
                    <ul class="info-list">
                        <li>Panelists are stored as an array</li>
                        <li>Special position required if marked as special episode</li>
                        <li>Display order affects listing sequence</li>
                        <li>Image URL supports Google Drive links</li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="subsection">
            <h3 class="subsection-title">8.2 Editing Podcasts</h3>
            <div class="content-block">
                <div class="block-title">Steps to Edit a Podcast:</div>
                <ul class="info-list">
                    <li>Find the podcast in the list</li>
                    <li>Click "Edit" button</li>
                    <li>Modify podcast details:
                        <ul>
                            <li>All fields from creation form are editable</li>
                            <li>Special episode settings can be changed</li>
                            <li>Display order will be recalculated if needed</li>
                        </ul>
                    </li>
                    <li>Click "Save" to update</li>
                </ul>
            </div>
        </div>

        <div class="subsection">
            <h3 class="subsection-title">8.3 Deleting Podcasts</h3>
            <div class="content-block">
                <div class="block-title">Steps to Delete a Podcast:</div>
                <ul class="info-list">
                    <li>Locate the podcast in the list</li>
                    <li>Click "Delete" button</li>
                    <li>Confirm deletion in the popup</li>
                </ul>

                <div class="note-box">
                    <div class="note-title">Warning</div>
                    <ul class="info-list">
                        <li>Podcast deletion is permanent</li>
                        <li>Consider impact on episode numbering</li>
                        <li>Check for special episode relationships</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="page-break"></div>

    <div class="section">
        <h2 class="section-title">9. Attendance Form Management</h2>
        
        <div class="subsection">
            <h3 class="subsection-title">9.1 Generating Attendance Form</h3>
            <div class="content-block">
                <div class="block-title">Steps to Generate Attendance Form:</div>
                <ul class="info-list">
                    <li>Navigate to Orders section</li>
                    <li>Click "Download Attendance Form" button in the header</li>
                    <li>PDF will include:
                        <ul>
                            <li>Order Information:
                                <ul>
                                    <li>Reference number</li>
                                    <li>Order date</li>
                                    <li>Purchaser name</li>
                                    <li>Purchaser email</li>
                                </ul>
                            </li>
                            <li>Ticket Groups:
                                <ul>
                                    <li>Ticket name</li>
                                    <li>Quantity purchased</li>
                                </ul>
                            </li>
                            <li>Attendee Fields:
                                <ul>
                                    <li>Number</li>
                                    <li>Name field (for filling)</li>
                                    <li>Email field (for filling)</li>
                                    <li>Phone field (for filling)</li>
                                    <li>Signature space</li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                </ul>

                <div class="note-box">
                    <div class="note-title">Important Notes</div>
                    <ul class="info-list">
                        <li>Form is generated as A4 size PDF</li>
                        <li>Each ticket type starts on a new page</li>
                        <li>Form includes spaces for on-site completion</li>
                        <li>Margins are optimized for printing</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="page-break"></div>

    <div class="section">
        <h2 class="section-title">10. Payment Logging</h2>
        
        <div class="subsection">
            <h3 class="subsection-title">10.1 Accessing Transaction Logs</h3>
            <div class="content-block">
                <div class="block-title">Steps to Download Success Logs:</div>
                <ul class="info-list">
                    <li>Navigate to Orders section</li>
                    <li>Click "Download Success Log" button</li>
                    <li>Log file will contain:
                        <ul>
                            <li>Timestamp (Y-m-d H:i:s format)</li>
                            <li>Payment method details</li>
                            <li>Reference numbers</li>
                            <li>Transaction amounts</li>
                            <li>Additional transaction data</li>
                        </ul>
                    </li>
                </ul>

                <div class="block-title">Steps to Download Failed Transaction Logs:</div>
                <ul class="info-list">
                    <li>Go to Orders section</li>
                    <li>Click "Download Failed Log" button</li>
                    <li>Log file will include:
                        <ul>
                            <li>Timestamp (Y-m-d H:i:s format)</li>
                            <li>Payment method used</li>
                            <li>Error status details</li>
                            <li>Failure reasons</li>
                            <li>Additional error information</li>
                        </ul>
                    </li>
                </ul>

                <div class="note-box">
                    <div class="note-title">Important Notes</div>
                    <ul class="info-list">
                        <li>Logs are stored in storage/logs/payments directory</li>
                        <li>Files include date in filename (YYYY-MM-DD)</li>
                        <li>Newest transactions appear first</li>
                        <li>Directory is created automatically if needed</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="page-break"></div>

    <div class="section">
        <h2 class="section-title">11. Documentation Management</h2>
        
        <div class="subsection">
            <h3 class="subsection-title">11.1 Accessing Documentation</h3>
            <div class="content-block">
                <div class="block-title">Available Documentation Types:</div>
                <ul class="info-list">
                    <li>Admin Manual:
                        <ul>
                            <li>Complete guide for administrators</li>
                            <li>System management instructions</li>
                            <li>Administrative procedures</li>
                        </ul>
                    </li>
                    <li>Client Manual:
                        <ul>
                            <li>End-user documentation</li>
                            <li>Website usage guide</li>
                            <li>Feature explanations</li>
                        </ul>
                    </li>
                    <li>System Manual:
                        <ul>
                            <li>Technical documentation</li>
                            <li>System architecture</li>
                            <li>Integration details</li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>

        <div class="subsection">
            <h3 class="subsection-title">11.2 Downloading Documentation</h3>
            <div class="content-block">
                <div class="block-title">Steps to Download Documentation:</div>
                <ul class="info-list">
                    <li>Navigate to Documentation section</li>
                    <li>Select documentation type:
                        <ul>
                            <li>Admin Manual (admin-user-manual.pdf)</li>
                            <li>Client Manual (client-user-manual.pdf)</li>
                            <li>System Documentation (system-documentation.pdf)</li>
                        </ul>
                    </li>
                    <li>Click "Download" button for selected type</li>
                    <li>PDF will be generated and downloaded</li>
                </ul>

                <div class="note-box">
                    <div class="note-title">Important Notes</div>
                    <ul class="info-list">
                        <li>All documentation is generated as PDF</li>
                        <li>Files are generated on-demand for latest content</li>
                        <li>Documentation includes proper formatting and styling</li>
                        <li>Each manual type has a specific target audience</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</body>
</html>