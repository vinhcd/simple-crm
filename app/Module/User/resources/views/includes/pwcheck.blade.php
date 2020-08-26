<script>
    var errorMessage = 'Password must contain lower-case, upper-case, digit and special character';
    $.validator.addMethod("pwcheck", function(value) {
        return /[!@#$%^&*]/.test(value)
            && /[A-Z]/.test(value)
            && /[a-z]/.test(value)
            && /\d/.test(value);
    }, errorMessage);
</script>
