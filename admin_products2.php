<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    
   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<!-- custom admin css file link  -->
<link rel="stylesheet" href="css/admin_style.css">

    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #ffffff;
        }
        section {
            margin: 30px;
            text-align: center;
        }

        form {
            display: flex;
            flex-direction: column;
            max-width: 500px;
            max-height: 500px;
            margin: 100px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        label {
            margin-bottom: 8px;
            font-weight: bold;
        }

        input {
            margin-bottom: 16px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        button {
            padding: 10px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }

        button:hover {
            background-color: #218838;
        }

        ul {
            list-style-type: none;
            padding: 0;
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            width: 100%;
            height: 100%;
        }

        li {
            background-color: #fff;
            margin: 10px;
            padding: 15px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
            max-width: 300px;
        }

        .delete-btn {
            background-color: #dc3545;
            color: white;
            border: none;
            padding: 8px;
            cursor: pointer;
            border-radius: 4px;
            margin-left: 20px;
        }

        .delete-btn:hover {
            background-color: #c82333;
        }
    </style>
</head>
<body>
    <?php include 'admin_header.php'; ?>
    <form id="addUserForm" enctype="multipart/form-data">
    <label for="username">Name:</label>
    <input type="text" id="username" name="username" required>

    <label for="profileImage">Choose Profile Image:</label>
    <input type="file" id="profileImage" name="profileImage" accept="image/*">

    <button type="button" onclick="addUser()">Add Authors</button>
</form>


    <section>
        <h2>Authors List</h2>
        <ul id="userList"></ul>
    </section>

    <script>
        function addUser() {
            var username = document.getElementById("username").value;
            var email = document.getElementById("email").value;

            var userList = document.getElementById("userList");
            var listItem = document.createElement("li");
            listItem.innerHTML = `
                <span>${username} - ${email}</span>
                <button class="delete-btn" onclick="deleteItem(this)">Delete</button>
            `;

            userList.appendChild(listItem);
        }

        function addBook() {
            var bookTitle = document.getElementById("bookTitle").value;
            var author = document.getElementById("author").value;

            var bookList = document.getElementById("bookList");
            var listItem = document.createElement("li");
            listItem.innerHTML = `
                <span>${bookTitle} by ${author}</span>
                <button class="delete-btn" onclick="deleteItem(this)">Delete</button>
            `;

            bookList.appendChild(listItem);
        }

        function deleteItem(button) {
            var listItem = button.parentNode;
            listItem.parentNode.removeChild(listItem);
        }

        function addUser() {
    var username = document.getElementById("username").value;
    var profileImageInput = document.getElementById("profileImage");

    if (profileImageInput.files.length > 0) {
        var file = profileImageInput.files[0];

        // Resize the image using a canvas (adjust the dimensions as needed)
        var canvas = document.createElement("canvas");
        var ctx = canvas.getContext("2d");
        var maxImageSize = 200; // Set the maximum size for the image
        var image = new Image();

        image.onload = function () {
            var width = image.width;
            var height = image.height;

            if (width > height) {
                if (width > maxImageSize) {
                    height *= maxImageSize / width;
                    width = maxImageSize;
                }
            } else {
                if (height > maxImageSize) {
                    width *= maxImageSize / height;
                    height = maxImageSize;
                }
            }

            canvas.width = width;
            canvas.height = height;

            ctx.drawImage(image, 0, 0, width, height);

            // Get the data URL of the resized image
            var resizedImageDataUrl = canvas.toDataURL("image/jpeg");

            var userList = document.getElementById("userList");
            var listItem = document.createElement("li");
            listItem.innerHTML = `
                <span style="font-size: 16px;ont-size: large;
                font-family: fantasy;
                display: block;
                margin-right: 30px;
                display: block;">${username}</span>
                <img src="${resizedImageDataUrl}" alt="${username}'s profile image">
                <button class="delete-btn" onclick="deleteItem(this)">Delete</button>
            `;

            userList.appendChild(listItem);
        };

        // Set the source of the image to the selected file
        image.src = URL.createObjectURL(file);
    } else {
        // Handle the case when no file is selected
        alert("Please choose a profile image.");
    }
}

    </script>

</body>
</html>
