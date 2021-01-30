<center><span>Copyright © {'Y'|date} {$sitename}.</span></center>

<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
<script src="assets/js/bootstrap.bundle.min.js"></script>
<script src="assets/js/clipboard.min.js"></script>
<script>
$(document).ready(function(){
    var clipboard = new ClipboardJS('.btn');
    $('[data-toggle="popover"]').popover({
        placement: 'bottom',
        delay: {
            show: 500,
            hide: 100
        }
    });

    $('[data-toggle="popover"]').click(function(){
        $('#copyLink').popover('show');
        setTimeout(function() {
            $('.popover').fadeOut('slow',function() {});
        },1000);
    });
});
</script>
</body>
</html>