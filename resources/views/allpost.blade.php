<!DOCTYPE html>
<html lang="en">

<head>
    <title>Bootstrap Example</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>

    <div class="container mt-3">
        <div class="d-flex justify-content-between">
            <h4>All Post</h4>
            <a href="" id="logoutBtn" class="btn btn-dark">Logout</a>
        </div>
        <div id="PostsContainer"></div>
    </div>
    <!-- Single Post  Modal -->
    <div class="modal fade" id="singlePostModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="singlePostLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fs-5" id="singlePostLabel">Single Post</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    ...
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script>
        document.querySelector('#logoutBtn').addEventListener('click', function(event) {
            event.preventDefault();
            const token = localStorage.getItem('api_token');

            fetch('/api/logout', {
                    method: 'POST',
                    headers: {
                        'Authorization': `Bearer ${token}`
                    }
                })
                .then(response => response.json())
                .then(data => {
                    console.log(data);
                    window.location.href = "http://localhost:8000/";
                })
                .catch(error => console.error('Error:', error));
        });
        function loadData() {
            const token = localStorage.getItem('api_token');
            fetch('/api/posts', {
                    method: 'GET',
                    headers: {
                        'Authorization': `Bearer ${token}`
                    }
                })
                .then(response => response.json())
                .then(data => {
                    // console.log(data.data.posts);
                    var allpost = data.data.posts;
                    const postContainer = document.querySelector('#PostsContainer');
                    var tabledata = `<table class="table text-center">
                <tr>
                    <th>Image</th>
                    <th>Title</th>
                    <th>Description</th>
                    <th colspan="3">Action</th>
                </tr>`;
                    allpost.forEach(post => {
                        tabledata += `
                <tr>
                    <td><img src="/uploads/${post.image}" alt="" width="100" height="100"></td>
                    <td>${post.title}</td>
                    <td>${post.description}</td>
                    <td><a href="" class="btn btn-primary"  data-bs-toggle="modal" data-bs-target="#singlePostModal" data-bs-postid="${post.id}">View</a></td>
                    <td><a href="" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#updatePostModal" data-bs-postid="${post.id}" >Update</a></td>
                    <td><a href="" class="btn btn-danger">Delete</a></td>
                </tr>`;
                    });
                    tabledata += `</table>`;
                    postContainer.innerHTML = tabledata;
                })
                .catch(error => console.error('Error:', error));
        }
        loadData();
        var singleModal = document.querySelector("#singlePostModal");
        if (singleModal) {
            singleModal.addEventListener('show.bs.modal', event => {
                const button = event.relatedTarget;
                const modalBody = document.querySelector("#singlePostModal .modal-body" );
                modalBody.innerHTML = "";
                const id = button.getAttribute('data-bs-postid');
                console.log(id);
                const token = localStorage.getItem('api_token');
                fetch(`/api/posts/${id}`, {
                        method: 'GET',
                        headers: {
                            'Authorization': `Bearer ${token}`,
                            'Content-Type': 'application/json'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        const post = data.data.post ;
                        modalBody.innerHTML = `
                        title : ${post.title}
                        <br>
                        Description : ${post.description}
                        <br>
                        <img width="150px" src="http://localhost:8000/uploads/${post.image}" >
                        `;
                    });
            });
        }
    </script>
</body>

</html>
