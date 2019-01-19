<div class="alert alert-danger" role="alert">
    <strong><i class="fas fa-exclamation-circle mr-2"></i>Warning:</strong>
    This page is for developers only.
</div>
<hr/>
<div id="clients"></div>

<div class="modal fade" id="createClientModal" tabindex="-1" role="dialog" aria-labelledby="createClientModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            {{ html()->form('POST', '/oauth/clients')->id('createClientForm')->open() }}
            <div class="modal-header">
                <h5 class="modal-title" id="createClientModalTitle">Create a OAuth2 Client</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="alert alert-info" role="alert">
                    <i class="fas fa-info-circle mr-2"></i>
                    A redirect URL must be provided and shall it be <strong>valid</strong>,
                    or you would get 422 (Unprocessable Entity) error.
                </div>
                {{ html()->text('name')->placeholder('Client Name')->class('form-control my-3')->required() }}
                {{ html()->text('redirect')->placeholder('Redirect URL [https://]')->class('form-control')->required() }}
            </div>
            <div class="modal-footer">
                <button id="createClientSubmit" type="submit" class="btn btn-primary">Submit</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
            {{ html()->form()->close() }}
        </div>
    </div>
</div>

@push('after-scripts')
    <script type="text/javascript" id="OAuth2Scripts">
        window.onload = function () {
            updateClients();
        };

        $('body').on('submit', '#createClientForm', function (e) {
            e.preventDefault();
            let name = $('#createClientForm #name').val();
            let redirect = $('#createClientForm #redirect').val();
            createClient(name, redirect);
            updateClients();
            $('#createClientSubmit').removeAttr('disabled');
        });

        let updateClients = function () {
            axios.get('/oauth/clients', {})
                .then(function (response) {
                    let clients = response.data;
                    let clients_html = "<p>You have " + clients.length + " OAuth2 client(s). Click ["
                        + "<a href='#oauth' id='createClientLink' data-toggle='modal' data-target='#createClientModal'>HERE</a>"
                        + "] to create a new client.</p>";

                    clients_html += "<table class='table table-hover'><tbody><tr><th>ID</th><th>Name</th><th>Redirect URL</th><th>Secret</th><th>Action</th></tr> ";
                    clients.forEach(function (client, index) {
                        clients_html += "<tr><td>" + client.id + "</td><td>"
                            + client.name + "</td><td>"
                            + client.redirect + "</td><td>"
                            + client.secret + "</td><td>" + "</td>";
                    });
                    clients_html += "</tbody></table>";

                    $('#clients').html(clients_html);
                })
                .catch(function (error) {
                    alertError(error);
                });
        };

        let createClient = function (name, redirect) {
            const data = {
                name: name,
                redirect: redirect,
            };
            console.log(data);
            axios.post('/oauth/clients', data)
                .then(function (response) {
                    $.alert({
                        icon: 'fas fa-check-circle',
                        title: 'Success',
                        content: 'Your data:' + response.data,
                        type: 'green',
                        typeAnimated: true,
                    });
                    $('#createClientLink').click();
                })
                .catch(function (error) {
                    alertError(error);
                });
        }
    </script>
@endpush