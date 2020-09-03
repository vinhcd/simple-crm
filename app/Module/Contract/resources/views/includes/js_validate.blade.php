
{{--TODO: move to js components--}}
<script>
    $.validator.addMethod("dateGreaterThan",
        function(value, element, param) {
            return Date.parse($(param).val()) < Date.parse(value);
        },
        "Please enter a greater date."
    );
</script>
