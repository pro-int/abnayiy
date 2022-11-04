<html xmlns='https://www.w3.org/1999/xhtml'>

<head></head>

<body>
    <form action="{{ $form_array['url'] }}" method='post' name="frm">
        @foreach ($form_array['params'] as $a => $b)
        <input type='hidden' name="{{ htmlentities($a) }}" value="{{ htmlentities($b) }}">
        @endforeach
    </form>
    <script type='text/javascript'>
        document.frm.submit();
    </script>
</body>

</html>