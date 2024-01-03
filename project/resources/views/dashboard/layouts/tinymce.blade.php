<script id="script_tinymce" type="text/javascript" src="{{ asset('libs/cupload/js/creative-upload-plugins.min.js') }}"></script>
<script id="script_tinymce" type="text/javascript" src="{{ asset('libs/tinymce/tinymce.min.js') }}"></script>
<script>
tinymce.init({
    selector: "textarea#content",
    language: '{{$admin_lang}}',
    direction: '{{get_option('direction', 'ltr')}}',
    resize: true,
    menubar: false,
    indent: true,
    relative_urls: true,
    remove_script_host: false,
    convert_urls: false,
    browser_spellcheck: true,
    fix_list_elements: true,
    entities: "38,amp,60,lt,62,gt",
    entity_encoding: "raw",
    keep_styles: false,
    plugins: 'print preview fullpage paste importcss searchreplace autolink autosave save directionality code visualblocks visualchars fullscreen image link media template codesample table charmap hr pagebreak nonbreaking anchor toc insertdatetime advlist lists wordcount imagetools textpattern noneditable help charmap quickbars emoticons',
    toolbar: 'undo redo | bold italic underline strikethrough | fontselect fontsizeselect formatselect | alignleft aligncenter alignright alignjustify | outdent indent |  numlist bullist | forecolor backcolor removeformat | pagebreak | charmap emoticons | fullscreen  preview save print | insertfile image media template link anchor codesample | ltr rtl',
    image_advtab: true,
    height: 500,
    image_caption: true,
    quickbars_selection_toolbar: 'bold italic | quicklink h2 h3 blockquote quickimage quicktable',
    noneditable_noneditable_class: "mceNonEditable",
    toolbar_drawer: 'sliding',
    contextmenu: "link image imagetools table",
});
</script>
<script type="text/javascript">creative_media_upload("picture", "library", "library", "content");</script>