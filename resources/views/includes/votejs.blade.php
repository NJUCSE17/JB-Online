<script type="text/javascript" id="voteBtnScript">
    $('.voteBtn').on('click', function (e) {
        e.preventDefault();
        if ('<?php echo \Auth::hasUser(); ?>') {
            let pid = this.dataset.pid;
            let api = this.dataset.api;
            let voteUpBtn = document.getElementById('vote_up_' + pid);
            let voteDownBtn = document.getElementById('vote_down_' + pid);
            let voteCountLabel = document.getElementById('vote_count_label_' + pid);
            $.getJSON(api, function(res){
                if (res.status === 1) {
                    voteUpBtn.setAttribute('class', res.vote_up_class);
                    voteDownBtn.setAttribute('class', res.vote_down_class);
                    voteCountLabel.innerHTML = res.vote_count_label;
                } else {
                    $.alert({
                        title: 'Fail',
                        content: "Failed to proceed.",
                        type: 'red',
                        theme: 'supervan',
                        typeAnimated: true,
                        backgroundDismiss: 'close',
                        buttons:{
                            close: function(){
                            }
                        }
                    });
                }
            });
        } else {
            document.location.href = '{{ route("frontend.auth.login") }}';
        }
    });
</script>