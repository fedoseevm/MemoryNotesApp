<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Memory Recording Site</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles/general.css">
    <link rel="stylesheet" href="index.css">
    <?php 
    session_start();
    ?>
</head>

<body>
    <header>
        <a href="index.php">
            <div id="logo">LOGO</div>
        </a>
        <div class="btn-container">
            <a href="auth/login.html"><button id="login-btn" class="btn btn-primary me-2">Login</button></a>
            <a href="auth/register.html"><button id="register-btn" class="btn btn-secondary">Registration</button></a>
            <a><button id="join-class-btn" class="btn btn-primary me-2" style="display: none;">Join class</button></a>
            <a><button id="create-class-btn" class="btn btn-secondary" style="display: none;">Create class</button></a>
        </div>
    </header>

    <main>
        <div class="table-container">
            <table class="table table-bordered">
                <thead>
                    <th>Date</th>
                    <th>Your memories</th>
                </thead>
                <tbody id="memory-table">
                    <tr>
                        <td id="current-date"></td>
                        <td class="text-center" id="memory-cell">
                            <button class="btn-icon add-memory-btn">
                                <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor"
                                    class="bi bi-plus-circle" viewBox="0 0 16 16">
                                    <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16" />
                                    <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4" />
                                </svg>
                            </button>
                            <div id="memory-list" style="display: flex; gap: 10px; align-items: center;"></div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </main>

    <footer>
        <p>&copy; 2025 MemoryNotes app</p>
    </footer>

    <div class="modal fade" id="memoryModal" tabindex="-1" aria-labelledby="memoryModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="memoryModalLabel">Add a Memory</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- todo: check if text contains special characters -->
                    <textarea id="memoryText" class="form-control"
                        placeholder="Write your memory... (max 50 characters)" maxlength="50"></textarea>
                    <input type="file" id="memoryImage" class="form-control mt-2" accept="image/*">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="saveMemory">Save</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            let isLoggedIn = false;
            if ('<?php 
        echo $_SESSION["isLoggedIn"];
        ?>' === "1")
        {
isLoggedIn = true;
        }
            const isInClass = true;

            if (isLoggedIn) {
                document.getElementById("login-btn").style.display = "none";
                document.getElementById("register-btn").style.display = "none";
                document.getElementById("join-class-btn").style.display = "inline-block";
                document.getElementById("create-class-btn").style.display = "inline-block";

                if (isInClass) {
                    document.getElementById("join-class-btn").style.display = "none";
                    document.getElementById("create-class-btn").style.display = "none";

                    document.querySelector(".table-container").style.display = "block";
                }
            }

            const modal = new bootstrap.Modal(document.getElementById('memoryModal'));
            const addMemoryButton = document.querySelector(".add-memory-btn");
            const saveMemoryButton = document.getElementById("saveMemory");
            const memoryText = document.getElementById("memoryText");
            const memoryImage = document.getElementById("memoryImage");
            const memoryCell = document.getElementById("memory-cell");
            const currentDateCell = document.getElementById("current-date");

            const today = new Date();
            currentDateCell.textContent = `${today.getDate()}.${today.getMonth() + 1}`;

            addMemoryButton.addEventListener("click", function () {
                modal.show();
            });

            saveMemoryButton.addEventListener("click", function () {
                const text = memoryText.value.trim();
                const file = memoryImage.files[0];

                if (!text && !file) {
                    alert("Please enter a memory or select an image.");
                    return;
                }

                let memoryContent = document.createElement("div");
                memoryContent.classList.add("memory-item");

                if (file) {
                    const imgURL = URL.createObjectURL(file);
                    memoryContent.innerHTML = `<img src="${imgURL}"><span class='tooltip-text'>${text}</span>`;
                } else {
                    memoryContent.innerHTML = `<p class='memory-text'>${text}</p>`;
                }

                const memoryList = document.getElementById("memory-list");
                memoryList.insertBefore(memoryContent, memoryList.firstChild); 
                // todo: send memories to the database

                memoryText.value = "";
                memoryImage.value = "";
                modal.hide();
            });
        });
    </script>
</body>

</html>