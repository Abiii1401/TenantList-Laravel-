<?php
session_start();

$host = "localhost";
$user = "root";
$pass = "";
$dbname = "shoppingmall";

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    // Set error flash message and show on page
    $_SESSION["flash_msg"] = "<div class='message error'>❌ Connection failed: " . $conn->connect_error . "</div>";
}

// Handle Add Tenant POST
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["add_tenant"])) {
    $name = $conn->real_escape_string($_POST["name"]);
    $email = $conn->real_escape_string($_POST["email"]);
    $rent = (int) $_POST["rent"];

    $check_sql = "SELECT * FROM tenants WHERE email = '$email'";
    $check_result = $conn->query($check_sql);

    if ($check_result->num_rows == 0) {
        $sql = "INSERT INTO tenants (name, email, rent) VALUES('$name', '$email', $rent)";
        if ($conn->query($sql) === TRUE) {
            $_SESSION["flash_msg"] = "<div class='message success'>✅ Tenant added successfully.</div>";
        } else {
            $_SESSION["flash_msg"] = "<div class='message error'>❌ Insert Error: " . $conn->error . "</div>";
        }
    } else {
        $_SESSION["flash_msg"] = "<div class='message warning'>⚠️ Tenant already exists with this email.</div>";
    }

    // Redirect to avoid resubmission and repeated message on reload
    header("Location: " . $_SERVER["PHP_SELF"]);
    exit();
}

// Handle Delete Tenant GET
if (isset($_GET["delete_id"])) {
    $id = (int) $_GET["delete_id"];
    $delete_sql = "DELETE FROM tenants WHERE id = $id";
    if ($conn->query($delete_sql) === TRUE) {
        $_SESSION["flash_msg"] = "<div class='message success'>🗑️ Tenant deleted successfully.</div>";
    } else {
        $_SESSION["flash_msg"] = "<div class='message error'>❌ Delete Error: " . $conn->error . "</div>";
    }

    // Redirect to avoid repeated delete message on reload
    header("Location: " . strtok($_SERVER["REQUEST_URI"], '?')); // Redirect to same page without query params
    exit();
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <title>Tenant Management</title>
    <link rel="stylesheet" href="style.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500;700&display=swap" rel="stylesheet" />
</head>

<body>

    <?php
    // Show flash message once then clear
    if (!empty($_SESSION["flash_msg"])) {
        echo $_SESSION["flash_msg"];
        unset($_SESSION["flash_msg"]);
    } elseif (!$conn->connect_error) {
        // Show successful connection message only once on initial page load (optional)
        echo "<div class='message success'>✅ Connected to database successfully.</div>";
    }
    ?>

    <div class="container">
        <h2>➕ Add New Tenant</h2>
        <form method="POST" action="">
            <label for="name">Name:</label>
            <input type="text" name="name" required />

            <label for="email">Email:</label>
            <input type="email" name="email" required />

            <label for="rent">Rent:</label>
            <input type="number" name="rent" required />

            <input type="submit" name="add_tenant" value="Add Tenant" />
        </form>

        <hr />

        <h2>🏢 Tenant List</h2>
        <div class="tenant-table-wrapper">
            <table class="tenant-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Rent</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = "SELECT * FROM tenants";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        $count = 1;
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $count++ . "</td>";
                            echo "<td>" . htmlspecialchars($row["name"]) . "</td>";
                            echo "<td>" . htmlspecialchars($row["email"]) . "</td>";
                            echo "<td>$" . htmlspecialchars($row["rent"]) . "</td>";
                            echo "<td><a class='delete-link' href='?delete_id=" . $row["id"] . "' onclick='return confirm(\"Delete this tenant?\");'>🗑️ Delete</a></td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='5'>No tenants found.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <script>
        // Auto-hide flash message after 4 seconds
        setTimeout(() => {
            const msg = document.querySelector('.message');
            if (msg) msg.style.display = 'none';
        }, 4000);
    </script>

</body>

</html>