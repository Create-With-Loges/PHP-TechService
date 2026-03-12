# Tech Service Support - User Manual

## Introduction
Welcome to the **Tech Service Support** system! This lightweight web application connects users experiencing laptop issues with expert service providers. Whether you have a hardware malfunction or a software glitch, our platform helps you find the right help quickly.

## System Requirements
-   **OS**: Windows 7 or higher
-   **Server**: XAMPP 3.2.2 (Apache & MySQL)
-   **Browser**: Chrome, Firefox, or Internet Explorer 8+

## Getting Started
1.  **Access the Site**: Open your browser and go to `http://localhost/ts/`.
2.  **Home Page**: You will see our services overview (Hardware & Software Support).
3.  **Navigation**: Use the menu bar to Login or Register.

---

## User Roles

### 1. User (The Customer)
*Sign up here if you need your laptop fixed.*

**Key Features:**
-   **Find Providers**: View a list of available experts.
-   **Request Support**: Send a direct help request to a provider.
-   **Track Status**: See if your request is "Pending", "In Progress", or "Completed".

**Step-by-Step Guide:**
1.  **Register**: Click "Register", select "User", and fill in your laptop details (Model & Company).
2.  **Login**: Use your username and password.
3.  **Search**: Click "View Service Providers" on your dashboard.
4.  **Request**: Click "Request Support" on a provider's card, describe your issue, and submit.
5.  **Track**: Go back to Dashboard -> "Track Requests" to see updates.

---

### 2. Service Provider (The Technician)
*Sign up here if you offer repair services.*

**Key Features:**
-   **Manage Requests**: View incoming jobs from users.
-   **Update Status**: Mark jobs as "Accepted", "In Progress", or "Completed".
-   **Profile**: Update your shop details and service expertise.

**Step-by-Step Guide:**
1.  **Register**: Click "Register", select "Service Provider", and enter your Shop ID and Service Type.
2.  **Login**: Access your Provider Dashboard.
3.  **Check Work**: Click "Manage Support Requests". You will see new tickets.
4.  **Update Job**:
    *   Review the user's issue and contact info.
    *   Change status to **"Accepted"** when you start.
    *   Change status to **"Completed"** when finished.
5.  **Save**: Click "Update" to notify the user.

---

### 3. Admin (The Manager)
*The system overseer.*

**Key Features:**
-   **Review Activity**: See all interactions between Users and Providers.
-   **Manage Accounts**: Oversee profile data.

**Step-by-Step Guide:**
1.  **Login**: Use the specific Admin credentials (default: `admin` / `admin123`).
2.  **Monitor**: Click "Review All Support Contacts" to see a history of all requests in the system.

---

## Troubleshooting

| Issue | Solution |
| :--- | :--- |
| **Login Failed** | Check if you selected the correct **Role** (User vs Provider) on the login page. |
| **Page Not Loading** | Ensure XAMPP Control Panel has Apache and MySQL services **Running** (Green). |
| **Forgot Password** | Contact the Admin (Passwords are currently stored simply for recovery). |

## Support
For further technical assistance, please contact the system administrator at `admin@techsupport.com`.
