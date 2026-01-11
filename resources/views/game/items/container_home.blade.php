<style>


.content-collapsed {
    max-height: 260px; /* chỉnh chiều cao ban đầu tại đây */
    overflow: hidden;
    position: relative;
    transition: max-height 0.4s ease;
}

/* Hiệu ứng mờ phía dưới */
.content-collapsed::after {
    content: "";
    position: absolute;
    left: 0;
    right: 0;
    bottom: 0;
    height: 80px;
    background: linear-gradient(to bottom, rgba(37, 36, 36,0), rgba(37, 36, 36,255));
}

/* Khi mở */
.content-expanded {
    max-height: 5000px;
}

.content-expanded::after {
    display: none;
}

</style>
	<div class="col-12 mb-4">
      <div class="bg-body-secondary rounded-4 p-3 px-xl-5">

        <div id="content-wrapper" class="content-collapsed">
		{!! $container_home!!}
        </div>

        <div class="text-center mt-3">
            <button id="toggleBtn" class="btn btn-outline-success rounded-pill px-4">
                View more
            </button>
        </div>

    </div>
	</div>

    <script>
document.getElementById('toggleBtn').addEventListener('click', function () {
    const content = document.getElementById('content-wrapper');

    if (content.classList.contains('content-collapsed')) {
        content.classList.remove('content-collapsed');
        content.classList.add('content-expanded');
        this.textContent = 'Show less';
    } else {
        content.classList.remove('content-expanded');
        content.classList.add('content-collapsed');
        this.textContent = 'View more';
    }
});
</script>
