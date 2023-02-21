@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="container">
            <div>
                <h1>Add New customer</h1><br>
            </div>
            @if (session()->has('success'))
                <div>
                    <p>{{ session()->get('success') }}</p>
                </div>
            @endif

            <div>
                <form name="addUser" onsubmit="getFormValue(e)" method="post">
                    @method('post')
                    @csrf
                    <input type="text" class="form-control name" name="name" placeholder="Customer name"><br>
                    <input type="email" class="form-control email" name="email" placeholder="Customer email"><br>
                    <input type="text" class="form-control address" name="address" placeholder="Customer address"><br>
                    <input type="tel" class="form-control phone" name="phone" placeholder="Customer Tel"><br>
                    <button class="btn btn-primary saveBtn" type="submit">Save</button><br><br>
                </form>
            </div>
        </div>

        <div class="container">
            <table border="1" class="table table-stripsd">
                <thead>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Delete</th>
                    <th>Edit</th>
                </thead>
                <tbody>
                    @forelse ($homes as $home)
                        <tr>
                            <td>
                                {{ $home->name }}</td>
                            <td>
                                {{ $home->email }}</td>
                            <td>
                                {{ $home->phone }} </td>
                            <td>
                                <form>
                                    @method('delete')
                                    @csrf
                                    <button class="btn btn-danger deleteBtn" type="submit" data-id="{{ $home->id }}">Delete</button>
                                </form>
                            </td>
                            <td>
                                <form action="#" method="put">
                                    @method('put')
                                    @csrf
                                    <button class="btn btn-success updateBtn" type="submit" data-id="{{ $home->id }}">Edit</button>
                                </form>
                            </td>
                        </tr>
                </tbody>

            @empty
                <tr>
                    <td colspan="3">NO users</td>
                </tr>
                @endforelse
            </table>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"
        integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <script>

        $(document).ready(function () {
            function getFormValue(e) {
            e.preventDefault();
            var data = {
                'name': $('name').val(),
                'email': $('email').val(),
                'address': $('address').val(),
                'phone': $('phone').val(),
            }

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: "post",
                url: "/home",
                data: data,
                dataType: "json",
                success: function(response) {
                    console.log(response);
                }
            });

        }

        });

        
        $(document).ready(function () {
            
            $('.deleteBtn').click(function(e) {
            e.preventDefault();
            var id = $(this).data('id');
            console.log(id);

            var token = $("meta[name='csrf-token']").attr("content");

            $.ajax({
                url: "/home/" + id,
                type: "DELETE",
                data: {
                    "id": id,
                    "_token": token,
                },
                success: function() {
                    console.log("deleted");
                }

            });
            window.location.reload();
        });

        });

        $(document).ready(function () {
            $('.updateBtn').click(function(e) {
            e.preventDefault();

            var id = $(this).data('id');
            //console.log(id);

            $('.saveBtn').text('Update');
            $(".saveBtn").toggleClass("updateBtn");

            var token = $("meta[name='csrf-token']").attr("content");

            $.ajax({
                url: "/home/" + id,
                type: "get",
                success: function(response) {

                    $('.name').val(response.cutomer.name);
                    $('.email').val(response.cutomer.email);
                    $('.address').val(response.cutomer.address);
                    $('.phone').val(response.cutomer.phone);
                }
            });

            $('.updateBtn').click(function(e) {
                e.preventDefault();

                var data = {
                    'name': $('.name').val(),
                    'email': $('.email').val(),
                    'address': $('.address').val(),
                    'phone': $('.phone').val(),
                }
                console.log(id);
                console.log(data);

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    type: "put",
                    url: "/home/"+ id,
                    data: data,
                    dataType: "json",
                    success: function(response) {
                        console.log(response);
                    }
                });
                window.location.reload();

            });
        });

        });
    </script>
@endsection
