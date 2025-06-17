# TenantList

TenantList is a simple PHP web application for managing tenants in a shopping mall. It allows you to add, view, and delete tenants, with a clean and modern user interface.

## Features

- Add new tenants with name, email, and rent amount.
- View a list of all tenants.
- Delete tenants from the list.
- Flash messages for success, error, and warnings.
- Responsive and stylish UI using custom CSS.

## Requirements

- PHP 7.x or higher
- MySQL
- Web server (e.g., Apache, XAMPP)

## Setup

1. **Clone or copy the project files** to your web server directory (e.g., `htdocs` for XAMPP).
   Or clone directly from GitHub:

   ```bash
   git clone https://github.com/Abiii1401/TenantList-Laravel-.git
   ```

2. **Create the database and table:**

   - Create a database named `shoppingmall`.
   - Run the following SQL to create the `tenants` table:

     ```sql
     CREATE TABLE tenants (
         id INT AUTO_INCREMENT PRIMARY KEY,
         name VARCHAR(100) NOT NULL,
         email VARCHAR(100) NOT NULL UNIQUE,
         rent INT NOT NULL
     );
     ```

3. **Configure database connection:**

   - The database connection settings are in [`index.php`](index.php). By default, it uses:
     - Host: `localhost`
     - User: `root`
     - Password: (empty)
     - Database: `shoppingmall`
   - Update these values if your setup is different.

4. **Start your web server** and open [http://localhost/TenantList/index.php](http://localhost/TenantList/index.php) in your browser.

## How to change your GitHub repository from private to public

If your repository is currently private and you want to make it public, follow these steps:

1. Go to your repository page on GitHub:  
   [https://github.com/Abiii1401/TenantList-Laravel-](https://github.com/Abiii1401/TenantList-Laravel-)

2. Click on the **Settings** tab near the top right.

3. Scroll down to the **"Danger Zone"** section at the bottom of the page.

4. Click on **Change repository visibility**.

5. Choose **Make public**.

6. Confirm your choice by typing the repository name and clicking the confirmation button.

Once done, your repo will be public and accessible to everyone.

## File Structure

- [`index.php`](index.php): Main application file with all PHP logic and HTML.
- [`style.css`](style.css): Stylesheet for the UI.
- [`README.md`](README.md): Project documentation.

## License

This project is licensed under the MIT License.  
See the [LICENSE](LICENSE) file for details.

---

**Author:** Abishek  
3rd Year Software Engineering Student, SLIIT University  
Web Developer Intern

> This project was built as part of my personal portfolio to demonstrate my PHP and web development skills.

