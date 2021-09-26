<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        table{
            font-size: 17px;
        }
        td{
            border: 1px solid #ddd;
        }
    </style>
</head>
<body>
    <h2>running base url: '/api/v1'</h2>
    <div style="width: 48%; float:left; padding: 1%">
        <h2 style="text-align: center;">category</h2>
        <table style="border: 1px solid black;width: 100%;text-align: center;">
            <thead>
                <tr>
                    <th>name</th>
                    <th>method</th>
                    <th>url</th>
                </tr>
            </thead>
           <tbody>
                <tr>
                    <td>add category:</td>
                    <td>post</td>
                    <td>/categories</td>
                </tr>
                <tr>
                    <td>update category:</td>
                    <td>put/patch</td>
                    <td>/categories</td>
                </tr>
                <tr>
                    <td>all category:</td>
                    <td>get</td>
                    <td>/categories</td>
                </tr>
                <tr>
                    <td>show category:</td>
                    <td>get</td>
                    <td>/categories/id</td>
                </tr>
                <tr>
                    <td>trash all category:</td>
                    <td>post</td>
                    <td>/categories/delete/all</td>
                </tr>
                <tr>
                    <td>change all category status:</td>
                    <td>post</td>
                    <td>/categories/change/all</td>
                </tr>
                <tr>
                    <td>force delete all category:</td>
                    <td>post</td>
                    <td>/categories/change/all</td>
                </tr>
                <tr>
                    <td>restore all category:</td>
                    <td>post</td>
                    <td>/categories/change/all</td>
                </tr>
           </tbody>
        </table>
        </div>
    </div>
    <div style="width: 48%; float:left; padding: 1%">
    <h2 style="text-align: center;">sub category</h2>
        <table style="border: 1px solid black;width: 100%;text-align: center;">
            <thead>
                <tr>
                    <th>name</th>
                    <th>method</th>
                    <th>url</th>
                </tr>
            </thead>
           <tbody>
                <tr>
                    <td>add sub-category:</td>
                    <td>post</td>
                    <td>sub/categories</td>
                </tr>
                <tr>
                    <td>update sub-category:</td>
                    <td>put/patch</td>
                    <td>sub/categories</td>
                </tr>
                <tr>
                    <td>all sub-category:</td>
                    <td>get</td>
                    <td>sub/categories</td>
                </tr>
                <tr>
                    <td>show sub-category:</td>
                    <td>get</td>
                    <td>sub/categories/id</td>
                </tr>
                <tr>
                    <td>trash all sub-category:</td>
                    <td>post</td>
                    <td>sub/categories/delete/all</td>
                </tr>
                <tr>
                    <td>change all sub-category status:</td>
                    <td>post</td>
                    <td>/categories/change/all</td>
                </tr>
                <tr>
                    <td>force delete all sub-category:</td>
                    <td>post</td>
                    <td>sub/categories/change/all</td>
                </tr>
                <tr>
                    <td>restore all sub-category:</td>
                    <td>post</td>
                    <td>sub/categories/change/all</td>
                </tr>
           </tbody>
        </table>
    </div>
</body>
</html>