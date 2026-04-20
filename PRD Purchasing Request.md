Procurement: Purchase Request → Purchase Order → Goods Receipt
 
1. Project Admin identifies a need for items/materials and navigates to "Purchase Requests → Create Purchase Request."

2. Project Admin fills in the request: item name(s), quantities, units, and notes, then submits.

3. System creates the Purchase Request with status "Submitted" and notifies the Purchasing Admin.

4. Purchasing Admin reviews the Purchase Request and clicks "Accept" (or "Decline" with reason).

5. If declined, the Project Admin is notified with the reason and can revise and resubmit.

6. If accepted, the Purchasing Admin navigates to "Purchase Orders → Create Purchase Order."

7. Purchasing Admin selects a supplier from the directory, confirms item details and pricing, and upload a pdf file of the Purchase Order.

8. Purchasing Admin print the Purchase Order and sends it to the supplier (outside the system).

9. Purchasing Admin updates the PO status as the supplier acknowledges and ships the order.

10. When items arrive at the warehouse, the Project Admin opens "Goods Receipt → Verify & Accept Items."

11. Project Admin compares delivered items against the original Purchase Request: records quantities received, inspects for defects, and notes any discrepancies.

12. If all items match and pass inspection, the Project Admin marks the Goods Receipt as "Verified (Full Match)" and items are added to warehouse inventory therefore ending the Purchase Request .

13. If there are discrepancies (missing items, defects, wrong items), the Project Admin marks the receipt as "Verified (Partial / With Discrepancies)" and the system notifies the Purchasing Admin for supplier follow-up.


### Purchase Request (PR) Management

| ID       | Requirement                                                                 | Priority |

|----------|-----------------------------------------------------------------------------|----------|
| PR-01    | Project Admin can create a Purchase Request with: item name(s), quantities, unit, justification notes. | P0 |
| PR-02    | Purchase Requests are tagged with the requesting warehouse and Project Admin name.                | P0       |
| PR-03    | Purchasing Admin receives notification when a new PR is submitted.         | P0       |
| PR-04    | Purchasing Admin can view a list of all PRs with filters (status, warehouse, date). | P0   |
| PR-05    | Purchasing Admin can accept or decline a PR with notes.                   | P0       |
| PR-06    | Project Admin receives notification when their PR is accepted or declined. | P0       |
| PR-07    | Project Admin can revise and resubmit a declined PR.                       | P1       |
| PR-08    | System tracks PR status (Submitted, Accepted, Declined, Converted to PO).  | P0       |

### Purchase Order (PO) Management

| ID       | Requirement                                                                 | Priority |

|----------|-----------------------------------------------------------------------------|----------|
| PO-01    | Purchasing Admin can create a PO from an accepted PR.                      | P0       |
| PO-02    | PO includes: supplier, item details, quantities, pricing, delivery date, PR reference. | P0  |
| PO-03    | Purchasing Admin can select a supplier from the directory or add a new one.| P0       |
| PO-04    | System generates a PO number automatically.                                | P0       |
| PO-05    | Purchasing Admin can export PO as PDF.                                     | P0       |
| PO-06    | Purchasing Admin can update PO status (Pending, Sent to Supplier, Shipped, Delivered). | P0 |
| PO-07    | System links PO to original PR for traceability.                           | P0       |
| PO-08    | Purchasing Admin can view all POs with filters (status, supplier, date, warehouse). | P0   |

### Supplier Management

| ID       | Requirement                                                                 | Priority |

|----------|-----------------------------------------------------------------------------|----------|
| SUP-01   | Purchasing Admin can add a new supplier with: name, contact person, email, phone, address. | P0 |
| SUP-02   | Purchasing Admin can edit supplier details.                                | P0       |
| SUP-03   | Purchasing Admin can deactivate a supplier (soft delete).                  | P1       |
| SUP-04   | System displays a supplier directory with active/inactive filters.         | P0       |
| SUP-05   | Track supplier performance metrics (on-time delivery rate, defect rate).   | P2       |

### Goods Receipt & Verification

| ID       | Requirement                                                                 | Priority |

|----------|-----------------------------------------------------------------------------|----------|
| GR-01    | Project Admin can open a Goods Receipt form linked to a specific PR/PO.    | P0       |
| GR-02    | Goods Receipt form auto-populates expected item details from PR/PO.        | P0       |
| GR-03    | Project Admin records actual quantities received, inspects for defects, and notes discrepancies. | P0 |
| GR-04    | Project Admin marks the receipt as "Verified (Full Match)" or "Verified (Partial / With Discrepancies)". | P0 |
| GR-05    | If "Full Match," items are automatically added to warehouse inventory.     | P0       |
| GR-06    | If "Partial / With Discrepancies," system notifies Purchasing Admin and flags the PO for follow-up. | P0 |
| GR-07    | System logs all Goods Receipts with timestamps and verification status.    | P0       |
| GR-08    | Goods Receipt data is linked to the original PR and PO for traceability.   | P0       |

### Assumptions
- One Project Admins can have multiple Purchase Requests
- Purchasing Admins 
- Suppliers are not users in the system; all supplier communication (sending POs, order updates) happens outside the platform.
- A Purchase Request can only be created by a Project Admin; a Purchase Order can only be created by a Purchasing Admin.
- Project Admins have read-only visibility across all warehouses to facilitate coordination and transfer planning, but can only manage items within their assigned warehouse.