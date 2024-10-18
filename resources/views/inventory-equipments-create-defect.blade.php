<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap Css -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">

    <!-- Link Custom Css File -->
    <link rel="stylesheet" href="{{asset('assets/css/equipments-form-defect.css')}}">

    <!-- Font-Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <title>Equipment Form</title>
</head>

<body>
    <div class="container">
        <header>Add Equipment Item Defect</header>

        <form action="{{ route('equipments.store') }}" method="POST">
            @csrf
            <div class="form first">
                <div class="details personal">
                    <div class="fields">

                        <div class="input-field">
                            <label>Select Name</label>
                            <select name="equipment_id" id="select_name">
                                @foreach ($equipments as $equipment)
                                    <option value={{$equipment->id}}>{{$equipment->item_name}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="input-field">
                            <label>Quantity</label>
                            <input type="text" placeholder="Enter Quantity" name="quantity" required>
                        </div>

                        <div class="input-field">
                            <label>Defect</label>
                            <select name="defect" id="defect">
                                <optgroup label="Option">
                                    <option value="None">None</option>
                                    <option value="Broken">Broken</option>
                                    <option value="Very Rusty">Very Rusty</option>
                                    <option value="Loose Bearings">Loose Bearings</option>
                                    <option value="Torn Bands">Torn Bands</option>
                                </optgroup>
                            </select>
                        </div>

                        <div class="input-field">
                            <label>Date</label>
                            <input type="date" placeholder="Enter the date" name="date" required>
                        </div>

                        <div class="input-field">
                            <label>Time</label>
                            <input type="time" placeholder="Enter the time" name="time" required>
                        </div>

                    </div>
                </div>

                @if(session('success'))
                    <div class="custom-alert-message">
                        {{ session('success') }}
                    </div>
                @endif

                <script>
                    document.addEventListener("DOMContentLoaded", function () {
                        setTimeout(function () {
                            const alert = document.querySelector('.custom-alert-message');
                            if (alert) {
                                alert.classList.add('fade-out');
                            }
                        }, 3000); // 3000ms = 3 seconds
                    });
                </script>

                <button type="submit" class="nextBtn">
                    <span class="btnText">Submit</span>
                </button>

            </div>
        </form>

    </div>
</body>

</html>