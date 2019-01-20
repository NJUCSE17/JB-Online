<div class="alert alert-danger" role="alert">
    <strong><i class="fas fa-exclamation-circle mr-2"></i>Warning:</strong>
    This page is for developers only.
</div>
<div class="alert alert-warning" role="alert">
    <i class="fas fa-info-circle mr-2"></i>This page only issues authorization
    code grant type clients (i.e. 3rd party clients), and does not issue password
    grant type clients (i.e. 1st party authorization client),
    if you need one, you need to contant with site admin.
</div>
<hr/>
<div id="clientsInfo"></div>
<div id="clientsTable" style="overflow: auto;"></div>

<div class="modal fade" id="createClientModal" tabindex="-1" role="dialog" aria-labelledby="createClientModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            {{ html()->form('POST', '/oauth/clients')->id('createClientForm')->open() }}
            <div class="modal-header">
                <h5 class="modal-title" id="createClientModalTitle">Create an OAuth2 Client</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="alert alert-success" role="alert">
                    <i class="fas fa-laptop-code mr-2"></i> A redirect URL must be
                    provided and shall it be <strong>valid</strong>,
                    or you would get 422 (Unprocessable Entity) error.
                    To try APIs in the Swagger documentation,
                    leave the redirect url empty.
                </div>
                {{ html()->text('name')->id('createName')->placeholder('Client Name')->class('form-control my-3')->required() }}
                {{ html()->text('redirect')->id('createRedirect')->placeholder('Redirect URL [empty => ' . config('app.url') . '/api/docs/oauth2-callback]')->class('form-control') }}
            </div>
            <div class="modal-footer">
                <button id="createClientSubmit" type="submit" class="btn btn-success">Submit</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
            {{ html()->form()->close() }}
        </div>
    </div>
</div>
<div class="modal fade" id="updateClientModal" tabindex="-1" role="dialog" aria-labelledby="updateClientModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            {{ html()->form('PUT', '/oauth/clients')->id('updateClientForm')->open() }}
            <div class="modal-header">
                <h5 class="modal-title" id="updateClientModalTitle">Update an OAuth2 Client</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="alert alert-success" role="alert">
                    <i class="fas fa-laptop-code mr-2"></i> A redirect URL must be
                    provided and shall it be <strong>valid</strong>,
                    or you would get 422 (Unprocessable Entity) error.
                    To try APIs in the Swagger documentation,
                    leave the redirect url empty.
                </div>
                {{ html()->text('name')->id('updateName')->placeholder('Client Name')->class('form-control my-3')->required() }}
                {{ html()->text('redirect')->id('updateRedirect')->placeholder('Redirect URL [empty => ' . config('app.url') . '/api/docs/oauth2-callback]')->class('form-control') }}
            </div>
            <div class="modal-footer">
                <button id="updateClientSubmit" type="submit" class="btn btn-info">Update</button>
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
            let name = $('#createClientForm #createName').val();
            let redirect = $('#createClientForm #createRedirect').val();
            if (redirect === '') redirect = "{{ config('app.url') . '/api/docs/oauth2-callback' }}";
            $('#createClientSubmit').removeAttr('disabled');
            createClient(name, redirect);
        })
            .on('click', '#updateClientBtn', function (e) {
                $('#updateClientForm').attr('data-cid', this.dataset.cid);
                $('#updateClientForm #updateName').val($('#clientName').text());
                $('#updateClientForm #updateRedirect').val($('#clientRedirect').text());
            })
            .on('submit', '#updateClientForm', function (e) {
                e.preventDefault();
                let clientID = this.dataset.cid;
                let name = $('#updateClientForm #updateName').val();
                let redirect = $('#updateClientForm #updateRedirect').val();
                if (redirect === '') redirect = "{{ config('app.url') . '/api/docs/oauth2-callback' }}";
                $('#updateClientSubmit').removeAttr('disabled');
                updateClient(clientID, name, redirect);
            })
            .on('click', '#deleteClientBtn', function (e) {
                e.preventDefault();
                let clientID = this.dataset.cid;
                deleteClient(clientID);
            });

        let updateClients = function () {
            axios.get('/oauth/clients', {})
                .then(function (response) {
                    let clients = response.data;
                    let clients_info = "<p>You have " + clients.length
                        + " OAuth2 client(s). Click the button to create a new client. "
                        + "<btn class='btn btn-sm btn-success float-right' href='#oauth' "
                        + "id='createClientBtn' data-toggle='modal' data-target='#createClientModal'>"
                        + "<i class='fas fa-plus'></i></btn></p>";

                    let clients_html = "<table class='table table-hover'><tbody>" +
                        "<tr><th>ID</th><th>Name</th><th>Redirect URL</th>" +
                        "<th>Secret</th><th>Action</th></tr> ";
                    clients.forEach(function (client, index) {
                        clients_html += "<tr><td>" + client.id + "</td><td id='clientName'>"
                            + client.name + "</td><td id='clientRedirect'>"
                            + client.redirect + "</td><td>"
                            + client.secret + "</td><td>"
                            + getClientActions(client) + "</td>";
                    });
                    clients_html += "</tbody></table>";

                    $('#clientsInfo').html(clients_info);
                    $('#clientsTable').html(clients_html);
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
                        content: 'Created an OAuth2 client.',
                        type: 'green',
                        typeAnimated: true,
                    });
                    updateClients();
                    $('#createClientBtn').click();
                })
                .catch(function (error) {
                    alertError(error);
                });
        };

        let getClientActions = function (client) {
            return "<div class='btn-group'><btn id='updateClientBtn' class='btn btn-sm btn-info' "
                + "data-cid='" + client.id + "' data-toggle='modal' data-target='#updateClientModal'><i class='fas fa-edit'></i></btn>"
                + "<btn id='deleteClientBtn' class='btn btn-sm btn-danger' data-cid='"
                + client.id + "'><i class='fas fa-trash'></i></btn></div>";
        };

        let updateClient = function (clientID, name, redirect) {
            const data = {
                name: name,
                redirect: redirect,
            };
            console.log(data);
            axios.put('/oauth/clients/' + clientID, data)
                .then(function (response) {
                    $.alert({
                        icon: 'fas fa-check-circle',
                        title: 'Success',
                        content: 'Updated OAuth2 client No.' + clientID + '.',
                        type: 'green',
                        typeAnimated: true,
                    });
                    updateClients();
                    $('#updateClientBtn').click();
                })
                .catch(function (error) {
                    alertError(error);
                });
        };

        let deleteClient = function (clientID) {
            $.confirm({
                title: 'Are you sure?',
                content: 'Are you sure to delete client No.' + clientID + '?',
                icon: 'fas fa-question-circle',
                typeAnimated: true,
                type: 'yellow',
                buttons: {
                    confirm: {
                        text: 'DELETE',
                        btnClass: 'btn-danger',
                        action: function () {
                            axios.delete('/oauth/clients/' + clientID, {})
                                .then(function (response) {
                                    $.alert({
                                        icon: 'fas fa-check-circle',
                                        title: 'Success',
                                        content: 'Deleted client ' + clientID + '.',
                                        type: 'green',
                                        typeAnimated: true,
                                    });
                                    updateClients();
                                })
                        }
                    },
                    cancel: {
                        text: 'cancel',
                        btnClass: 'btn-red',
                    },
                }
            });
        }
    </script>
@endpush