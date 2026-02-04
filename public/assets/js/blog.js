// <!-- Sidebar Toggle Script -->

const sidebar = document.getElementById('sidebar');
const overlay = document.getElementById('sidebarOverlay');
const menuBtn = document.getElementById('menuBtn');

menuBtn?.addEventListener('click', () => {
    sidebar.classList.add('active');
    overlay.classList.add('active');
});

overlay.addEventListener('click', () => {
    sidebar.classList.remove('active');
    overlay.classList.remove('active');
});

$(document).ready(function () {
    $('#blogsTable').DataTable({
        pageLength: 10,
        lengthChange: false,
        ordering: true,
        searching: true,
        responsive: true,
        columnDefs: [{
            orderable: false,
            targets: [6]
        } // Action column
        ]
    });
});

$(function () {
    /* ---------- OPEN CREATE ---------- */
    $('.addBlog').click(function () {
        $('#modalTitle').text('New Blog');
        $('#blogForm')[0].reset();
        $('#blog_id').val('');
        $('#saveBtn').show();
        $('#blogModal').modal('show');
    });

    /* ---------- SAVE / UPDATE ---------- */
    $('#blogForm').submit(function (e) {
        e.preventDefault();

        let id = $('#blog_id').val();
        let url = id ?
            `/admin/blogs/update/${id}` :
            `/admin/blogs/store`;

        $.post(url, {
            _token: '{{ csrf_token() }}',
            title: $('#title').val(),
            description: $('#description').val(),
            reference_link: $('#reference_link').val(),
            status: $('#status').val()
        }, function () {
            location.reload();
        });
    });

    /* ---------- VIEW ---------- */
    $('.viewBlog').click(function () {
        let id = $(this).data('id');

        $.get(`/admin/blogs/view/${id}`, function (data) {
            $('#modalTitle').text('View Blog');
            fillForm(data);
            $('#saveBtn').hide();
            $('#blogModal').modal('show');
        });
    });

    /* ---------- EDIT ---------- */
    $('.editBlog').click(function () {
        let id = $(this).data('id');

        $.get(`/admin/blogs/view/${id}`, function (data) {
            $('#modalTitle').text('Edit Blog');
            fillForm(data);
            $('#saveBtn').show();
            $('#blogModal').modal('show');
        });
    });

    function fillForm(data) {
        $('#blog_id').val(data.id);
        $('#title').val(data.title);
        $('#description').val(data.description);
        $('#reference_link').val(data.reference_link);
        $('#status').val(data.status);
    }

});
