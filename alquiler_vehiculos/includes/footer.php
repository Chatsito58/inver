<footer class="text-center mt-4">
    <p>&copy; <?php echo date('Y'); ?> Alquiler Vehículos</p>
</footer>
<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('form').forEach(function (form) {
        form.addEventListener('submit', function () {
            form.querySelectorAll('button[type="submit"], input[type="submit"]').forEach(function (btn) {
                btn.disabled = true;
                if (btn.tagName.toLowerCase() === 'input') {
                    btn.value = 'Procesando…';
                } else {
                    btn.textContent = 'Procesando…';
                }
            });
        });
    });
});
</script>
</body>
</html>
