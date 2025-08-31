<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CI4 Crud </title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

    <style>
        * {
            padding: 0;
            margin: 0;
            box-sizing: border-box;
        }
    </style>
</head>

<body>
    <div class="container-fluid bg-dark vh-120">
        <h1 class="text-center text-info py-2 fs-3">CI4 CRUD</h1>
        <div class="container bg-light py-3 rounded-3">

            <!-- to open modal to add student -->
            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#exampleModal">
                <i class="fa-solid fa-plus text-light"></i> Add Student
            </button>
            <!-- to open modal to add student -->

            <!-- create student model -->
            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Add Student Details</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="createForm">
                                <!-- Student Name -->
                                <div class="mb-3">
                                    <label for="studentName" class="form-label">Student Name</label>
                                    <input type="text" class="form-control" id="studentName" name="name"
                                        placeholder="Enter your name" required>
                                    <div id="nameHelp" class="form-text">Name should contain only alphabets and spaces.
                                    </div>
                                </div>

                                <!-- Email Address -->
                                <div class="mb-3">
                                    <label for="emailAddress" class="form-label">Email Address</label>
                                    <input type="email" class="form-control" id="emailAddress" name="email"
                                        aria-describedby="emailHelp" placeholder="Enter your email" required>
                                    <div id="emailHelp" class="form-text">Enter a valid email (e.g., name@example.com).
                                    </div>
                                </div>

                                <!-- Student Phone -->
                                <div class="mb-3">
                                    <label for="studentPhone" class="form-label">Student Phone</label>
                                    <input type="tel" class="form-control" id="studentPhone" name="phone"
                                        placeholder="Enter your phone number" pattern="[0-9]{10}" required>
                                    <div id="phoneHelp" class="form-text">Enter a 10-digit phone number without spaces
                                        or
                                        special characters.</div>
                                </div>

                                <!-- Course -->
                                <div class="mb-3">
                                    <label for="course" class="form-label">Course</label>
                                    <input type="text" class="form-control" id="course" name="course"
                                        placeholder="Enter your course name" required>
                                    <div id="courseHelp" class="form-text">Specify your enrolled course (e.g., B.Sc
                                        Computer
                                        Science).</div>
                                </div>

                                <!-- Actions -->
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary btn-sm"
                                        data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-success btn-sm">Save changes</button>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
            <!-- create student model -->

            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">Sr No.</th>
                        <th scope="col">Name</th>
                        <th scope="col">Email</th>
                        <th scope="col">Phone</th>
                        <th scope="col">Course</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>

                    <?php if ($students !== []): ?>
                        <?php $i = 1 + ($pager->getCurrentPage('default') - 1) * $pager->getPerPage('default'); ?>
                        <?php foreach ($students as $key => $student): ?>
                            <tr>
                                <th scope="row"><?= $i++ ?></th>
                                <td><?= esc($student['name']) ?></td>
                                <td><?= esc($student['email']) ?></td>
                                <td><?= esc($student['phone']) ?></td>
                                <td><?= esc($student['course']) ?></td>
                                <td>
                                    <Button class="btn-success btn btn-sm editBtn" data-id="<?= $student['id'] ?>"
                                        data-name="<?= esc($student['name']) ?>" data-email="<?= esc($student['email']) ?>"
                                        data-phone="<?= esc($student['phone']) ?>" data-course="<?= esc($student['course']) ?>"
                                        data-bs-toggle="modal" data-bs-target="#editModal">
                                        Edit
                                    </Button>
                                    <Button class="btn-danger btn btn-sm ms-1 deleteBtn" data-id="<?= $student['id'] ?>">
                                        Delete
                                    </Button>
                                </td>
                            </tr>
                        <?php endforeach ?>

                    <?php else: ?>
                        <p>No student info</p>
                    <?php endif ?>
                </tbody>
            </table>

            <div class="mt-3 d-flex justify-content-center">
                <?= $pager->links() ?>
            </div>

            <!-- student edit modal -->
            <div class="modal fade" id="editModal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <input type="hidden" id="editId">

                        <div class="modal-header">
                            <h5 class="modal-title">Edit Student</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>

                        <div class="modal-body">
                            <div class="mb-3">
                                <label class="form-label">Student Name</label>
                                <input type="text" class="form-control" id="editName" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Email Address</label>
                                <input type="email" class="form-control" id="editEmail" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Phone</label>
                                <input type="tel" class="form-control" id="editPhone" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Course</label>
                                <input type="text" class="form-control" id="editCourse" required>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary btn-sm"
                                data-bs-dismiss="modal">Close</button>
                            <button type="button" id="updateBtn" class="btn btn-primary btn-sm">Update</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- student edit modal -->


        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <script>
        $(document).ready(function () {


            toastr.options = {
                closeButton: true,
                progressBar: true,
                positionClass: "toast-top-right",
                timeOut: "3000"
            };

            $("#createForm").on("submit", function (e) {
                e.preventDefault();

                let form = $(this);

                $.ajax({
                    url: '/create',
                    method: "POST",
                    data: form.serialize(),
                    success: function (response) {
                        if (response.status === "success") {
                            toastr.success(response.message);

                            $("#exampleModal").modal("hide");

                            form[0].reset();

                            window.location.reload();
                            // Append new row to table
                            let newRow = `
                        <tr id="row-${response.student.id}">
                            <th scope="row">NEW</th>
                            <td>${response.student.name}</td>
                            <td>${response.student.email}</td>
                            <td>${response.student.phone}</td>
                            <td>${response.student.course}</td>
                            <td>
                                <button class="btn btn-success btn-sm editBtn" data-id="${response.student.id}" 
                                        data-name="${response.student.name}" 
                                        data-email="${response.student.email}" 
                                        data-phone="${response.student.phone}" 
                                        data-course="${response.student.course}">Edit</button>
                                <button class="btn btn-danger btn-sm ms-1 deleteBtn" data-id="${response.student.id}">Delete</button>
                            </td>
                        </tr>
                    `;
                            $("table tbody").append(newRow);

                        } else {
                            // Validation errors
                            $.each(response.errors, function (field, error) {
                                toastr.error(error);
                            });
                        }
                    },
                    error: function () {
                        toastr.error("Something went wrong!");
                    }
                });
            });

            $('.editBtn').click(function () {
                $("#editId").val($(this).data("id"));
                $("#editName").val($(this).data("name"));
                $("#editEmail").val($(this).data("email"));
                $("#editPhone").val($(this).data("phone"));
                $("#editCourse").val($(this).data("course"));
            })

            $("#updateBtn").click(function () {
                $.ajax({
                    url: "/update",
                    type: "POST",
                    data: {
                        id: $("#editId").val(),
                        name: $("#editName").val(),
                        email: $("#editEmail").val(),
                        phone: $("#editPhone").val(),
                        course: $("#editCourse").val(),
                    },
                    success: function (response) {
                        if (response.status === "success") {
                            let id = $("#editId").val();
                            let row = $("#row-" + id);
                            row.find("td:eq(0)").text($("#editName").val());
                            row.find("td:eq(1)").text($("#editEmail").val());
                            row.find("td:eq(2)").text($("#editPhone").val());
                            row.find("td:eq(3)").text($("#editCourse").val());


                            $("#editModal").modal("hide");
                            toastr.success(response.message);

                            window.location.reload();
                        } else {
                            toastr.error("Update failed!");
                        }
                    }
                });
            });


            $('.deleteBtn').click(function () {
                let id = $(this).data('id');

                if (!confirm("Are you sure you want to delete this student?")) return;
                $.ajax({
                    url: "/delete/" + id,
                    type: "DELETE",
                    success: function (response) {
                        if (response.status === "success") {
                            $("#row-" + id).fadeOut(300, function () {
                                $(this).remove();
                            });
                            toastr.success(response.message);

                            window.location.reload()
                        } else {
                            toastr.error("Delete failed!");
                        }
                    }
                });

            })

        })

    </script>

</body>

</html>