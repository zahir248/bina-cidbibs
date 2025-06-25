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
                    <li>Enter your admin credentials (email and password)</li>
                    <li>Click "Login" to access the dashboard</li>
                </ul>

                <div class="note-box">
                    <div class="note-title">Important Notes</div>
                    <ul class="info-list">
                        <li>Only users with 'admin' or 'superadmin' roles can access the admin area</li>
                        <li>Session will remember your login if "Remember me" is checked</li>
                        <li>For security, use the logout button when finished</li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="page-break"></div>

        <div class="subsection">
            <h3 class="subsection-title">1.2 Dashboard Features</h3>
            <div class="content-block">
                <div class="block-title">Available Statistics:</div>
                <ul class="info-list">
                    <li>Total Users (excluding superadmin)</li>
                    <li>Total Orders and Revenue</li>
                    <li>Success Rate (percentage of paid orders)</li>
                    <li>Gender and Category Demographics</li>
                    <li>Location Statistics (Countries and Cities)</li>
                    <li>Ticket Sales Performance</li>
                </ul>

                <div class="block-title">Quick Actions:</div>
                <ul class="info-list">
                    <li>Add New Ticket</li>
                    <li>View All Orders</li>
                    <li>Manage Tickets</li>
                    <li>Download Orders Report</li>
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
                            <li>Title (will be automatically converted to uppercase)</li>
                            <li>Description</li>
                            <li>Location</li>
                            <li>Start Date & Time</li>
                            <li>End Date & Time</li>
                            <li>Event Type (modular-asia or facility-management)</li>
                            <li>Optional: Upload event image (max 2MB, jpeg/png/jpg/gif)</li>
                        </ul>
                    </li>
                    <li>Set event status:
                        <ul>
                            <li>Featured status (for highlighting events)</li>
                            <li>Published status (for public visibility)</li>
                        </ul>
                    </li>
                    <li>Click "Save" to create the event</li>
                </ul>
            </div>
        </div>

        <div class="page-break"></div>

        <div class="subsection">
            <h3 class="subsection-title">2.2 Editing Events</h3>
            <div class="content-block">
                <div class="block-title">Steps to Edit an Event:</div>
                <ul class="info-list">
                    <li>Locate the event in the events list</li>
                    <li>Click the "Edit" button (pencil icon)</li>
                    <li>Modify any of the event details</li>
                    <li>Update event image if needed (old image will be deleted)</li>
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
                    <li>Find the event in the events list</li>
                    <li>Click the "Delete" button (trash icon)</li>
                    <li>Confirm deletion in the popup modal</li>
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
                            <li>Name (required)</li>
                            <li>SKU (unique identifier)</li>
                            <li>Price (minimum 0)</li>
                            <li>Stock quantity</li>
                            <li>Description</li>
                            <li>Categories (Facility Management, General, Modular Asia, Ticket)</li>
                            <li>Optional: Quantity selection toggle, Quantity discounts, Additional information, Ticket image (max 2MB)</li>
                        </ul>
                    </li>
                    <li>Click "Save" to create the ticket</li>
                </ul>

                <div class="note-box">
                    <div class="note-title">Important Notes</div>
                    <ul class="info-list">
                        <li>SKU must be unique across all tickets</li>
                        <li>Multiple categories can be selected using Ctrl/Cmd key</li>
                        <li>Enable quantity selection for bulk purchases</li>
                        <li>Set up quantity discounts for bulk pricing</li>
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
                    <li>Modify ticket details as needed</li>
                    <li>Update ticket image if required (old image will be removed)</li>
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
                        <li>Deletion will remove the ticket from the system permanently</li>
                        <li>Associated ticket image will be deleted</li>
                        <li>Consider setting stock to 0 instead of deleting if temporary unavailability is needed</li>
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
                <table class="info-table">
                    <tr>
                        <th>Report Type</th>
                        <th>Information Included</th>
                        <th>Usage</th>
                    </tr>
                    <tr>
                        <td>All Reports</td>
                        <td>
                            <ul class="info-list">
                                <li>Total stock and sold quantities</li>
                                <li>Monthly sales data</li>
                                <li>Ticket type statistics</li>
                                <li>Total revenue (excluding processing fees)</li>
                            </ul>
                        </td>
                        <td>
                            <ul class="info-list">
                                <li>Complete business overview</li>
                                <li>Monthly performance analysis</li>
                                <li>Revenue tracking</li>
                            </ul>
                        </td>
                    </tr>
                    <tr>
                        <td>Ticket Reports</td>
                        <td>
                            <ul class="info-list">
                                <li>Total stock levels</li>
                                <li>Total tickets sold</li>
                                <li>Detailed ticket type statistics</li>
                            </ul>
                        </td>
                        <td>
                            <ul class="info-list">
                                <li>Stock management</li>
                                <li>Sales performance by ticket type</li>
                                <li>Inventory planning</li>
                            </ul>
                        </td>
                    </tr>
                    <tr>
                        <td>Sales Reports</td>
                        <td>
                            <ul class="info-list">
                                <li>Monthly sales breakdown</li>
                                <li>Daily sales quantities</li>
                                <li>Revenue calculations (excluding fees)</li>
                            </ul>
                        </td>
                        <td>
                            <ul class="info-list">
                                <li>Financial tracking</li>
                                <li>Daily sales monitoring</li>
                                <li>Revenue analysis</li>
                            </ul>
                        </td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="page-break"></div>

        <div class="subsection">
            <h3 class="subsection-title">4.2 Generating Reports</h3>
            <div class="content-block">
                <div class="block-title">Steps to Generate Reports:</div>
                <ul class="info-list">
                    <li>Navigate to Reports section in the sidebar</li>
                    <li>Click on "Download Report" button</li>
                    <li>Select desired report type from dropdown:
                        <ul>
                            <li>All Reports - comprehensive overview</li>
                            <li>Ticket Reports - stock and sales focus</li>
                            <li>Sales Reports - financial focus</li>
                        </ul>
                    </li>
                    <li>Report will be generated in PDF format</li>
                </ul>

                <div class="note-box">
                    <div class="note-title">Important Notes</div>
                    <ul class="info-list">
                        <li>Reports are generated with real-time data</li>
                        <li>Revenue calculations exclude processing fees</li>
                        <li>Reports include generation timestamp</li>
                        <li>PDF format ensures consistent viewing</li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="page-break"></div>

        <div class="subsection">
            <h3 class="subsection-title">4.3 Report Calculations</h3>
            <div class="content-block">
                <div class="block-title">Understanding Report Data:</div>
                <ul class="info-list">
                    <li>Total Stock: Sum of all available tickets</li>
                    <li>Total Sold: Sum of quantities from paid orders</li>
                    <li>Revenue Calculation:
                        <ul>
                            <li>Based on paid orders only</li>
                            <li>Includes quantity discount calculations</li>
                            <li>Excludes processing fees</li>
                        </ul>
                    </li>
                    <li>Sales Statistics:
                        <ul>
                            <li>Grouped by date for trend analysis</li>
                            <li>Includes quantity and revenue metrics</li>
                            <li>Filtered by month and year when specified</li>
                        </ul>
                    </li>
                </ul>
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
                    <li>Access Orders section from sidebar</li>
                    <li>View list of all orders with:
                        <ul>
                            <li>Reference number</li>
                            <li>Customer details</li>
                            <li>Order status</li>
                            <li>Total amount</li>
                            <li>Number of items</li>
                        </ul>
                    </li>
                    <li>Click on details buttons to view:
                        <ul>
                            <li>Billing information</li>
                            <li>Order items breakdown</li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>

        <div class="page-break"></div>

        <div class="subsection">
            <h3 class="subsection-title">5.2 Downloading Order PDFs</h3>
            <div class="content-block">
                <div class="block-title">Steps to Download Order PDF:</div>
                <ul class="info-list">
                    <li>Find the order in the orders list</li>
                    <li>Click the "Download PDF" button</li>
                    <li>PDF will include:
                        <ul>
                            <li>Order details and reference</li>
                            <li>Complete billing information</li>
                            <li>Itemized list with prices</li>
                            <li>Discount calculations</li>
                            <li>Total amounts</li>
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
                <div class="block-title">User Types and Roles:</div>
                <ul class="info-list">
                    <li>Admin Users:
                        <ul>
                            <li>Full access to admin dashboard</li>
                            <li>Can manage other admin users</li>
                            <li>Can view and manage all system features</li>
                        </ul>
                    </li>
                    <li>Client Users:
                        <ul>
                            <li>Regular website users</li>
                            <li>Have associated profiles with categories</li>
                            <li>Can be students or professionals</li>
                        </ul>
                    </li>
                </ul>

                <div class="block-title">Steps to View Users:</div>
                <ul class="info-list">
                    <li>Navigate to Users section in sidebar</li>
                    <li>View separate tables for:
                        <ul>
                            <li>Admin Users - showing name, email, and creation date</li>
                            <li>Client Users - showing name, email, category, and organization/institution</li>
                        </ul>
                    </li>
                    <li>Use search functionality to filter users by name or email</li>
                </ul>
            </div>
        </div>

        <div class="page-break"></div>

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
                            <li>Password (minimum 8 characters)</li>
                            <li>Password confirmation</li>
                        </ul>
                    </li>
                    <li>Click "Create Admin" to save</li>
                </ul>

                <div class="note-box">
                    <div class="note-title">Important Notes</div>
                    <ul class="info-list">
                        <li>Only admin users can be created through this interface</li>
                        <li>Client users register through the public website</li>
                        <li>Passwords are automatically hashed for security</li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="page-break"></div>

        <div class="subsection">
            <h3 class="subsection-title">6.3 Editing Users</h3>
            <div class="content-block">
                <div class="block-title">Steps to Edit Admin User:</div>
                <ul class="info-list">
                    <li>Find the admin user in the list</li>
                    <li>Click the "Edit" button (pencil icon)</li>
                    <li>Modify available fields:
                        <ul>
                            <li>Name</li>
                            <li>Email (must remain unique)</li>
                            <li>Optional: New password</li>
                        </ul>
                    </li>
                    <li>Click "Update Admin" to save changes</li>
                </ul>

                <div class="note-box">
                    <div class="note-title">Password Updates</div>
                    <ul class="info-list">
                        <li>Leave password fields blank to keep current password</li>
                        <li>New passwords require confirmation</li>
                        <li>Password changes take effect immediately</li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="page-break"></div>

        <div class="subsection">
            <h3 class="subsection-title">6.4 Deleting Users</h3>
            <div class="content-block">
                <div class="block-title">Steps to Delete Admin User:</div>
                <ul class="info-list">
                    <li>Locate the admin user in the list</li>
                    <li>Click the "Delete" button (trash icon)</li>
                    <li>Confirm deletion in the modal dialog</li>
                </ul>

                <div class="note-box">
                    <div class="note-title">Important Security Notes</div>
                    <ul class="info-list">
                        <li>Only admin users can be deleted through this interface</li>
                        <li>Deletion is permanent and cannot be undone</li>
                        <li>Consider implications before deleting an admin user</li>
                        <li>System prevents deletion of your own account</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="page-break"></div>

    <div class="section">
        <h2 class="section-title">7. Schedule Management</h2>
        
        <div class="subsection">
            <h3 class="subsection-title">7.1 Managing Schedules</h3>
            <div class="content-block">
                <div class="block-title">Schedule Overview:</div>
                <ul class="info-list">
                    <li>Schedule Types:
                        <ul>
                            <li>Facility Management schedules</li>
                            <li>Modular Asia schedules</li>
                        </ul>
                    </li>
                    <li>Schedule Components:
                        <ul>
                            <li>Title and description</li>
                            <li>Start and end times</li>
                            <li>Optional session grouping</li>
                            <li>Event type categorization</li>
                        </ul>
                    </li>
                </ul>

                <div class="block-title">Schedule List Features:</div>
                <ul class="info-list">
                    <li>Search by title</li>
                    <li>Filter by event type</li>
                    <li>Sort by time</li>
                    <li>View session groupings</li>
                </ul>
            </div>
        </div>

        <div class="page-break"></div>

        <div class="subsection">
            <h3 class="subsection-title">7.2 Creating Schedules</h3>
            <div class="content-block">
                <div class="block-title">Steps to Create Schedule:</div>
                <ul class="info-list">
                    <li>Click "Add New Schedule" button</li>
                    <li>Fill in required details:
                        <ul>
                            <li>Title (required, max 255 characters)</li>
                            <li>Description (optional)</li>
                            <li>Start Time (required, 24-hour format)</li>
                            <li>End Time (optional, must be after start time)</li>
                            <li>Session (optional, e.g., "1", "2")</li>
                            <li>Event Type (required, select Facility Management or Modular Asia)</li>
                        </ul>
                    </li>
                    <li>Click "Create Schedule" to save</li>
                </ul>

                <div class="note-box">
                    <div class="note-title">Important Notes</div>
                    <ul class="info-list">
                        <li>Times are in 24-hour format</li>
                        <li>End time must be after start time</li>
                        <li>Session numbers help group related activities</li>
                        <li>Event type determines where schedule appears</li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="page-break"></div>

        <div class="subsection">
            <h3 class="subsection-title">7.3 Editing Schedules</h3>
            <div class="content-block">
                <div class="block-title">Steps to Edit Schedule:</div>
                <ul class="info-list">
                    <li>Find the schedule in the list</li>
                    <li>Click the "Edit" button (pencil icon)</li>
                    <li>Modify available fields:
                        <ul>
                            <li>Update title or description</li>
                            <li>Adjust start/end times</li>
                            <li>Change session number</li>
                            <li>Switch event type if needed</li>
                        </ul>
                    </li>
                    <li>Click "Update Schedule" to save changes</li>
                </ul>

                <div class="note-box">
                    <div class="note-title">Time Management</div>
                    <ul class="info-list">
                        <li>Verify no scheduling conflicts</li>
                        <li>Consider buffer times between sessions</li>
                        <li>End time can be removed if duration is flexible</li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="page-break"></div>

        <div class="subsection">
            <h3 class="subsection-title">7.4 Deleting Schedules</h3>
            <div class="content-block">
                <div class="block-title">Steps to Delete Schedule:</div>
                <ul class="info-list">
                    <li>Locate the schedule in the list</li>
                    <li>Click the "Delete" button (trash icon)</li>
                    <li>Review schedule details in confirmation modal</li>
                    <li>Confirm deletion</li>
                </ul>

                <div class="note-box">
                    <div class="note-title">Warning</div>
                    <ul class="info-list">
                        <li>Deletion is permanent and cannot be undone</li>
                        <li>Consider impact on event timeline</li>
                        <li>Check for dependent activities</li>
                        <li>Verify if temporary deactivation is better</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</body>
</html>