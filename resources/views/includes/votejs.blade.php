<script type="text/javascript" id="voteBtnScript">
    $('.voteBtnContainer').on('click', '.voteBtn', function (e) {
        e.preventDefault();
        let pid = this.dataset.pid;
        let api = this.dataset.api;
        axios.post(api, {})
            .then(function (response) {
                $('#voteBtnContainer-' + pid).html(response.data.vote_buttons_html);
            })
            .catch(function (error) {
                $.alert({
                    title: 'Fail',
                    content: "Failed to proceed. Error: " + error,
                    type: 'red',
                    typeAnimated: true,
                    backgroundDismiss: 'close',
                    buttons: {
                        close: function () {
                        }
                    }
                });
            });
    });
</script>