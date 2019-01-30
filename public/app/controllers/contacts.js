app.controller('myContacts', function($scope, $http, API_URL) {
    //display contacts from database
    $http.get(API_URL + "contacts")
            .then(function(response) {
                $scope.contacts = response.data;
            }),
            function(error) {
                console.log(response.data);
                $scope.contacts = error;
            };

    //show modal form
    $scope.toggle = function(modalstate, id) {
        $scope.modalstate = modalstate;

        switch (modalstate) {
            case 'add':
                $scope.form_title = "Add New Contact";
                break;
            case 'edit':
                $scope.form_title = "Contact Details";
                $scope.id = id;
                $http.get(API_URL + 'contacts/' + id)
                        .then(function(response) {
                            console.log(response.data);
                            $scope.contacts = response.data;
                        });
                break;
            default:
                break;
        }
        console.log(id);
        $('#myModal').modal('show');
    }

    //save new record / update existing record
    $scope.save = function(modalstate, id) {
        var url = API_URL + "contacts";

        //append contact id to the URL if the form is in edit mode
        if (modalstate === 'edit'){
            url += "/" + id;
        }

        $http({
            method: 'POST',
            url: url,
            data: $.param($scope.contact),
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).then(function(response) {
            console.log(response.data);
            location.reload();
        }),function(error) {
            console.log(response.data);
            alert('This is embarassing. An error has occured. Please check the log for details');
        };
    }

    //delete record
    $scope.confirmDelete = function(id) {
        if (confirm('Are you sure you want to delete this contact?')) {
            $http({
                method: 'DELETE',
                url: API_URL + 'contacts/' + id
            }).
                    then(function(response) {
                        console.log(response.data);
                        location.reload();
                    }),
                    function(error) {
                        console.log(response.data);
                        alert('Unable to delete');
                    };
        } else {
            return false;
        }
    }
});   