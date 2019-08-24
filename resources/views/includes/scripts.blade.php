<script defer src="https://cdn.jsdelivr.net/npm/katex@0.10.2/dist/katex.min.js"
        integrity="sha384-9Nhn55MVVN0/4OFx7EE5kpFBPsEMZxKTCnA+4fqDmg12eCTqGi6+BB2LjY8brQxJ"
        crossorigin="anonymous"></script>
<script defer src="https://cdn.jsdelivr.net/npm/katex@0.10.2/dist/contrib/auto-render.min.js"
        integrity="sha384-kWPLUVMOks5AQFrykwIup5lo0m3iMkkHrD0uJ4H5cjeGihAutqP0yW0J6dpFiVkI"
        crossorigin="anonymous"></script>

<script defer src="{{ mix('js/app.js') }}" type="text/javascript"></script>
<script type="text/javascript">
    document.addEventListener("DOMContentLoaded", function () {
        renderMathInElement(document.body, {
            delimiters: [
                {left: "$$", right: "$$", display: true},
                {left: "\\[", right: "\\]", display: true},
                {left: "$", right: "$", display: false},
                {left: "\\(", right: "\\)", display: false}
            ]
        });
    });
</script>
