<!DOCTYPE html>
<html ng-app="myApp">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Log Reader</title>
    <script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <style>
        body {
            margin: 0;
            padding: 0;
            background: #f4f4f4;
            font-family: sans-serif;
        }

        .btn {
            text-decoration: none;
            background: antiquewhite;
            padding: 5px 12px;
            border-radius: 25px;
        }

        header {
            min-height: 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px;
            background: #3F51B5;
            position: fixed;
            left: 0;
            right: 0;
            top: 0;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.12), 0 1px 2px rgba(0, 0, 0, 0.24);
        }

        header .btn_clear_all {
            background: #de4f4f;
            color: #fff;
        }

        header .name {
            font-size: 25px;
            font-weight: 500;
            color: white;
        }

        .content {
            margin-top: 65px;
            padding: 15px;
            background: #fff;
            min-height: 100px;
        }

        .content .date_selector {
            min-height: 26px;
            min-width: 130px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        .top_content {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .top_content .top_content_left {
            display: flex;
        }

        .top_content .top_content_left .log_filter {
            display: flex;
            align-items: center;
            margin-left: 15px;
        }

        .top_content .top_content_left .log_filter .log_type_item {
            margin-right: 4px;
            background: #eae9e9;
            max-height: 20px;
            font-size: 11px;
            box-sizing: border-box;
            padding: 4px 6px;
            cursor: pointer;
        }

        .top_content .top_content_left .log_filter .log_type_item.active {
            background: #2f2e2f;
            color: white;
        }

        .top_content .top_content_left .log_filter .log_type_item.clear {
            background: #607D8B;
            color: white;
        }

        table {
            border: 1px solid #ccc;
            border-collapse: collapse;
            margin: 0;
            padding: 0;
            width: 100%;
        }

        table tr {
            border: 1px solid #e8e8e8;
            padding: 5px;
        }

        table tr:hover {
            background: #f4f4f4;
        }

        thead tr td {
            background: #717171;
            color: #fff;
        }

        table th,
        table td {
            padding: 5px;
            font-size: 14px;
            color: #666;
        }

        table th {
            font-size: 14px;
            letter-spacing: 1px;
            text-transform: uppercase;
        }

        @media screen and (max-width: 700px) {
            .top_content {
                flex-direction: column;
            }

            .top_content .top_content_left {
                flex-direction: column;
            }

            .top_content .log_filter {
                flex-wrap: wrap;
            }

            .top_content .log_filter .log_type_item {
                margin-bottom: 3px;
            }
        }

        @media screen and (max-width: 600px) {
            header {
                flex-direction: column;
            }

            header .name {
                margin-bottom: 20px;
            }

            .content {
                margin-top: 90px;
            }

            .btn {
                font-size: 13px;
            }

            .dt_box,
            .selected_date {
                text-align: center;
            }

            .responsive_table {
                max-width: 100%;
                overflow-x: auto;
            }

            table {
                border: 0;
            }

            table thead {
                display: none;
            }

            table tr {
                border-bottom: 2px solid #ddd;
                display: block;
                margin-bottom: 10px;
            }

            table td {
                border-bottom: 1px dotted #ccc;
                display: block;
                font-size: 15px;
            }

            table td:last-child {
                border-bottom: 0;
            }

            table td:before {
                content: attr(data-label);
                float: left;
                font-weight: bold;
                text-transform: uppercase;
            }
        }

        .badge {
            padding: 2px 8px;
            -webkit-border-radius: 25px;
            -moz-border-radius: 25px;
            border-radius: 25px;
            font-size: 11px;
        }

        .badge.info {
            background: #6bb5b5;
            color: #fff;
        }

        .badge.warning {
            background: #f7be57;
        }

        .badge.critical {
            background: #de4f4f;
            color: #fff;
        }

        .badge.emergency {
            background: #ff6060;
            color: white;
        }

        .badge.notice {
            background: bisque;
        }

        .badge.debug {
            background: #8e8c8c;
            color: white;
        }

        .badge.alert {
            background: #4ba4ea;
            color: white;
        }

        .badge.error {
            background: #c36a6a;
            color: white;
        }
    </style>


</head>

<body ng-controller="LogCtrl">
    <header>
        <div class="name">Log File Viwer</div>
        <div class="actions">
            <a class="btn btn_clear_all" href="#" onclick="clearAll()">Clear All</a>
        </div>
    </header>
    <section class="content">
        <div class="top_content">
            <div class="top_content_right ">
                <p class="dt_box">FIle </p>
                <form action="{{ route('read') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" id="_token" value="{{ csrf_token() }}">

                    <select name="type">
                        <option value="upload">Upload</option>
                        <option value="path">path</option>
                    </select>
                    <input type="file" name="file">
                    <input type="text" name="path">
                    <button type="submit">Upload</button>
                </form>


            </div>
        </div>
        <div>
            <div class="responsive_table">

                <table>
                    <thead>
                        <tr>
                            <td width="250px">Log</td>
                            <td>Action</td>
                        </tr>
                    </thead>

                    @if (empty($data))
                    @else
                        @foreach (array_slice($data, 0, 10) as $key => $item)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $item }}</td>
                            </tr>
                        @endforeach



                    @endif
                </table>
                <button onclick="next()">sdfsd</button>

            </div>
        </div>
        <script type="text/javascript">      
            window.csrf_token = "{{ csrf_token() }}"
          </script>

        <script>
            function next() {
                fetch('{{ route('read') }}', {
                    method: "POST",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    body: JSON.stringify({
                        path: "log.txt",
                    })
                }).then(result => {
                    // do something with the result
                    console.log("Completed with result:", result);
                }).catch(err => {
                    // if any error occured, then catch it here
                    console.error(err);
                });
            }
        </script>
        <script>
            function clearAll() {
                window.location.href = "{{ route('home') }}";
            }
        </script>
    </section>

</body>

</html>
