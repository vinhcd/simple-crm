
{{--TODO: move to js components--}}
<script>
    $.validator.addMethod("pwcheck",
        function(value) {
            return /^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#\$%\^&\*])(?=.{8,})/.test(value);
        },
        'Password must contain at lease one lower-case, upper-case, digit and special character'
    );

    $.validator.addMethod("notEqualTo",
        function(value, element, param) {
            var notEqual = true;
            value = $.trim(value);
            for (i = 0; i < param.length; i++) {
                if (value == $.trim($(param[i]).val())) { notEqual = false; }
            }
            return this.optional(element) || notEqual;
        },
        "Please enter a different value."
    );
</script>
