<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <title>Hello, world!</title>
</head>

<body>
    <div class="container">
        <div class="row mt-2 mb-4">
        <a href="#categories" class="btn btn-outline-danger ml-2">#Categories</a>
        <a href="#sub-categories" class="btn btn-outline-warning ml-2">#Sub Categories</a>
        <a href="#products" class="btn btn-outline-info ml-2">#Products</a>
        </div>
        <div class="row">
            <!-- categories -->
            <div id="categories" class="col-10 ml-auto mr-auto mb-4">
                <div class="card text-center">
                    <div class="card-header bg-primary">
                        <h3>#categories</h3>
                    </div>
                    <div class="card-body text-left">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">Action</th>
                                    <th scope="col">URL</th>
                                    <th scope="col">Method</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>show all categories</td>
                                    <td>/categories</td>
                                    <td>GET</td>
                                </tr>
                                <tr>
                                    <td>add category</td>
                                    <td>/categories</td>
                                    <td>POST
                                        <br>
                                        <p class="text-danger">{ name }</p>
                                    </td>
                                </tr>
                                <tr>
                                    <td>show a single category</td>
                                    <td>/categories/{parameter}</td>
                                    <td>GET</td>
                                </tr>
                                <tr>
                                    <td>update category</td>
                                    <td>/categories/{parameter}</td>
                                    <td>PUT
                                        <br>
                                        <p class="text-danger">{ name, status, slug }</p>
                                   </td>
                                </tr>
                                <tr>
                                    <td>change multiple categories status</td>
                                    <td>/categories/change/status</td>
                                    <td>POST
                                        <br>
                                        <p class="text-danger">{ data[ id,status ] }</p>
                                    </td>
                                </tr>
                                <tr>
                                    <td>move to trash multiple categories</td>
                                    <td>/categories/move/to/trash</td>
                                    <td>POST
                                        <br>
                                        <p class="text-danger">{ data[ id ] }</p>
                                    </td>
                                </tr>
                                <tr>
                                    <td>show all trashed categories</td>
                                    <td>/categories/trashed/items</td>
                                    <td>GET</td>
                                </tr>
                                <tr>
                                    <td>force delete multiple categories</td>
                                    <td>/categories/force/delete</td>
                                    <td>POST
                                        <br>
                                        <p class="text-danger">{ data[ id ] }</p>
                                    </td>
                                </tr>
                                <tr>
                                    <td>restore multiple trashed categories</td>
                                    <td>/categories/restore</td>
                                    <td>POST
                                        <br>
                                        <p class="text-danger">{ data[ id ] }</p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- sub categories -->

            <div id="sub-categories" class="col-10 ml-auto mr-auto mb-4">
                <div class="card text-center">
                    <div class="card-header bg-info">
                        <h3>#sub-categories</h3>
                    </div>
                    <div class="card-body text-left">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">Action</th>
                                    <th scope="col">URL</th>
                                    <th scope="col">Method</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>show all sub-categories</td>
                                    <td>/sub/categories</td>
                                    <td>GET</td>
                                </tr>
                                <tr>
                                    <td>add sub-category</td>
                                    <td>/sub/categories</td>
                                    <td>POST
                                        <br>
                                        <p class="text-danger">{ name, category_id }</p>
                                    </td>
                                </tr>
                                <tr>
                                    <td>show a single sub-category</td>
                                    <td>/sub/categories/{parameter}</td>
                                    <td>GET</td>
                                </tr>
                                <tr>
                                    <td>update sub-category</td>
                                    <td>/sub/categories/{parameter}</td>
                                    <td>PUT
                                        <br>
                                        <p class="text-danger">{ name, category_id, status, slug }</p>
                                    </td>
                                </tr>
                                <tr>
                                    <td>change multiple sub-categories status</td>
                                    <td>/sub/categories/change/status</td>
                                    <td>POST
                                        <br>
                                        <p class="text-danger">{ data[ id,status ] }</p>
                                    </td>
                                </tr>
                                <tr>
                                    <td>move to trash multiple sub-categories</td>
                                    <td>/sub/categories/move/to/trash</td>
                                    <td>POST
                                        <br>
                                        <p class="text-danger">{ data[ id ] }</p>
                                    </td>
                                </tr>
                                <tr>
                                    <td>show all trashed sub-categories</td>
                                    <td>/sub/categories/trashed/items</td>
                                    <td>GET</td>
                                </tr>
                                <tr>
                                    <td>force delete multiple categories</td>
                                    <td>/sub/categories/force/delete</td>
                                    <td>POST
                                        <br>
                                        <p class="text-danger">{ data[ id ] }</p>
                                    </td>
                                </tr>
                                <tr>
                                    <td>restore multiple trashed sub-categories</td>
                                    <td>/sub/categories/restore</td>
                                    <td>POST
                                        <br>
                                        <p class="text-danger">{ data[ id ] }</p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- products -->
            <div id="products" class="col-10 ml-auto mr-auto mb-4">
                <div class="card text-center">
                    <div class="card-header bg-primary">
                        <h3>#Products</h3>
                    </div>
                    <div class="card-body text-left">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">Action</th>
                                    <th scope="col">URL</th>
                                    <th scope="col">Method</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>show all products</td>
                                    <td>/products</td>
                                    <td>GET</td>
                                </tr>
                                <tr>
                                    <td>add product</td>
                                    <td>/products</td>
                                    <td>POST
                                        <br>
                                        <p class="text-danger">{ category_id, sub_category_id, name, thumbnail, file_type, gallery[file_type, data], price[cost_price, retail_price, discount_price, discount_start, discount_end], stock[product_color_name, product_size_id, stock] }</p>
                                    </td>
                                </tr>
                                <tr>
                                    <td>show a single product</td>
                                    <td>/products/{parameter}</td>
                                    <td>GET</td>
                                </tr>
                                <tr>
                                    <td>update product</td>
                                    <td>/products/{parameter}</td>
                                    <td>PUT
                                        <br>
                                        <p class="text-danger">{ category_id, sub_category_id, name, thumbnail, file_type, gallery[file_type, data], price[cost_price, retail_price, discount_price, discount_start, discount_end], stock[product_color_name, product_size_id, stock], status }</p>
                                    </td>
                                </tr>
                                <tr>
                                    <td>change multiple products status</td>
                                    <td>/products/change/status</td>
                                    <td>POST
                                        <br>
                                        <p class="text-danger">{ data[ id,status ] }</p>
                                    </td>
                                </tr>
                                <tr>
                                    <td>move to trash multiple products</td>
                                    <td>/products/move/to/trash</td>
                                    <td>POST
                                        <br>
                                        <p class="text-danger">{ data[ id ] }</p>
                                    </td>
                                </tr>
                                <tr>
                                    <td>show all trashed products</td>
                                    <td>/products/trashed/items</td>
                                    <td>GET</td>
                                </tr>
                                <tr>
                                    <td>force delete multiple products</td>
                                    <td>/products/force/delete</td>
                                    <td>POST
                                        <br>
                                        <p class="text-danger">{ data[ id ] }</p>
                                    </td>
                                </tr>
                                <tr>
                                    <td>restore multiple trashed products</td>
                                    <td>/products/restore</td>
                                    <td>POST
                                        <br>
                                        <p class="text-danger">{ data[ id ] }</p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>

</html>