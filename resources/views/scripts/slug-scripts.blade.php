<script src="https://code.jquery.com/jquery-3.7.1.slim.min.js" integrity="sha256-kmHvs0B+OpCW5GVHUNjv9rOmY0IvSIRcf7zGUDTDQM8=" crossorigin="anonymous"></script>

<script>
    $('#InputTitle').on('blur',function(){

    var theTitle=this.value.toLowerCase().trim(),
        slugInput=$('#InputSlug'),
        theSlug=theTitle.replace(/&/g,'-and-')
            .replace(/[^a-z0-9-]+/g,'-')
            .replace(/\-\-+/g,'-')
            .replace(/^-+|-+$/g,'');

    slugInput.val(theSlug);
    });
</script>