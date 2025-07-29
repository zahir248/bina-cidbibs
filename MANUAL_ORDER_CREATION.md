# Manual Order Creation Feature

## Overview
This feature allows administrators to manually create orders in the admin panel. This is particularly useful when:
- A transaction was successful but the order wasn't created due to technical issues
- A customer made a payment offline (cash, bank transfer, etc.)
- You need to create orders for special cases or bulk purchases

## How to Use

### 1. Access the Feature
1. Log in to the admin panel
2. Navigate to "Orders" in the sidebar
3. Click the "Create Order" button (green button with plus icon)

### 2. Fill in Customer Information
- **Select User (Optional)**: If the customer already has an account, you can select them to link this order to their account
- **Create New Customer**: If no user is selected, the order will be created without linking to any existing account

### 3. Billing Details
Fill in all required billing information:
- **Personal Information**: First name, last name, email, phone, gender, category
- **Address**: Country, address lines, city, state, postcode
- **Identity Number**: Optional field for identification

#### Category-Specific Fields
Depending on the selected category, additional fields will appear:

**Individual**: No additional fields

**Organization (B2B)**:
- Company Name
- Business Registration Number
- Tax Number

**Academician**:
- Student ID
- Academic Institution

### 4. Ticket Selection
- Select one or more tickets from the available options
- Each ticket shows its price and current stock
- Set the quantity for each ticket
- You can add multiple tickets by clicking "Add Another Ticket"
- The system will automatically calculate discounts based on quantity

### 5. Order Information
- **Reference Number**: Enter a unique reference number for this order (required)
- **Order Date**: Select the date when the order was created (required)
- **Order Time**: Select the time when the order was created (required)
- The system will validate that the reference number is unique

### 6. Payment Information
- **Payment Method**: Select from Cash, Bank Transfer, Stripe, or ToyyibPay
- **Payment Country**: Optional field for payment processing
- **Processing Fee**: Add any additional processing fees
- **Notes**: Add any relevant notes about the order

### 7. Order Summary
The form automatically calculates and displays:
- Subtotal (with quantity discounts applied)
- Processing fee
- Total amount
- Reference number (as entered above)
- Order date and time (as selected above)

### 8. Create Order
- Review all information
- Click "Create Order" to finalize
- The system will:
  - Use the provided reference number
  - Use the selected date and time for order creation
  - Create billing details record
  - Create the order record
  - Update ticket stock
  - Mark the order as "paid"
  - Generate QR codes for each ticket (for event entry)

## Important Notes

### Stock Management
- The system checks stock availability before creating orders
- Stock is automatically reduced when orders are created
- If insufficient stock, the order creation will fail with an error message

### Validation
- All required fields must be filled
- Email must be in valid format
- Phone numbers should be properly formatted
- Quantities must be positive integers
- Stock availability is checked

### Error Handling
- If any validation fails, the form will show error messages
- If stock is insufficient, a specific error will be displayed
- Database transactions ensure data consistency

### Reference Numbers
- **Manually entered** by the admin
- Must be unique across all orders
- Can follow any format (e.g., `ORD-20250115-001`, `CASH-001`, `BANK-20250115`)
- System validates uniqueness before creating order

### QR Codes
- **Automatically generated** for each ticket in the order
- One QR code per ticket (e.g., if quantity is 3, 3 QR codes are generated)
- QR codes contain order reference number and ticket name
- Stored as SVG files in the public storage
- Used for event entry verification
- Generated after order creation (won't fail order creation if QR generation fails)
- **Included in PDF downloads** from the orders list (same format as email PDFs)

## Troubleshooting

### Common Issues
1. **"Insufficient stock" error**: Check current ticket stock and reduce quantity
2. **"Reference number already exists" error**: Choose a different reference number
3. **"Invalid date/time format" error**: Ensure date and time are in correct format
4. **Validation errors**: Ensure all required fields are filled correctly
5. **Database errors**: Check if all migrations have been run

### Best Practices
1. Always verify customer information before creating orders
2. Double-check ticket quantities and prices
3. Use meaningful reference numbers (e.g., `CASH-001`, `BANK-20250115-001`)
4. Set accurate order date and time to reflect when the transaction actually occurred
5. Link orders to existing user accounts when possible for better tracking
6. Add notes for any special circumstances
7. Use appropriate payment methods for the transaction type
8. QR codes are automatically generated and can be accessed from the orders list

## Technical Details

### Files Modified/Created
- `app/Http/Controllers/Admin/OrderController.php` - Added create() and store() methods
- `resources/views/admin/orders/create.blade.php` - New order creation form
- `resources/views/admin/orders/index.blade.php` - Added "Create Order" button
- `routes/web.php` - Added new routes for order creation

### Database Tables Used
- `users` - For existing customer lookup (optional)
- `billing_details` - Stores customer billing information
- `tickets` - For ticket information and stock management
- `orders` - Stores the order record

### Security
- Admin authentication required
- Input validation and sanitization
- Database transaction safety
- Stock validation to prevent overselling 