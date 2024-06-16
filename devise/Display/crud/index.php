<!DOCTYPE html>
<html lang="en">
<head>
<!--    <meta charset="UTF-8">-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog CRUD</title>
    <link rel="stylesheet" href="../../public/css/output.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @media (max-width: 640px) {
            table, thead, tbody, th, td, tr {
                display: block;
            }
            thead tr {
                position: absolute;
                top: -9999px;
                left: -9999px;
            }
            tr {
                margin-bottom: 1rem;
                border: 1px solid #ccc;
            }
            td {
                border: none;
                position: relative;
                padding-left: 50%;
            }
            td:before {
                position: absolute;
                top: 6px;
                left: 6px;
                width: 45%;
                padding-right: 10px;
                white-space: nowrap;
                content: attr(data-label);
                font-weight: bold;
            }
        }
    </style>
</head>
<body class="bg-gray-100 p-4 sm:p-8">

<div class="max-w-4xl mx-auto">
    <h1 class="text-2xl sm:text-3xl font-bold mb-4 sm:mb-6">Blog Posts</h1>
    <div class="flex space-x-2 mb-4">
        <a href="/" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            Back to Home
        </a>
        <button id="addNewBtn" class="bg-green-500 text-white px-3 py-1 sm:px-4 sm:py-2 rounded">Add New Post</button>
        <button id="toggleViewBtn" class="bg-blue-500 text-white px-3 py-1 sm:px-4 sm:py-2 rounded">Toggle View</button>
    </div>

    <!-- Create Form -->
    <div id="createFormContainer" class="hidden mb-4 p-4 bg-white rounded shadow">
        <h2 class="text-xl font-bold mb-4">Create New Post</h2>
        <form id="createForm">
            <div class="mb-4">
                <label for="createName" class="block mb-2">Name:</label>
                <input type="text" id="createName" name="name" required class="w-full p-2 border rounded">
            </div>
            <div class="mb-4">
                <label for="createDescription" class="block mb-2">Description:</label>
                <textarea id="createDescription" name="description" required class="w-full p-2 border rounded"></textarea>
            </div>
            <div class="mb-4">
                <label for="createImage" class="block mb-2">Image:</label>
                <input type="file" id="createImage" name="image" accept="image/*" required class="w-full p-2 border rounded">
            </div>
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Create Post</button>
        </form>
    </div>

    <!-- Update Form -->
    <div id="updateFormContainer" class="hidden mb-4 p-4 bg-white rounded shadow">
        <h2 class="text-xl font-bold mb-4">Update Post</h2>
        <form id="updateForm">
            <input type="hidden" id="updatePostId" name="id">
            <div class="mb-4">
                <label for="updateName" class="block mb-2">Name:</label>
                <input type="text" id="updateName" name="name" required class="w-full p-2 border rounded">
            </div>
            <div class="mb-4">
                <label for="updateDescription" class="block mb-2">Description:</label>
                <textarea id="updateDescription" name="description" required class="w-full p-2 border rounded"></textarea>
            </div>
            <div class="mb-4">
                <label for="updateImage" class="block mb-2">Image:</label>
                <input type="file" id="updateImage" name="image" accept="image/*" class="w-full p-2 border rounded">
            </div>
            <button type="submit" class="bg-yellow-500 text-white px-4 py-2 rounded">Update Post</button>
        </form>
    </div>

    <!-- Table View -->
    <div id="tableView" class="overflow-x-auto">
        <table class="w-full bg-white shadow-md rounded">
            <thead class="bg-gray-200">
            <tr>
                <th class="p-3 text-left">ID</th>
                <th class="p-3 text-left">Name</th>
                <th class="p-3 text-left">Description</th>
                <th class="p-3 text-left">Image</th>
                <th class="p-3 text-left">Actions</th>
            </tr>
            </thead>
            <tbody id="blogData"></tbody>
        </table>
    </div>

    <!-- Gallery View -->
    <div id="galleryView" class="hidden">
        <div id="imageGrid" class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4"></div>
    </div>

    <!-- Modal -->
    <div id="imageModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center">
        <div class="bg-white p-4 rounded-lg max-w-xl w-full">
            <img id="modalImage" src="" alt="" class="h-full w-full object-cover  mb-4">
            <h2 id="modalTitle" class="text-xl font-bold mb-2"></h2>
            <p id="modalDescription" class="mb-4"></p>
            <button id="closeModal" class="bg-red-500 text-white px-4 py-2 rounded">Close</button>
        </div>
    </div>
</div>

<script type="module">
    import { makeRequestWithCsrfToken } from "../../../public/js/request.js";

    const apiUrl = 'http://localhost:9501/crud/blog';
    const blogData = document.getElementById('blogData');
    const createFormContainer = document.getElementById('createFormContainer');
    const updateFormContainer = document.getElementById('updateFormContainer');
    const createForm = document.getElementById('createForm');
    const updateForm = document.getElementById('updateForm');
    const addNewBtn = document.getElementById('addNewBtn');
    const toggleViewBtn = document.getElementById('toggleViewBtn');
    const tableView = document.getElementById('tableView');
    const galleryView = document.getElementById('galleryView');
    const imageGrid = document.getElementById('imageGrid');
    const imageModal = document.getElementById('imageModal');
    const modalImage = document.getElementById('modalImage');
    const modalTitle = document.getElementById('modalTitle');
    const modalDescription = document.getElementById('modalDescription');
    const closeModal = document.getElementById('closeModal');

    let isTableView = true;

    function fetchBlogPosts() {
        fetch(apiUrl)
            .then(response => response.json())
            .then(posts => {
                renderTable(posts);
                renderGallery(posts);
            })
            .catch(error => console.error('Error fetching blog posts:', error));
    }

    function renderTable(posts) {
        blogData.innerHTML = '';
        posts.forEach(post => {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td class="p-3" data-label="ID">${post.id}</td>
                <td class="p-3" data-label="Name">${post.name}</td>
                <td class="p-3" data-label="Description">${post.description}</td>
                <td class="p-3" data-label="Image">
                    <img src="${post.image}" alt="${post.name}" class="w-16 h-16 object-cover">
                </td>
                <td class="p-3" data-label="Actions">
                    <button class="editBtn bg-yellow-500 text-white px-2 py-1 rounded mr-2 mb-1 sm:mb-0">Edit</button>
                    <button class="deleteBtn bg-red-500 text-white px-2 py-1 rounded">Delete</button>
                </td>
            `;
            blogData.appendChild(row);

            row.querySelector('.editBtn').addEventListener('click', () => editPost(post.id));
            row.querySelector('.deleteBtn').addEventListener('click', () => deletePost(post.id));
        });
    }

    function renderGallery(posts) {
        imageGrid.innerHTML = '';
        posts.forEach(post => {
            const imageCard = document.createElement('div');
            imageCard.className = 'relative overflow-hidden rounded-lg shadow-md transition-transform duration-300 hover:scale-105';
            imageCard.innerHTML = `
                <img src="${post.image}" alt="${post.name}" class="w-full h-48 object-cover">
                <div class="absolute inset-0 bg-black bg-opacity-50 opacity-0 hover:opacity-100 transition-opacity duration-300 flex items-center justify-center">
                    <h3 class="text-white text-center font-bold">${post.name}</h3>
                </div>
            `;
            imageCard.addEventListener('click', () => showImageModal(post));
            imageGrid.appendChild(imageCard);
        });
    }

    function showImageModal(post) {
        modalImage.src = post.image;
        modalImage.alt = post.name;
        modalTitle.textContent = post.name;
        modalDescription.textContent = post.description;
        imageModal.classList.remove('hidden');
        imageModal.classList.add('flex');
    }

    function editPost(id) {
        fetch(`${apiUrl}/${id}`)
            .then(response => response.json())
            .then(data => {
                const post = Array.isArray(data) ? data[0] : data;

                document.getElementById('updatePostId').value = post.id;
                document.getElementById('updateName').value = post.name;
                document.getElementById('updateDescription').value = post.description;
                updateFormContainer.classList.remove('hidden');
                createFormContainer.classList.add('hidden');
            })
            .catch(error => console.error('Error fetching post details:', error));
    }

    async function deletePost(id) {
        if (confirm('Are you sure you want to delete this post?')) {
            try {
                const response = await makeRequestWithCsrfToken(`http://localhost:9501/crud/delete/${id}`, {
                    method: 'DELETE',
                });

                if (response.ok) {
                    fetchBlogPosts();
                } else {
                    console.error('Error deleting post:', response.status);
                }
            } catch (error) {
                console.error('Error deleting post:', error);
            }
        }
    }

    function toggleView() {
        isTableView = !isTableView;
        if (isTableView) {
            tableView.classList.remove('hidden');
            galleryView.classList.add('hidden');
        } else {
            tableView.classList.add('hidden');
            galleryView.classList.remove('hidden');
        }
    }

    toggleViewBtn.addEventListener('click', toggleView);

    addNewBtn.addEventListener('click', () => {
        createForm.reset();
        createFormContainer.classList.remove('hidden');
        updateFormContainer.classList.add('hidden');
    });

    closeModal.addEventListener('click', () => {
        imageModal.classList.add('hidden');
        imageModal.classList.remove('flex');
    });

    createForm.addEventListener('submit', async (e) => {
        e.preventDefault();
        const formData = new FormData(createForm);

        try {
            const response = await makeRequestWithCsrfToken("http://localhost:9501/crud/create", {
                method: 'POST',
                body: formData
            });

            if (response.ok) {
                fetchBlogPosts();
                createFormContainer.classList.add('hidden');
            } else {
                console.error('Error creating post:', response.status);
            }
        } catch (error) {
            console.error('Error creating post:', error);
        }
    });

    updateForm.addEventListener('submit', async (e) => {
        e.preventDefault();
        const formData = new FormData(updateForm);
        const postId = document.getElementById('updatePostId').value;

        try {
            const response = await makeRequestWithCsrfToken(`http://localhost:9501/crud/update/${postId}`, {
                method: 'PUT',
                body: formData
            });

            if (response.ok) {
                fetchBlogPosts();
                updateFormContainer.classList.add('hidden');
            } else {
                console.error('Error updating post:', response.status);
            }
        } catch (error) {
            console.error('Error updating post:', error);
        }
    });

    fetchBlogPosts();
</script>

</body>
</html>