<div class="row">
    <div class="col-lg-12">
        <iframe id="iframe_view_open_file" style="
            width: 100%;
            min-height: 70vh;
        " src="<?=base_url($url)?>">
        </iframe>
    </div>
</div>
<script>
    $('#iframe_view_open_file')[0].contentWindow.location.reload(true);
</script>